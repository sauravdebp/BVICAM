<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 4/20/14
 * Time: 12:24 AM
 */

?>

<html>
<head>
    <title>Create Announcement</title>
</head>
<body>
<form>
    <table>
        <tr>
            <td>Announcement ID</td>
            <td><input type="text"></td>
        </tr>
        <tr>
            <td>Category</td>
            <td>
                <select>
                    <?php
                    include_once("../Models/Announcement/Announcement_Category.php");
                    $catObj = new Announcement_Category();
                    $categories = $catObj->retrieveAllRecords();
                    foreach($categories as $category) {
                        echo "<option>".$category['CategoryName']."</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Target Groups
            </td>
            <td>
                <ul style="list-style-type: none;">
                    <?php
                    include_once("../Models/Announcement/Announcement_Group.php");
                    $groupObj = new Announcement_Group();
                    $groups = $groupObj->retrieveAllRecords();
                    foreach($groups as $group) {
                        echo "<li><input type=\"checkbox\">".$group['GroupName']."</li>";
                    }
                    ?>
                </ul>
            </td>
        </tr>
        <tr>
            <td>
                Announcement
            </td>
            <td>
                <textarea></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit">
            </td>
        </tr>
    </table>
</form>
</body>
</html>