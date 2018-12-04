<?php
/**
 * Created by IntelliJ IDEA.
 * User: noahcoomer
 * Date: 11/29/18
 * Time: 4:35 PM
 */

include_once '../db/auth.php';

$db = connectToSQLDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $text = $_POST['inputComment'];
    $user_id = $GLOBALS['uid'];
    $sql = 'INSERT INTO Comment(user_id, tweet_id, text) VALUES($user_id, $text, z);';
    if ($result = $db->query($sql)) {
        header('Location: ../feed.php?error=false');
    } else {
        header('Location: ../feed.php?error=true');
    }
} else {
    echo "Invalid request method. Please try again.";
}