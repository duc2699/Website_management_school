<?php include "includes/headerTopic.php" ?>
<?php
if (isset($_SESSION['user_role'])) {
  if (($_SESSION['user_role']) !== 'Student') {
    header('Location: ./index.php');
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
  <div id="home" class="view jarallax" data-jarallax='{"speed": 0.2}' style="background-image: url('/public/images/pngtree-welcome-back-to-school-background-image_389856.jpg'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
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
  <form method="post" enctype="multipart/form-data">
    <div class="popup__form">
      <h2 class="mb-4 text-center">Submit Form</h2>
      <?php

      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\Exception;

      if (isset($_GET['p_id'])) {
        $the_topic_id   = escape($_GET['p_id']);
        $the_user_id = $_SESSION['user_id'];
        // Check deadline to contribute
        $now_date = date("H:i d-m-Y");

        $query_contribution = "SELECT * FROM contributions WHERE student_id = {$the_user_id} AND topicId = {$the_topic_id}";
        $select_user_contribute = mysqli_query($connection, $query_contribution);
        if(mysqli_num_rows($select_user_contribute) !== 0)
        {
          header('Location: ./rvtopic.php');
        }

        $query = "SELECT * FROM topics WHERE topic_id = {$the_topic_id}";
        $select_topic_query = mysqli_query($connection, $query);

        if (!$select_topic_query) {
          die("Query Failed!" . mysqli_error($connection));
        }

        if (mysqli_num_rows($select_topic_query) == 1) {
          $row = mysqli_fetch_array($select_topic_query, MYSQLI_ASSOC);
          $upDate1 = $row['deadline_1'];
          $upDate  = $row['start'];
          $name = $row['topic_name'];
        }

        $now            =       strtotime($now_date);
        $deadline_1     =       strtotime($upDate1);
        $start          =       strtotime($upDate);

        if ($now > $deadline_1 || $now < $start) {
          header('Location: ./rvtopic.php');
        }
        // END

        // Contribute
        $target_img_dir = "uploads/img/";
        $target_doc_dir = "uploads/doc/";



        if (isset($_POST['contribute'])) {
          $target_img_file = $target_img_dir . basename($_FILES["upload_img"]["name"]);
          $target_doc_file = $target_doc_dir . basename($_FILES["upload_doc"]["name"]);
          $imageFileType   = strtolower(pathinfo($target_img_file, PATHINFO_EXTENSION));
          $docFileType     = strtolower(pathinfo($target_doc_file, PATHINFO_EXTENSION));

          $title          = escape($_POST['title']);
          $image          = time() . '-' . $_FILES['upload_img']['name'];
          $document       = time() . '-' . $_FILES['upload_doc']['name'];
          $status         = 'Pending';
          $upload_date    = date("Y-m-d H:i:s", time());
          $student_id     = $_SESSION['user_id'];
          $faculty_id     = $_SESSION['user_faculty'];
          $notes          = escape($_POST['notes']);

          $error = [
            'image'  =>  '',
            'doc'  =>  '',
          ];

          $success = [
            'success' => '',
          ];

          if (!isset($_FILES['upload_img']['tmp_name'])) {
            $error['image'] = "Please upload image!";
          }

          if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error['image'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          }

          if (!isset($_FILES['upload_doc']['tmp_name'])) {
            $error['doc'] = "Please upload document!";
          }

          if ($docFileType != "doc" && $docFileType != "docx") {
            $error['doc'] = "Sorry, only DOC and DOCX files are allowed.";
          }

          if (empty($_POST['agree'])) {
            $error['accept'] = "Accept term and conditions before submit!";
          }

          if ($title == '') {
            $error['title'] = "Title cannot be empty!";
          }


          foreach ($error as $key => $value) {
            if (empty($value)) {
              unset($error[$key]);
            }
          }

          if (empty($error)) {
            
            move_uploaded_file($_FILES['upload_img']['tmp_name'], $target_img_dir . time() . '-' . $_FILES['upload_img']['name']);
            move_uploaded_file($_FILES['upload_doc']['tmp_name'], $target_doc_dir . time() . '-'  . $_FILES['upload_doc']['name']);
            add_contribution($title, $image, $document, $status, $upload_date, $student_id, $faculty_id, $notes, $the_topic_id);
            $query_user = "SELECT * FROM users INNER JOIN roles ON users.user_role = roles.role_id WHERE users.user_faculty_id = {$faculty_id} AND roles.role_name = 'Coordinator'";

            $users = mysqli_query($connection, $query_user);

            while ($row = mysqli_fetch_assoc($users)) {
              $to = $row['user_email'];
              $fullname = $_SESSION['fullname'];
              $subject    = "$fullname has submited";
              $body       = "$fullname has submited to topic '$name'";

              require_once('includes/PHPMailer/src/PHPMailer.php');
              require_once('includes/PHPMailer/src/Exception.php');
              require_once('includes/PHPMailer/src/SMTP.php');

              $mail = new PHPMailer();
              $mail->isSMTP();
              $mail->SMTPAuth = true;
              $mail->SMTPSecure = 'ssl';
              $mail->Host = 'smtp.gmail.com';
              $mail->Port = '465';
              $mail->isHTML();
              $mail->Username = 'huytpk7411@gmail.com';
              $mail->Password = 'huytpk123';
              $mail->SetFrom($to);
              $mail->AddReplyTo($to);
              $mail->Subject = $subject;
              $mail->Body = $body;
              $mail->AddAddress($to);

              // $mail ->Send();

              if (!$mail->Send()) {
                // echo "<p class='bg-success'>Send mail successful</p>";
              }
            }
            $success['success'] = "The contribution has been added! <a href='contribution_detail.php?user_id={$student_id}&topic_id={$the_topic_id}'>View My Contribution</a>";
          }
        }
      } else {
        header('Location: ./rvtopic.php');
      }
      ?>
      <div class="con__term mt-4 mb-4">
        <div class="wrapper__termcond mb-4">
          <h4>Terms and conditions</h4>
          <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem incidunt ipsa voluptatibus
            debitis est nesciunt aliquam laudantium quae ea vero facilis nihil laboriosam temporibus,
            placeat excepturi molestiae accusamus odio maiores!
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet voluptatem impedit numquam
            aliquam optio possimus doloremque illum quasi obcaecati mollitia iure temporibus, delectus
            tempore distinctio nisi autem illo officiis repellendus?
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem incidunt ipsa voluptatibus
            debitis est nesciunt aliquam laudantium quae ea vero facilis nihil laboriosam temporibus,
            placeat excepturi molestiae accusamus odio maiores!
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet voluptatem impedit numquam
            aliquam optio possimus doloremque illum quasi obcaecati mollitia iure temporibus, delectus
            tempore distinctio nisi autem illo officiis repellendus?
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem incidunt ipsa voluptatibus
            debitis est nesciunt aliquam laudantium quae ea vero facilis nihil laboriosam temporibus,
            placeat excepturi molestiae accusamus odio maiores!
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet voluptatem impedit numquam
            aliquam optio possimus doloremque illum quasi obcaecati mollitia iure temporibus, delectus
            tempore distinctio nisi autem illo officiis repellendus?
            Lorem ipsum dolor sit, amet consectetur adipisicing elit. Autem incidunt ipsa voluptatibus
            debitis est nesciunt aliquam laudantium quae ea vero facilis nihil laboriosam temporibus,
            placeat excepturi molestiae accusamus odio maiores!
            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet voluptatem impedit numquam
            aliquam optio possimus doloremque illum quasi obcaecati mollitia iure temporibus, delectus
            tempore distinctio nisi autem illo officiis repellendus?
          </p>
        </div>
      </div>
      <div class="wrapper__input-pusubmit">
      <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
          </div>
          <input type="text" name="title" class="form-control" placeholder="Title" aria-label="" aria-describedby="inputGroup-sizing-default" value="<?php echo isset($title) ? $title : '' ?>">
          <p style="color: red;" href=""><?php echo isset($error['title']) ? $error['title'] : '' ?></p>
        </div>

        <div class="">
          <textarea placeholder="Write some notes..." class="textarea-pusubmit mt-3 mb-3" name="notes"><?php echo isset($notes) ? $notes : '' ?></textarea>
        </div>
      </div>

      <div class="wrapper__input-upload mt-3 mb-4">
        <span class="font-weight-bold">Image:</span>
        <input type="file" name="upload_img" id="upload_img">
        <p style="color: red;" href=""><?php echo isset($error['image']) ? $error['image'] : '' ?></p>
      </div>

      <div class="wrapper__input-upload mt-3 mb-4">
        <span class="font-weight-bold">Document:</span>
        <input type="file" name="upload_doc" id="upload_doc">
        <p style="color: red;" href=""><?php echo isset($error['doc']) ? $error['doc'] : '' ?></p>
      </div>

      <span style="font-size:15px">
        <input type="checkbox" name="agree" value="check" id="agree" />
        I have read and agree to the Terms and Conditions and Privacy Policy
      </span><br>
      <span style="color: red;"><?php echo isset($error['accept']) ? $error['accept'] : '' ?></span>
      <p style="color: green;" id="success"><?php echo isset($success['success']) ? $success['success'] : '' ?></p>

      <div id="wrapper__popup-btn" class="wrapper__popup-btn text-center mt-3">
        <input type="submit" class="btn btn-primary mt-5 mb-5"value="Upload Contribution" name="contribute">
      </div>
    </div>
  </form>
</div>

<?php include "includes/footerTopic.php" ?>