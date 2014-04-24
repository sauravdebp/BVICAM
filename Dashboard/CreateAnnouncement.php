<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/24/14
 * Time: 8:21 PM
 */
require_once ("../Models/Announcement/Announcement_All.php");
$obj = new Announcement_All();
if($obj->captureData()) {
    $obj->insertRecord();
    header('Location: '.dirname(__FILE__));
}
else {
    echo "Enter Announcement Details";
}
?>

<html>
<head><title>Create Announcement</title></head>
<body>
<?php
$obj->buildForm("POST");
?>
</body>
</html>