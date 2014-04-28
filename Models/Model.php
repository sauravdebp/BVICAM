<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 5:30 PM
 */
require_once "Utils/FormBuilder.php";

abstract class Model {
    protected $attribs = array();
    public function Attribs() {
        return $this->attribs;
    }
    protected $attribFlags = array();
    public function AttribFlags() {
        return $this->attribFlags;
    }
    protected $primaryKey;
    public function PrimaryKey() {
        return $this->primaryKey;
    }
    protected $mysql_host;
    protected $mysql_user;
    protected $mysql_pass;
    protected $dbname;
    protected $tablename;
    public function Tablename() {
        return $this->tablename;
    }
    public $form;
    protected $collection = array();

    public function __construct() {
        $this->mysql_host = "localhost";
        $this->mysql_user = "root";
        $this->mysql_pass = "";
        $this->dbname = "bvicam";
        $this->form = new FormBuilder($this);
    }

    /*
     * Creates a mysqli connection and executes the query provided as argument.
     * Parameters : $query - A SQL query string
     * Return Value : An mysqli_result() object on success. Null on failure.
     */
    protected function fireQuery($query) {
        try{
            $con = mysqli_connect($this->mysql_host, $this->mysql_user, $this->mysql_pass, $this->dbname);
            if(!$con) {
                throw new Exception("Failed to connect to mysql: " . mysqli_connect_error());
            }
            $result =  mysqli_query($con, $query);
            if(!$result) {
                throw new Exception("Failed to fire query $query<br>: " . mysqli_error($con));
            }
            mysqli_close($con);
            return $result;
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
        return null;
    }

    /*
     * Sets the attribute values of the current instance.
     * Parameters : $datas - An associative array with the indexes containing valid attribute names.
     * Return Value : None
     */
    public function setData($datas) {
        foreach($datas as $attr=>$val) {
            /*if(!isset($this->attribs[$attr]))
                throw new Exception("$attr not an attribute of $this->tablename");*/
            $this->attribs[$attr] = $val;
        }
    }

    /*
     * Inserts the current values of attributes into table.
     * Parameters : None
     * Return Value : None
     */
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

    /*
     * Retrieves records that satisfy condition in $cond and retrieves only those attributes specified in $attribs.
     * Parameters : $attribs - Comma separated attribute names which are to be retrieved
     *              $cond - A condition string for identifying which rows to be retrieved
     *              $extraQuery - Extra query keywords like ORDER BY, GROUP BY etc..
     * Return Value : An array of associative arrays.
     */
    public function retrieveRecord($attribs=null, $cond=null, $extraQuery=null) {
        $query = $this->getRetrieveQuery($attribs, $cond, $extraQuery);
        $result = $this->fireQuery($query);
        while($row=mysqli_fetch_assoc($result)){
            array_push($this->collection, $row);
        }
        return $this->collection;
    }

    /*
     * Retrieves by joining two relations. Second relation is given as the first parameter.
     * Parameters : $joinRelnObj - An object of the relation with which the current relation will be joined
     *              $joinAttrib - Attribute name on which join is to be performed
     *              $attribs - same as retrieveRecord()
     *              $cond - same as retrieveRecord()
     *              $extraQuery - same as retrieveRecord()
     */
    public function retrieveRecordByJoin($attribs=null, $cond=null, $extraQuery=null, $joinRelnObj, $joinAttrib) {
        $query = $this->getRetrieveByJoinQuery($attribs, $cond, $extraQuery, $joinRelnObj, $joinAttrib);
        $result = $this->fireQuery($query);
        while($row=mysqli_fetch_assoc($result)){
            array_push($this->collection, $row);
        }
        return $this->collection;
    }

    public function getRecord() {
        return array_pop($this->collection);
    }

    public function getRetrieveByJoinQuery($attribs=null, $cond=null, $extraQuery=null, $joinRelnObj, $joinAttrib) {
        $dirty = " $this->tablename.Dirty='0' AND $joinRelnObj->tablename.Dirty='0'";
        if($cond != null)
            $dirty = " AND" . $dirty;
        return $this->buildRetrieveQuery($attribs, $cond.$dirty, $extraQuery, $joinRelnObj, $joinAttrib);
    }

    public function getRetrieveQuery($attribs=null, $cond=null, $extraQuery=null) {
        $dirty = " Dirty='0'";
        if($cond != null)
            $dirty = " AND" . $dirty;
        return $this->buildRetrieveQuery($attribs, $cond.$dirty, $extraQuery);
    }

    private function buildRetrieveQuery() {
        require_once("Utils/QueryBuilder.php");
        $attribs = func_get_arg(0);
        $cond = func_get_arg(1);
        $extraQuery = func_get_arg(2);
        //$dirty = ($cond==null) ? " Dirty='0'" : " AND Dirty='0'";
        $select = QueryBuilder_SELECT($attribs);
        $from = QueryBuilder_FROM($this->tablename);
        $where = QueryBuilder_WHERE($cond);
        if(func_num_args() == 5) {
            $joinRelnObj = func_get_arg(3);
            $joinAttrib = func_get_arg(4);
            $from = "FROM $this->tablename JOIN $joinRelnObj->tablename ON $this->tablename.$joinAttrib = $joinRelnObj->tablename.$joinAttrib ";
        }
        $query = sprintf("(%s)", rtrim($select . $from . $where . $extraQuery, " "));
        return $query;
    }

    /*
     * Updates the values of the attributes given in the $attribs parameter for rows matching the condition given in $cond parameter.
     * Parameters : $attribs - Comma separated attribute names whose values are to be updated. If null then all attributes are updated
     *              $cond - A condition string for identifying which rows to be updated. Essentially the Where part of a SQL query without the "WHERE"
     * Return Value : Same as fireQuery().
     */
    public function updateRecord($attribs=null, $cond=null) {
        require_once("Utils/QueryBuilder.php");
        $query = "UPDATE " . $this->tablename . " ";
        $set = QueryBuilder_SET($attribs, $this);
        $cond = QueryBuilder_WHERE($cond);
        $query .= $set . $cond;
        echo $query;
        return $this->fireQuery($query);
    }
}

