<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 1:15 AM
 */

if(isset($_GET) && isset($_GET['formSubmit'])) {
    include_once("../Models/Master/Master_Subject.php");
    $subjectObj = new Master_Subject();
    $subjectObj->setData($_GET['txt_subcode'], $_GET['txt_subname'], $_GET['txt_semester']);
    if(!$subjectObj->insertData())
        echo ("Error Inserting Data");
}
?>

<html>
<head>
    <title>Add Subject</title>
</head>
<body>
<form name="newSubjectForm" method="get">
    <table>
        <tr>
            <td>
                Subject Code
            </td>
            <td>
                <input type="text" name="txt_subcode">
            </td>
        </tr>
        <tr>
            <td>
                Subject Name
            </td>
            <td>
                <input type="text" name="txt_subname">
            </td>
        </tr>
        <tr>
            <td>
                Semester
            </td>
            <td>
                <input type="text" name="txt_semester">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" name="formSubmit">
            </td>
        </tr>
    </table>
</form>
</body>
</html>