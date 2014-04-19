<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:15 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Announcement_Group_Dynamic extends Model {
    public function __construct() {
        parent::__construct();
        $this->tablename = "announcement_group_dynamic";
        $this->attribs['GroupId'] = null;
        $this->attribs['ScriptSource'] = null;
    }

    public function setData($groupId, $scriptSrc) {
        $this->attribs['GroupId'] = $groupId;
        $this->attribs['ScriptSource'] = $scriptSrc;
    }
} 