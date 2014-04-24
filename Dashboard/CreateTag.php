<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/24/14
 * Time: 9:32 PM
 */
require_once "../Models/Announcement/Announcement_Tag.php";
$obj = new Announcement_Tag();
if($obj->captureData()) {
    $obj->insertRecord();
}
else {
    echo "Enter Group Details";
}
?>

<html>
<head><title>Create Tag</title></head>
<body>
<?php
$obj->buildForm("POST");
?>
</body>
</html>