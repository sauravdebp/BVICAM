<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 1:04 PM
 */
include_once("../Models/API/Api_Developer.php");
$developerObj = new Api_Developer();
if($developerObj->captureData()) {
    if(!$developerObj->insertRecord())
        echo "Error inserting data";
}
?>

<html>
<head>
    <title>Add Developer</title>
</head>
<body>
<?php
$developerObj->buildForm("GET");
?>
</body>
</html>