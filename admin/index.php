<?php include "includes/header.php" ?>

<?php
// Set your timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Get prev & next month
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    // This month
    $ym = date('Y-m');
}

// Check format
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

// Today
$today = date('Y-m-j', time());

// For H3 title
$html_title = date('Y / m', $timestamp);

// Create prev & next month link     mktime(hour,minute,second,month,day,year)
$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) - 1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp) + 1, 1, date('Y', $timestamp)));
// You can also use strtotime!
// $prev = date('Y-m', strtotime('-1 month', $timestamp));
// $next = date('Y-m', strtotime('+1 month', $timestamp));

// Number of days in the month
$day_count = date('t', $timestamp);

// 0:Sun 1:Mon 2:Tue ...
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
//$str = date('w', $timestamp);


// Create Calendar!!
$weeks = array();
$week = '';

// Add empty cell
$week .= str_repeat('<td></td>', $str);

for ($day = 1; $day <= $day_count; $day++, $str++) {

    $date = $ym . '-' . $day;

    if ($today == $date) {
        $week .= '<td class="today">' . $day;
    } else {
        $week .= '<td>' . $day;
    }
    $week .= '</td>';

    // End of the week OR End of the month
    if ($str % 7 == 6 || $day == $day_count) {

        if ($day == $day_count) {
            // Add empty cell
            $week .= str_repeat('<td></td>', 6 - ($str % 7));
        }

        $weeks[] = '<tr>' . $week . '</tr>';

        // Prepare for new week
        $week = '';
    }
}
?>


<?php
$query = "SELECT * FROM faculties";
$get_all_faculties = mysqli_query($connection, $query);
for ($i = 1; $i <= mysqli_num_rows($get_all_faculties); $i++) {


    $query = "SELECT * FROM users JOIN faculties ON user_faculty_id = faculty_id JOIN roles ON user_role = role_id";
    $get_count_users = mysqli_query($connection, $query);
    $student = 0;
    $guest = 0;
    $staff = 0;
    //  $array = array();

    while ($row = mysqli_fetch_assoc($get_count_users)) {
        $role = $row['role_name'];

        if ($role == "Student") {
            $student += 1;
        } elseif ($role == "Guest") {
            $guest += 1;
        } elseif ($role == "Coordinator") {
            $staff += 1;
        }
    }
}
?>

<style>
    .today {
        background: orange;
    }
</style>

