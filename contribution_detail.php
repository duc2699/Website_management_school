<?php include "includes/headerTopic.php" ?>

<?php
if (isset($_SESSION['user_role'])) {
  if ($_SESSION['user_role'] !== 'Student') {
    if ($_SESSION['user_role'] !== 'Coordinator') {
      header('Location: ./index.php');
    }
  }
}
date_default_timezone_set('Asia/Ho_Chi_Minh');
include("includes/download_modal.php");
include("includes/delete_modal.php");
?>



<!--Navigation & Intro-->
<header>

  <!--Navbar-->
  <?php include "includes/navigation.php" ?>
  <!--Navbar-->
  <!-- Intro Section -->
  <div id="home" class="view jarallax" data-jarallax='{"speed": 0.2}' style="background-image: url('./images/bg_articledetails.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
    <div class="mask rgba-black-strong">
      <div class="container h-100 d-flex justify-content-center align-items-center">
        <div class="row smooth-scroll">
          <div class="col-md-12 white-text text-center">
            <div class="wow fadeInDown" data-wow-delay="0.2s">
              <h2 class="display-3 font-weight-bold mb-2">Contribute</h2>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!--Navigation & Intro-->

<!-- POPUP CONFIRM DELETE -->
<div class="container">
  <div class="container mt-5">
    <div class="ss">
      <div class="row">

        <!-- Show info -->
        <div class="col-lg-6 col-md-12">
          <div class="ssa">
            <?php
            if (isset($_GET['user_id']) || $_GET['user_id'] != '' || isset($_GET['topic_id']) || $_GET['topic_id'] != '') {
              $the_user_id = escape($_GET['user_id']);
              $the_topic_id = escape($_GET['topic_id']);

              $query = "SELECT * FROM contributions JOIN users ON student_id = user_id JOIN topics ON topicId = topic_id WHERE student_id = {$the_user_id} AND topicId = {$the_topic_id}";

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
                $deadline_2             =       $row['deadline_2'];
                $filesize               =       filesize("./uploads/doc/{$file_name}");
              }
              // if (($_SESSION['user_faculty']) !== $faculty_id) {
              //     header('Location: ../admin/index.php');
              // }
            } else {
              header('Location: ./rvtopic.php');
            }
            ?>
            <div class="mb-3">
              <span>Title: </span><label><?php echo $contribution_name ?></label>
            </div>
            <div class="mb-3">
              <span>Upload date: </span><label><?php echo $upload_date ?></label>
            </div>
            <div class="mb-3">
              <span>Topic: </span><label id="deadline_2" rel="<?php echo $deadline_2; ?>"><?php echo $topic_name ?></label>
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
              <span>Student: </span><label id='user_id' rel='<?php echo $the_user_id ?>'><?php echo $student_name ?></label>
            </div>
            <div class="mb-3">
              <span>File name: </span><label><?php echo $file_name ?></label>
              <a rel='<?php echo $file_name ?>' href="contribution_detail.php?user_id=<?php echo $the_user_id ?>&topic_id=<?php echo $the_topic_id ?>&download=<?php echo $file_name ?>" data-toggle="tooltip" class="text-success ml-4" title="Download file"><i class="fas fa-file-download"></i></a>
            </div>
            <div class="mb-3">
              <span>File size: </span><label>
                <?php
                if (($filesize) < 1024) {
                  echo number_format($filesize, 2) . " Bytes";
                } else if (($filesize / 1024) < 1024) {
                  echo number_format($filesize / 1024, 2) . " Kb";
                } else if (($filesize / 1024 / 1024) < 1024) {
                  echo number_format($filesize / 1024 / 1024, 2) . " Mb";
                } else {
                  echo number_format($filesize / 1024 / 1024 / 1024, 2) . " Gb";
                }

                ?>
              </label>
            </div>
            <div class="mb-3">
              <span>Notes: </span><label><?php echo $notes ?></label>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 m-auto">
          <div class="ssm text-center">

            <img style='width:500px; height:500px;' id='image' rel='<?php echo $the_topic_id ?>' src="./uploads/img/<?php echo $image ?>" alt="<?php echo $image ?>">

          </div>
        </div>
        <!-- -------- -->
      </div>
    </div>

    <?php
    if (isset($_REQUEST["download"]) && isset($_GET['download'])) {
      // Get parameters
      $filename = urldecode($_REQUEST["download"]); // Decode URL-encoded string
      $filepath = "./uploads/doc/" . $filename;

      // Process download
      if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filepath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer
        readfile($filepath);
        exit;
      }
    }
    ?>
    <div class='text-center mt-4'>
      <?php
      $the_user_id = $_SESSION['user_id'];
      $now_date = date("H:i d-m-Y");

      $query = "SELECT * FROM topics WHERE topic_id = {$the_topic_id}";
      $select_topic_query = mysqli_query($connection, $query);

      if (!$select_topic_query) {
        die("Query Failed!" . mysqli_error($connection));
      }

      if (mysqli_num_rows($select_topic_query) == 1) {
        $row = mysqli_fetch_array($select_topic_query, MYSQLI_ASSOC);
        $upDate2 = $row['deadline_2'];
      }

      $now            =       strtotime($now_date);
      $deadline_2     =       strtotime($upDate2);

      if ($now > $deadline_2) {
        echo "<p>You cannot edit your topic now!</p>";
      } else {
        echo "<a href='edit_contribution.php?p_id={$contribution_id}' class='btn btn-info accept_link'>Edit my contribution</a>";
        echo "<p>Time remaining: <span style='color:red;' id='countdown'></span></p>";
      }
      ?>
    </div>

    <!-- COMMENTS -->
    <div class="container mb-4">
      <hr>
      <?php
      if (isset($_POST['submitComment'])) {
        $new_comment  = escape($_POST['comment']);
        $time_comment = date("Y-m-d H:i:s");
        $user_id      = $_SESSION['user_id'];
        // $contribution_id = $_GET['p_id'];

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
          add_comment($new_comment, $time_comment, $user_id, $contribution_id, $the_topic_id);
        }
      }
      ?>
      <form method="post">
        <textarea name="comment" class="input__comment" placeholder="Say something..."></textarea>
        <div class="text-right">
          <input type="submit" name="submitComment" class="btn btn-success" value="Comment">
        </div>
        <div class="text-left">
          <p style="color: red;" href=""><?php echo isset($error['comment']) ? $error['comment'] : '' ?></p>
        </div>
      </form>
    </div>
    <div class="container wrapper__ mt-5 mb-2">
      <?php

      // View more
      $query = "SELECT * FROM comments JOIN users ON userId = user_id  WHERE contribution_id = {$contribution_id}";
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

      $query = "SELECT * FROM comments JOIN users ON userId = user_id  WHERE contribution_id = {$contribution_id} ORDER BY comment_id DESC LIMIT {$view}";

      $select_comment_query = mysqli_query($connection, $query);

      if (!$select_comment_query) {
        die("Query Failed!" . mysqli_error($connection));
      }

      echo "<h4 class='mt-5 mb-5'>Comment <span>($count)</span></h4>";

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
                        <div class='d-flex flex-row user-info'><img class='rounded-circle' src='.{$user_image}' width='40'>
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

      if ($count == 0 || $view >= $count) {
      } else {
        echo "<div class='m-auto text-center'>
                  <a id='viewmore' class='btn btn-info mt-2' href='contribution_detail.php?user_id={$user_id}&topic_id={$the_topic_id}&viewmore={$view}'>View more</a>
                </div>";
      }

      if (isset($_GET['delete'])) {
        $the_comment_id = mysqli_real_escape_string($connection, $_GET['delete']);

        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id}";

        $delete_comment_query = mysqli_query($connection, $query);

        if (!$delete_comment_query) {
          die("Query Failed!" . mysqli_error($connection));
        }

        header("Location: ./contribution_detail.php?user_id={$the_user_id}&topic_id={$the_topic_id}");
      }
      ?>

    </div>


  </div>
