<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/24/14
 * Time: 8:21 PM
 */
require_once ("../Models/Announcement/Announcement_All.php");
$obj = new Announcement_All();
if($obj->form->captureData()) {
    $obj->insertRecord();
}
else {
    echo "Enter Announcement Details";
}
?>

<html>
<head><title>Create Announcement</title></head>
<body>
<?php
$obj->form->buildForm("POST");
?>
<table>
    <?php
    $records = $obj->retrieveRecord(null, null, "ORDER BY date DESC ,time DESC");
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