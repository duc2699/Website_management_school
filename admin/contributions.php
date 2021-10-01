<?php include "includes/header.php" ?>

<?php
if (isset($_SESSION['user_role'])) {
    if (($_SESSION['user_role']) !== 'Coordinator') {
        header('Location: ../index.php');
    }
}
date_default_timezone_set('Asia/Ho_Chi_Minh');
include("includes/confirm_modal.php");
include("includes/download_modal.php");
?>

<div class="container-fluid">
    <div class="row">
        <?php include "includes/sidebar.php" ?>
        <div class="col-lg-10 col-md-12 pl-0 pr-0">
            <?php include "includes/wrapperHeader.php" ?>
            <div class="wrapper__maindashboard p-3">
                <div class="container-fluid mt-5">
                    <div>
                        <div class="res__sidebar">
                            <?php
                            if (isset($_SESSION['user_role'])) {
                                if ($_SESSION['user_role'] == 'Admin' || $_SESSION['user_role'] == 'Coordinator' || $_SESSION['user_role'] == 'Manager') {

                                    echo    "
                    <a href='./index.php'>
                        <li class='sidebar__list mb-3'>
                            <span class='sidebar__links'>
                                <i class='fas fa-home fa-lg'></i>
                                <span href='#' class='ml-2 active'>Dashboard</span>
                                <i id='arr1' class='fas fa-angle-right'></i>
                            </span>

                        </li>
                    </a>
                    <a href='./index.php'>
                        <li class='sidebar__list mb-3'>
                            <span class='sidebar__links'>
                                <i class='far fa-chart-bar fa-lg mr-1'></i>
                                <span href='#' class='ml-2 active'>Chart</span>
                                <i id='arr6' class='fas fa-angle-right'></i>
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
                        <div class="row">
                            <div class="col-6">
                                <h3 class="title-form">Contribution Management</h3>
                            </div>
                            <div class="col-6 ">
                                <ol class="breadcrumbs">
                                    <li class="breadcrumbs-item">
                                        <a href="./index.php"><i class="fas fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumbs-item">
                                        <a href="./contributions.php">Contribution Management</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="table-wrapper">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Student name</th>
                                    <th>Title</th>
                                    <th>Notes</th>
                                    <th>Image</th>
                                    <th>Document</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                // Start Pagination
                                $per_page = 6;

                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                } else {
                                    $page = " ";
                                }

                                if ($page == " " || $page == 1) {
                                    $page_1 = 0;
                                } else {
                                    $page_1 = ($page * $per_page) - $per_page;
                                }

                                $contribution_query_count = "SELECT * FROM contributions";
                                $find_count       = mysqli_query($connection, $contribution_query_count);
                                $count            = mysqli_num_rows($find_count);

                                $count            = ceil($count / $per_page);

                                // End pagination
                                $coordinator_faculty = $_SESSION['user_faculty'];
                                if (isset($_GET['p_id'])) {
                                    $the_topic_id = $_GET['p_id'];
                                    $query = "SELECT * FROM contributions INNER JOIN users ON student_id = user_id WHERE faculty_id = {$coordinator_faculty} AND topicId = {$the_topic_id} LIMIT $page_1, $per_page";
                                } else {
                                    $query = "SELECT * FROM contributions INNER JOIN users ON student_id = user_id WHERE faculty_id = {$coordinator_faculty} LIMIT $page_1, $per_page";
                                }

                                $get_contributions_query = mysqli_query($connection, $query);

                                while ($row = mysqli_fetch_assoc($get_contributions_query)) {

                                    $contribution_id        =       $row['contribution_id'];
                                    $namestu        =       $row['fullname'];
                                    $picture        =       $row['image'];
                                    $title          =       $row['name'];
                                    $document          =       $row['file'];
                                    $notes          =       $row['notes'];
                                    $status         =       $row['status'];

                                    echo "<tr>";
                                    echo "
                                        <td>{$namestu}</td>
                                        <td><a href='contribution_detail.php?p_id={$contribution_id}'>{$title}</a></td>
                                        <td>{$notes}</td>
                                        <td><img style='width:100px; height:100px' src='../uploads/img/{$picture}' class='image__contribution' alt='{$picture}'></td>
                                        <td>{$document}</td>
                                        <td style='white-space: nowrap;'>
                                        ";

                                    if ($status == 'Pending') {
                                        echo   "<span class='status text-warning'>&bull;</span>
                                            Pending";
                                    } elseif ($status == 'Accepted') {
                                        echo "<span class='status text-success'>&bull;</span>
                                            Accepted";
                                    } else {
                                        echo "<span class='status text-danger'>&bull;</span>
                                            Not accepted";
                                    }

                                    echo "  </td>
                                            <td style='white-space: nowrap;'>
                                            <a href='contribution_detail.php?p_id={$contribution_id}' class='edit' title='Detail' data-toggle='tooltip'><i class='fas fa-eye'></i></a>

                                            <a href='contributions.php?download={$document}' rel='{$document}' data-toggle='tooltip' class='text-success ml-4' title='Download file'><i class='fas fa-file-download'></i></a>
                                            </td>";
                                    echo "</tr>";
                                }

                                ?>

                                <?php
                                if (isset($_GET['accept'])) {
                                    $the_contribution_id = mysqli_real_escape_string($connection, $_GET['accept']);
                                    accept_contribution($the_contribution_id);
                                }
                                if (isset($_GET['decline'])) {
                                    $the_contribution_id = mysqli_real_escape_string($connection, $_GET['decline']);
                                    decline_contribution($the_contribution_id);
                                }
                                if (isset($_REQUEST["download"]) && isset($_GET['download'])) {
                                    // Get parameters
                                    $file = urldecode($_REQUEST["download"]); // Decode URL-encoded string
                                    $filepath = "../uploads/doc/" . $file;

                                    // Process download
                                    if (file_exists($filepath)) {
                                        header('Content-Description: File Transfer');
                                        header('Content-Type: application/octet-stream');
                                        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
                                        header('Expires: 0');
                                        header('Cache-Control: must-revalidate');
                                        header('Pragma: public');
                                        header('Content-Length: ' . filesize($filepath));
                                        ob_clean();
                                        flush(); // Flush system output buffer
                                        readfile($filepath);
                                        exit;
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                        <?php
                        if (mysqli_num_rows($get_contributions_query) === 0) {
                            echo "<p style='text-align:center;'>No contribution found!</p>";
                        }
                        ?>
                        <div class="clearfix">
                            <ul class="pagination">
                                <?php
                                if (isset($_GET['p_id'])) {
                                    for ($i = 1; $i <= $count; $i++) {
                                        if ($i == $page) {
                                            echo "<li><a class='active_link' href='contributions.php?p_id={$the_topic_id}&page={$i}'>{$i}</a></li>";
                                        } else {
                                            echo "<li><a href='contributions.php?p_id={$the_topic_id}&page={$i}'>{$i}</a></li>";
                                        }
                                    }
                                } else {
                                    for ($i = 1; $i <= $count; $i++) {
                                        if ($i == $page) {
                                            echo "<li><a class='active_link' href='contributions.php?page={$i}'>{$i}</a></li>";
                                        } else {
                                            echo "<li><a href='contributions.php?page={$i}'>{$i}</a></li>";
                                        }
                                    }
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".accept_link").on('click', function() {
            id = $(this).attr("rel");
            accept_url = "contributions.php?accept=" + id + "";

            $(".modal_confirm_link").attr('href', accept_url);
            $("#confirmModal").modal('show');
        })
        $(".decline_link").on('click', function() {
            id = $(this).attr("rel");
            decline_url = "contributions.php?decline=" + id + "";

            $(".modal_confirm_link").attr('href', decline_url);
            $("#confirmModal").modal('show');
        })
        $(".download_link").on('click', function() {
            doc_file = $(this).attr("rel");
            download_url = "contributions.php?download=" + doc_file + "";

            $(".modal_download_link").attr('href', download_url);
            $("#downloadModal").modal('show');
        })
    })
</script>

<?php include "includes/footer.php" ?>