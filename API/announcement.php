<?php
/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 4/28/14
 * Time: 10:40 PM
 */

class Announcement
{
    public $id;
    public $content;
    public $date;
    public $time;
    public $categoryId;
    /*public $groupId = array();
    public $tagId = array();*/
}

function getAnnouncementId($roll)
{
    require_once("../Models/Announcement/Announcement_All.php");
    require_once("../Models/Announcement/Announcement_Category.php");
    require_once("../Models/Announcement/Announcement_Map_All_Group.php");
    require_once("../Models/Announcement/Announcement_Group.php");
    require_once("../Models/Announcement/Announcement_Group_Static.php");

    $allAnn=array();
    $roll=1;

    $obj1=new Announcement_Group_Static();
    $obj2=new Announcement_Map_All_Group();
    $obj3=new Announcement_All();

    //$record=$obj2->retrieveRecordByJoin("AnnouncementId","MembRollNo=$roll",null,$obj1,"GroupId");

  $records=$obj3->retrieveRecordByJoin(null,"Announcement_All.AnnouncementId IN".$obj2->getRetrieveByJoinQuery("AnnouncementId","MembRollNo=$roll",null,$obj1,"GroupId"),null,$obj2,"AnnouncementId");

    foreach($records as $record)
    {
      $annObj=new Announcement();
        $annObj->id=$record['AnnouncementId'];
        array_push($allAnn,$annObj);
    }

    return $allAnn;
}

require_once("../Libs/Slim/Slim.php");

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/newsByCat/:nItems/:catId', function ($nItems,$catId) use ($app) {
    $app->response()->header('Content-Type', 'application/json');
    $roll=$app->request->headers->get('RollNo');
    $newsByCat = getNewsByCat($roll);
    echo json_encode($newsByCat);
});

$app->run();