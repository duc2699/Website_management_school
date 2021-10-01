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
?>

<!--Navigation & Intro-->
<header>

    <!--Navbar-->
    <?php include "includes/navigation.php" ?>
    <!--Navbar-->

    <!-- Intro Section -->
    <div id="home" class="view jarallax" data-jarallax='{"speed": 0.2}' style="background-image: url('./images/pngtree-welcome-back-to-school-background-image_389856.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
        <div class="mask rgba-black-strong">
            <?php
            if (isset($_GET['p_id'])) {
                $the_topic_id = escape($_GET['p_id']);

                $query = "SELECT * FROM topics WHERE topic_id = {$the_topic_id}";

                $select_topic_query = mysqli_query($connection, $query);

                if (!$select_topic_query) {
                    die("Query Failed!" . mysqli_error($connection));
                }

                if (mysqli_num_rows($select_topic_query) == 1) {
                    $row = mysqli_fetch_array($select_topic_query, MYSQLI_ASSOC);
                    $upDate1 = $row['start'];;
                    $upDate2 = $row['deadline_1'];
                    $upDate3 = $row['deadline_2'];


                    $topicname      =       $row['topic_name'];
                    $description    =       $row['description'];
                    $start          =       date("H:i d-m-Y", strtotime($upDate1));
                    $deadline_1     =       date("H:i d-m-Y", strtotime($upDate2));
                    $deadline_2     =       date("H:i d-m-Y", strtotime($upDate3));
                    $topic_id       =       $row['topic_id'];
                }
            } else {
                header('Location: ./rvtopic.php');
            }
            ?>
            <div class="container h-100 d-flex justify-content-center align-items-center">
                <div class="row smooth-scroll">
                    <div class="col-md-12 white-text text-center">
                        <div class="wow fadeInDown" data-wow-delay="0.2s">
                            <h2 class="display-3 font-weight-bold mb-2"><?php echo $topicname; ?></h2>
                            <hr class="hr-light">
                            <h3 class="subtext-header mt-4 mb-5">Published <?php echo $start; ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!--Main content-->
<div class="container">
    <div class="topic__durations text-center mt-4">
        <h2 class="articles_details-subtitle mt-4 mb-3">Duration</h2>
        <h4 class="mb-3" style="">Start Time: <span  id="start" rel="<?php echo $upDate1; ?>"><?php echo  $start; ?></span></h4>
        <h4 class="mb-3" style="margin-left:7px">Contribute Deadline: <span id="deadline_1" rel="<?php echo $upDate2; ?>"><?php echo $deadline_1; ?></span></h4>
        <h4 class="mb-3" style="margin-left:15px">Edit Deadline: <span id="deadline_2" rel="<?php echo $upDate3; ?>"><?php echo $deadline_2; ?></span></h4>
        <!-- <h4 class="mb-3" style="margin-left:15px">Remaining: <span  id="countdown"></span></h4> -->
    </div>
    <hr>
    <h2 class="articles_details-subtitle mt-4 mb-3">Description</h2>
    <div class="inner__content-article">
        <p><?php echo $description; ?>
        </p>
    </div>
</div>
<div class="text-center mt-5 mb-5">
    <?php
    if (isset($_SESSION['user_role'])) {
        if (($_SESSION['user_role']) == 'Student') {
            $the_user_id = $_SESSION['user_id'];
            $now_date = date("H:i d-m-Y");

            $now            =       strtotime($now_date);
            $start          =       strtotime($upDate1);
            $deadline_1     =       strtotime($upDate2);

            $contribute_start   = abs($start - $now);
            $contribute_expired = abs($deadline_1 - $now);

            $query = "SELECT * FROM contributions WHERE student_id = {$the_user_id} AND  topicId = {$the_topic_id}";
            $select_contribution_query = mysqli_query($connection, $query);

            if (!$select_contribution_query) {
                die("Query Failed!" . mysqli_error($connection));
            }

            $count = mysqli_num_rows($select_contribution_query);

            if ($count == 0) {
                if ($now < $start) {
                    echo "<p>This topic will open after: <span style='color:red;' id='countdown'></span></p>";
                } else if ($now > $deadline_1) {
                    echo "<p>This topic is no longer available to contribute!</p>";
                } else {
                    echo "<a href='contribute.php?p_id={$the_topic_id}' class='btn btn-info'>Contribute</a>";
                    echo "<p>Time remaining: <span style='color:red;' id='countdown'></span></p>";
                }
            }

            if ($count == 1) {
                echo "<a href='contribution_detail.php?user_id={$the_user_id}&topic_id={$the_topic_id}' class='btn btn-info'>View my contribute</a>";
            }
        }
        if (($_SESSION['user_role']) == 'Coordinator') {
            echo "<a href='./admin/contributions.php?p_id={$the_topic_id}' class='btn btn-info'>View all contribute</a>";
        }
    }
    ?>
</div>
<!--Main content-->

<script>
    function func() {
        var deadline1 = $('#deadline_1').attr("rel");
        var start_date = $('#start').attr("rel");
 
        var now = Math.abs((new Date().getTime() / 1000).toFixed(0));
        var deadline_1 = Math.abs((new Date(deadline1).getTime() / 1000).toFixed(0));
        var start = Math.abs((new Date(start_date).getTime() / 1000).toFixed(0));   

        if(start - now > 0)
        {
            var diff = start - now;
        }
        else if(deadline_1 - now > 0)
        {
            var diff = deadline_1 - now;
        }
 
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