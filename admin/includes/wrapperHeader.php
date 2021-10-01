<div class="wrapper__header-dashboard">
    <i class="far fa-moon fa-lg"></i>
    <div class="wrapper__items-header">
        <!-- <div class="wrapper__icons">
            <i class="fas fa-bell fa-lg"></i>
            <span class="num__noti">1</span>
        </div> -->
        <div id="wrapper__icon-user" class="wrapper__icon-user">
            <img src="..<?php echo $_SESSION['user_image'] ?>" alt="<?php echo $_SESSION['user_image'] ?>">
            <div class="wrapper__nr-user ml-3">
                <span class="font-weight-bold"><?php echo $_SESSION['username']?></span>
                <span onclick="showDrd()" id="role__user" class="role__user"  style="font-size:13px">
                    <!-- <span>Admin</span> -->
                    <i class="fas fa-angle-down"></i>
                </span>
            </div>
            <div id="wrapper__drd" class="wrapper__drd">
                <div class="inner__drd">
                    <!-- <a href="/articles.html"><li>Profile</li></a>
                    <a href="#"><li>Setting</li></a> -->
                    <a href="includes/logout.php"><li>Logout</li></a>
                </div>
            </div>
        </div>
    </div>
</div>