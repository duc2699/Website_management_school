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
    <!-- Navigation -->
    <?php include "includes/navigation.php" ?>

    <!-- Intro -->
    <?php include "includes/introTopic.php" ?>
</header>
<!--Navigation & Intro-->

<!--Main content-->
<div class="courses-container">
    <h2 class="text-center mt-5 mb-5">All Topics</h2>

    <?php
    $per_page = 4;

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

    $topic_query_count = "SELECT * FROM topics";
    $find_count       = mysqli_query($connection, $topic_query_count);
    $count            = mysqli_num_rows($find_count);

    $count            = ceil($count / $per_page);

    // End Pagination

    $query = "SELECT * FROM topics ORDER by topic_id DESC LIMIT $page_1, $per_page";
    $get_rvtopics_query = mysqli_query($connection, $query);

    if (!$get_rvtopics_query) {
        die("Query Failed!" . mysqli_error($connection));
    }

    while ($row = mysqli_fetch_assoc($get_rvtopics_query)) {

        $topicname      =       $row['topic_name'];
        $description    =       $row['description'];
        $start          =       $row['start'];
        $deadline_1     =       $row['deadline_1'];
        $deadline_2     =       $row['deadline_2'];
        $topic_id       =       $row['topic_id'];

        echo " <div class=' course mb-5'>  
                <div class='course-preview'>
                            <h6>Topic</h6>
                            <p style='white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            max-width: 200px;' class='mt-3'>$topicname</p>
                            <a href='rvtopic_details.php?p_id={$topic_id}'>View topic detail<i class='ml-2 fas fa-chevron-right'></i></a>
                        </div>
                        <div class=' course-info'>
                            <div class='progress-container'>
                                <div class='progress'></div>
                                <span class='progress-text'>
                                    <span>Start:</span>
                                    <span>$start</span>
                                </span>
                                <div class='progress'></div>
                                <span class='progress-text'>
                                    <span>End:</span>
                                    <span>$deadline_1</span>
                                </span>
                                <div class='progress'></div>
                                <span class='progress-text'>
                                    <span>Edit end:</span>
                                    <span>$deadline_2</span>
                                </span>
                            </div>
                            <div class='wrapper__desc-card'>
                                <h6>Description</h6>
                                <p class='description__card-rv mt-3'>
                                $description
                                </p>
                            </div>
                        </div>
                    </div>
                </div>";
    }
    ?>

    <div class="clearfix">
        <ul class="pagination">
            <?php
            for ($i = 1; $i <= $count; $i++) {
                if ($i == $page) {
                    echo "<li><a class='active_link' href='rvtopic.php?page={$i}'>{$i}</a></li>";
                } else {
                    echo "<li><a href='rvtopic.php?page={$i}'>{$i}</a></li>";
                }
            }
            ?>

        </ul>
    </div>
    <!--Main content-->
</div>


<?php include "includes/footerTopic.php" ?>