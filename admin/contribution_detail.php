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
include("includes/delete_modal.php");
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
                                <h3 class="title-form">Upload details</h3>
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

                <!-- FORM SHOW DETAIL UPLOAD -->
                <div class="container mt-5">
                    <div class="ss">
                        <div class="row">

                            <!-- Show info -->
                            <div class="col-6">
                                <div class="ssa">
                                    <?php
                                    if (isset($_GET['p_id']) || $_GET['p_id'] != '') {
                                        $the_contribution_id = escape($_GET['p_id']);

                                        $query = "SELECT * FROM contributions JOIN users ON student_id = user_id JOIN topics ON topicId = topic_id  WHERE contribution_id = {$the_contribution_id}";

                                        $select_contribution_query = mysqli_query($connection, $query);

                                        if (!$select_contribution_query) {
                                            die("Query Failed!" . mysqli_error($connection));
                                        }

                                        if (mysqli_num_rows($select_contribution_query) == 1) {
                                            $row = mysqli_fetch_array($select_contribution_query, MYSQLI_ASSOC);

                                            $contribution_id        =       $row['contribution_id'];
                                            $contribution_name      =       $row['name'];
                                            $upload_date            =       date("H:i d-m-Y", strtotime($row['upload_date']));
                                            $student_name           =       $row['fullname'];
                                            $file_name              =       $row['file'];
                                            $notes                  =       $row['notes'];
                                            $image                  =       $row['image'];
                                            $status                 =       $row['status'];
                                            $faculty_id             =       $row['faculty_id'];
                                            $topic_name             =       $row['topic_name'];
                                            $filesize               =       filesize("../uploads/doc/{$file_name}");
                                        }
                                        // if (($_SESSION['user_faculty']) !== $faculty_id) {
                                        //     header('Location: ../admin/index.php');
                                        // }
                                    } else {
                                        header('Location: ../admin/contributions.php');
                                    }
                                    ?>
                                    <div class="mb-3">
                                        <span>Title: </span><label><?php echo $contribution_name ?></label>
                                    </div>
                                    <div class="mb-3">
                                        <span>Upload date: </span><label><?php echo $upload_date ?></label>
                                    </div>
                                    <div class="mb-3">
                                        <span>Topic: </span><label><?php echo $topic_name ?></label>
                                    </div>
                                    <div class="mb-3">
                                        <span>Status: </span>
                                        <label>
                                            <?php
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
                                            ?>
                                        </label>
                                    </div>
                                    <div class="mb-3">
                                        <span>Student: </span><label><?php echo $student_name ?></label>
                                    </div>
                                    <div class="mb-3">
                                        <span>File name: </span><label><?php echo $file_name ?></label>
                                        <a rel='<?php echo $file_name ?>' href="contribution_detail.php?p_id=<?php echo $contribution_id ?>&download=<?php echo $file_name ?>" data-toggle="tooltip" class="text-success ml-4" title="Download file"><i class="fas fa-file-download"></i></a>
                                    </div>
                                    <div class="mb-3">
                                        <span>File size: </span><label><?php
                                                                        if (($filesize) < 1024) {
                                                                            echo number_format($filesize, 2) . " Bytes";
                                                                        } else if (($filesize / 1024) < 1024) {
                                                                            echo number_format($filesize / 1024, 2) . " Kb";
                                                                        } else if (($filesize / 1024 / 1024) < 1024) {
                                                                            echo number_format($filesize / 1024 / 1024, 2) . " Mb";
                                                                        } else {
                                                                            echo number_format($filesize / 1024 / 1024 / 1024, 2) . " Gb";
                                                                        }

                                                                        ?></label>
                                    </div>
                                    <div class="mb-3">
                                        <span>Notes: </span><label><?php echo $notes ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 m-auto">
                                <div class="ssm text-center">

                                    <img id='image' rel='<?php echo $contribution_id ?>' src="../uploads/img/<?php echo $image ?>" alt="<?php echo $image ?>">

                                </div>
                            </div>
                            <!-- -------- -->
                        </div>
                    </div>

                    <?php
                    use PHPMailer\PHPMailer\PHPMailer;
                    use PHPMailer\PHPMailer\Exception;
                    if (isset($_GET['accept'])) {
                        $c_id = mysqli_real_escape_string($connection, $_GET['accept']);
                        $query = "SELECT * FROM contributions WHERE contribution_id = '$c_id'";

                        $select_student_id = mysqli_query($connection, $query);

                        while($row = mysqli_fetch_assoc($select_student_id)) {
                            $studentID = $row['student_id'];
                        }

                        $query_email = "SELECT * FROM users WHERE user_id = ${studentID}";

                        $select_email = mysqli_query($connection, $query_email);

                        while ($row = mysqli_fetch_assoc($select_email)) {
                            $email = $row['user_email'];
                        }

                        $to = $email;
                        $subject    = "Accept"; 
                        $body       = "Accept Accept";

                        require_once('includes/PHPMailer/src/PHPMailer.php');
                        require_once('includes/PHPMailer/src/Exception.php');
                        require_once('includes/PHPMailer/src/SMTP.php');

                        $mail = new PHPMailer();
                        $mail ->isSMTP();
                        $mail ->SMTPAuth = true;
                        $mail ->SMTPSecure = 'ssl';
                        $mail ->Host = 'smtp.gmail.com';
                        $mail ->Port = '465';
                        $mail ->isHTML();
                        $mail ->Username = 'huytpk7411@gmail.com';
                        $mail ->Password = 'huytpk123';
                        $mail ->SetFrom($to);
                        $mail ->AddReplyTo($to);
                        $mail ->Subject = $subject;
                        $mail ->Body = $body;
                        $mail ->AddAddress($to);

                        // $mail ->Send();

                        if(!$mail->Send())
                        {
                            // echo "<p class='bg-success'>Send mail successful</p>";
                        }
                        accept_contribution($c_id);
                    }
                    if (isset($_GET['decline'])) {
                        $c_id = mysqli_real_escape_string($connection, $_GET['decline']);
                        $query = "SELECT * FROM contributions WHERE contribution_id = '$c_id'";

                        $select_student_id = mysqli_query($connection, $query);

                        while($row = mysqli_fetch_assoc($select_student_id)) {
                            $studentID = $row['student_id'];
                        }

                        $query_email = "SELECT * FROM users WHERE user_id = ${studentID}";

                        $select_email = mysqli_query($connection, $query_email);

                        while ($row = mysqli_fetch_assoc($select_email)) {
                            $email = $row['user_email'];
                        }

                        $to = $email;
                        $subject    = "Decline"; 
                        $body       = "Decline Decline";

                        require_once('includes/PHPMailer/src/PHPMailer.php');
                        require_once('includes/PHPMailer/src/Exception.php');
                        require_once('includes/PHPMailer/src/SMTP.php');

                        $mail = new PHPMailer();
                        $mail ->isSMTP();
                        $mail ->SMTPAuth = true;
                        $mail ->SMTPSecure = 'ssl';
                        $mail ->Host = 'smtp.gmail.com';
                        $mail ->Port = '465';
                        $mail ->isHTML();
                        $mail ->Username = 'huytpk7411@gmail.com';
                        $mail ->Password = 'huytpk123';
                        $mail ->SetFrom($to);
                        $mail ->AddReplyTo($to);
                        $mail ->Subject = $subject;
                        $mail ->Body = $body;
                        $mail ->AddAddress($to);

                        // $mail ->Send();

                        if(!$mail->Send())
                        {
                            // echo "<p class='bg-success'>Send mail successful</p>";
                        }
                        decline_contribution($c_id);
                    }
                    if (isset($_REQUEST["download"]) && isset($_GET['download'])) {
                        // Get parameters
                        $filename = urldecode($_REQUEST["download"]); // Decode URL-encoded string
                        $filepath = "../uploads/doc/" . $filename;

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

                    <div class="text-center mt-4">
                        <button rel='<?php echo $contribution_id ?>' class="btn btn-info accept_link">Accept</button>
                        <button rel='<?php echo $contribution_id ?>' class="btn btn-danger decline_link">Decline</button>
                    </div>

                    <!-- COMMENTS -->
                    <div class="container mb-4">
                        <hr>
                        <?php
                        if (isset($_POST['submitComment'])) {
                            $new_comment  = escape($_POST['comment']);
                            $time_comment = date("Y-m-d H:i:s");
                            $user_id = $_SESSION['user_id'];
                            $contribution_id = $_GET['p_id'];

                            $error = [
                                'comment'  =>  '',
                            ];

                            if ($new_comment == '') {
                                $error['comment'] = "Please comment something!";
                            }

                            foreach ($error as $key => $value) {
                                if (empty($value)) {
                                    unset($error[$key]);
                                }
                            }

                            if (empty($error)) {
                                add_comment($new_comment, $time_comment, $user_id, $contribution_id);
                            }
                        }
                        ?>
                        <form method="post">
                            <p style="color: red;" href=""><?php echo isset($error['comment']) ? $error['comment'] : '' ?></p>
                            <textarea name="comment" class="input__comment" placeholder="Say something..."></textarea>
                            <div class="text-right">
                                <input type="submit" name="submitComment" class="btn btn-success" value="Comment">

                            </div>
                        </form>
                    </div>
                    <div class="container wrapper__ mt-5 mb-2">
                        <?php
                        if (isset($_GET['p_id'])) {
                            // View more
                            $query = "SELECT * FROM comments JOIN users ON userId = user_id  WHERE contribution_id = {$the_contribution_id}";
                            $count_comment_query = mysqli_query($connection, $query);
                            if (!$count_comment_query) {
                                die("Query Failed!" . mysqli_error($connection));
                            }

                            $count = mysqli_num_rows($count_comment_query);
                            $view = 5;
                            if (isset($_GET['viewmore'])) {
                                $viewmore = $_GET['viewmore'];
                                $view = $viewmore + $view;
                            }

                            $query = "SELECT * FROM comments JOIN users ON userId = user_id  WHERE contribution_id = {$the_contribution_id} ORDER BY comment_id DESC LIMIT {$view}";

                            $select_comment_query = mysqli_query($connection, $query);

                            if (!$select_comment_query) {
                                die("Query Failed!" . mysqli_error($connection));
                            }

                            echo "<h4>Comment <span>($count)</span></h4>";

                            while ($row = mysqli_fetch_assoc($select_comment_query)) {

                                $user_id       = $row['userId'];
                                $comment_id    = $row['comment_id'];
                                $user_fullname = $row['fullname'];
                                $user_image    = $row['user_image'];
                                $time_comment  = $row['date'];
                                $comment       = $row['comment'];
                                $login_image   = $_SESSION['user_image'];

                                echo "<div class='d-flex justify-content-center row' id='comment'>
                                    <div class='col-md-12'>
                                        <div class='d-flex flex-column comment-section' id='myGroup'>
                                            <div class='bg-white p-2'>
                                                <div class='d-flex flex-row user-info'><img class='rounded-circle' src='..{$user_image}' width='40'>
                                                    <div class='d-flex flex-column justify-content-start ml-2'><span class='d-block font-weight-bold name'>{$user_fullname}</span><span class='date text-black-50'>{$time_comment}</span>
                                                    </div>";
                                if ($user_id == $_SESSION['user_id']) {
                                    echo "<a rel='{$comment_id}' href='#' data-toggle='tooltip' class='text-danger ml-4 delete_link' title='Delete'><i class='fas fa-trash'></i></a>";
                                }
                                echo " </div>
                                                <div class='mt-2'>
                                                    <p class='comment-text'>{$comment}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>";
                            }

                            if ($count == 0 || $view > $count) {
                            } else {
                                echo "
                                <div class='m-auto text-center'>
                                    <a id='viewmore' class='btn btn-info mt-2' href='contribution_detail.php?p_id={$the_contribution_id}&viewmore={$view}'>View more</a>
                                </div>";
                            }
                            if (isset($_GET['delete'])) {
                                $the_comment_id = mysqli_real_escape_string($connection, $_GET['delete']);

                                $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";

                                $delete_comment_query = mysqli_query($connection, $query);

                                if (!$delete_comment_query) {
                                    die("Query Failed!" . mysqli_error($connection));
                                }

                                header("Location: ../admin/contribution_detail.php?p_id={$the_contribution_id}");
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
    $(document).ready(function() {
        $(".accept_link").on('click', function() {
            id = $(this).attr("rel");
            accept_url = "contribution_detail.php?accept=" + id + "";

            $(".modal_confirm_link").attr('href', accept_url);
            $("#confirmModal").modal('show');
        })
        $(".decline_link").on('click', function() {
            id = $(this).attr("rel");
            decline_url = "contribution_detail.php?decline=" + id + "";

            $(".modal_confirm_link").attr('href', decline_url);
            $("#confirmModal").modal('show');
        })
        $(".delete_link").on('click', function() {
            id = $(this).attr("rel");
            contribution_id = $('#image').attr("rel");
            delete_url = "contribution_detail.php?p_id=" + contribution_id + "&delete=" + id + "";

            $(".modal_delete_link").attr('href', delete_url);
            $("#myModal").modal('show');
        })
        $(".download_link").on('click', function() {
            doc_file = $(this).attr("rel");
            contribution_id = $('#image').attr("rel");
            download_url = "contribution_detail.php?p_id=" + contribution_id + "&download=" + doc_file + "";

            $(".modal_download_link").attr('href', download_url);
            $("#downloadModal").modal('show');
        })
    })
</script>

<?php include "includes/footer.php" ?>