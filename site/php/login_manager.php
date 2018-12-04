<?php
/**
 * Created by IntelliJ IDEA.
 * User: noahcoomer
 * Date: 11/27/18
 * Time: 2:48 PM
 */

include_once '../db/auth.php';

$db = connectToSQLDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input_email = $_POST['inputEmail'];
    $input_pw = $_POST['inputPassword'];

    $sql = "SELECT id, password FROM User WHERE email='" . $input_email . "';";
    if ($result = $db->query($sql)) {
        $row = $result->fetch_assoc();
        if ($row['password'] == $input_pw) {
            // Here is where we would perform a password hash
            $uid = $row['id'];
            header('Location: ../feed.php?uid=' . $uid);
        } else {
            echo "Invalid password. Please try again.";
        }
    } else {
        echo "Email not found. Please sign up.";
    }
}
