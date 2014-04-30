<?php

    class TimeTable
    {
        public $subcode;
        public $day;
        public $startTime;
        public $endTime;
        public $subname;
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

        $obj1=new Master_Student();
        $obj2=new Master_Subject();
        $obj3=new Timetable_Permanent();
        $obj4=new Timetable_Temporary();

        $recordsPermanent=$obj3->retrieveRecordByJoin(null,"Master_Subject.subCode IN".$obj2->getRetrieveByJoinQuery("SubCode","RollNo=$roll",null,$obj1,"Semester"),null,$obj2,"SubCode");
        $recordsTemporary=$obj4->retrieveRecordByJoin(null,"Master_Subject.subCode IN".$obj2->getRetrieveByJoinQuery("SubCode","RollNo=$roll",null,$obj1,"Semester"),null,$obj2,"SubCode");

        foreach ($recordsPermanent as $recordPermanent) {
                $tobj = new TimeTable();
                $subCode=$tobj->subcode = $recordPermanent['SubCode'];
                $tobj->startTime = $recordPermanent['StartTime'];
                $tobj->endTime = $recordPermanent['EndTime'];
                $tobj->day = $recordPermanent['Day'];
                $obj2->retrieveRecordByJoin("SubName","RollNo=$roll AND SubCode=$subCode",null,$obj1,"Semester");

                $tobj->subname=$recordPermanent['SubName'];
                foreach ($recordsTemporary as $recordTemporary) {
                    $t = new TimeTable();
                    $date = $recordTemporary['Date'];
                    $subCode=$t->subcode = $recordTemporary['SubCode'];
                    $t->startTime = $recordTemporary['StartTime'];
                    $t->endTime = $recordTemporary['EndTime'];
                    $obj2->retrieveRecordByJoin("SubName","RollNo=$roll AND SubCode=$subCode",null,$obj1,"Semester");
                    $t->subname=$recordTemporary['SubName'];
                    $dt = new DateTime($date);
                    $d = returnDate($dt->format('l'));
                if($tobj->day == $d && $tobj->startTime==$t->startTime && $tobj->endTime==$t->endTime)
                {
                    $tobj->subcode = $t->subcode;
                    $tobj->startTime = $t->startTime;
                    $tobj->endTime = $t->endTime;
                    $tobj->subname=$t->subname;
                }

            }
            array_push($timeTable, $tobj);

            }


        return $timeTable;

    }

    function validateHeader($app)
    {
        require_once("../Models/API/API_Developer.php");
        require_once("../Models/API/API_EndUser.php");

        $roll = $app->request->headers->get('RollNo');
        $api_key = $app->request->headers->get('APIKey');
        $dev_id = $app->request->headers->get('DeveloperId');

        $api_dev = new Api_Developer();

        $records1 = $api_dev -> retrieveRecord(null, "DeveloperId = '$dev_id'");

        $last_access = null;

        if($records1)
        {
            foreach($records1 as $record1)
            {
                if($record1['API_Key'] == $api_key)
                {
                    $api_end = new Api_EndUser();

                    $records2 = $api_end -> retrieveRecord(null, "UserId = '$roll'");

                    foreach($records2 as $record2)
                        if($record2['UserId'] == $roll)
                        {
                            $last_access = $record2['LastAccess'];
                            $api_end -> updateRecord("LastAccess", "UserId = '$roll'");
                        }
                }
            }
        }

        return $last_access;
    }


    require_once("../Libs/Slim/Slim.php");

    \Slim\Slim::registerAutoloader();

    $app = new \Slim\Slim();

    $app->get('/timetable', function () use ($app) {
        if(validateHeader($app))
        {
            $app->response()->header('Content-Type', 'application/json');
            $roll=$app->request->headers->get('RollNo');
            $timeTable = showTimeTable($roll);
            echo json_encode($timeTable);
        }
    });

    $app->run();
?>