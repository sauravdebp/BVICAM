<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:18 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Api_EndUser extends Model{
    public function __construct($userId=null, $developerId=null) {
        parent::__construct();
        $this->tablename = "api_enduser";
        $this->attribs['UserId'] = $userId;
        $this->attribs['DeveloperId'] = $developerId;
        $this->attribs['LastAccess'] = null;
        $this->attribs['AccountStatus'] = null;
    }

    public function setData($datas) {
        parent::setData($datas);
    }
}