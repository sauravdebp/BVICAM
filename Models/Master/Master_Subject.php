<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:19 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Master_Subject extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "master_subject";
        $this->attribs['SubCode'] = null;
        $this->attribs['SubName'] = null;
        $this->attribs['Semester'] = null;
    }

    public function setData($subCode, $subName, $semester) {
        $this->attribs['SubCode'] = $subCode;
        $this->attribs['SubName'] = $subName;
        $this->attribs['Semester'] = $semester;
    }
} 