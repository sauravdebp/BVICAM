<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:20 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Timetable_Temporary extends Model{
    public function __construct($subCode=null, $date=null, $startTime=null, $endTime=null) {
        parent::__construct();
        $this->tablename = "timetable_permanent";
        $this->attribs['SubCode'] = $subCode;
        $this->attribs['Date'] = $date;
        $this->attribs['StartTime'] = $startTime;
        $this->attribs['EndTime'] = $endTime;
    }

    public function setData($datas) {
        parent::setData($datas);
    }
} 