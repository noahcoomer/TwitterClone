<?php
/**
 * Created by IntelliJ IDEA.
 * User: noahcoomer
 * Date: 11/15/18
 * Time: 8:06 PM
 */
    include_once './db/auth.php';
    $db = connectToSQLDatabase();

    // TODO: Create a feed based object based on who the user follows

    // Select the users that the current user is following
    // Create an assoc array that has usernames associated to ids

    $tweets = [];
    $sql = "SELECT * FROM Tweet";
    $result = $db->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $tweets[] = $row;
            // Select the comments based on the tweet id
            // Add the comments to a sub-assoc array for each tweet OR create another array of tweet ids and do this separately
        }
    }
    $result->close();

    $uids = array();
    $name_sql = "SELECT id, fname, lname FROM User";
    $name_result = $db->query($sql);
    if ($name_result) {
        while ($row = $name_result->fetch_assoc()) {
            $str = (string) $row['id'];
            echo $str;
            $uids[$str] = $row['fname'] . ' ' . $row['lname'];
        }
    }
    echo var_dump($uids);
?>

<html>
    <head>
        <?php echo file_get_contents('common/header.html'); ?>
    </head>
    <body class="bg-light">
        <?php $currentPage = "feed"; include('common/nav.php'); ?>
        <div class="container">
            <h1>Feed</h1>
            <br>
            <?php foreach ($tweets as $tweet) { ?>

                <div class="border border-secondary rounded bg-white" style="padding-left: .5em">
                    <h2><?php echo $uids[(string)$tweet['user_id']]; ?></h2>
                    <p><?php echo $tweet['text']; ?></p>
                </div>
                <br>
            <?php } ?>
        </div>
    </body>
</html>
