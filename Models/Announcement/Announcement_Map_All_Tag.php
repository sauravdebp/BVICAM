<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:17 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Announcement_Map_All_Tag extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "announcement_map_all_tag";
        $this->attribs['AnnouncementId'] = null;
        $this->attribs['TagId'] = null;
    }

    public function setData($announcementId, $tagId) {
        $this->attribs['AnnouncementId'] = $announcementId;
        $this->attribs['TagId'] = $tagId;
    }
} 