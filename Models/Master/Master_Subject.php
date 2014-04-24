<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:19 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Master_Subject extends Model{
    public function __construct($subCode=null, $subName=null, $semester=null) {
        parent::__construct();
        $this->tablename = "master_subject";
        $this->attribs['SubCode'] = $subCode;
        $this->attribs['SubName'] = $subName;
        $this->attribs['Semester'] = $semester;
    }

    public function setData($datas) {
        parent::setData($datas);
    }
} 