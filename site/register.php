<?php
/**
 * Created by IntelliJ IDEA.
 * User: noahcoomer
 * Date: 11/19/18
 * Time: 1:33 PM
 */

?>

<html>
    <head>
        <?php echo file_get_contents('common/header.html'); ?>
    </head>
    <body class="text-center bg-light">
        <form class="form-signin" method="post" action="php/register_manager.php">
            <h1 class="h3 mb-3 font-weight-normal">Register today!</h1>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
            <label for="inputPassword" class="sr-only">Username</label>
            <input type="text" id="inputUsername" name="inputUsername" class="form-control" placeholder="Username" required>
            <label for="inputFirstName" class="sr-only">First Name</label>
            <input type="text" id="inputFirstName" name="inputFirstName" class="form-control" placeholder="First Name" required>
            <label for="inputLastName" class="sr-only">Last Name</label>
            <input type="text" id="inputFirstName" name="inputLastName" class="form-control" placeholder="Last Name" required>
            <button style="margin-top: 10px;" class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
            <p class="mt-5 mb-3 text-muted">Have an account already?<br><a href="login.php">Log in here!</a></p>
        </form>
    </body>
</html>
