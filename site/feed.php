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

    $uid = $_GET['uid'];
    $follows = [];
    $sql = "SELECT following_id FROM Follows_User WHERE user_id=$uid";
    $result = $db->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            array_push($follows, $row['following_id']);
        }
    }

    $uids = '';
    if (!empty($follows)) {
        $uids = $follows[0];
    }
    for ($i = 1; $i < count($follows); $i += 1) {
        $uids .= ', ' . $follows[$i];
    }
    $tweets = [];
    $sql = "SELECT t.tweet_id, t.user_id, t.text, t.date_created, u.fname, u.lname 
            FROM Tweet t INNER JOIN USER u ON t.user_id=u.id WHERE u.id IN ($uids)";
    $result = $db->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $tweets[] = $row;
            // Select the comments based on the tweet id
            // Add the comments to a sub-assoc array for each tweet OR create another array of tweet ids and do this separately
        }
    }

    $comments = [];
    foreach ($tweets as $tweet) {
        $tweet_id = $tweet['tweet_id'];
        $sql = "SELECT c.text, u.fname, u.lname FROM Comment c 
                INNER JOIN User u ON c.user_id=u.id
                WHERE c.tweet_id IN 
                (SELECT t.tweet_id FROM Tweet t WHERE t.tweet_id=$tweet_id);";
        $result = $db->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                if ($comments[$tweet_id]) {
                    array_push($comments[$tweet_id], $row);
                }
                else {
                    $comments[$tweet_id] = array();
                    array_push($comments[$tweet_id], $row);
                }
            }
        }
    }

    $likes = [];
    $sql = "SELECT tweet_id, user_id FROM Likes";
    $result = $db->query($sql);
    if ($result) {
        while($row = $result->fetch_assoc()) {
            $id = $row['tweet_id'];
            if ($likes[$id]) {
                $likes[$id] += 1;
            }
            else {
                $likes[$id] = 1;
            }
        }
    }


    $result->close();
    $db->close();

?>

<html>
    <head>
        <?php echo file_get_contents('common/header.html'); ?>
    </head>
    <body class="bg-light">
        <div class="container">

            <?php $currentPage = "feed"; include('common/nav.php'); ?>
            <?php if ($error = $_GET['error']) { ?>
                <?php if ($error) { ?>
                    <div class="alert alert-success">
                        <p>Successfully performed action.</p>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger">
                        <p>Encountered an error. Please try again.</p>
                    </div>
                <?php } ?>
            <?php } ?>

            <h1>Feed</h1>
            <br>
            <?php foreach ($tweets as $tweet) { ?>
                <div class="border border-secondary rounded bg-white feed-div shadow">
                    <h2><?php echo $tweet['fname'] . ' ' . $tweet['lname']; ?></h2>
                    <p><?php echo $tweet['text']; ?></p>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <a href="php/like_manager.php?uid=<?php echo $uid; ?>&tweet=<?php echo $tweet['tweet_id']; ?>">
                                <button type="button" class="btn btn-primary"><?php echo $likes[$tweet['tweet_id']]; ?> Likes</button>
                            </a>
                            <button type="button" class="btn btn-secondary"><?php echo count($comments[$tweet['tweet_id']]); ?> Comments</button>
                        </div>
                    </div>

                    <?php $tweet_comments = $comments[$tweet['tweet_id']]; ?>
                    <?php foreach ($tweet_comments as $tweet_comment) { ?>
                        <br>
                        <div class="border border-secondary rounded p-3">
                            <h3><?php echo $tweet_comment['fname'] . ' ' . $tweet_comment['lname']; ?></h3>
                            <p><?php echo $tweet_comment['text'] ?></p>
                        </div>
                    <?php } ?>

                    <br>
                    <form method="post" action="php/comment_manager.php?uid=<?php echo $uid; ?>&tweet=<?php echo $tweet['tweet_id']; ?>">
                        <div class="form-row">
                            <div class="col-11">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="inputComment" aria-describedby="commentHelp" placeholder="Enter a comment...">
                                </div>

                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </div>
                    </form>

                 </div>

                <br>
            <?php } ?>

        </div>
    </body>
</html>
