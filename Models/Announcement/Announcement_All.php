<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 6:00 PM
 */

include_once(dirname(__FILE__)."/../Model.php");
include_once(dirname(__FILE__)."/../Announcement/Announcement_Category.php");

class Announcement_All extends Model{
    public $extraAttribs = array();
    public $extraAttribsFlags = array();
    public function __construct($content=null, $categoryId=null){
        parent::__construct();
        $this->tablename = "announcement_all";
        $this->primaryKey = "AnnouncementId";
        $this->attribs['AnnouncementId'] = null;
        $this->attribs['Content'] = $content;
        $this->attribs['Date'] = "CURRENT_DATE()";
        $this->attribFlags['Date']['isfunc'] = true;
        $this->attribs['Time'] = "CURRENT_TIME()";
        $this->attribFlags['Time']['isfunc'] = true;
        $this->attribs['CategoryId'] = $categoryId;
        $this->attribFlags['CategoryId']['FK'] = new Announcement_Category();
        $this->attribFlags['CategoryId']['FK_optionAttr'] = "CategoryName";
        $this->extraAttribs['Group'] = array();
        $this->extraAttribs['Tag'] = array();
    }

    public function setData($datas) {
        parent::setData($datas);
    }
}

