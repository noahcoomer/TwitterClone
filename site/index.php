<?php
/**
 * Created by IntelliJ IDEA.
 * User: noahcoomer
 * Date: 11/15/18
 * Time: 8:05 PM
 */

?>

<html>
    <head>
        <?php echo file_get_contents('common/header.html'); ?>
    </head>
    <body class="text-center">
        <!-- This file should be used to ask the user if they want to use the Neo4j DB or the SQL DB -->
        <div class="container">
            <div class="row p-6">
                <div class="col-6">
                    <button class="btn-lg btn-primary">SQL</button>
                </div>
                <div class="col-6">
                    <button class="btn-lg btn-secondary">Neo4j</button>
                </div>
            </div>
        </div>
    </body>
</html>
