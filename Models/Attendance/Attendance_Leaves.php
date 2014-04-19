<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:18 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Attendance_Leaves extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "attendance_leaves";
        $this->attribs['RollNo'] = null;
        $this->attribs['SubCode'] = null;
        $this->attribs['LeaveDate'] = null;
        $this->attribs['LeaveType'] = null;
    }

    public function setData($rollNo, $subCode, $leaveDate, $leaveType) {
        $this->attribs['RollNo'] = $rollNo;
        $this->attribs['SubCode'] = $subCode;
        $this->attribs['LeaveDate'] = $leaveDate;
        $this->attribs['LeaveType'] = $leaveType;
    }
} 