</div>
<script>
  $(document).ready(function() {
    $(".delete_link").on('click', function() {
      id = $(this).attr("rel");
      user_id = $('#user_id').attr("rel");
      topic_id = $('#image').attr("rel");
      delete_url = "contribution_detail.php?user_id=" + user_id + "&topic_id=" + topic_id + "&delete=" + id + "";

      $(".modal_delete_link").attr('href', delete_url);
      $("#myModal").modal('show');
    })
    $(".download_link").on('click', function() {
      doc_file = $(this).attr("rel");
      user_id = $('#user_id').attr("rel");
      topic_id = $('#image').attr("rel");
      download_url = "contribution_detail.php?user_id=" + user_id + "&topic_id=" + topic_id + "&download=" + doc_file + "";

      $(".modal_download_link").attr('href', download_url);
      $("#downloadModal").modal('show');
    })
  })
</script>
<script>
    function func() {
        var deadline2 = $('#deadline_2').attr("rel");
 
        var now = Math.abs((new Date().getTime() / 1000).toFixed(0));
        var deadline_2 = Math.abs((new Date(deadline2).getTime() / 1000).toFixed(0));
 
        var diff = deadline_2 - now;
 
        var days = Math.floor(diff / 86400);
        var hours = Math.floor(diff / 3600) % 24;
        var minutes = Math.floor(diff / 60) % 60;
        var seconds = diff % 60;
 
        var daysStr = days;
        if (days < 10) {
            daysStr = "0" + days;
        }
  
        var hoursStr = hours;
        if (hours < 10) {
            hoursStr = "0" + hours;
        }
  
        var minutesStr = minutes;
        if (minutes < 10) {
            minutesStr = "0" + minutes;
        }
  
        var secondsStr = seconds;
        if (seconds < 10) {
            secondsStr = "0" + seconds;
        }
 
        if (days < 0 && hours < 0 && minutes < 0 && seconds < 0) {
            daysStr = "00";
            hoursStr = "00";
            minutesStr = "00";
            secondsStr = "00";
 
            console.log("close");
            if (typeof interval !== "undefined") {
                clearInterval(interval);
            }
        }
 
        document.getElementById("countdown").innerHTML = daysStr + " days, " + hoursStr + ":" + minutesStr + ":" + secondsStr;
    }
 
    func();
    var interval = setInterval(func, 1000);
</script>
<?php include "includes/footerTopic.php" ?>