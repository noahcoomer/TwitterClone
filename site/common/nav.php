<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">TwitterClone</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?php if($currentPage =='feed'){echo 'active';}?>" href="./feed.php">Feed</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if($currentPage =='users'){echo 'active';}?>" href="./users.php">Users</a>
            </li>
        </ul>
    </div>
</nav>
