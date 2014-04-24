<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:15 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Announcement_Group_Dynamic extends Model {
    public function __construct($groupId=null, $scriptSrc=null) {
        parent::__construct();
        $this->tablename = "announcement_group_dynamic";
        $this->attribs['GroupId'] = $groupId;
        $this->attribs['ScriptSource'] = $scriptSrc;
    }

    public function setData($datas) {
        parent::setData($datas);
    }
} 