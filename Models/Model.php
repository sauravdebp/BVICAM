<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 5:30 PM
 */

abstract class Model {
    protected $attribs = array();
    protected $attribFlags = array();
    protected $mysql_host;
    protected $mysql_user;
    protected $mysql_pass;
    protected $dbname;
    protected $tablename;

    public function __construct() {
        $this->mysql_host = "localhost";
        $this->mysql_user = "root";
        $this->mysql_pass = "";
        $this->dbname = "bvicam";
    }

    protected function fireQuery($query) {
        $con = mysqli_connect($this->mysql_host, $this->mysql_user, $this->mysql_pass, $this->dbname);
        if(!$con) {
            die("Failed to connect to mysql: " . mysqli_connect_error());
        }
        $result =  mysqli_query($con, $query);
        if(!$result) {
            die("Failed to fire query: " . mysqli_error($con));
        }
        mysqli_close($con);
        return $result;
    }

    public function insertData() {
        $query = "INSERT INTO " . $this->tablename;
        $cols = "";
        $vals = "";
        foreach($this->attribs as $col=>$val) {
            $cols .= $col . ",";
            if(isset($this->attribFlags[$col]['isfunc']))
                $vals .= $val . ",";
            else
                $vals .= "'" . $val . "',";
        }
        $cols = rtrim($cols, ",");
        $vals = rtrim($vals, ",");
        $cols = sprintf(" (%s) ", $cols);
        $vals = sprintf(" VALUES(%s);", $vals);
        $query .= $cols . $vals;
        //echo $query . "<br>";
        return $this->fireQuery($query);
    }

    public function retrieveAllRecords() {
        $query = "SELECT * FROM " . $this->tablename;
        $result = $this->fireQuery($query);
        $allRows = array();
        while($row=mysqli_fetch_assoc($result)){
            array_push($allRows, $row);
        }
        return $allRows;
    }

    public function filterRetrieve($cond) {
        $query = "SELECT * FROM " . $this->tablename . " $cond";
        $result = $this->fireQuery($query);
        $allRows = array();
        while($row=mysqli_fetch_assoc($result)){
            array_push($allRows, $row);
        }
        return $allRows;
    }

    public function updateRecord($cond) {
        $query = "UPDATE " . $this->tablename;
        $set = " SET ";
        foreach($this->attribs as $col=>$val) {
            if($val != NULL) {
                if(isset($this->attribFlags[$col]['isfunc']))
                    $set .= "$col=$val,";
                else
                    $set .= "$col='$val',";
            }
        }
        $set = rtrim($set, ",");
        $set = sprintf("%s ", $set);
        $query .= $set . $cond;
        return $this->fireQuery($query);
    }
}

