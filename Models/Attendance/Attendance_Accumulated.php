<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:18 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Attendance_Accumulated extends Model{
    public function __construct($rollNo=null, $subCode=null) {
        parent::__construct();
        $this->tablename = "attendance_accumulated";
        $this->attribs['RollNo'] = $rollNo;
        $this->attribs['SubCode'] = $subCode;
        $this->attribs['PresentCount'] = null;
        $this->attribs['AbsentCount'] = null;
    }

    public function setData($datas) {
        parent::setData($datas);
    }
} 