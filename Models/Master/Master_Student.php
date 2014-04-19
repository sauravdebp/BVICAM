<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:19 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Master_Student extends Model{
    private $validData = false;
    public function __construct() {
        parent::__construct();
        $this->tablename = "master_student";
        $this->attribs['RollNo'] = null;
        $this->attribs['Batch'] = null;
        $this->attribs['Semester'] = null;
        $this->attribs['FirstName'] = null;
        $this->attribs['LastName'] = null;
        $this->attribs['Email'] = null;
        $this->attribs['PhoneNo'] = null;
    }

    public function setData($rollNo, $batch, $semester, $firstName, $lastName, $email, $phoneNo) {
        if($semester >= 1 && $semester <= 6)
            $this->validData = true;

        $this->attribs['RollNo'] = $rollNo;
        $this->attribs['Batch'] = $batch;
        $this->attribs['Semester'] = $semester;
        $this->attribs['FirstName'] = $firstName;
        $this->attribs['LastName'] = $lastName;
        $this->attribs['Email'] = $email;
        $this->attribs['PhoneNo'] = $phoneNo;
    }

    public function insertData() {
        if(!$this->validData) {
            return false;
        }
        else
            parent::insertData();
    }
} 