<?php
/**
 * Created by IntelliJ IDEA.
 * User: noahcoomer
 * Date: 11/15/18
 * Time: 5:54 PM
 */

function connectToSQLDatabase(){
    $dbhost = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "britton11";
    $dbname = "TwitterClone";

    // Create connection
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);

    return $conn;
}
