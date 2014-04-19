<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 8:11 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Announcement_Category extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "announcement_category";
        $this->attribs['CategoryId'] = null;
        $this->attribs['CategoryName'] = null;
    }

    public function setData($categoryId, $categoryName) {
        $this->attribs['CategoryId'] = $categoryId;
        $this->attribs['CategoryName'] = $categoryName;
    }
}

