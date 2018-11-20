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
        <form class="form-signin">
            <img class="mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            <!--<p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>-->
        </form>
    </body>
</html>