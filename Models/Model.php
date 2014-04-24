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
    protected $primaryKey;
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
        try{
            $con = mysqli_connect($this->mysql_host, $this->mysql_user, $this->mysql_pass, $this->dbname);
            if(!$con) {
                throw new Exception("Failed to connect to mysql: " . mysqli_connect_error());
            }
            $result =  mysqli_query($con, $query);
            if(!$result) {
                throw new Exception("Failed to fire query: " . mysqli_error($con));
            }
            mysqli_close($con);
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
        return $result;
    }

    public function setData($datas) {
        foreach($datas as $attr=>$val) {
            $this->attribs[$attr] = $val;
        }
    }

    public function insertRecord() {
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
        return $this->fireQuery($query);
    }

    public function retrieveRecord($attribs=null, $cond=null) {
        if($cond == null)
            $dirty = " Dirty='0'";
        else
            $dirty = " AND Dirty='0'";
        $query = $this->buildRetrieveQuery($attribs, $cond.$dirty);
        $result = $this->fireQuery($query);
        $allRows = array();
        while($row=mysqli_fetch_assoc($result)){
            array_push($allRows, $row);
        }
        return $allRows;
    }

    public function buildRetrieveQuery($attribs=null,$cond=null) {
        include_once("Utils/QueryBuilder.php");
        $select = QueryBuilder_SELECT($attribs);
        $from = "FROM " . $this->tablename . " ";
        $where = QueryBuilder_WHERE($cond);
        $query = rtrim($select . $from . $where, " ");
        $query = sprintf("(%s)", $query);
        return $query;
    }

    public function updateRecord($attribs=null, $cond=null) {
        $query = "UPDATE " . $this->tablename . " ";
        $set = QueryBuilder_SET($attribs, $this->attribs);
        $cond = QueryBuilder_WHERE($cond);
        $query .= $set . $cond;

        return $this->fireQuery($query);
    }

    public function buildForm($method) {
        $form = "<form name=\"".$this->tablename."\" method=\"$method\">";
        $table = "<table>";
        foreach($this->attribs as $col=>$val) {
            $table .= $this->getInputRow($col);
        }
        $table .= "<tr><td colspan=\"2\"><input type=\"submit\" name=\"".$this->tablename."_submit\"></td></tr>";
        $table .= "</table>";
        $form .= $table . "</form>";
        echo $form;
    }

    public function getInputRow($col) {
        $row = "";
        if(isset($this->attribFlags[$col]['isfunc']))
            return "";
        if(isset($this->attribFlags[$col]['FK'])) {
            $objectType = $this->attribFlags[$col]['FK'];
            $obj = new $objectType;
            $options = $obj->retrieveRecord();
            $row = "<tr><td>$col</td>";
            $row .= "<td><select name=\"".$obj->primaryKey."\">";
            foreach($options as $option) {
                $row.= "<option value=\"".$option[$obj->primaryKey]."\">".
                        (
                            isset($this->attribFlags[$col]['FK_optionAttr'])?
                                $option[$this->attribFlags[$col]['FK_optionAttr']]:
                                $option[$obj->primaryKey]
                        ).
                        "</option>";
            }
            $row .= "</select></td>";
            $row .= "</tr>";
        }
        else {
            $row = "<tr>";
            $row .= "<td>$col</td>";
            $row .= "<td><input type=\"text\" name=\"$col\"></td>";
            $row .= "</tr>";
        }
        return $row;
    }

    public function captureData() {
        if(isset($_GET[$this->tablename."_submit"])) {
            $formData = $_GET;
        }
        else if(isset($_POST[$this->tablename."_submit"])) {
            $formData = $_POST;
        }
        else
            return false;
        foreach($this->attribs as $col=>$val) {
            if(!isset($this->attribFlags[$col]['isfunc']))
                $this->attribs[$col] = $formData[$col];
        }
        return true;
    }
}

