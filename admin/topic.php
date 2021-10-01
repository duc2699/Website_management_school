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
                                <h3 class="title-form">Topic Management</h3>
                            </div>
                            <div class="col-6 ">
                                <ol class="breadcrumbs">
                                    <li class="breadcrumbs-item">
                                        <a href="./index.php"><i class="fas fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumbs-item">
                                        <a href="./topic.php">Topic Management</a>
                                    </li>
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
                                        case 'add_topic':
                                            include "includes/add_topic.php";
                                            break;
                                        case 'edit_topic':
                                            include "includes/edit_topic.php";
                                            break;
                                        default:
                                            include "includes/view_all_topic.php";
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


<!-- DATETIME PICKER -->
<script type="text/javascript" src="js/moment.js"></script>
<script>
jSuites.calendar(document.getElementById('calendar1'), {
    time: true,
    format: 'YYYY-MM-DD HH24:MI:SS',
    readonly: false,
    validRange: [ '2021-01-01' ]
});
jSuites.calendar(document.getElementById('calendar2'), {
    time: true,
    format: 'YYYY-MM-DD HH24:MI:SS',
    readonly: false,
    validRange: [ '2021-01-01' ]
});
jSuites.calendar(document.getElementById('calendar3'), {
    time: true,
    format: 'YYYY-MM-DD HH24:MI:SS',
    readonly: false,
    validRange: [ '2021-01-01' ]
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/2.14.1/moment.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js">
</script>
<?php include "includes/footer.php" ?>