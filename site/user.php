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
?>

<html>
    <head>
        <?php file_get_contents('./common/header.html'); ?>
    </head>
    <body>
        <div class="container">
            <h1>NBA Stats</h1>
        </div>
        <div>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Year Of Birth</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($users as $row) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['password']; ?></td>
                        <td><?php echo $row['fname']; ?></td>
                        <td><?php echo $row['lname']; ?></td>
                        <td><?php echo $row['yob']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php file_get_contents('./common/footer.html'); ?>
    </body>
</html>