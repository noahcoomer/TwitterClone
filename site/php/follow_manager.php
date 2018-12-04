<?php
/**
 * Created by IntelliJ IDEA.
 * User: noahcoomer
 * Date: 12/4/18
 * Time: 1:34 AM
 */

include_once '../db/auth.php';

$db = connectToSQLDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = $_GET['uid'];
    $follow_id = $_GET['follow'];
    $sql = 'INSERT INTO Follows_User(user_id, following_id) VALUES(' . $user_id . ', ' . $follow_id . ');';
    if ($result = $db->query($sql)) {
        header('Location: ../users.php?uid=' . $user_id . '&error=false');
    } else {
        header('Location: ../users.php?uid=' . $user_id . '&error=true');
    }
} else {
    echo "Invalid request method. Please try again.";
}