<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:16 PM
 */

require_once(dirname(__FILE__)."/../Model.php");
require_once(dirname(__FILE__)."/../Announcement/Announcement_All.php");
require_once(dirname(__FILE__)."/../Announcement/Announcement_Group.php");

class Announcement_Map_All_Group extends Model{
    public function __construct($announcementId=null, $groupId=null) {
        parent::__construct();
        $this->tablename = "announcement_map_all_group";
        $this->attribs['AnnouncementId'] = $announcementId;
        $this->attribFlags['AnnouncementId']['FK'] = new Announcement_All();
        $this->attribs['GroupId'] = $groupId;
        $this->attribFlags['GroupId']['FK'] = new Announcement_Group();
    }

    public function setData($datas) {
        parent::setData($datas);
    }
} 