<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:19 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Attendance_Leave_Count extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "attendance_leave_count";
        $this->attribs['RollNo'] = null;
        $this->attribs['LeaveType'] = null;
        $this->attribs['UsedCount'] = null;
    }

    public function setData($rollNo, $leaveType, $usedCount) {
        $this->attribs['RollNo'] = $rollNo;
        $this->attribs['LeaveType'] = $leaveType;
        $this->attribs['UsedCount'] = $usedCount;
    }
} 