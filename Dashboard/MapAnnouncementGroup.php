<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/24/14
 * Time: 9:09 PM
 */
require_once("../Models/Announcement/Announcement_Map_All_Group.php");

$obj = new Announcement_Map_All_Group();
if($obj->captureData()){
    $obj->insertRecord();
}
?>

<html>
<head><title>Map Announcement with Group</title></head>
<body>
<?php
$obj->buildForm("POST");
?>
</body>
</html>