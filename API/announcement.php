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
    public $categoryName;
    public $categoryId;
    public $tags = array();
    /*public $groupId = array();
    public $tagId = array();*/
}

function getAnnouncements($roll,$strt_date,$strt_time,$n_items)
{
    require_once("../Models/Announcement/Announcement_All.php");
    require_once("../Models/Announcement/Announcement_Category.php");
    require_once("../Models/Announcement/Announcement_Map_All_Group.php");
    require_once("../Models/Announcement/Announcement_Group.php");
    require_once("../Models/Announcement/Announcement_Group_Static.php");
    require_once("../Models/Announcement/Announcement_Tag.php");
    require_once("../Models/Announcement/Announcement_Map_All_Tag.php");


    $allAnn=array();
    //$roll=911604413;

    $obj1=new Announcement_Group_Static();
    $obj2=new Announcement_Map_All_Group();
    $obj3=new Announcement_All();

    //$record=$obj2->retrieveRecordByJoin("AnnouncementId","MembRollNo=$roll",null,$obj1,"GroupId");

    $records1=$obj3->retrieveRecordByJoin("distinct Announcement_All.AnnouncementId, Content, Date, Time, CategoryId" ,"Date <= '$strt_date' AND Time <= '$strt_time' AND Announcement_All.AnnouncementId IN".$obj2->getRetrieveByJoinQuery("AnnouncementId","MembRollNo=$roll",null,$obj1,"GroupId")," limit 0, $n_items",$obj2,"AnnouncementId");
    //$query = $obj3->getRetrieveByJoinQuery("distinct Announcement_All.AnnouncementId, Content, Date, Time" ,"Announcement_All.AnnouncementId IN".$obj2->getRetrieveByJoinQuery("AnnouncementId","MembRollNo=$roll",null,$obj1,"GroupId"),null,$obj2,"AnnouncementId");
   //$query = $obj3->getRetrieveByJoinQuery(null,"Announcement_All.AnnouncementId, GroupId IN".$obj2->getRetrieveByJoinQuery("AnnouncementId, Announcement_Map_All_Group.GroupId","MembRollNo=$roll","group by AnnouncementId",$obj1,"GroupId"),null,$obj2,"AnnouncementId");
    //$query = $obj2->getRetrieveByJoinQuery("AnnouncementId, Announcement_Map_All_Group.GroupId","MembRollNo=$roll",null,$obj1,"GroupId");
    //echo $query;

    foreach($records1 as $record1)
    {
        $annObj=new Announcement();
        $obj4 =  new Announcement_Category();
        $obj5 = new Announcement_Tag();
        $obj6 = new Announcement_Map_All_Tag();

        $annObj = new Announcement();
        $annID = $annObj->id = $record1['AnnouncementId'];
        $annObj->content = $record1['Content'];
        $annObj -> date = $record1['Date'];
        $annObj -> time = $record1['Time'];
        $catID = $annObj -> categoryId = $record1['CategoryId'];

        $records2 = $obj4 -> retrieveRecordByJoin(null, "Date <= '$strt_date' AND Time <= '$strt_time' AND Announcement_Category.CategoryId='$catID'", null, $obj3, "CategoryId");
        foreach($records2 as $record2)
            $annObj -> categoryName = $record2['CategoryName'];

        $records3 = $obj5 -> retrieveRecordByJoin("TagName, Announcement_Tag.TagId", "Announcement_Tag.TagId in ".$obj6 -> getRetrieveByJoinQuery("TagId", "Announcement_Map_All_Tag.AnnouncementId in".$obj3->getRetrieveByJoinQuery("Announcement_All.AnnouncementId","Date <= '$strt_date' AND Time <= '$strt_time' AND Announcement_All.AnnouncementId IN".$obj2->getRetrieveByJoinQuery("AnnouncementId","MembRollNo='$roll'",null,$obj1,"GroupId"),null,$obj2,"AnnouncementId"), null, $obj3, "AnnouncementId"), " limit 0, $n_items", $obj6, "TagId");
        foreach($records3 as $record3)
            $annObj -> tags[$record3['TagName']] = $record3['TagId'];

        array_push($allAnn,$annObj);
    }

    return $allAnn;
}


function getNewsByCat($roll,$catId, $strt_date, $strt_time, $n_items)
{
    require_once("../Models/Announcement/Announcement_All.php");
    require_once("../Models/Announcement/Announcement_Category.php");
    require_once("../Models/Announcement/Announcement_Map_All_Group.php");
    require_once("../Models/Announcement/Announcement_Group.php");
    require_once("../Models/Announcement/Announcement_Group_Static.php");
    require_once("../Models/Announcement/Announcement_Tag.php");
    require_once("../Models/Announcement/Announcement_Map_All_Tag.php");

    $roll = 1;
    $allAnn=array();
    $obj1=new Announcement_Group_Static();
    $obj2=new Announcement_Map_All_Group();
    $obj3=new Announcement_All();
    $records1=$obj3->retrieveRecordByJoin("distinct Announcement_All.AnnouncementId, Content, Date, Time, CategoryId" ,"CategoryId='$catId' AND Date <= '$strt_date' AND Time <= '$strt_time' AND Announcement_All.AnnouncementId IN".$obj2->getRetrieveByJoinQuery("AnnouncementId","MembRollNo=$roll",null,$obj1,"GroupId")," limit 0, $n_items",$obj2,"AnnouncementId");
    foreach($records1 as $record1)
    {
        $annObj=new Announcement();
        $annID = $annObj->id = $record1['AnnouncementId'];
        $annObj->content = $record1['Content'];
        $annObj -> date = $record1['Date'];
        $annObj -> time = $record1['Time'];
        array_push($allAnn,$annObj);
    }
    return $allAnn;
}

