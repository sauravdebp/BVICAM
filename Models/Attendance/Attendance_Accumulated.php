<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:18 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Attendance_Accumulated extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "attendance_accumulated";
        $this->attribs['RollNo'] = null;
        $this->attribs['SubCode'] = null;
        $this->attribs['PresentCount'] = null;
        $this->attribs['AbsentCount'] = null;
    }

    public function setData($rollNo, $subCode, $presentCount, $absentCount) {
        $this->attribs['RollNo'] = $rollNo;
        $this->attribs['SubCode'] = $subCode;
        $this->attribs['PresentCount'] = $presentCount;
        $this->attribs['AbsentCount'] = $absentCount;
    }
} 