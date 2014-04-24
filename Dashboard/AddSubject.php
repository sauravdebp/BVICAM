<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 1:15 AM
 */
include_once("../Models/Master/Master_Subject.php");
$subjectObj = new Master_Subject();
if($subjectObj->captureData()) {
    if(!$subjectObj->insertRecord())
        echo "Error inserting data!";
}
?>

<html>
<head>
    <title>Add Subject</title>
</head>
<body>
<?php
$subjectObj->buildForm("GET");
?>
</body>
</html>