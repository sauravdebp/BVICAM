<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/24/14
 * Time: 9:29 PM
 */
require_once("../Models/Announcement/Announcement_Map_All_Tag.php");

$obj = new Announcement_Map_All_Tag();
if($obj->captureData()){
    $obj->insertRecord();
}
?>

<html>
<head><title>Map Announcement with Tag</title></head>
<body>
<?php
$obj->buildForm("POST");
?>
</body>
</html>