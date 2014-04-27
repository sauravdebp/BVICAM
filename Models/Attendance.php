<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 11:39 PM
 */
$dir = "Attendance";
require_once("$dir/Attendance_Accumulated.php");
require_once("$dir/Attendance_Leave_Count.php");
require_once("$dir/Attendance_Leave_Type.php");
require_once("$dir/Attendance_Leaves.php");
require_once("Model.php");

class SubjectAttendance {
    private $attAcc = array();
    private $attLeaves = array();
    private $subCode;

    public function __construct($subCode) {
        $this->subCode = $subCode;
    }

    public function getAttendanceAcc() {
        require_once("Master/Master_Student.php");
        require_once("Master/Master_Subject.php");
        $objAtt = new Attendance_Accumulated();
        $objStu = new Master_Student();
        $objSub = new Master_Subject();
        $this->attAcc = $objAtt->retrieveRecord(null, "SubCode='$this->subCode' AND RollNo IN " . $objStu->getRetrieveByJoinQuery("RollNo", "SubCode='$this->subCode'", null, $objSub, "Semester"));

    }
}