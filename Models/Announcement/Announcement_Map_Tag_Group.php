<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:17 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Announcement_Map_Tag_Group extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "announcement_map_tag_group";
        $this->attribs['TagId'] = null;
        $this->attribs['GroupId'] = null;
    }

    public function setData($tagId, $groupId) {
        $this->attribs['TagId'] = $tagId;
        $this->attribs['GroupId'] = $groupId;
    }
} 