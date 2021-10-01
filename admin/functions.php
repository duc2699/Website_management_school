<?php
function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function comfirmQuery($result)
{
    global $connection;

    if (!$result) {
        die("Query Failed" . mysqli_error($connection));
    }
}

function usersOnline()
{
    if (isset($_GET['onlineusers'])) {
        global $connection;

        if (!$connection) {
            session_start();
            include("../includes/db.php");

            $session                =       session_id();
            $time                   =       time();
            $time_out_in_seconds    =       05;
            $time_out               =       $time - $time_out_in_seconds;

            $query      = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count      = mysqli_num_rows($send_query);

            if ($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('{$session}', '{$time}')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time = '{$time}' WHERE session = '{$session}'");
            }

            $user_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '{$time_out}'");
            echo $count_user   = mysqli_num_rows($user_online_query);
        }
    }
}

usersOnline();

function add_user($username, $email, $password, $role, $faculty, $fullname, $datecreated)
{
    global $connection;

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "INSERT INTO users(username, password, fullname, user_email, user_image, user_role, user_faculty_id, createdAt)";
    $query .= "VALUES('{$username}', '{$password}', '{$fullname}', '{$email}', 'images/default-avatar.png', '{$role}', '{$faculty}', '{$datecreated}')";

    $add_user_query = mysqli_query($connection, $query);

    if (!$add_user_query) {
        die("Query Failed!" . mysqli_error($connection));
    }  
}

function update_user($username, $email, $password, $role, $faculty, $fullname, $id)
{
    global $connection;

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "UPDATE users SET username='{$username}', password='{$password}', fullname='{$fullname}', user_email='{$email}', user_role={$role}, user_faculty_id={$faculty} WHERE user_id={$id}";

    $update_user_query = mysqli_query($connection, $query);

    if (!$update_user_query) {
        die("Query Failed!" . mysqli_error($connection));
    }

    header("Location: ../admin/account.php?source=edit_user&p_id={$id}");
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

function add_topic($startdate, $enddate, $editdate, $nametopic, $description)
{
    global $connection;

    $query = "INSERT INTO topics(start, deadline_1, deadline_2, topic_name, description)";
    $query .= "VALUES('{$startdate}', '{$enddate}', '{$editdate}', '{$nametopic}', '{$description}')";

    $add_topic_query = mysqli_query($connection, $query);

    if (!$add_topic_query) {
        die("Query Failed!" . mysqli_error($connection));
    }
}

function update_topic($start, $deadline_1, $deadline_2, $topicname, $description, $topic_id)
{
    global $connection;

    $query = "UPDATE topics SET start='{$start}', deadline_1='{$deadline_1}', deadline_2='{$deadline_2}', topic_name='{$topicname}', description='{$description}' WHERE topic_id={$topic_id}";

    $update_topic_query = mysqli_query($connection, $query);

    if (!$update_topic_query) {
        die("Query Failed!" . mysqli_error($connection));
    }

    header("Location: ../admin/topic.php?source=edit_topic&p_id={$topic_id}");
}

function add_faculty($faculty_name, $description)
{
    global $connection;

    $query = "INSERT INTO faculties(faculty_name, description)";
    $query .= "VALUES('{$faculty_name}', '{$description}')";

    $add_user_query = mysqli_query($connection, $query);

    if (!$add_user_query) {
        die("Query Failed!" . mysqli_error($connection));
    }
}

function update_faculty($faculty_name, $description, $faculty_id)
{
    global $connection;

    $query = "UPDATE faculties SET faculty_name='{$faculty_name}', description='{$description}' WHERE faculty_id={$faculty_id}";

    $update_topic_query = mysqli_query($connection, $query);

    if (!$update_topic_query) {
        die("Query Failed!" . mysqli_error($connection));
    }

    header("Location: ../admin/faculty.php?source=edit_faculty&p_id={$faculty_id}");
}


function recordCount($table)
{
    global $connection;

    $query = "SELECT * FROM " . $table;
    $select_record_count_query = mysqli_query($connection, $query);
    $result = mysqli_num_rows($select_record_count_query);

    return $result;
}

function checkStatus($table, $column, $status)
{
    global $connection;

    $query  = "SELECT * FROM $table WHERE $column = '$status'";
    $result = mysqli_query($connection, $query);

    return mysqli_num_rows($result);
}

function accept_contribution($id)
{
    global $connection;

    $query = "UPDATE contributions SET status = 'Accepted' WHERE contribution_id = '$id'";

    $accept_contribution_query = mysqli_query($connection, $query);

    if (!$accept_contribution_query) {
        die("Query Failed!" . mysqli_error($connection));
    }

    header("Location: ../admin/contribution_detail.php?p_id={$id}");
}

function decline_contribution($id)
{
    global $connection;

    $query = "UPDATE contributions SET status = 'Not Accepted' WHERE contribution_id = '$id'";

    $decline_contribution_query = mysqli_query($connection, $query);

    if (!$decline_contribution_query) {
        die("Query Failed!" . mysqli_error($connection));
    }

    header("Location: ../admin/contribution_detail.php?p_id={$id}");
}

function download_all_by_zip($faculty_id, $topic_id)
{
    global $connection;

    $query = "SELECT * FROM faculties WHERE faculty_id = $faculty_id";
    $get_faculty_query = mysqli_query($connection, $query);
    if (!$get_faculty_query) {
        die("Query Failed!" . mysqli_error($connection));
    }
    while ($row = mysqli_fetch_assoc($get_faculty_query)) {
        $faculty_name = $row['faculty_name'];
    }

    $query = "SELECT * FROM topics WHERE topic_id = $topic_id";
    $get_topic_query = mysqli_query($connection, $query);
    if (!$get_topic_query) {
        die("Query Failed!" . mysqli_error($connection));
    }
    while ($row = mysqli_fetch_assoc($get_topic_query)) {
        $topic_name = $row['topic_name'];
    }

    $query = "SELECT * FROM contributions WHERE status = 'Accepted' AND faculty_id = $faculty_id AND topicId = $topic_id";
    $get_contributions_query = mysqli_query($connection, $query);
    if (!$get_contributions_query) {
        die("Query Failed!" . mysqli_error($connection));
    }

    $zipname = '../uploads/zip/'.time() . '-' . $faculty_name . '-' . $topic_name . '.zip';
    $zip = new ZipArchive;

    if ($zip->open($zipname,  ZipArchive::CREATE) == TRUE) {
        while ($row = mysqli_fetch_assoc($get_contributions_query)) {
            $filename = $row['file'];
            $filepath = "../uploads/doc/" . $filename;
            if (file_exists($filepath)) {
                $zip->addFile(getcwd() . $filepath, $filename);
                $download_file = file_get_contents($filepath);
                $zip->addFromString(basename($filepath), $download_file);
            } else {
                echo "file does not exist";
            }
        }
        $zip->close();
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($zipname) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($zipname));
        ob_clean();
        flush();

        readfile($zipname);
    }
}

function add_comment($comment, $time_comment, $user_id, $contribution_id) {
    global $connection;

    $query = "INSERT INTO comments(comment, date, contribution_id, userId)";
    $query .= "VALUES('{$comment}', '{$time_comment}', '{$contribution_id}', '{$user_id}')";

    $add_comment_query = mysqli_query($connection, $query);

    if (!$add_comment_query) {
        die("Query Failed!" . mysqli_error($connection));
    }

    header("Location: ../admin/contribution_detail.php?p_id={$contribution_id}");
}