<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 12:47 AM
 */
if(isset($_GET) && isset($_GET['formSubmit'])) {
    include_once("../Models/Master/Master_Student.php");
    $studentObj = new Master_Student();
    $studentObj->setData($_GET['txt_rollno'], $_GET['txt_batch'], $_GET['txt_semester'], $_GET['txt_firstname'], $_GET['txt_lastname'], $_GET['txt_email'], $_GET['txt_phone']);
    if(!$studentObj->insertData())
        echo ("Error Inserting Data");
}
?>

<html>
<head>
    <title>Add Student</title>
</head>
<body>
<form name="newStudentForm" method="get">
    <table>
        <tr>
            <td>
                Roll No.
            </td>
            <td>
                <input type="text" name="txt_rollno">
            </td>
        </tr>
        <tr>
            <td>
                Batch
            </td>
            <td>
                <input type="text" name="txt_batch">
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
            <td>
                First Name
            </td>
            <td>
                <input type="text" name="txt_firstname">
            </td>
        </tr>
        <tr>
            <td>
                Last Name
            </td>
            <td>
                <input type="text" name="txt_lastname">
            </td>
        </tr>
        <tr>
            <td>
                Email
            </td>
            <td>
                <input type="text" name="txt_email">
            </td>
        </tr>
        <tr>
            <td>
                Phone No
            </td>
            <td>
                <input type="text" name="txt_phone">
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