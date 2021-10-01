<div class="container-fluid mt-5" style="width: 520px;background: #fff; margin: 0 auto;">
    <div class="sign-up-content">
        <form method="POST" class="signup-form">
            <?php
            if (isset($_POST['submit'])) {
                $username       = escape($_POST['username']);
                $password       = escape($_POST['password']);
                $email          = escape($_POST['email']);
                $fullname       = escape($_POST['fullname']);
                $datecreated    = date("Y-m-d H:i:s");

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
                    $role = escape($_POST['role']);
                    if ($role == '1' || $role == '2') {
                        $faculty = 0;
                    } else {
                        if (isset($_POST['faculty'])) {
                            $faculty  = escape($_POST['faculty']);
                        } else {
                            $error['faculty'] = "This role need to be in a <strong>faculty</strong>!";
                        }
                    }
                } else {
                    $error['role'] = "Please select a role!";
                }
                if (strlen($username) < 5) {
                    $error['username'] = "Username needs to longer!";
                }
                if ($username == '') {
                    $error['username'] = "Username cannot be empty!";
                }
                if (username_exist($username)) {
                    $error['username'] = "This username already exists, pick another another. <a href='index.php'>Please Login</a>";
                }
                if ($fullname == '') {
                    $error['fullname'] = "Fullname cannot be empty!";
                }
                if ($email == '') {
                    $error['email']    = "Email cannot be empty!";
                }
                if (email_exist($email)) {
                    $error['email']    = "This email already exists, pick another another. <a href='index.php'>Please Login</a>";
                }
                if ($password == '') {
                    $error['password'] = "Password cannot be empty!";
                }

                foreach ($error as $key => $value) {
                    if (empty($value)) {
                        unset($error[$key]);
                    }
                }

                if (empty($error)) {
                    add_user($username, $email, $password, $role, $faculty, $fullname, $datecreated);
                    $success['success'] = "Account has been created! <a href='account.php'>View Users</a>";
                }
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
                        echo "<input onclick='offChecked()' type='radio' name='role' value='{$id}' id='{$name}' />";
                        echo "<label for='{$name}'>{$name}</label>";
                    } else {
                        echo "<input onclick='showChecked()' type='radio' name='role' value='{$id}' id='{$name}' />";
                        echo "<label for='{$name}'>{$name}</label>";
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
                        echo "<input type='radio' name='faculty' value='{$id}' id='{$name}' />";
                        echo "<label for='{$name}'>{$name}</label>";
                    }
                }
                ?>
            </div>
            <p style="color: red;" href=""><?php echo isset($error['faculty']) ? $error['faculty'] : '' ?></p>

            <div class="form-textbox-addUser">
                <div class="wrapper__input-field" style="position:relative;">
                    <label for="name">Full name</label>
                    <input type="text" name="fullname" id="fullname" class="input-addUser mb-2" value="<?php echo isset($fullname) ? $fullname : '' ?>" autocomplete="on" />
                </div>
                <p style="color: red;" href=""><?php echo isset($error['fullname']) ? $error['fullname'] : '' ?></p>
            </div>

            <div class="form-textbox-addUser">
                <div class="wrapper__input-field" style="position:relative;">
                    <label for="name">Username</label>
                    <input type="text" name="username" id="username" class="input-addUser mb-2" value="<?php echo isset($username) ? $username : '' ?>" autocomplete="on" />
                </div>
                <p style="color: red;" href=""><?php echo isset($error['username']) ? $error['username'] : '' ?></p>
            </div>

            <div class="form-textbox-addUser">
                <div class="wrapper__input-field" style="position:relative;">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="input-addUser mb-2" value="<?php echo isset($email) ? $email : '' ?>" autocomplete="on" />
                </div>
                <p style="color: red;" href=""><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
            </div>

            <div class="form-textbox-addUser">
                <div class="wrapper__input-field" style="position:relative;">
                    <label for="pass">Password</label>
                    <input type="password" name="password" id="password" class="input-addUser mb-2" value="<?php echo isset($password) ? $password : '' ?>" autocomplete="on" />
                </div>
                <p style="color: red;" href=""><?php echo isset($error['password']) ? $error['password'] : '' ?></p>
                <p style="color: green;" id="success"><?php echo isset($success['success']) ? $success['success'] : '' ?></p>
            </div>

            <div class="form-textbox-addUser">
                <input type="submit" name="submit" id="submit" class="submit-addUser" value="Create Account" />
            </div>
        </form>
    </div>
</div>