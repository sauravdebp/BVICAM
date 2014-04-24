<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:17 PM
 */

require_once(dirname(__FILE__)."/../Model.php");
require_once(dirname(__FILE__)."/../Announcement/Announcement_All.php");
require_once(dirname(__FILE__)."/../Announcement/Announcement_Tag.php");

class Announcement_Map_All_Tag extends Model{
    public function __construct($announcementId=null, $tagId=null) {
        parent::__construct();
        $this->tablename = "announcement_map_all_tag";
        $this->attribs['AnnouncementId'] = $announcementId;
        $this->attribFlags['AnnouncementId']['FK'] = new Announcement_All();
        $this->attribs['TagId'] = $tagId;
        $this->attribFlags['TagId']['FK'] = new Announcement_Tag();
    }

    public function setData($datas) {
        parent::setData($datas);
    }
} 