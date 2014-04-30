<?php

    class Announcement
    {
        public $id;
        public $content;
        public $date;
        public $time;
        public $categoryName;
        public $categoryId;
        public $tags = array();
        public $categories = array();
    }

    function getAnnouncements($roll, $strt_date, $strt_time ,$n_items)
    {
        require_once("../Models/Announcement/Announcement_All.php");
        require_once("../Models/Announcement/Announcement_Category.php");
        require_once("../Models/Announcement/Announcement_Map_All_Group.php");
        require_once("../Models/Announcement/Announcement_Group.php");
        require_once("../Models/Announcement/Announcement_Group_Static.php");
        require_once("../Models/Announcement/Announcement_Tag.php");
        require_once("../Models/Announcement/Announcement_Map_All_Tag.php");

        $allAnn=array();

        $ann_grp_stat = new Announcement_Group_Static();
        $ann_map_grp=new Announcement_Map_All_Group();
        $ann_all=new Announcement_All();

        $records1=$ann_all->retrieveRecordByJoin("distinct Announcement_All.AnnouncementId, Content, Date, Time, CategoryId" ,"Date <= '$strt_date' AND Time <= '$strt_time' AND Announcement_All.AnnouncementId IN".$ann_map_grp->getRetrieveByJoinQuery("AnnouncementId","MembRollNo = '$roll'",null,$ann_grp_stat,"GroupId")," limit 0, $n_items",$ann_map_grp,"AnnouncementId");

        foreach($records1 as $record1)
        {
            $ann_cat =  new Announcement_Category();
            $ann_tag = new Announcement_Tag();
            $ann_map_tag = new Announcement_Map_All_Tag();

            $annObj = new Announcement();
            $annObj->id = $record1['AnnouncementId'];
            $annObj->content = $record1['Content'];
            $annObj -> date = $record1['Date'];
            $annObj -> time = $record1['Time'];
            $catID = $annObj -> categoryId = $record1['CategoryId'];

            $records2 = $ann_cat -> retrieveRecordByJoin(null, "Date <= '$strt_date' AND Time <= '$strt_time' AND Announcement_Category.CategoryId='$catID'", null, $ann_all, "CategoryId");
            foreach($records2 as $record2)
                $annObj -> categoryName = $record2['CategoryName'];

            $records3 = $ann_tag -> retrieveRecordByJoin("TagName, Announcement_Tag.TagId", "Announcement_Tag.TagId in ".$ann_map_tag -> getRetrieveByJoinQuery("TagId", "Announcement_Map_All_Tag.AnnouncementId in".$ann_all->getRetrieveByJoinQuery("Announcement_All.AnnouncementId","Date <= '$strt_date' AND Time <= '$strt_time' AND Announcement_All.AnnouncementId IN".$ann_map_grp->getRetrieveByJoinQuery("AnnouncementId","MembRollNo = '$roll'",null,$ann_grp_stat,"GroupId"),null,$ann_map_grp,"AnnouncementId"), null, $ann_all, "AnnouncementId"), " limit 0, $n_items", $ann_map_tag, "TagId");
            foreach($records3 as $record3)
                $annObj -> tags[$record3['TagName']] = $record3['TagId'];

            $categories = new Announcement_Category();
            $records = $categories -> retrieveRecord();

            foreach($records as $record)
                $annObj -> cat[$record['CategoryName']] = $record['CategoryId'];

            array_push($allAnn,$annObj);
        }

        return $allAnn;
    }

    function getNAnnouncements($roll, $n_items)
    {
        require_once("../Models/Announcement/Announcement_All.php");
        require_once("../Models/Announcement/Announcement_Category.php");
        require_once("../Models/Announcement/Announcement_Map_All_Group.php");
        require_once("../Models/Announcement/Announcement_Group.php");
        require_once("../Models/Announcement/Announcement_Group_Static.php");
        require_once("../Models/Announcement/Announcement_Tag.php");
        require_once("../Models/Announcement/Announcement_Map_All_Tag.php");


        $allAnn=array();

        $ann_grp_stat=new Announcement_Group_Static();
        $ann_map_grp=new Announcement_Map_All_Group();
        $ann_all=new Announcement_All();

        $records1=$ann_all->retrieveRecordByJoin("distinct Announcement_All.AnnouncementId, Content, Date, Time, CategoryId", "Announcement_All.AnnouncementId IN".$ann_map_grp->getRetrieveByJoinQuery("AnnouncementId","MembRollNo = '$roll'",null,$ann_grp_stat,"GroupId")," limit 0, $n_items",$ann_map_grp,"AnnouncementId");

        foreach($records1 as $record1)
        {
            $ann_cat =  new Announcement_Category();
            $ann_tag = new Announcement_Tag();
            $ann_map_tag = new Announcement_Map_All_Tag();

            $annObj = new Announcement();
            $annObj->id = $record1['AnnouncementId'];
            $annObj->content = $record1['Content'];
            $annObj -> date = $record1['Date'];
            $annObj -> time = $record1['Time'];
            $catID = $annObj -> categoryId = $record1['CategoryId'];

            $records2 = $ann_cat -> retrieveRecordByJoin(null, "Announcement_Category.CategoryId='$catID'", null, $ann_all, "CategoryId");
            foreach($records2 as $record2)
                $annObj -> categoryName = $record2['CategoryName'];

            $records3 = $ann_tag -> retrieveRecordByJoin("TagName, Announcement_Tag.TagId", "Announcement_Tag.TagId in ".$ann_map_tag -> getRetrieveByJoinQuery("TagId", "Announcement_Map_All_Tag.AnnouncementId in".$ann_all->getRetrieveByJoinQuery("Announcement_All.AnnouncementId"," Announcement_All.AnnouncementId IN".$ann_map_grp->getRetrieveByJoinQuery("AnnouncementId","MembRollNo='$roll'",null,$ann_grp_stat,"GroupId"),null,$ann_map_grp,"AnnouncementId"), null, $ann_all, "AnnouncementId"), " limit 0, $n_items", $ann_map_tag, "TagId");
            foreach($records3 as $record3)
                $annObj -> tags[$record3['TagName']] = $record3['TagId'];

            $categories = new Announcement_Category();
            $records = $categories -> retrieveRecord();

            foreach($records as $record)
                $annObj -> cat[$record['CategoryName']] = $record['CategoryId'];

            array_push($allAnn,$annObj);
        }

        return $allAnn;
    }

    function getAllAnnouncements($roll)
    {
        require_once("../Models/Announcement/Announcement_All.php");
        require_once("../Models/Announcement/Announcement_Category.php");
        require_once("../Models/Announcement/Announcement_Map_All_Group.php");
        require_once("../Models/Announcement/Announcement_Group.php");
        require_once("../Models/Announcement/Announcement_Group_Static.php");
        require_once("../Models/Announcement/Announcement_Tag.php");
        require_once("../Models/Announcement/Announcement_Map_All_Tag.php");


        $allAnn=array();

        $ann_grp_stat=new Announcement_Group_Static();
        $ann_map_grp=new Announcement_Map_All_Group();
        $ann_all=new Announcement_All();

        $records1=$ann_all->retrieveRecordByJoin("distinct Announcement_All.AnnouncementId, Content, Date, Time, CategoryId", "Announcement_All.AnnouncementId IN".$ann_map_grp->getRetrieveByJoinQuery("AnnouncementId","MembRollNo='$roll''",null,$ann_grp_stat,"GroupId"), null, $ann_map_grp,"AnnouncementId");

        foreach($records1 as $record1)
        {
            $ann_cat =  new Announcement_Category();
            $ann_tag = new Announcement_Tag();
            $ann_map_tag = new Announcement_Map_All_Tag();

            $annObj = new Announcement();
            $annObj->id = $record1['AnnouncementId'];
            $annObj->content = $record1['Content'];
            $annObj -> date = $record1['Date'];
            $annObj -> time = $record1['Time'];
            $catID = $annObj -> categoryId = $record1['CategoryId'];

            $records2 = $ann_cat -> retrieveRecordByJoin(null, "Announcement_Category.CategoryId='$catID'", null, $ann_all, "CategoryId");
            foreach($records2 as $record2)
                $annObj -> categoryName = $record2['CategoryName'];

            $records3 = $ann_tag -> retrieveRecordByJoin("TagName, Announcement_Tag.TagId", "Announcement_Tag.TagId in ".$ann_map_tag -> getRetrieveByJoinQuery("TagId", "Announcement_Map_All_Tag.AnnouncementId in".$ann_all->getRetrieveByJoinQuery("Announcement_All.AnnouncementId"," Announcement_All.AnnouncementId IN".$ann_map_grp->getRetrieveByJoinQuery("AnnouncementId","MembRollNo='$roll'",null,$ann_grp_stat,"GroupId"),null,$ann_map_grp,"AnnouncementId"), null, $ann_all, "AnnouncementId"), null, $ann_map_tag, "TagId");
            foreach($records3 as $record3)
                $annObj -> tags[$record3['TagName']] = $record3['TagId'];

            $categories = new Announcement_Category();
            $records = $categories -> retrieveRecord();

            foreach($records as $record)
                $annObj -> cat[$record['CategoryName']] = $record['CategoryId'];

            array_push($allAnn,$annObj);
        }

        return $allAnn;
    }


    function getAnnouncementsByCategory($roll,$catId, $strt_date, $strt_time, $n_items)
    {
        require_once("../Models/Announcement/Announcement_All.php");
        require_once("../Models/Announcement/Announcement_Category.php");
        require_once("../Models/Announcement/Announcement_Map_All_Group.php");
        require_once("../Models/Announcement/Announcement_Group.php");
        require_once("../Models/Announcement/Announcement_Group_Static.php");
        require_once("../Models/Announcement/Announcement_Tag.php");
        require_once("../Models/Announcement/Announcement_Map_All_Tag.php");


        $allAnn=array();

        $ann_grp_stat=new Announcement_Group_Static();
        $ann_map_grp=new Announcement_Map_All_Group();
        $ann_all=new Announcement_All();

        $records1=$ann_all->retrieveRecordByJoin("distinct Announcement_All.AnnouncementId, Content, Date, Time, CategoryId" ,"CategoryId='$catId' AND Date <= '$strt_date' AND Time <= '$strt_time' AND Announcement_All.AnnouncementId IN".$ann_map_grp->getRetrieveByJoinQuery("AnnouncementId","MembRollNo='$roll'",null,$ann_grp_stat,"GroupId")," limit 0, $n_items",$ann_map_grp,"AnnouncementId");

        foreach($records1 as $record1)
        {
            $annObj=new Announcement();
            $annObj->id = $record1['AnnouncementId'];
            $annObj->content = $record1['Content'];
            $annObj -> date = $record1['Date'];
            $annObj -> time = $record1['Time'];

            $categories = new Announcement_Category();
            $records = $categories -> retrieveRecord();

            foreach($records as $record)
                $annObj -> cat[$record['CategoryName']] = $record['CategoryId'];

            array_push($allAnn,$annObj);
        }

        return $allAnn;
    }

    function getNAnnouncementsByCategory($roll,$catId, $n_items)
    {
        require_once("../Models/Announcement/Announcement_All.php");
        require_once("../Models/Announcement/Announcement_Category.php");
        require_once("../Models/Announcement/Announcement_Map_All_Group.php");
        require_once("../Models/Announcement/Announcement_Group.php");
        require_once("../Models/Announcement/Announcement_Group_Static.php");
        require_once("../Models/Announcement/Announcement_Tag.php");
        require_once("../Models/Announcement/Announcement_Map_All_Tag.php");

        $allAnn=array();

        $ann_grp_stat=new Announcement_Group_Static();
        $ann_map_grp=new Announcement_Map_All_Group();
        $ann_all=new Announcement_All();

        $records1=$ann_all->retrieveRecordByJoin("distinct Announcement_All.AnnouncementId, Content, Date, Time, CategoryId" ,"CategoryId='$catId' AND Announcement_All.AnnouncementId IN".$ann_map_grp->getRetrieveByJoinQuery("AnnouncementId","MembRollNo='$roll'",null,$ann_grp_stat,"GroupId")," limit 0, $n_items",$ann_map_grp,"AnnouncementId");

        foreach($records1 as $record1)
        {
            $annObj=new Announcement();
            $annObj->id = $record1['AnnouncementId'];
            $annObj->content = $record1['Content'];
            $annObj -> date = $record1['Date'];
            $annObj -> time = $record1['Time'];

            $categories = new Announcement_Category();
            $records = $categories -> retrieveRecord();

            foreach($records as $record)
                $annObj -> cat[$record['CategoryName']] = $record['CategoryId'];

            array_push($allAnn,$annObj);
        }

        return $allAnn;
    }


    function getLatestAnnouncements($roll, $last_access)
    {
        require_once("../Models/Announcement/Announcement_All.php");
        require_once("../Models/Announcement/Announcement_Category.php");
        require_once("../Models/Announcement/Announcement_Map_All_Group.php");
        require_once("../Models/Announcement/Announcement_Group.php");
        require_once("../Models/Announcement/Announcement_Group_Static.php");
        require_once("../Models/Announcement/Announcement_Tag.php");
        require_once("../Models/Announcement/Announcement_Map_All_Tag.php");
        require_once("../Models/API/Api_EndUser.php");

        /*$user = new Api_EndUser();

        $records = $user ->retrieveRecord("LastAccess", "UserId = '$roll'", null);

        foreach($records as $record)
            $last_access = $record['LastAccess'];
        */

        $allAnn=array();

        $ann_grp_stat=new Announcement_Group_Static();
        $ann_map_grp=new Announcement_Map_All_Group();
        $ann_all=new Announcement_All();

        $last_access = explode(" ", $last_access);

        $records1=$ann_all->retrieveRecordByJoin("distinct Announcement_All.AnnouncementId, Content, Date, Time, CategoryId" ,"Date >= '$last_access[0]' and  Time >= '$last_access[1]' and Announcement_All.AnnouncementId IN".$ann_map_grp->getRetrieveByJoinQuery("AnnouncementId","MembRollNo='$roll'",null,$ann_grp_stat,"GroupId"),"ORDER BY Date, Time desc",$ann_map_grp,"AnnouncementId");

        foreach($records1 as $record1)
        {
            $ann_cat =  new Announcement_Category();
            $ann_tag = new Announcement_Tag();
            $ann_map_tag = new Announcement_Map_All_Tag();

            $annObj = new Announcement();
            $annObj->id = $record1['AnnouncementId'];
            $annObj->content = $record1['Content'];
            $annObj -> date = $record1['Date'];
            $annObj -> time = $record1['Time'];
            $catID = $annObj -> categoryId = $record1['CategoryId'];

            $records2 = $ann_cat -> retrieveRecordByJoin(null, "Announcement_Category.CategoryId='$catID'", null, $ann_all, "CategoryId");
            foreach($records2 as $record2)
                $annObj -> categoryName = $record2['CategoryName'];

            $records3 = $ann_tag -> retrieveRecordByJoin("TagName, Announcement_Tag.TagId", "Announcement_Tag.TagId in ".$ann_map_tag -> getRetrieveByJoinQuery("TagId", "Announcement_Map_All_Tag.AnnouncementId in".$ann_all->getRetrieveByJoinQuery("Announcement_All.AnnouncementId","Announcement_All.AnnouncementId IN".$ann_map_grp->getRetrieveByJoinQuery("AnnouncementId","MembRollNo='$roll'",null,$ann_grp_stat,"GroupId"),null,$ann_map_grp,"AnnouncementId"), null, $ann_all, "AnnouncementId"), null, $ann_map_tag, "TagId");
            foreach($records3 as $record3)
                $annObj -> tags[$record3['TagName']] = $record3['TagId'];

            $categories = new Announcement_Category();
            $records = $categories -> retrieveRecord();

            foreach($records as $record)
                $annObj -> cat[$record['CategoryName']] = $record['CategoryId'];

            array_push($allAnn,$annObj);
        }

        return $allAnn;
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

    $app->get('/allAnnouncements/:strt_date/:strt_time/:n_items', function ($strt_date,$strt_time,$n_items) use ($app) {
        if(validateHeader($app))
        {
            $app->response()->header('Content-Type', 'application/json');
            $roll=$app->request->headers->get('RollNo');
            $announcements = getAnnouncements($roll, $strt_date, $strt_time, $n_items);
            echo json_encode($announcements);
        }
    });

    $app->get('/allAnnouncements/:n_items', function ($n_items) use ($app) {
        if(validateHeader($app))
        {
            $app->response()->header('Content-Type', 'application/json');
            $roll=$app->request->headers->get('RollNo');
            $n_announcements = getNAnnouncements($roll, $n_items);
            echo json_encode($n_announcements);
        }
    });

    $app->get('/latestAnnouncements', function () use ($app) {
        if($last_access = validateHeader($app))
        {
            $app->response()->header('Content-Type', 'application/json');
            $roll=$app->request->headers->get('RollNo');
            $l_announcements = getLatestAnnouncements($roll, $last_access);
            echo json_encode($l_announcements);
        }
    });

    $app->get('/getAnnouncementsByCategory/:catId/:strt_date/:strt_time/:n_items', function ($catId, $strt_date, $strt_time, $n_items) use ($app) {
        if(validateHeader($app))
        {
            $app->response()->header('Content-Type', 'application/json');
            $roll=$app->request->headers->get('RollNo');
            $newsByCat = getAnnouncementsByCategory($roll,$catId, $strt_date, $strt_time, $n_items);
            echo json_encode($newsByCat);
        }
    });

    $app->get('/getAnnouncementsByCategory/:catId/:n_items', function ($catId, $n_items) use ($app) {
        if(validateHeader($app))
        {
            $app->response()->header('Content-Type', 'application/json');
            $roll=$app->request->headers->get('RollNo');
            $n_newsByCat = getNAnnouncementsByCategory($roll, $catId, $n_items);
            echo json_encode($n_newsByCat);
        }
    });

    $app->run();

?>