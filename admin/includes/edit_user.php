<div class="container-fluid mt-5" style="width: 520px;background: #fff; margin: 0 auto;">
    <div class="sign-up-content">
        <form method="POST" class="signup-form">
            <?php
            if (isset($_GET['p_id'])) {
                $the_user_id = escape($_GET['p_id']);

                $query = "SELECT * FROM users WHERE user_id = {$the_user_id}";

                $select_user_query = mysqli_query($connection, $query);

                if (!$select_user_query) {
                    die("Query Failed!" . mysqli_error($connection));
                }

                if (mysqli_num_rows($select_user_query) == 1) {
                    $row = mysqli_fetch_array($select_user_query, MYSQLI_ASSOC);
                    $fullname = $row["fullname"];
                    $username = $row["username"];
                    $email    = $row["user_email"];
                    $password = $row["password"];
                    $role     = $row["user_role"];
                    $faculty  = $row["user_faculty_id"];
                }

                if (isset($_POST['submit'])) {
                    $new_username = escape($_POST['username']);
                    $new_password = escape($_POST['password']);
                    $new_email    = escape($_POST['email']);
                    $new_fullname = escape($_POST['fullname']);

                    $error = [
                        'username'  =>  '',
                        'password'  =>  '',
                        'email'     =>  '',
                        'fullname'  =>  ''
                    ];

                    $success = [
                        'success' => '',
                    ];

                    if (isset($_POST['role'])) {
                        $new_role = escape($_POST['role']);
                        if ($new_role == '1' || $new_role == '2') {
                            $new_faculty = 0;
                        } else {
                            if (isset($_POST['faculty'])) {
                                $new_faculty  = escape($_POST['faculty']);
                            } else {
                                $error['faculty'] = "This role need to be in a <strong>faculty</strong>!";
                            }
                        }
                    } else {
                        $error['role'] = "Please select a role!";
                    }
                    if (strlen($new_username) < 5) {
                        $error['username'] = "Username needs to longer!";
                    }
                    if ($new_username == '') {
                        $error['username'] = "Username cannot be empty!";
                    }
                    if (username_exist($new_username) && $new_username != $username) {
                        $error['username'] = "This username already exists, pick another another. <a href='index.php'>Please Login</a>";
                    }
                    if ($new_fullname == '') {
                        $error['fullname'] = "Fullname cannot be empty!";
                    }
                    if ($new_email == '') {
                        $error['email']    = "Email cannot be empty!";
                    }
                    if (email_exist($new_email) && $new_email != $email) {
                        $error['email']    = "This email already exists, pick another another. <a href='index.php'>Please Login</a>";
                    }
                    if ($new_password == '') {
                        $error['password'] = "Password cannot be empty!";
                    }

                    foreach ($error as $key => $value) {
                        if (empty($value)) {
                            unset($error[$key]);
                        }
                    }

                    if (empty($error)) {
                        update_user($new_username, $new_email, $new_password, $new_role, $new_faculty, $new_fullname, $the_user_id);
                        $success['success'] = "Account has been updated! <a href='account.php'>View Users</a>";
                    }
                }
            }
            else {
                header("Location: ../admin/account.php");
            }
            ?>
            <h2 class="form-title">What type of user?</h2>
            <div class="form-radio-addUser">
                <?php
                $query = "SELECT * FROM roles";
                $get_roles_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($get_roles_query)) {
                    $id   = $row['role_id'];
                    $name = $row['role_name'];


                    if ($name == "Admin" || $name == "Manager") {
                        if($id == $role)
                        {
                            echo "<input onclick='offChecked()' type='radio' name='role' value='{$id}' id='{$name}' checked/>";
                            echo "<label for='{$name}'>{$name}</label>";
                        }
                        else
                        {
                            echo "<input onclick='offChecked()' type='radio' name='role' value='{$id}' id='{$name}'/>";
                            echo "<label for='{$name}'>{$name}</label>";
                        }
                    } else {
                        if($id == $role)
                        {
                            echo "<input onclick='showChecked()' type='radio' name='role' value='{$id}' id='{$name}' checked/>";
                            echo "<label for='{$name}'>{$name}</label>";
                            echo "<script>
                                    $(document).ready(function() {
                                        showChecked();
                                    })
                                 </script>";
                        }
                        else
                        {
                            echo "<input onclick='showChecked()' type='radio' name='role' value='{$id}' id='{$name}'/>";
                            echo "<label for='{$name}'>{$name}</label>";
                        }
                    }
                }
                ?>
            </div>
            <p style="color: red;" href=""><?php echo isset($error['role']) ? $error['role'] : '' ?></p>

            <div class="hiddenSubject mb-4 mt-4" id="selectedform" style="display: none">
                <h2 class="form-title-subject">What type of Falcuty?</h2>
                <?php
                $query = "SELECT * FROM faculties";
                $get_faculties_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($get_faculties_query)) {
                    $id   = $row['faculty_id'];
                    $name = $row['faculty_name'];

                    if ($id != 0) {
                        if($id == $faculty && $faculty != 0 )
                        {
                            echo "<input type='radio' name='faculty' value='{$id}' id='{$name}' checked/>";
                            echo "<label for='{$name}'>{$name}</label>";
                        }
                        else
                        {
                            echo "<input type='radio' name='faculty' value='{$id}' id='{$name}'/>";
                            echo "<label for='{$name}'>{$name}</label>";
                        }

                    }
                }
                ?>
            </div>
            <p style="color: red;" href=""><?php echo isset($error['faculty']) ? $error['faculty'] : '' ?></p>

            <div class="form-textbox-addUser">
                <div class="wrapper__input-field" style="position:relative;">
                    <label for="name">Full name</label>
                    <input type="text" name="fullname" id="fullname" class="input-addUser mb-2" value="<?php echo $fullname; ?>" autocomplete="on" />
                </div>
                <p style="color: red;" href=""><?php echo isset($error['fullname']) ? $error['fullname'] : '' ?></p>
            </div>

            <div class="form-textbox-addUser">
                <div class="wrapper__input-field" style="position:relative;">
                    <label for="name">Username</label>
                    <input type="text" name="username" id="username" class="input-addUser mb-2" value="<?php echo $username; ?>" autocomplete="on" />
                </div>
                <p style="color: red;" href=""><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
            </div>

            <div class="form-textbox-addUser">
                <div class="wrapper__input-field" style="position:relative;">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="input-addUser mb-2" value="<?php echo $email;?>" autocomplete="on" />
                </div>
                <p style="color: red;" href=""><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
            </div>

            <div class="form-textbox-addUser">
                <div class="wrapper__input-field" style="position:relative;">
                    <label for="pass">Password</label>
                    <input type="password" name="password" id="password" class="input-addUser mb-2" value="" autocomplete="on" />
                </div>
                <p style="color: red;" href=""><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                <p style="color: green;" id="success"><?php echo isset($success['success']) ? $success['success'] : '' ?></p>
            </div>

            <div class="form-textbox-addUser">
                <input type="submit" name="submit" id="submit" class="submit-addUser" value="Update" />
            </div>
        </form>
    </div>
</div>