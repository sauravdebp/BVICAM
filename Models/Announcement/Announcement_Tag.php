<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:17 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Announcement_Tag extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "announcement_tag";
        $this->attribs['TagId'] = null;
        $this->attribs['TagName'] = null;
        $this->attribs['CategoryId'] = null;
    }

    public function setData($tagId, $tagName, $categoryId) {
        $this->attribs['TagId'] = $tagId;
        $this->attribs['TagName'] = $tagName;
        $this->attribs['CategoryId'] = $categoryId;
    }
} 