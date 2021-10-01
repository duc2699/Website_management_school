<?php include "db.php" ?>

<!--Navbar-->
<nav id="navbar" class="navbar fixed-top navbar-expand-lg navbar-dark scrolling-navbar">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!--Links-->
            <ul class="navbar-nav mr-auto smooth-scroll">
                <li class="nav-item  mr-4">
                    <a class="nav-link" href="./index.php">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                
                <?php
                if (isset($_SESSION['user_role'])) {
                    if($_SESSION['user_role'] == 'Student' || $_SESSION['user_role'] == 'Coordinator'){
                        echo"
                        <li class='nav-item  mr-4'>
                            <a class='nav-link' href='./rvtopic.php' data-offset='100'>Topic</a>
                        </li>";
                    }
                    if ($_SESSION['user_role'] == 'Admin' || $_SESSION['user_role'] == 'Coordinator' || $_SESSION['user_role'] == 'Manager') {
                        echo
                        "<li class='nav-item  mr-4'>
                            <a class='nav-link' href='./admin/index.php' data-offset='100'>Admin Dashboard</a>
                        </li>";
                    }
                    if ($_SESSION['user_role'] == 'Guest') {
                        echo
                        "<li class='nav-item  mr-4'>
                            <a class='nav-link' href='./admin/index.php' data-offset='100'>Statistical Dashboard</a>
                        </li>";
                    }
                }
                if (isset($_SESSION['username']))
                {
                    echo
                        "<li class='nav-item  mr-4'>
                            <a class='nav-link' href='./includes/logout.php' data-offset='100'>Hello {$_SESSION['username']}, Logout</a>
                        </li>";
                }
                ?>
            </ul>

            <!--Social Icons-->
            <ul class="navbar-nav nav-flex-icons">
                <li class="nav-item">
                    <a class="nav-link">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!--Navbar-->