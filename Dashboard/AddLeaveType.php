<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 3:48 PM
 */
include_once("../Models/Attendance/Attendance_Leave_Type.php");
$attObj = new Attendance_Leave_Type();
if($attObj->captureData()) {
    $attObj->insertRecord();
}
?>

<html>
<head>
    <title>Add Attendance Type</title>
</head>
<body>
<?php
$attObj->buildForm("GET");
?>
</body>
</html>