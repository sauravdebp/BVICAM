<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 12:47 AM
 */
include_once("../Models/Master/Master_Student.php");
$studentObj = new Master_Student();
if($studentObj->form->captureData()) {
    $studentObj->insertRecord();
}
else {
    echo"Fill Up the Form";
}
?>

<html>
<head>
    <title>Add Student</title>
</head>
<body>
<?php
$obj = new Master_Student();
$obj->form->buildForm("POST");
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