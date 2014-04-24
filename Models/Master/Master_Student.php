<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:19 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Master_Student extends Model{
    public function __construct($rollNo=null, $batch=null, $semester=null, $firstName=null, $lastName=null, $email=null, $phoneNo=null) {
        parent::__construct();
        $this->tablename = "master_student";
        $this->primaryKey = "RollNo";
        $this->attribs['RollNo'] = $rollNo;
        $this->attribs['Batch'] = $batch;
        $this->attribs['Semester'] = $semester;
        $this->attribs['FirstName'] = $firstName;
        $this->attribs['LastName'] = $lastName;
        $this->attribs['Email'] = $email;
        $this->attribs['PhoneNo'] = $phoneNo;
    }

    public function setData($datas) {
        parent::setData($datas);
    }
} 