<?php
include("delete_modal.php");
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $facultiesValueId) {
        $bulkOptions = $_POST['bulkOptions'];

        switch ($bulkOptions) {
            case 'delete':
                $query = "DELETE FROM faculties WHERE faculty_id = {$facultiesValueId}";
        }
    }
}
?>

<div class="container-fluid">
    <div class="table-responsive">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-3">
                        <a href="faculty.php?source=add_faculty" class="btn btn-info" style="float: left; border:1px solid black; border-radius: 5px;"><i class="material-icons">&#xE147;</i> <span style="color:black">New topic</span></a>
                    </div>
                    <div class="col-sm-5">
                    </div>
                    <div class="col-sm-4">
                        <div>
                            <div class="searchbar">
                                <input class="search_input" type="text" name="" placeholder="Search...">
                                <a href="#" class="search_icon"><i class="fas fa-search"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>

                        <th style="white-space:nowrap">Faculty Name</th>
                        <th style="padding-left: 50px;">Descripton</th>
                        <th>Action</th>
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

                    $topic_query_count = "SELECT * FROM faculties";
                    $find_count       = mysqli_query($connection, $topic_query_count);
                    $count            = mysqli_num_rows($find_count);

                    $count            = ceil($count / $per_page);

                    // End Pagination

                    $query = "SELECT * FROM faculties ORDER BY faculty_id DESC LIMIT $page_1, $per_page";


                    $get_topics_query = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($get_topics_query)) {

                        $faculty_name      =       $row['faculty_name'];
                        $description       =       $row['description'];
                        $faculty_id        =       $row['faculty_id'];



                    ?>

                    <?php
                        if ($faculty_id != 0) {
                            echo "<tr>";
                            echo "<td>{$faculty_name}</td>";
                            echo "<td style='padding-left: 50px'>{$description}</td>";
                            echo "<td>";
                            echo "<a href='faculty.php?source=edit_faculty&p_id={$faculty_id}' class='edit' title='edit' data-toggle='tooltip'><i class='material-icons'>&#xE8B8;</i></a>";
                            echo "<a rel='$faculty_id' href='javascript:void(0)' class='delete_link' title='delete' data-toggle='tooltip'><i class='material-icons'>&#xE5C9;</i></a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                    <?php
                    if (isset($_GET['delete'])) {
                        $the_topic_id = mysqli_real_escape_string($connection, $_GET['delete']);

                        $query = "DELETE FROM faculties WHERE faculty_id = {$faculty_id}";

                        $delete_topic_query = mysqli_query($connection, $query);

                        if (!$delete_topic_query) {
                            die("Query Failed!" . mysqli_error($connection));
                        }

                        header("Location: faculty.php");
                    }
                    ?>
                </tbody>
            </table>
            <div class="clearfix">
                <ul class="pagination">
                    <?php
                    for ($i = 1; $i <= $count; $i++) {
                        if ($i == $page) {
                            echo "<li><a class='active_link' href='faculty.php?page={$i}'>{$i}</a></li>";
                        } else {
                            echo "<li><a href='faculty.php?page={$i}'>{$i}</a></li>";
                        }
                    }
                    ?>

                </ul>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $(".delete_link").on('click', function() {
                    id = $(this).attr("rel");
                    delete_url = "faculty.php?delete=" + id + "";

                    $(".modal_delete_link").attr('href', delete_url);
                    $("#myModal").modal('show');
                })
            })
        </script>