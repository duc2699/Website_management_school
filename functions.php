<?php
$now = new DateTime();

function comfirmQuery($result)
{
    global $connection;

    if (!$result) {
        die("Query Failed" . mysqli_error($connection));
    }
}

function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function redirect($file)
{
    global $connection;

    return header("Location .$file");
}

function username_exist($username)
{
    global $connection;

    $query  = "SELECT username FROM users WHERE username = '{$username}'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function email_exist($email)
{
    global $connection;

    $query  = "SELECT user_email FROM users WHERE user_email = '{$email}'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function register_user($username, $email, $password)
{
    global $connection;

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

    $query = "INSERT INTO users(username, password, user_email, user_role)";
    $query .= "VALUES('{$username}', '{$password}', '{$email}', 'Subscriber')";

    $register_user_query = mysqli_query($connection, $query);

    if (!$register_user_query) {
        die("Query Failed!" . mysqli_error($connection));
    }

    echo "<p class='bg-success'>Your registration has been submitted</p>";
}

function login_user($username, $password)
{
    global $connection;

    // if ($username === ' ') {
    //     $_SESSION['validate_username'] = "<p class='alert alert-danger'>Username is required!</p>";
    // }
    // if ($password === ' ') {
    //     $_SESSION['validate_password'] = "<p class='alert alert-danger'>Password is required!</p>";
    // }

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_query = mysqli_query($connection, $query);

    comfirmQuery($select_user_query);

    while ($row = mysqli_fetch_assoc($select_user_query)) {
        $db_user_id         =   $row['user_id'];
        $db_username        =   $row['username'];
        $db_password        =   $row['password'];
        $db_fullname        =   $row['fullname'];
        $db_email           =   $row['user_email'];
        $db_user_role       =   $row['user_role'];
        $db_user_faculty    =   $row['user_faculty_id'];
        $db_user_image      =   $row['user_image'];
    }

    if ($db_user_role !== "") {
        $role_query = "SELECT role_name FROM roles WHERE role_id = {$db_user_role}";
        $select_role_query = mysqli_query($connection, $role_query);

        while ($row = mysqli_fetch_assoc($select_role_query)) {
            $db_role = $row['role_name'];
        }
    }

    // $password = crypt($password, $db_password);

    if ($username === $db_username && password_verify($password, $db_password)) {
        $_SESSION['user_id']        =   $db_user_id;
        $_SESSION['username']       =   $db_username;
        $_SESSION['password']       =   $db_password;
        $_SESSION['fullname']       =   $db_fullname;
        $_SESSION['user_email']     =   $db_email;
        $_SESSION['user_role']      =   $db_role;
        $_SESSION['user_faculty']   =   $db_user_faculty;
        $_SESSION['user_image']     =   $db_user_image;

        header("Location: ../admin");
    } else {
        $_SESSION['error'] = "<p class='alert alert-danger'>Your username or password is wrong!</p>";
        header("Location: ../login.php");
    }
}

function is_admin($username = '')
{
    global $connection;

    $user_role_query = "SELECT user_role FROM users WHERE username = '$username'";
    $query = "SELECT role_name FROM roles WHERE role_id = '$user_role_query";

    $result = mysqli_query($connection, $query);

    if ($result == 'Admin') {
        return true;
    } else {
        return false;
    }
}

function add_contribution($name, $image, $file, $status, $upload_date, $student_id, $faculty_id, $notes, $topic_id)
{
    global $connection;

    $query = "INSERT INTO contributions(name, image, file, status, upload_date, student_id, faculty_id, notes, topicId)";
    $query .= "VALUES('{$name}', '{$image}', '{$file}', '{$status}', '{$upload_date}', '{$student_id}', '{$faculty_id}', '{$notes}', '{$topic_id}')";

    $add_contribution_query = mysqli_query($connection, $query);

    if (!$add_contribution_query) {
        die("Query Failed!" . mysqli_error($connection));
    }
}

function edit_contribution($name, $image, $file, $notes, $id)
{
    global $connection;

    $query = "UPDATE contributions SET name = '{$name}', image = '{$image}', file = '{$file}', notes = '{$notes}' WHERE contribution_id = '$id'";

    $edit_contribution_query = mysqli_query($connection, $query);

    if (!$edit_contribution_query) {
        die("Query Failed!" . mysqli_error($connection));
    }
}

function add_comment($comment, $time_comment, $user_id, $contribution_id, $the_topic_id)
{
    global $connection;

    $query = "INSERT INTO comments(comment, date, contribution_id, userId)";
    $query .= "VALUES('{$comment}', '{$time_comment}', '{$contribution_id}', '{$user_id}')";

    $add_comment_query = mysqli_query($connection, $query);

    if (!$add_comment_query) {
        die("Query Failed!" . mysqli_error($connection));
    }

    header("Location: ./contribution_detail.php?user_id={$user_id}&topic_id={$the_topic_id}");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_mail($to, $subject, $body)
{
    // for live
    /*$headers = 'From: Cinema <your_gmail>' . "\r\n";
        $headers .= 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        return mail($to, $subject, $body, $headers);*/


    //  use PHPMailer\PHPMailer\PHPMailer;
    // use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $mail = new PHPMailer;

    // $mail->SMTPDebug = 3;                               // Enable verbose debug output

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'huytpk7411@gmail.com';                 // SMTP username
    $mail->Password = 'huytpk123';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    $mail->setFrom('huytpk7411@gmail.com', 'WEB');
    $mail->addAddress($to);     // Add a recipient
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body    = $body;

    if (!$mail->send()) {
        // die('Mailer Error: ' . $mail->ErrorInfo);
    }
}
