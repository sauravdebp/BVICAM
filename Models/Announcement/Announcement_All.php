<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 6:00 PM
 */

include_once(dirname(__FILE__)."/../Model.php");
class Announcement_All extends Model{

    public function __construct(){
        parent::__construct();
        $this->tablename = "announcement_all";
        $this->attribs['AnnouncementId'] = null;
        $this->attribs['Content'] = null;
        $this->attribs['Date'] = "CURRENT_DATE()";
        $this->attribFlags['Date']['isfunc'] = true;
        $this->attribs['Time'] = "CURRENT_TIME()";
        $this->attribFlags['Time']['isfunc'] = true;
        $this->attribs['CategoryId'] = null;
    }

    public function setData($announcementId, $content, $categoryId) {
        $this->attribs['AnnouncementId'] = $announcementId;
        $this->attribs['Content'] = $content;
        $this->attribs['CategoryId'] = $categoryId;
    }
}

