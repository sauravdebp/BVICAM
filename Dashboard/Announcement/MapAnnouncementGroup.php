<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/24/14
 * Time: 9:09 PM
 */
require_once("../Models/Announcement/Announcement_Map_All_Group.php");

$obj = new Announcement_Map_All_Group();
if($obj->form->captureData()){
    $obj->insertRecord();
}
?>

<html>
<head><title>Map Announcement with Group</title></head>
<body>
<?php
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