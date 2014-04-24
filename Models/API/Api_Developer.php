<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 10:18 PM
 */

include_once(dirname(__FILE__)."/../Model.php");

class Api_Developer extends Model{
    public function __construct($developerId=null, $apiKey=null) {
        parent::__construct();
        $this->tablename = "api_developer";
        $this->primaryKey = "DeveloperId";
        $this->attribs['DeveloperId'] = $developerId;
        $this->attribs['API_Key'] = $apiKey;
    }

    public function setData($datas) {
        parent::setData($datas);
    }
} 