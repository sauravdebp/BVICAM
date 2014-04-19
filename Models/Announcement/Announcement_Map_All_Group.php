<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:16 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Announcement_Map_All_Group extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "announcement_map_all_group";
        $this->attribs['AnnouncementId'] = null;
        $this->attribs['GroupId'] = null;
    }

    public function setData($announcementId, $groupId) {
        $this->attribs['AnnouncementId'] = $announcementId;
        $this->attribs['GroupId'] = $groupId;
    }
} 