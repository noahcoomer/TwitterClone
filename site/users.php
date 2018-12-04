<?php
    include_once './db/auth.php';
    $db = connectToSQLDatabase();

    $users = array();
    $sql = 'SELECT * FROM User;';
    $result = $db->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    $follows = array();
    $uid = $_GET['uid'];
    $sql = 'SELECT following_id FROM Follows_User WHERE user_id=' . $uid;
    $result = $db->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['following_id'];
            array_push($follows, $id);
        }
    }
?>

<html>
    <head>
        <?php echo file_get_contents('common/header.html'); ?>
    </head>
    <body class="bg-light">
        <?php $currentPage = 'users'; include('common/nav.php'); ?>
        <div class="container">

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

            <h1>Users</h1>
            <br>
            <table class="table table-bordered table-responsive-md table-striped bg-white">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Password</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">YOB</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $row) { ?>
                    <tr scope="row">
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['password']; ?></td>
                        <td><?php echo $row['fname']; ?></td>
                        <td><?php echo $row['lname']; ?></td>
                        <td><?php echo $row['yob']; ?></td>
                        <td>
                            <?php if (in_array($row['id'], $follows)) { ?>
                                <a href="php/unfollow_manager.php?uid=<?php echo $_GET['uid']; ?>&follow=<?php echo $row['id'] ?>">
                                    <button type="button" class="btn btn-secondary btn-sm">Unfollow</button>
                                </a>
                            <?php } else { ?>
                                <a href="php/follow_manager.php?uid=<?php echo $_GET['uid']; ?>&follow=<?php echo $row['id'] ?>">
                                    <button type="button" class="btn btn-primary btn-sm">Follow</button>
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php echo file_get_contents('common/footer.html'); ?>
    </body>
</html>