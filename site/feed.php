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



?>

<html>
    <head>
        <?php echo file_get_contents('common/header.html')
        ?>
    </head>
    <body>
        <?php $currentPage = "feed"; include('common/nav.php'); ?>
        <div class="container">
            <?php foreach ($tweets as $tweet) { ?>
                <div>
                    <h1><?php echo $tweet['user_id']; ?></h1>
                    <p><?php echo $tweet['text']; ?></p>
                </div>
            <?php } ?>
        </div>
    </body>
</html>
