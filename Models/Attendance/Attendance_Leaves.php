<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:18 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Attendance_Leaves extends Model{
    public function __construct($rollNo=null, $subCode=null, $leaveType=null, $leaveDate=null) {
        parent::__construct();
        $this->tablename = "attendance_leaves";
        $this->attribs['RollNo'] = null;
        $this->attribs['SubCode'] = null;
        if($leaveDate=null) {
            $this->attribs['LeaveDate'] = "CURRENT_DATE()";
            $this->attribFlags['LeaveDate']['isfunc'] = $leaveType;
        }
        else
            $this->attribs['LeaveDate'] = $leaveDate;
        $this->attribs['LeaveType'] = null;
    }

    public function setData($datas) {
        parent::setData($datas);
    }
} 