<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 8:11 PM
 */

require_once(dirname(__FILE__)."/../Model.php");

class Announcement_Category extends Model{
    public function __construct($categoryName=null) {
        parent::__construct();
        $this->tablename = "announcement_category";
        $this->primaryKey = "CategoryId";
        $this->attribs['CategoryId'] = null;
        $this->attribs['CategoryName'] = $categoryName;
    }

    public function setData($datas) {
        parent::setData($datas);
    }
}