function getLatestNews($roll)
{
    require_once("../Models/Announcement/Announcement_All.php");
    require_once("../Models/Announcement/Announcement_Category.php");
    require_once("../Models/Announcement/Announcement_Map_All_Group.php");
    require_once("../Models/Announcement/Announcement_Group.php");
    require_once("../Models/Announcement/Announcement_Group_Static.php");
    require_once("../Models/Announcement/Announcement_Tag.php");
    require_once("../Models/Announcement/Announcement_Map_All_Tag.php");
    require_once("../Models/API/Api_EndUser.php");

    $user = new Api_EndUser();

    $last_access = $user ->retrieveRecord("LastAccess", "UserId = '$roll'", null);
    $allAnn=array();
    //$roll=911604413;

    $obj1=new Announcement_Group_Static();
    $obj2=new Announcement_Map_All_Group();
    $obj3=new Announcement_All();

    //$record=$obj2->retrieveRecordByJoin("AnnouncementId","MembRollNo=$roll",null,$obj1,"GroupId");

    $records1=$obj3->retrieveRecordByJoin("distinct Announcement_All.AnnouncementId, Content, Date, Time, CategoryId" ,"Date >= '$last_access' and Announcement_All.AnnouncementId IN".$obj2->getRetrieveByJoinQuery("AnnouncementId","MembRollNo=$roll",null,$obj1,"GroupId"),"ORDER BY Date ORDER BY Time",$obj2,"AnnouncementId");
    //$query = $obj3->getRetrieveByJoinQuery("distinct Announcement_All.AnnouncementId, Content, Date, Time" ,"Announcement_All.AnnouncementId IN".$obj2->getRetrieveByJoinQuery("AnnouncementId","MembRollNo=$roll",null,$obj1,"GroupId"),null,$obj2,"AnnouncementId");
    //$query = $obj3->getRetrieveByJoinQuery(null,"Announcement_All.AnnouncementId, GroupId IN".$obj2->getRetrieveByJoinQuery("AnnouncementId, Announcement_Map_All_Group.GroupId","MembRollNo=$roll","group by AnnouncementId",$obj1,"GroupId"),null,$obj2,"AnnouncementId");
    //$query = $obj2->getRetrieveByJoinQuery("AnnouncementId, Announcement_Map_All_Group.GroupId","MembRollNo=$roll",null,$obj1,"GroupId");
    //echo $query;

    foreach($records1 as $record1)
    {
        $annObj=new Announcement();
        $obj4 =  new Announcement_Category();
        $obj5 = new Announcement_Tag();
        $obj6 = new Announcement_Map_All_Tag();

        $annObj = new Announcement();
        $annID = $annObj->id = $record1['AnnouncementId'];
        $annObj->content = $record1['Content'];
        $annObj -> date = $record1['Date'];
        $annObj -> time = $record1['Time'];
        $catID = $annObj -> categoryId = $record1['CategoryId'];

        $records2 = $obj4 -> retrieveRecordByJoin(null, "Announcement_Category.CategoryId='$catID'", null, $obj3, "CategoryId");
        foreach($records2 as $record2)
            $annObj -> categoryName = $record2['CategoryName'];

        $records3 = $obj5 -> retrieveRecordByJoin("TagName, Announcement_Tag.TagId", "Announcement_Tag.TagId in ".$obj6 -> getRetrieveByJoinQuery("TagId", "Announcement_Map_All_Tag.AnnouncementId in".$obj3->getRetrieveByJoinQuery("Announcement_All.AnnouncementId","Announcement_All.AnnouncementId IN".$obj2->getRetrieveByJoinQuery("AnnouncementId","MembRollNo='$roll'",null,$obj1,"GroupId"),null,$obj2,"AnnouncementId"), null, $obj3, "AnnouncementId"), null, $obj6, "TagId");
        foreach($records3 as $record3)
            $annObj -> tags[$record3['TagName']] = $record3['TagId'];

        array_push($allAnn,$annObj);
    }

    return $allAnn;
}





require_once("../Libs/Slim/Slim.php");

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/allAnnouncements/:strt_date/:strt_time/:n_items', function ($strt_date,$strt_time,$n_items) use ($app) {
    $app->response()->header('Content-Type', 'application/json');
    $roll=$app->request->headers->get('RollNo');
    $newsByCat = getAnnouncements($roll,$strt_date,$strt_time,$n_items);
    echo json_encode($newsByCat);

});

$app->get('/getNewsByCat/:catId/:strt_date/:strt_time/:n_items', function ($catId, $strt_date, $strt_time, $n_items) use ($app) {
    $app->response()->header('Content-Type', 'application/json');
    $roll=$app->request->headers->get('RollNo');
    $newsByCat = getNewsByCat($roll,$catId, $strt_date, $strt_time, $n_items);
    echo json_encode($newsByCat);
 });

$app->get('/latestNews', function () use ($app) {
    $app->response()->header('Content-Type', 'application/json');
    $roll=$app->request->headers->get('RollNo');
    $latestNews = getLatestNews($roll);
    echo json_encode($latestNews);

});

$app->run();