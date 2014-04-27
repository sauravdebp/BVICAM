<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/19/14
 * Time: 6:46 PM
 */

/*class Announcement {
    public $id;
    public $content;
    public $date;
    public $time;
    public $categoryId;
    public $groupId = array();
    public $tagId = array();
}

function getAllAnnouncements() {
    require_once("Announcement/Announcement_All.php");
    require_once("Announcement/Announcement_Map_All_Group.php");
    require_once("Announcement/Announcement_Map_All_Tag.php");
    $allAnn = array();
    $obj = new Announcement_All();
    $obj->retrieveRecord(null, null, "ORDER BY Date DESC, Time DESC");
    while($record = $obj->getRecord()) {
        $annObj = new Announcement();
        $annObj->id = $record['AnnouncementId'];
        $annObj->content = $record['Content'];
        $annObj->date = $record['Date'];
        $annObj->time = $record['Time'];
        $annObj->categoryId = $record['CategoryId'];

        $mapAllGroupObj = new Announcement_Map_All_Group();
        $groups = $mapAllGroupObj->retrieveRecord(null, "AnnouncementId='$annObj->id'");
        foreach($groups as $group) {
            array_push($annObj->groupId, $group['GroupId']);
        }
        $mapAllTagObj = new Announcement_Map_All_Tag();
        $tags = $mapAllTagObj->retrieveRecord(null, "AnnouncementId='$annObj->id'");
        foreach($tags as $tag) {
            array_push($annObj->tagId, $tag['TagId']);
        }
        array_push($allAnn, $annObj);
    }
    return $allAnn;
}

require_once ("../Libs/Slim/Slim.php");

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/announcements', function() use($app) {
    $app->response()->header('Content-Type', 'application/json');
    $allAnn = getAllAnnouncements();
    echo json_encode($allAnn);
});

$app->run();*/

class TimeTable
{
    public $subcode;
    public $day;
    public $startTime;
    public $endTime;

}

function showTimeTable()
{
    require_once("Timetable/Timetable_Permanent.php");
    require_once("Timetable/Timetable_Temporary.php");
    $timeTable=array();
    $ttable=new Timetable_Permanent();
    $records = $ttable->retrieveRecord(null, null,null);
    foreach($records as $record) {
        $tobj= new TimeTable();
        $tobj->subcode=$record['SubCode'];
        $tobj->day=$record['Day'];
        $tobj->startTime=$record['StartTime'];
        $tobj->endTime=$record['EndTime'];
        array_push($timeTable,$tobj);
    }
    return $timeTable;
}

require_once ("../Libs/Slim/Slim.php");

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/timetable', function() use($app) {
    $app->response()->header('Content-Type', 'application/json');
    $timeTable = showTimeTable();
    echo json_encode($timeTable);
});

$app->run();