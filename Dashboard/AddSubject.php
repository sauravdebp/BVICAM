<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 1:15 AM
 */
include_once("../Models/Master/Master_Subject.php");
$obj = new Master_Subject();
if($obj->form->captureData()) {
    if(!$obj->insertRecord())
        echo "Error inserting data!";
}
?>

<html>
<head>
    <title>Add Subject</title>
</head>
<body>
<?php
$obj->form->buildForm("GET");
?>
<table>
    <?php
    $records = $obj->retrieveRecord();
    $row = "";
    while($record = $obj->getRecord()) {
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