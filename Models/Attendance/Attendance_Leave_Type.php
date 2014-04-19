<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 11:11 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Attendance_Leave_Type extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "attendance_leave_type";
        $this->attribs['LeaveType'] = null;
        $this->attribs['LeaveName'] = null;
        $this->attribs['MaxLeaves'] = null;
    }

    public function setData($leaveType, $leaveName, $maxLeaves) {
        $this->attribs['LeaveType'] = $leaveType;
        $this->attribs['LeaveName'] = $leaveName;
        $this->attribs['MaxLeaves'] = $maxLeaves;
    }
} 