<?php
/**
 * Created by IntelliJ IDEA.
 * User: noahcoomer
 * Date: 11/27/18
 * Time: 3:46 PM
 */

include_once '../db/auth.php';

$db = connectToSQLDatabase();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];
    $username = $_POST['inputUsername'];
    $fname = $_POST['inputFirstName'];
    $lname = $_POST['inputLastName'];

    $sql = "INSERT INTO User(email, password, username, fname, lname) VALUES('$email', '$password', '$username', '$fname', '$lname')";
    if ($result = $db->query($sql)) {
        $sql = "SELECT id FROM User WHERE email='$email'";
        if ($result = $db->query($sql)) {
            $row = $result->fetch_assoc();
            global $uid;
            $uid = $row['id'];
            $db->close();
            header('Location: ../feed.php');
        }
        else {
            $db->close();
            echo "Could not create user. Please try again.";
        }
    } else {
        echo "Could not execute query. Please try again.";
    }
}
