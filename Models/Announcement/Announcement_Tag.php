<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:17 PM
 */

require_once(dirname(__FILE__)."/../Model.php");
require_once(dirname(__FILE__)."/../Announcement/Announcement_Category.php");

class Announcement_Tag extends Model{
    public function __construct() {
        parent::__construct($tagId=null, $categoryId=null);
        $this->tablename = "announcement_tag";
        $this->primaryKey = "TagId";
        $this->attribs['TagId'] = $tagId;
        $this->attribs['TagName'] = null;
        $this->attribs['CategoryId'] = $categoryId;
        $this->attribFlags['CategoryId']['FK'] = new Announcement_Category();
        $this->attribFlags['CategoryId']['FK_optionAttr'] = "CategoryName";
    }

    public function setData($datas) {
        parent::setData($datas);
    }
} 