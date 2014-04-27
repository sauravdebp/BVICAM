<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/24/14
 * Time: 9:29 PM
 */
require_once("../Models/Announcement/Announcement_Map_All_Tag.php");

$obj = new Announcement_Map_All_Tag();
if($obj->form->captureData()){
    $obj->insertRecord();
}
?>

<html>
<head><title>Map Announcement with Tag</title></head>
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