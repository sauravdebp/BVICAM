<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 12:13 AM
 */
include("Models/Announcement.php");
include("Models/Utils/QueryBuilder.php");

$announce = new Announcement_Tag();
$announce->setData("T001", "DS", "C001");
$announce->insertData();
$announce->setData("T002", "C++", "C001");
$announce->insertData();
$announce->setData("T003", "NSC", "C002");
$announce->insertData();
$announce->setData("T004", "Education Day", "C002");
$announce->insertData();