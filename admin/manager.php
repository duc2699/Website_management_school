<?php include "includes/header.php" ?>
<?php
if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] !== 'Manager') {
        header('Location: ../index.php');
    }
}
date_default_timezone_set('Asia/Ho_Chi_Minh');
?>
<?php
include("includes/download_modal.php");
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
                                <h3 class="title-form">Download all</h3>
                            </div>
                            <div class="col-6 ">
                                <ol class="breadcrumbs">
                                    <li class="breadcrumbs-item">
                                        <a href="./index.php"><i class="fas fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumbs-item">
                                        <a href="./manager.php">Marketing Manager</a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="table-wrapper">
                        <form name="download" method="POST">
                            <label for="name">Faculty</label>
                            <select name="faculty" id="faculty" class="form-control">
                                <option value="">Select Options</option>
                                <?php
                                $query = "SELECT * FROM faculties";
                                $get_faculties_query = mysqli_query($connection, $query);

                                if (!$get_faculties_query) {
                                    die("Query Failed!" . mysqli_error($connection));
                                }

                                while ($row = mysqli_fetch_assoc($get_faculties_query)) {
                                    $id   = $row['faculty_id'];
                                    $name = $row['faculty_name'];

                                    if ($id != 0) {
                                        echo "<option value='{$id}'>{$name}</option>";
                                    }
                                }
                                ?>
                            </select>
                            <p id="facultyerr" style="color: red;" href=""><?php echo isset($error['faculty']) ? $error['faculty'] : '' ?></p>


                            <label for="name">Topic</label>
                            <select name="topic" id="topic" class="form-control">
                                <option value="">Select Options</option>
                                <?php
                                $query = "SELECT * FROM topics";
                                $get_topics_query = mysqli_query($connection, $query);

                                if (!$get_topics_query) {
                                    die("Query Failed!" . mysqli_error($connection));
                                }

                                while ($row = mysqli_fetch_assoc($get_topics_query)) {
                                    $id   = $row['topic_id'];
                                    $name = $row['topic_name'];

                                    if ($id != 0) {
                                        echo "<option value='{$id}'>{$name}</option>";
                                    }
                                }
                                ?>
                            </select>
                            <p id="topicerr" style="color: red;" href=""><?php echo isset($error['topic']) ? $error['topic'] : '' ?></p>
                            <p id="err" style="color: red;" href=""><?php echo isset($error['error']) ? $error['error'] : '' ?></p>
                            <input name='download' type='submit' href='#' data-toggle='tooltip' class='btn btn-success' value='Download all'>
                        </form>



                        <?php
                      if (isset($_POST['download'])) {
                            $faculty_id = escape($_POST['faculty']);
                            $topic_id = escape($_POST['topic']);
                            $now_date = date("H:i d-m-Y");

                            $error = [
                                'error'  =>  '',
                                'topic'  =>  '',
                                'faculty'  =>  '',
                            ];


                            if ($faculty_id == '' || $topic_id == '') {

                                if ($faculty_id == '') {
                                    $error['faculty'] = "Please select a faculty!";
                                    echo "<script>$('#facultyerr').text('{$error['faculty']}');</script>";
                                }

                                if ($topic_id == '') {
                                    $error['topic'] = "Please select a topic!";
                                    echo "<script>$('#topicerr').text('{$error['topic']}');</script>";
                                }
                            } else {
                                $query = "SELECT deadline_2 FROM topics WHERE topic_id = $topic_id";
                                $select_topics_query = mysqli_query($connection, $query);

                                while ($row = mysqli_fetch_assoc($select_topics_query)) {
                                    $deadline_2   = strtotime($row['deadline_2']);
                                    $now          = strtotime($now_date);
                                }

                                if (!$select_topics_query) {
                                    die("Query Failed!" . mysqli_error($connection));
                                }

                                $query = "SELECT contribution_id FROM contributions WHERE status = 'Accepted' AND faculty_id = $faculty_id AND topicId = $topic_id";
                                $count_contributions_query = mysqli_query($connection, $query);

                                if (!$count_contributions_query) {
                                    die("Query Failed!" . mysqli_error($connection));
                                }

                                $count = mysqli_num_rows($count_contributions_query);

                                if ($now < $deadline_2) {
                                    $error['error'] = "This topic did not close!";
                                    echo "<script>$('#err').text('{$error['error']}');</script>";
                                } else if ($count == 0) {
                                    $error['error'] = "There is no contribution accepted in this faculty!";
                                    echo "<script>$('#err').text('{$error['error']}');</script>";
                                }
                            }

                            foreach ($error as $key => $value) {
                                if (empty($value)) {
                                    unset($error[$key]);
                                }
                            }

                            if (empty($error)) {
                                download_all_by_zip($faculty_id, $topic_id);
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".download_link").on('click', function() {
        faculty_id = $("#faculty").val();
        topic_id = $("#topic").val();
        download_url = "manager.php?faculty_id=" + faculty_id + "&topic_id=" + topic_id + "";

        $(".modal_download_link").attr('href', download_url);
        $("#downloadModal").modal('show');
    })
</script>


<?php include "includes/footer.php" ?>