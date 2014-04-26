<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 12:13 AM
 */
require_once("Models/Master/Master_Subject.php");
require_once("Models/Master/Master_Student.php");

$subObj = new Master_Subject();
$stuObj = new Master_Student(null, null, 1);

//$stuObj->updateRecord("Semester", "RollNo=5411604413");

$records = $stuObj->retrieveRecordByJoin($subObj, "Semester","RollNo, SubCode", "RollNo='5411604413'");
$row = "";
foreach($records as $record) {
    $row .= "<tr>";
    foreach($record as $col=>$val) {
        $row .= "<td>$val</td>";
    }
    $row .= "</tr>";
}
echo "<table border=1>" . $row . "</table>";

