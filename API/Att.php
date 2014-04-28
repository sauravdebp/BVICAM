<?php
    
    $dir = "Attendance";
	$m_dir = "Master";
	
    include("../Models/$dir/Attendance_Accumulated.php");
    include("../Models/$dir/Attendance_Leave_Count.php");
    include("../Models/$dir/Attendance_Leave_Type.php");
    include("../Models/$dir/Attendance_Leaves.php");
	include("../Models/$m_dir/Master_Subject.php");
	include("../Models/$m_dir/Master_Student.php");
	
    class AttendanceSummary
    {
        public $roll_no;
        public $sub_code;
		public $sub_name;
        public $p_count;
        public $a_count;
		public $leave_u_count = array();
    }
	
	class AttendanceDetailed
	{
		public $roll_no;
		public $sub_code;
		public $leaves = array();
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
		
		$records = $obj2 -> retrieveRecordByJoin($obj3,"LeaveType", "LeaveName, count(*) as Count", "RollNo = $roll and SubCode = $sub", "group by $tablename.LeaveType");
		
		foreach($records as $record)
			$attObj -> leaves_u_count[$record['LeaveName']] = $record['Count'];
		
		array_push($sub_att, $attObj);		
		
		return $sub_att;
    }
		
	function getAllSubjectsAttendance($roll)
	{
		$all_sub_att = array();
		
		$obj1 = new master_student();
		$obj2 = new master_subject();
		
		$records = $obj1 -> retrieveRecordByJoin($obj2, "Semester", "SubCode", "RollNo = $roll");
		
		foreach($records as $record)
			array_push($all_sub_att, getSubjectAttendance($roll, $record['SubCode']));
		
		return $all_sub_att;
	}
	
	function getSubjectDetailAttendance($roll, $sub, $strt_date = 0, $end_date = CURRENT_DATE())
	{
		$sub_att = array();
		
		$obj1 = new Attendance_Leaves();
		$obj2 = new Attendance_Leave_Type();
		
		$attObj = new AttendanceDetailed();
		
		$records = $obj1->retrieveRecordByJoin( $obj2, "LeaveType", "LeaveName, LeaveDate", "RollNo = $roll and SubCode = $sub and LeaveDate Between $strt_date and $end_date", "order by LeaveDate Desc ");
		
		$attObj -> roll_no = $roll;
		$attObj -> sub_code = $sub;
		
		foreach($records as $record)
			$attObj -> leaves[$record['LeaveDate']] = $record['LeaveName'];
			
		array_push($sub_att, $attObj);
		
		return $sub_att;
		
	}
	
/*	
		foreach($records as $record)
			$attObj -> u_count[$record['LeaveType']] = $record['UsedCount'];

		SELECT * FROM `attendance_leaves` WHERE SubCode = 102 and LeaveDate between '2014-03-24' and '2014-04-24'
		
	function getLeaveUsedCount($roll)
	{
		$leaves = array();
		
		$obj = new Attendance_Leave_Count();
		
		$records = $obj -> retrieveRecord(null, "RollNo = $roll");
		
		$leaveObj = new Leave_Type();
		
		$leaveObj -> roll_no = $roll;
		
		foreach($records as $record)
		{
			array_push($leaveObj -> leave_type, $record['LeaveDate']);
			array_push($leaveObj -> u_count, $record['UsedCount']);
		}
		
		array_push($leaves, $leaveObj);
		
		return $leaves;
	}
	
*/       

        require_once ("../Libs/Slim/Slim.php");

        \Slim\Slim::registerAutoloader();

        $app = new \Slim\Slim();
		
		$app -> get('/attendanceSummary/:subcode', function($sub) use($app)
        {
            $app -> response() -> header('Content-Type', 'application/json');
            $sub_att = getSubjectAttendance(911604413, $sub);
            echo json_encode($sub_att);
        });
			
		$app -> get('/attendanceSummary', function() use($app)
        {
            $app -> response() -> header('Content-Type', 'application/json');
            $sub_att = getAllSubjectsAttendance(911604413);
            echo json_encode($sub_att);
        });
		
		$app -> get('/attendanceDetailed/:subcode/:start_date/:end_date', function($sub, $strt_date = null, $end_date = null) use($app)
        {
            $app -> response() -> header('Content-Type', 'application/json');
            $sub_att = getSubjectDetailAttendance(911604413, $sub, $strt_date, $end_date);
            echo json_encode($sub_att);
        });
		
		$app -> get('/attendanceDetailed/:subcode', function($sub) use($app)
        {
            $app -> response() -> header('Content-Type', 'application/json');
            $sub_att = getSubjectDetailAttendance(911604413, $sub);
            echo json_encode($sub_att);
        });
		
    $app->run();
?>