<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 1:04 PM
 */
include_once("../Models/API/Api_Developer.php");
$obj = new Api_Developer();
if($obj->form->captureData()) {
    if(!$obj->insertRecord())
        echo "Error inserting data";
}
?>

<html>
<head>
    <title>Add Developer</title>
</head>
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