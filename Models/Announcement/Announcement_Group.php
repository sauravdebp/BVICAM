<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:08 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Announcement_Group extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "announcement_group";
        $this->attribs['GroupId'] = null;
        $this->attribs['GroupName'] = null;
    }

    public function setData($groupId, $groupName) {
        $this->attribs['GroupId'] = $groupId;
        $this->attribs['GroupName'] = $groupName;
    }
}