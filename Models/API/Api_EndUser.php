<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:18 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Api_EndUser extends Model{
    public function __construct() {
        parent::__construct();
        $this->tablename = "api_enduser";
        $this->attribs['UserId'] = null;
        $this->attribs['DeveloperId'] = null;
        $this->attribs['LastAccess'] = null;
        $this->attribs['AccountStatus'] = null;
    }

    public function setData($userId, $developerId, $lastAccess, $accountStatus) {
        $this->attribs['UserId'] = $userId;
        $this->attribs['DeveloperId'] = $developerId;
        $this->attribs['LastAccess'] = $lastAccess;
        $this->attribs['AccountStatus'] = $accountStatus;
    }
}