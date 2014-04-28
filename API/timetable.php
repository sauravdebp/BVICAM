<?php

/**
 * Created by PhpStorm.
 * User: Pavithra
 * Date: 4/28/14
 * Time: 2:22 PM
 */
class TimeTable
{
    public $subcode;
    public $day;
    public $startTime;
    public $endTime;
    public $date;

}

function returnDate($day)
{
    switch ($day) {
        case 'Monday':
            return 1;
            break;
        case 'Tuesday':
            return 2;
            break;
        case 'Wednesday':
            return 3;
            break;
        case 'Thursday':
            return 4;
            break;
        case 'Friday':
            return 5;
            break;
        case 'Saturday':
            return 6;
            break;
        case 'Sunday':
            return 7;
            break;
        }
    return 0;
}

function showTimeTable($roll)
{
    require_once("../Models/Timetable/Timetable_Permanent.php");
    require_once("../Models/Timetable/Timetable_Temporary.php");
    require_once("../Models/Master/Master_Student.php");
    require_once("../Models/Master/Master_Subject.php");

    $timeTable = array();

    $ttablePermanent = new Timetable_Permanent();
    $ttableTemporary = new Timetable_Temporary();


    $recordsPermanent = $ttablePermanent->retrieveRecord(null, null, null);
    $recordsTemporary = $ttableTemporary->retrieveRecord(null, null, null);

    foreach ($recordsPermanent as $recordPermanent) {
            $tobj = new TimeTable();
            $tobj->subcode = $recordPermanent['SubCode'];
            $tobj->startTime = $recordPermanent['StartTime'];
            $tobj->endTime = $recordPermanent['EndTime'];
            $tobj->day = $recordPermanent['Day'];
            foreach ($recordsTemporary as $recordTemporary) {
                $t = new TimeTable();
                $t->date = $recordTemporary['Date'];
                $t->subcode = $recordTemporary['SubCode'];
                $t->startTime = $recordTemporary['StartTime'];
                $t->endTime = $recordTemporary['EndTime'];
                $dt = new DateTime($t->date);
                $d = returnDate($dt->format('l'));
            if($tobj->day == $d && $tobj->startTime==$t->startTime && $tobj->endTime==$t->endTime)
            {
                $tobj->subcode = $t->subcode;
                $tobj->startTime = $t->startTime;
                $tobj->endTime = $t->endTime;
            }

        }
        array_push($timeTable, $tobj);

        }


    return $timeTable;
}


require_once("../Libs/Slim/Slim.php");

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/timetable', function () use ($app) {
    $app->response()->header('Content-Type', 'application/json');
    $roll=$app->request->headers->get('RollNo');
    $timeTable = showTimeTable($roll);
    echo json_encode($timeTable);
});

$app->run();