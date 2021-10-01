<?php include "includes/headerTopic.php" ?>
<?php
if (isset($_SESSION['user_role'])) {
  if ($_SESSION['user_role'] !== 'Student') {
    header('Location: ./index.php');
  }
}
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
      <h2 class="mb-5 mt-5 text-center">Submit Form</h2>
      <?php
      if (isset($_GET['p_id'])) {
        $the_user_id = $_SESSION['user_id'];
        $the_contribution_id = escape($_GET['p_id']);
        // Check deadline to edit contribution
        $now_date = date("H:i d-m-Y");

        $query = "SELECT * FROM contributions JOIN topics on topicId = topic_id  WHERE contribution_id = {$the_contribution_id}";
        $select_topic_query = mysqli_query($connection, $query);

        if (!$select_topic_query) {
          die("Query Failed!" . mysqli_error($connection));
        }

        if (mysqli_num_rows($select_topic_query) == 1) {
          $row = mysqli_fetch_array($select_topic_query, MYSQLI_ASSOC);
          $upDate2 = $row['deadline_2'];
        }

        $now            =       strtotime($now_date);
        $deadline_2     =       strtotime($upDate2);

        if ($now > $deadline_2) {
          header('Location: ./rvtopic.php');
        }
        // END
        $target_img_dir = "uploads/img/";
        $target_doc_dir = "uploads/doc/";


        $query = "SELECT * FROM contributions JOIN users on student_id = user_id WHERE contribution_id = {$the_contribution_id}";
        $select_contribution_query = mysqli_query($connection, $query);

        if (!$select_contribution_query) {
          die("Query Failed!" . mysqli_error($connection));
        }

        if (mysqli_num_rows($select_contribution_query) == 1) {
          $row = mysqli_fetch_array($select_contribution_query, MYSQLI_ASSOC);

          $contribution_title                  =       $row['name'];
          $file_name                           =       $row['file'];
          $contribution_notes                  =       $row['notes'];
          $contribution_image                  =       $row['image'];
          $student_username                    =       $row['username'];
          $student_id                          =       $row['student_id'];
          $topic_id                            =       $row['topicId'];
        }

        if($student_username !== $_SESSION['username']){
          header('Location: ./rvtopic.php');
        }

        if (isset($_POST['contribute'])) {
          $target_img_file = $target_img_dir . basename($_FILES["upload_img"]["name"]);
          $target_doc_file = $target_doc_dir . basename($_FILES["upload_doc"]["name"]);
          $imageFileType   = strtolower(pathinfo($target_img_file, PATHINFO_EXTENSION));
          $docFileType     = strtolower(pathinfo($target_doc_file, PATHINFO_EXTENSION));

          $title          = escape($_POST['title']);
          $image          = time() . '-' . $_FILES['upload_img']['name'];
          $document       = time() . '-' . $_FILES['upload_doc']['name'];
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
            edit_contribution($title, $image, $document, $notes, $the_contribution_id);
            $success['success'] = "The contribution has been edited! <a href='contribution_detail.php?user_id={$student_id}&topic_id={$topic_id}'>View My Contribution</a>";
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
          <input type="text" name="title" class="form-control" placeholder="Title" aria-label="" aria-describedby="inputGroup-sizing-default" value="<?php echo isset($contribution_title) ? $contribution_title : '' ?>">
          <p style="color: red;" href=""><?php echo isset($error['title']) ? $error['title'] : '' ?></p>
        </div>


        <div class="">
          <textarea placeholder="Write some notes..." class="textarea-pusubmit mt-3 mb-3" name="notes"><?php echo isset($contribution_notes) ? $contribution_notes : '' ?></textarea>
        </div>
      </div>

      <div class="wrapper__input-upload mt-3 mb-4">
        <span class="font-weight-bold">Image file:</span>
        <input type="file" name="upload_img" id="upload_img">
        <p style="color: red;" href=""><?php echo isset($error['image']) ? $error['image'] : '' ?></p>
      </div>

      <div class="wrapper__input-upload mt-3 mb-4">
        <span class="font-weight-bold">Document file:</span>
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
        <input type="submit" value="Edit contribution" class="btn btn-primary mt-5 mb-5" name="contribute">
      </div>
    </div>
  </form>
</div>

<?php include "includes/footerTopic.php" ?>