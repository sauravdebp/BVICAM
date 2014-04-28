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

function QueryBuilder_SET($attribs, $obj) {
    $setQuery = "SET ";
    $attribArr = array();
    if($attribs != null) {
        $attribs = explode(",", $attribs);
        foreach($attribs as $attrib) {
            $attribArr[$attrib] = $obj->Attribs()[$attrib];
        }
    }
    else {
        $attribArr = $obj->Attribs();
    }
    foreach($attribArr as $col=>$val) {
        $attribFlags = $obj->AttribFlags();
        if(!isset($attribFlags[$col]['isfunc'])) {
            $val = "'" . trim($val) . "'";
        }
        $setQuery .= trim($col) . "=$val,";
    }


    return sprintf("%s ", rtrim($setQuery, ","));
}