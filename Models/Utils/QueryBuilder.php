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

function QueryBuilder_FROM($tablename) {
    $from = "FROM ";
    foreach(func_get_args() as $table){
        $from .= "$table,";
    }
    return sprintf("%s ", rtrim($from, ","));
}

function QueryBuilder_WHERE($cond) {
    if(!$cond)
        return "";
    return "WHERE $cond ";
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