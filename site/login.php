<?php
/**
 * Created by IntelliJ IDEA.
 * User: noahcoomer
 * Date: 11/19/18
 * Time: 3:17 PM
 */
?>

<html>
    <head>
        <?php echo file_get_contents('common/header.html'); ?>
        <style>
            body{
                display: -ms-flexbox;
                display: flex;
                -ms-flex-align: center;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
            }
        </style>
    </head>
    <body class="text-center bg-light">
        <form class="form-signin" method="post" action="php/login_manager.php">
            <!--<img class="mb-4" src="assets/img/basketball.jpg" alt="basketball.jpg" width="72" height="72">-->
            <h1 class="h3 mb-3 font-weight-normal">Sign In</h1>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">Don't have an account?<br><a href="register.php">Register for an account here!</a></p>
        </form>
    </body>
</html>