<?php
if (isset($_SESSION['user_role'])) {
    if ($_SESSION['user_role'] !== 'Admin') {
        if ($_SESSION['user_role'] !== 'Manager') {
            if ($_SESSION['user_role'] !== 'Coordinator') {
                if ($_SESSION['user_role'] !== 'Guest') {
                    header('Location: ../index.php');
                }
            }
        }
    }
}
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
                                
                                <h3 class="title-form">Welcome to <?php echo $_SESSION['username'] ?> !</h3>
                            </div>
                            <div class="col-6 ">
                                <ol class="breadcrumbs">
                                    <li class="breadcrumbs-item">
                                        <a href="#"><i class="fas fa-home"></i></a>
                                    </li>
                                    <li class="breadcrumbs-item">
                                        <a href="#">Dashboard</a>
                                    </li>
                                </ol>
                                <!-- <li><a href="">Users Online: <span class="useronline"></span></a></li> -->
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-6">
                                <div class="card o-hidden profile-greeting">
                                    <div class="greeting-user text-center">
                                        <img style="width: 200px;" src="images/icon.png" alt="photo">
                                        <h4>All best wishes for you, <?php echo $_SESSION['username'] ?> !</h4>
                                        <label style="display:block">Today , you have archived lots of comments from
                                            your article
                                        </label>
                                        <button class="btn btn-light">What's news !</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="calendar">

                                    <header>

                                        <h2></a> <?php echo $html_title; ?></h2>

                                        <a class="btn-prev fontawesome-angle-left" href="?ym=<?php echo $prev; ?>">
                                            <i class="fas fa-angle-left"></i>
                                        </a>
                                        <a class="btn-next fontawesome-angle-right" href="?ym=<?php echo $next; ?>">
                                            <i class="fas fa-angle-right"></i>
                                        </a>

                                    </header>

                                    <table style="margin: 0 auto;">

                                        <thead>

                                            <tr>

                                                <td>Mo</td>
                                                <td>Tu</td>
                                                <td>We</td>
                                                <td>Th</td>
                                                <td>Fr</td>
                                                <td>Sa</td>
                                                <td>Su</td>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php

                                            foreach ($weeks as $week) {
                                                echo $week;
                                            }
                                            ?>
                                        </tbody>



                                    </table>

                                </div> <!-- end calendar -->
                            </div>
                        </div>
                    </div>

                    <!-- Statistical -->
                    <div class="mt-4 mb-4">
                        <h3 class="title-form">Statistical</h3>

                        <div class="card mt-4">
                            <div class="card-body p-0">
                                <div class="row m-0 chart-main">
                                    <div class="col-4 p-0">
                                        <div class="wrapper__stcard bg-info media align-items-center">
                                            <div class="hospital-small-chart m-auto">
                                                <div class="small-bar">
                                                    <div class="small-chart flot-chart-container">
                                                        <div class="media-body d-flex">
                                                            <i class="fas fa-user-tie fa-4x"></i>
                                                            <div class="right-chart-content ml-5 mt-auto mb-auto">
                                                                <h4>
                                                                    <?= $staff; ?>
                                                                </h4>
                                                                <span>Coordinators</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 p-0">
                                        <div class="wrapper__stcard bg-primary media align-items-center">
                                            <div class="hospital-small-chart m-auto">
                                                <div class="small-bar">
                                                    <div class="small-chart flot-chart-container">
                                                        <div class="media-body d-flex">
                                                            <i class="far fa-newspaper fa-4x"></i>
                                                            <div class="right-chart-content ml-5 mt-auto mb-auto">
                                                                <h4>
                                                                    <?php
                                                                    $query = "SELECT * FROM topics";
                                                                    $get_count_contributions = mysqli_query($connection, $query);

                                                                    $count = mysqli_num_rows($get_count_contributions);

                                                                    echo $count;
                                                                    ?>
                                                                </h4>
                                                                <span>Topics</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 p-0">
                                        <div class="wrapper__stcard bg-warning media align-items-center">
                                            <div class="hospital-small-chart m-auto">
                                                <div class="small-bar">
                                                    <div class="small-chart flot-chart-container">
                                                        <div class="media-body d-flex">
                                                            <i class="far fa-newspaper fa-4x"></i>
                                                            <div class="right-chart-content ml-5 mt-auto mb-auto">
                                                                <h4>
                                                                    <?php
                                                                    $query = "SELECT * FROM contributions";
                                                                    $get_count_contributions = mysqli_query($connection, $query);

                                                                    $count = mysqli_num_rows($get_count_contributions);

                                                                    echo $count;
                                                                    ?>
                                                                </h4>
                                                                <span>Contributions</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 p-0">
                                        <div class="wrapper__stcard bg-warning media align-items-center">
                                            <div class="hospital-small-chart m-auto">
                                                <div class="small-bar">
                                                    <div class="small-chart flot-chart-container">
                                                        <div class="media-body d-flex">
                                                            <i class="fas fa-user-graduate fa-4x"></i>
                                                            <div class="right-chart-content ml-5 mt-auto mb-auto">
                                                                <h4>
                                                                    <?= $student; ?>
                                                                </h4>
                                                                <span>Students</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 p-0">
                                        <div class="wrapper__stcard bg-success media align-items-center">
                                            <div class="hospital-small-chart m-auto">
                                                <div class="small-bar">
                                                    <div class="small-chart flot-chart-container">
                                                        <div class="media-body d-flex">
                                                            <i class="far fa-newspaper fa-4x"></i>
                                                            <div class="right-chart-content ml-5 mt-auto mb-auto">
                                                                <h4>
                                                                    <?php
                                                                    $query = "SELECT * FROM topics Where Now() - deadline_1 < 0";
                                                                    $get_count_contributions = mysqli_query($connection, $query);

                                                                    $count = mysqli_num_rows($get_count_contributions);

                                                                    echo $count;
                                                                    ?>
                                                                </h4>
                                                                <span>Topics still time</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 p-0">
                                        <div class="wrapper__stcard bg-info media align-items-center">
                                            <div class="hospital-small-chart m-auto">
                                                <div class="small-bar">
                                                    <div class="small-chart flot-chart-container">
                                                        <div class="media-body d-flex">
                                                            <i class="far fa-newspaper fa-4x"></i>
                                                            <div class="right-chart-content ml-5 mt-auto mb-auto">
                                                                <h4>
                                                                    <?php
                                                                    $query = "SELECT * FROM contributions Where status = 'Accepted'";
                                                                    $get_count_contributions = mysqli_query($connection, $query);

                                                                    $count = mysqli_num_rows($get_count_contributions);

                                                                    echo $count;
                                                                    ?>
                                                                </h4>
                                                                <span>Contributions Confirmed</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 p-0">
                                        <div class="wrapper__stcard bg-info media align-items-center">
                                            <div class="hospital-small-chart m-auto">
                                                <div class="small-bar">
                                                    <div class="small-chart flot-chart-container">
                                                        <div class="media-body d-flex">
                                                            <i class="far fa-newspaper fa-4x"></i>
                                                            <div class="right-chart-content ml-5 mt-auto mb-auto">
                                                                <h4>
                                                                     <span class="useronline"></span>
                                                                </h4>
                                                                <span>User Online</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- <div class="row mt-5">
                            <canvas style="background-color: white; border-radius: 10px;" id="myChart"></canvas>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            var year = document.getElementById("year").value;
            var topic = document.getElementById("topic").value;
            var faculty = document.getElementById("faculty").value;
            var ajax = new XMLHttpRequest();
            ajax.open("POST", "./includes/statistical.php", true);

            ajax.onreadystatechange = function() {
                if (this.readyState == 4) {
                    if (this.status == 200) {
                        console.log(this.responseText);

                        if (this.responseText > 0) {
                            // document.getElementById("grant-total-text").innerHTML = "Total: $" + this.responseText;

                            // swal("Coupon code accepted", "Please wait while we re-calculate your price." , "success");
                            // window.location.reload();
                        } else {
                            // swal("Coupon code failed", "Sorry, this coupon code is not correct." , "error");
                        }
                    }

                    if (this.status == 500) {
                        console.log(this.responseText);
                    }
                }
            };

            var formData = new FormData();
            formData.append("hidden-year", year);
            formData.append("hidden-topic", topic);
            formData.append("hidden-faculty", faculty);
            ajax.send(formData);
        }

    )
</script>
<!-- Chart -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"></script>
<script>
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<script>
    var ctx = document.getElementById('myChart');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>
<?php include "includes/footer.php" ?>