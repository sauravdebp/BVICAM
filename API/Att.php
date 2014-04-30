
<?php
    
    $dir = "Attendance";
	
    require_once("../Models/$dir/Attendance_Accumulated.php");
    require_once("../Models/$dir/Attendance_Leave_Count.php");
    require_once("../Models/$dir/Attendance_Leave_Type.php");
    require_once("../Models/$dir/Attendance_Leaves.php");
	
	class AttendanceSummary
    {
        public $roll_no;
        public $sub_code;
		public $sub_name;
        public $p_count;					// present count
        public $a_count;					// absent count
		public $leave_names = array();
        public $used_count = array();
    }

	class AttendanceDetailed
	{
		public $roll_no;
		public $sub_code;
		public $leave_dates = array();
        public $leave_names = array();
	}
	
	class LeaveUsedFromMax
	{
		public $roll_no;
        public $leave_names = array();
		public $used_count = array();			// Used count
		public $max_count = array();			// Max count
	}
	

    function getSubjectAttendance($roll, $sub)
    {
        require_once("../Models/Master/Master_Subject.php");
		require_once("../Models/Master/Master_Student.php");
		
		$sub_att = array();

        $m_sub = new master_subject();
		$records = $m_sub -> retrieveRecord("SubName", "SubCode = $sub");
		
		$attObj = new AttendanceSummary();
		foreach($records as $record)
			$attObj -> sub_name = $record['SubName'];
		
		$att_acc = new Attendance_Accumulated();
        		
		$records = $att_acc -> retrieveRecord(null, "RollNo = $roll and SubCode = $sub");
			
		foreach($records as $record)
		{
			$attObj -> roll_no = $record['RollNo'];
			$attObj -> sub_code = $record['SubCode'];
			$attObj -> p_count = $record['PresentCount'];
			$attObj -> a_count = $record['AbsentCount'];
            //array_push($attObj -> leave_names, " ");
            //array_push($attObj -> used_count, " ");
		}
		
		$att_l = new Attendance_Leaves();
		$att_l_type = new Attendance_Leave_Type();
		$tablename = $att_l_type -> Tablename();

		$records = $att_l -> retrieveRecordByJoin("LeaveName, count(*) as Count", "RollNo = $roll and SubCode = $sub", "group by $tablename.LeaveType",$att_l_type,"LeaveType");
		
		foreach($records as $record)
        {
            //array_pop($attObj -> leave_names);
            //array_pop($attObj -> used_count);
            array_push($attObj -> leave_names, $record['LeaveName']);
            array_push($attObj -> used_count, $record['Count']);
        }
		
		//array_push($sub_att, $attObj);
		
		return $attObj;
    }
		
	function getAllSubjectsAttendance($roll)
	{
	
		require_once("../Models/Master/Master_Subject.php");
		require_once("../Models/Master/Master_Student.php");
		
		$all_sub_att = array();
		
		$m_stud = new master_student();
		$m_sub = new master_subject();
		
		$records = $m_stud -> retrieveRecordByJoin("SubCode", "RollNo = $roll",null, $m_sub, "Semester");
		
		foreach($records as $record)
			array_push($all_sub_att, getSubjectAttendance($roll, $record['SubCode']));
		
		
		return $all_sub_att;
	}
	
	function getSubjectDetailAttendance($roll, $sub, $strt_date = null, $end_date = null)
	{
		$sub_att = array();
		
		$att_l = new Attendance_Leaves();
		$att_l_type = new Attendance_Leave_Type();
		
		$attObj = new AttendanceDetailed();
		
		if($strt_date && $end_date)
			$records = $att_l->retrieveRecordByJoin("LeaveName, LeaveDate", "RollNo = '$roll' and SubCode = '$sub' and LeaveDate Between '$strt_date' and '$end_date'", "order by LeaveDate Desc ",$att_l_type, "LeaveType");
		else
			$records = $att_l->retrieveRecordByJoin("LeaveName, LeaveDate", "RollNo = $roll and SubCode = $sub", "order by LeaveDate Desc ",$att_l_type, "LeaveType");
		
		$attObj -> roll_no = $roll;
		$attObj -> sub_code = $sub;
		
		foreach($records as $record)
        {
            array_push($attObj -> leave_dates, $record['LeaveDate']);
            array_push($attObj -> leave_names, $record['LeaveName']);
        }
			
		array_push($sub_att, $attObj);
		
		return $sub_att;
		
	}

    function getLeaveUsedFromMax($roll)
    {
        $leaves = array();

        $att_l_count = new Attendance_Leave_Count();
        $att_l_type = new Attendance_Leave_Type();

        $records = $att_l_count -> retrieveRecordByJoin(null, "RollNo = $roll", null, $att_l_type, "LeaveType");

        $leaveObj = new LeaveUsedFromMax();

        $leaveObj -> roll_no = $roll;

        foreach($records as $record)
        {
            array_push($leaveObj -> leave_names, $record['LeaveName']);
            array_push($leaveObj -> used_count, $record['UsedCount']);
            array_push($leaveObj -> max_count, $record['MaxLeaves']);
        }

        array_push($leaves, $leaveObj);

        return $leaves;
    }

    function validateHeader($app)
    {
        require_once("../Models/API/API_Developer.php");
        require_once("../Models/API/API_EndUser.php");

        $roll = $app->request->headers->get('RollNo');
        $api_key = $app->request->headers->get('APIKey');
        $dev_id = $app->request->headers->get('DeveloperId');

        $api_dev = new Api_Developer();

        $records1 = $api_dev -> retrieveRecord(null, "DeveloperId = '$dev_id'");

        $last_access = null;

        if($records1)
        {
            foreach($records1 as $record1)
            {
                if($record1['API_Key'] == $api_key)
                {
                    $api_end = new Api_EndUser();

                    $records2 = $api_end -> retrieveRecord(null, "UserId = '$roll'");

                    foreach($records2 as $record2)
                        if($record2['UserId'] == $roll)
                        {
                            $last_access = $record2['LastAccess'];
                            $api_end -> updateRecord("LastAccess", "UserId = '$roll'");
                        }
                }
            }
        }

        return $last_access;
    }
	
	require_once ("../Libs/Slim/Slim.php");

	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();
	
	$app -> get('/attendanceSummary/:subcode', function($sub) use($app)
	{
		if(validateHeader($app))
		{
			$roll = $app->request->headers->get('RollNo');
			$app -> response() -> header('Content-Type', 'application/json');
			$sub_att = getSubjectAttendance($roll, $sub);
			echo json_encode($sub_att);
		}	
	});
		
	$app -> get('/attendanceSummary', function() use($app)
	{
		if(validateHeader($app))
		{
			$app -> response() -> header('Content-Type', 'application/json');
			$roll = $app->request->headers->get('RollNo');
			$sub_att = getAllSubjectsAttendance($roll);
			$leaves = getLeaveUsedFromMax($roll);
			//array_push($sub_att, $leaves);
			echo json_encode($sub_att);
		}
	});
	
	$app -> get('/attendanceDetailed/:subcode/:start_date/:end_date', function($sub, $strt_date, $end_date) use($app)
	{
        if(validateHeader($app))
        {
            $app -> response() -> header('Content-Type', 'application/json');
            $roll = $app->request->headers->get('RollNo');
            $sub_att = getSubjectDetailAttendance($roll, $sub, $strt_date, $end_date);
            echo json_encode($sub_att);
        }
	});
	
	$app -> get('/attendanceDetailed/:subcode', function($sub) use($app)
	{
		if(validateHeader($app))
        {
            $app -> response() -> header('Content-Type', 'application/json');
            $roll = $app->request->headers->get('RollNo');
            $sub_att = getSubjectDetailAttendance($roll, $sub);
            echo json_encode($sub_att);
        }

	});
	
	$app->run();
?>