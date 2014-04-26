<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 3:48 PM
 */
include_once("../Models/Attendance/Attendance_Leave_Type.php");
$obj = new Attendance_Leave_Type();
if($obj->form->captureData()) {
    $obj->insertRecord();
}
?>

<html>
<head>
    <title>Add Attendance Type</title>
</head>
<body>
<?php
$obj->form->buildForm("GET");
?>
<table>
    <?php
    $records = $obj->retrieveRecord();
    $row = "";
    foreach($records as $record) {
        $row .= "<tr>";
        foreach($record as $col=>$val) {
            $row .= "<td>$val</td>";
        }
        $row .= "</tr>";
    }
    echo "<table border=1>" . $row . "</table>";
    ?>
</table>
</body>
</html>