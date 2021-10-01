<?php
    include("delete_modal.php");
    if (isset($_POST['checkBoxArray'])) {
        foreach($_POST['checkBoxArray'] as $userValueId)
        {
            $bulkOptions = $_POST['bulkOptions'];

            switch($bulkOptions) 
            {
                case 'delete':
                    $query = "DELETE FROM users WHERE user_id = {$userValueId}";

            }
        }
    }
?>

<div>
    <div class="">
        <div class="table-title">
            <div class="row mb-4">
                <div class="col-sm-3">
                    <a href="account.php?source=add_user" class="btn btn-light" style="float: left; border:1px solid black; border-radius: 5px;"><i class="material-icons"">&#xE147;</i> <span style="color:black;">Add
                            New User</span></a>
                </div>
                <div class="col-sm-5"></div>
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
                    
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Faculty</th>
                    <th>Role</th>
                    <th>Date Created</th>
                    <th>Status</th>
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

                $user_query_count = "SELECT * FROM users";
                $find_count       = mysqli_query($connection, $user_query_count);
                $count            = mysqli_num_rows($find_count);

                $count            = ceil($count / $per_page);

                // End Pagination

                $query = "SELECT * FROM users JOIN faculties ON user_faculty_id = faculty_id JOIN roles ON user_role = role_id LIMIT $page_1, $per_page";


                $get_users_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($get_users_query)) {

                    $fullname       =       $row['fullname'];
                    $image          =       $row['user_image'];
                    $username       =       $row['username'];
                    $email          =       $row['user_email'];
                    $role           =       $row['role_name'];
                    $faculty        =       $row['faculty_name'];
                    $date_created   =       $row['createdAt'];
                    $user_id        =       $row['user_id'];

                    echo "<tr>";

                ?>

                    <!-- <td><input class='input-group-text checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $user_id; ?>'></td> -->

                <?php
                    echo "<td>{$fullname}</td>";
                    echo "<td>{$username}</td>";
                    echo "<td>{$email}</td>";
                    echo "<td><img src='../{$image}' class='avatar-account' alt='avatar' /></td>";
                    echo "<td>{$faculty}</td>";
                    echo "<td>{$role}</td>";
                    echo "<td>{$date_created}</td>";
                    echo "<td><span class='status text-success'>&bull;</span> Active</td>";
                    echo "<td>";
                    echo "<a href='account.php?source=edit_user&p_id={$user_id}' class='edit' title='edit' data-toggle='tooltip'><i class='material-icons'>&#xE8B8;</i></a>";
                    echo "<a rel='$user_id' href='javascript:void(0)' class='delete_link' title='delete' data-toggle='tooltip'><i class='material-icons'>&#xE5C9;</i></a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
                <?php
                if (isset($_GET['delete'])) {
                    $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);

                    $query = "DELETE FROM users WHERE user_id = {$the_user_id}";

                    $delete_user_query = mysqli_query($connection, $query);

                    if (!$delete_user_query) {
                        die("Query Failed!" . mysqli_error($connection));
                    }

                    header("Location: account.php");
                }
                ?>
            </tbody>
        </table>
        <div class="clearfix">
            <ul class="pagination">
                <?php
                for ($i = 1; $i <= $count; $i++) {
                    if ($i == $page) {
                        echo "<li><a class='active_link' href='account.php?page={$i}'>{$i}</a></li>";
                    } else {
                        echo "<li><a href='account.php?page={$i}'>{$i}</a></li>";
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
                delete_url = "account.php?delete=" + id + "";

                $(".modal_delete_link").attr('href', delete_url);
                $("#myModal").modal('show');
            })
        })
    </script>