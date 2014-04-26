<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/24/14
 * Time: 9:32 PM
 */
require_once "../Models/Announcement/Announcement_Tag.php";
$obj = new Announcement_Tag();
if($obj->form->captureData()) {
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