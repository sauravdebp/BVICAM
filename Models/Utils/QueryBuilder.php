<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 9:13 PM
 */

function QueryBuilder_SELECT($attribs) {
    if(!$attribs)
        $attribs = "*";
    return "SELECT $attribs ";
}

function QueryBuilder_WHERE($cond) {
    if(!$cond)
        return "";
    return "WHERE $cond ";

    /*$noofArgs = func_num_args();
    if($noofArgs%2 == 0) {
        die("Invalid number of arguments to QueryBuilder_WHERE()");
    }
    $query = "WHERE ";
    if($noofArgs == 1) {
        $query .= $cond;
    }
    else {
        $args = func_get_args();
        $filters = array();
        for($i=2; $i<$noofArgs; $i+=2) {
            $filters[$args[$i-1]] = $args[$i];
        }
        foreach($filters as $col=>$val) {
            $query .= "$col='".$val."' $cond ";
        }
        $query = rtrim($query, " $cond");
    }
    return sprintf("%s;", $query);*/
}

function QueryBuilder_SET($attribs, $attribVals=array()) {
    $setQuery = "SET ";
    if($attribs != null) {
        $attribArr = explode(",", $attribs);
        for($i=0; $i<count($attribArr); $i++) {
            $setQuery .= trim($attribArr[$i]) . "='" . $attribVals[trim($attribArr[$i])] . "',";
        }
    }
    else {
        foreach($attribVals as $attrib=>$val) {
            $setQuery .= $attrib . "='" . $val . "',";
        }
    }
    return sprintf("%s ", rtrim($setQuery, ","));
}