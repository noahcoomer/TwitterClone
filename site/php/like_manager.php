<?php
/**
 * Created by IntelliJ IDEA.
 * User: noahcoomer
 * Date: 12/4/18
 * Time: 1:46 AM
 */

include_once '../db/auth.php';

$db = connectToSQLDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = $_GET['uid'];
    $tweet_id = $_GET['tweet'];
    $sql = 'INSERT INTO Likes(user_id, tweet_id) VALUES(' . $user_id . ', ' . $tweet_id . ');';
    if ($result = $db->query($sql)) {
        header('Location: ../feed.php?uid=' . $user_id . '&error=false');
    } else {
        header('Location: ../feed.php?uid=' . $user_id . '&error=true');
    }
} else {
    echo "Invalid request method. Please try again.";
}