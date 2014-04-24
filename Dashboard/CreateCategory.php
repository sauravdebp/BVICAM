<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/24/14
 * Time: 9:36 PM
 */
require_once "../Models/Announcement/Announcement_Category.php";
$obj = new Announcement_Category();
if($obj->captureData()) {
    $obj->insertRecord();
}
else {
    echo "Enter Group Details";
}
?>

<html>
<head><title>Create Category</title></head>
<body>
<?php
$obj->buildForm("POST");
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