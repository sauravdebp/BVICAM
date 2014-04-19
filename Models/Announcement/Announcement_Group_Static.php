<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:16 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Announcement_Group_Static extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "announcement_group_static";
        $this->attribs['GroupId'] = null;
        $this->attribs['MembRollNo'] = null;
    }

    public function setData($groupId, $membRollNo) {
        $this->attribs['GroupId'] = $groupId;
        $this->attribs['MembRollNo'] = $membRollNo;
    }
} 