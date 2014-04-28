<?php
    
    $dir = "Attendance";
	$m_dir = "Master";
	$api_dir = "API";
	
    require_once("../Models/$dir/Attendance_Accumulated.php");
    require_once("../Models/$dir/Attendance_Leave_Count.php");
    require_once("../Models/$dir/Attendance_Leave_Type.php");
    require_once("../Models/$dir/Attendance_Leaves.php");
	require_once("../Models/$m_dir/Master_Subject.php");
	require_once("../Models/$m_dir/Master_Student.php");
	require_once("../Models/$api_dir/API_Developer.php");
	require_once("../Models/$api_dir/API_EndUser.php");
	
	
    class AttendanceSummary
    {
        public $roll_no;
        public $sub_code;
		public $sub_name;
        public $p_count;					// present count
        public $a_count;					// absent count
		public $leave_u_count = array();	// leave used count		
    }

	class AttendanceDetailed
	{
		public $roll_no;
		public $sub_code;
		public $leaves = array();
	}
	
	class LeaveUsedFromMax
	{
		public $roll_no;
		public $u_count = array();			// Used count
		public $m_count = array();			// Max count
	}
	
	function getLeaveUsedFromMax($roll)
	{
		$leaves = array();
		
		$obj1 = new Attendance_Leave_Count();
		$obj2 = new Attendance_Leave_Type();
		
		$records = $obj1 -> retrieveRecordByJoin(null, "RollNo = $roll", null, $obj2, "LeaveType");
		
		$leaveObj = new LeaveUsedFromMax();
		
		$leaveObj -> roll_no = $roll;
		
		foreach($records as $record)
		{
			$leaveObj -> u_count[$record['LeaveName']] = $record['UsedCount'];
			$leaveObj -> m_count[$record['LeaveName']] = $record['MaxLeaves'];
		}
		
		array_push($leaves, $leaveObj);
		
		return $leaves;
	}
	
    function getSubjectAttendance($roll, $sub)
    {
        $sub_att = array();

        $obj = new master_subject();
		$records = $obj -> retrieveRecord("SubName", "SubCode = $sub");
		
		$attObj = new AttendanceSummary();
		foreach($records as $record)
			$attObj -> sub_name = $record['SubName'];
		
		$obj1 = new Attendance_Accumulated();
        		
		$records = $obj1 -> retrieveRecord(null, "RollNo = $roll and SubCode = $sub");
			
		foreach($records as $record)
		{
			$attObj -> roll_no = $record['RollNo'];
			$attObj -> sub_code = $record['SubCode'];
			$attObj -> p_count = $record['PresentCount'];
			$attObj -> a_count = $record['AbsentCount'];
		}
		
		$obj2 = new Attendance_Leaves();
		$obj3 = new Attendance_Leave_Type();
		$tablename = $obj3 -> tablename();
		
		$records = $obj2 -> retrieveRecordByJoin("LeaveName, count(*) as Count", "RollNo = $roll and SubCode = $sub", "group by $tablename.LeaveType",$obj3,"LeaveType");
		
		foreach($records as $record)
			$attObj -> leave_u_count[$record['LeaveName']] = $record['Count'];
		
		array_push($sub_att, $attObj);		
		
		return $sub_att;
    }
		
	function getAllSubjectsAttendance($roll)
	{
		$all_sub_att = array();
		
		$obj1 = new master_student();
		$obj2 = new master_subject();
		
		$records = $obj1 -> retrieveRecordByJoin("SubCode", "RollNo = $roll",null, $obj2, "Semester");
		
		foreach($records as $record)
			array_push($all_sub_att, getSubjectAttendance($roll, $record['SubCode']));
		
		
		return $all_sub_att;
	}
	
	function getSubjectDetailAttendance($roll, $sub, $strt_date = null, $end_date = null)
	{
		$sub_att = array();
		
		$obj1 = new Attendance_Leaves();
		$obj2 = new Attendance_Leave_Type();
		
		$attObj = new AttendanceDetailed();
		
		if($strt_date && $end_date)
			$records = $obj1->retrieveRecordByJoin("LeaveName, LeaveDate", "RollNo = '$roll' and SubCode = '$sub' and LeaveDate Between '$strt_date' and '$end_date'", "order by LeaveDate Desc ",$obj2, "LeaveType");
		else
			$records = $obj1->retrieveRecordByJoin("LeaveName, LeaveDate", "RollNo = $roll and SubCode = $sub", "order by LeaveDate Desc ",$obj2, "LeaveType");
		
		$attObj -> roll_no = $roll;
		$attObj -> sub_code = $sub;
		
		foreach($records as $record)
			$attObj -> leaves[$record['LeaveDate']] = $record['LeaveName'];
			
		array_push($sub_att, $attObj);
		
		return $sub_att;
		
	}
       
	function validateHeader($app)
	{
		$roll = $app->request->headers->get('RollNo');
		$api_key = $app->request->headers->get('API_Key');
		$dev_id = $app->request->headers->get('DeveloperId');
		
		$obj = new Api_Developer();
		
		$records1 = $obj -> retrieveRecord(null, "DeveloperId = '$dev_id'");
		
		foreach($records1 as $record1)
		{
			if($record1['API_Key'] == $api_key)
			{
				$obj = new Api_enduser();
		
				$records2 = $obj -> retrieveRecord(null, "UserId = '$roll'");
				
				foreach($records2 as $record2)
				{
					if($record2['UserId'] == $roll)
					{
						$date = new DateTime();
						//$update_value['LastAccess'] = $date -> getTimestamp();
						//$obj -> setData($update_value);
						$obj -> updateRecord("LastAccess", "UserId = '$roll'");
					}
			    }
		    }
	    }
    }
	
	require_once ("../Libs/Slim/Slim.php");

	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();
	
	$app -> get('/attendanceSummary/:subcode', function($sub) use($app)
	{
		//if(validateHeader($app))
		{
			$roll = $app->request->headers->get('RollNo');
			$app -> response() -> header('Content-Type', 'application/json');
			$sub_att = getSubjectAttendance($roll, $sub);
			echo json_encode($sub_att);
		}	
	});
		
	$app -> get('/attendanceSummary', function() use($app)
	{
		//if(validateHeader($app))
		{
			$app -> response() -> header('Content-Type', 'application/json');
			$roll = $app->request->headers->get('RollNo');
			$sub_att = getAllSubjectsAttendance($roll);
			$leaves = getLeaveUsedFromMax($roll);
			array_push($sub_att, $leaves);
			echo json_encode($sub_att);
		}
	});
	
	$app -> get('/attendanceDetailed/:subcode/:start_date/:end_date', function($sub, $strt_date, $end_date) use($app)
	{
        //if(validateHeader($app))
        {
            $app -> response() -> header('Content-Type', 'application/json');
            $roll = $app->request->headers->get('RollNo');
            $sub_att = getSubjectDetailAttendance($roll, $sub, $strt_date, $end_date);
            echo json_encode($sub_att);
        }
	});
	
	$app -> get('/attendanceDetailed/:subcode', function($sub) use($app)
	{
		//if(validateHeader($app))
        {
            $app -> response() -> header('Content-Type', 'application/json');
            $roll = $app->request->headers->get('RollNo');
            $sub_att = getSubjectDetailAttendance($roll, $sub);
            echo json_encode($sub_att);
        }

	});
	
	$app->run();
?>