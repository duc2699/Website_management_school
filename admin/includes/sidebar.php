<div class="wrapper__sidebar-all col-lg-2 p-0">
    <div style="position: fixed; width: 100%; max-width:inherit;">
        <a href='../index.php'>
        <div class="wrapper__logo-icon">
            <i class="fas fa-chalkboard-teacher fa-2x"></i>
            <span>Dashboard</span>
        </div>
        </a>
        <div class="user-items__sidebar">
            <!-- 1 -->
            <?php
            if (isset($_SESSION['user_role'])) {
                if ($_SESSION['user_role'] == 'Admin' || $_SESSION['user_role'] == 'Coordinator' || $_SESSION['user_role'] == 'Manager' || $_SESSION['user_role'] == 'Guest') {

                    echo    "
                    <a href='./index.php'>
                        <li class='sidebar__list mb-3'>
                            <span class='sidebar__links'>
                                <i class='fas fa-home fa-lg'></i>
                                <span href='#' class='ml-2 active'>Dashboard</span>
                                <i id='arr1' class='fas fa-angle-right'></i>
                            </span>

                        </li>
                    </a>";
                }
                if ($_SESSION['user_role'] == 'Admin') {
                    echo "
                    <a href='./account.php'>
                        <li' class='sidebar__list mb-3'>
                            <span class='sidebar__links'>
                                <i class='fas fa-user-alt fa-lg mr-1'></i>
                                <span href='#' class='ml-2 active'>Account Management</span>
                                <i id='arr2' class='fas fa-angle-right'></i>
                            </span>
                        </li>
                    </a>
                    ";
                }

                if ($_SESSION['user_role'] == 'Admin' || $_SESSION['user_role'] == 'Manager') {

                    echo   "
                    <a href='./faculty.php'>
                        <li class='sidebar__list mb-3'>
                            <span class='sidebar__links'>
                                <i class='fas fa-book fa-lg mr-1'></i>
                                <span href='#' class='ml-2 active'>Faculty Management</span>
                                <i id='arr3' class='fas fa-angle-right'></i>
                            </span>
                        </li>
                    </a>
                    <a href='./topic.php'>
                        <li class='sidebar__list mb-3'>
                            <span class='sidebar__links'>
                                <i class='fas fa-bookmark fa-lg mr-1'></i>
                                <span href='#' class='ml-2 active'>Topic Management</span>
                                <i id='arr4' class='fas fa-angle-right'></i>
                            </span>
                        </li>
                    </a>";
                }
                if ($_SESSION['user_role'] == 'Manager') {
                    echo "
                    <a href='./manager.php'>
                        <li class='sidebar__list mb-3'>
                            <span class='sidebar__links'>
                                <i class='fas fa-cloud-download-alt fa-lg mr-1'></i>
                                <span href='#' class='ml-2 active'>Marketing Manager</span>
                                <i id='arr7' class='fas fa-angle-right'></i>
                            </span>
                        </li>
                    </a>";
                }
                if ($_SESSION['user_role'] == 'Coordinator') {
                    echo  "
                    <a href='./contributions.php'>
                        <li class='sidebar__list mb-3'>
                            <span class='sidebar__links'>
                                <i class='fas fa-clipboard-list fa-lg mr-1'></i>
                                <span href='#' class='ml-2 active'>Contribution Management</span>
                                <i id='arr5' class='fas fa-angle-right'></i>
                            </span>
                        </li>
                    </a>";
                }
            }
            ?>
        </div>
    </div>
</div>