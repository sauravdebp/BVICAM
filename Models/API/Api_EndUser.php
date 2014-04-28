<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:18 PM
 */

require_once(dirname(__FILE__)."/../Model.php");
require_once(dirname(__FILE__)."/../Master/Master_Student.php");
require_once(dirname(__FILE__)."/../API/API_Developer.php");

class Api_EndUser extends Model{
    public function __construct($userId=null, $developerId=null) {
        parent::__construct();
        $this->tablename = "api_enduser";
        $this->attribs['UserId'] = $userId;
        $this->attribFlags['UserId']['FK'] = new Master_Student();
        $this->attribs['DeveloperId'] = $developerId;
        $this->attribFlags['DeveloperId']['FK'] = new Api_Developer();
        $this->attribs['LastAccess'] = "NOW()";
        $this->attribFlags['LastAccess']['isfunc'] = true;
        $this->attribs['AccountStatus'] = null;
    }

    public function setData($datas) {
        parent::setData($datas);
    }
}