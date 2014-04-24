<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:19 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Attendance_Leave_Count extends Model{
    public function __construct($rollNo=null, $leaveType=null) {
        parent::__construct();
        $this->tablename = "attendance_leave_count";
        $this->attribs['RollNo'] = $rollNo;
        $this->attribs['LeaveType'] = $leaveType;
        $this->attribs['UsedCount'] = null;
    }

    public function setData($datas) {
        parent::setData($datas);
    }
} 