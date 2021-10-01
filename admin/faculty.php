<?php include "includes/header.php" ?>
<?php
    if (isset($_SESSION['user_role'])) {
        if($_SESSION['user_role'] !== 'Admin' )
        {
            if($_SESSION['user_role'] !== 'Manager'){
            header('Location: ../index.php');
            }
        }
    }
    date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
<div class="container-fluid">
    <div class="row">
        <?php include "includes/sidebar.php" ?>
        <div class="col-10 pl-0 pr-0">
            <?php include "includes/wrapperHeader.php" ?>
            <div class="wrapper__maindashboard p-3">
                <div class="container-fluid mt-5">
                    <div>
                        <div class="row">
                            <div class="col-6">
                                <h3 class="title-form">Faculty Management</h3>
                            </div>
                            <div class="col-6 ">
                                <ol class="breadcrumbs">
                                    <li class="breadcrumbs-item">
                                        <a href="./index.php"><i class="fas fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumbs-item">
                                        <a href="./faculty.php">Faculty Management</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="table-responsive">
                        <div class="table-wrapper">
                            <div class="table-title">
                                <div class="">
                                    <?php
                                    if (isset($_GET['source'])) {
                                        $source = $_GET['source'];
                                    } else {
                                        $source = '';
                                    }

                                    switch ($source) {
                                        case 'add_faculty':
                                            include "includes/add_faculty.php";
                                            break;
                                        case 'edit_faculty':
                                            include "includes/edit_faculty.php";
                                            break;
                                        default:
                                            include "includes/view_all_faculty.php";
                                            break;
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include "includes/footer.php" ?>