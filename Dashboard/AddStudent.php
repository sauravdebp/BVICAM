<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 12:47 AM
 */
include_once("../Models/Master/Master_Student.php");
$studentObj = new Master_Student();
if($studentObj->captureData()) {
    $studentObj->insertRecord();
}
else {
    echo"Fill Up the Form";
    /*if(isset($_POST))
        echo "<h1>".$_POST['txt_RollNo']."</h1>";
    if(isset($_GET))
        echo "<h1>".$_POST['txt_RollNo']."</h1>";*/
}
?>

<html>
<head>
    <title>Add Student</title>
</head>
<body>
<?php
$studentObj = new Master_Student();
$studentObj->buildForm("POST");
?>
</body>
</html>