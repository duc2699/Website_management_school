<div class="container-fluid mt-5" style="width: 520px;background: #fff; margin: 0 auto;">
	<div class="sign-up-content">
		<form method="POST" class="signup-form">
		<?php
            if (isset($_GET['p_id'])) {
                $the_faculty_id = escape($_GET['p_id']);

                $query = "SELECT * FROM faculties WHERE faculty_id = {$the_faculty_id}";

                $select_topic_query = mysqli_query($connection, $query);

                if (!$select_topic_query) {
                    die("Query Failed!" . mysqli_error($connection));
                }

                if (mysqli_num_rows($select_topic_query) == 1 && $the_faculty_id !=0) {
                    $row = mysqli_fetch_array($select_topic_query, MYSQLI_ASSOC);
                    $facultyname      =       $row['faculty_name'];
                    $description      =       $row['description'];
                    $faculty_id         =       $row['faculty_id'];

                    
                }
                if (isset($_POST['submit'])) {
                    $facultyname       = escape($_POST['facultyname']);
                    $description       = escape($_POST['description']);
                    
    
                    $error = [
                        'facultyname'       =>  '',
                        'description'       =>  '',
                    ];
    
                    $success = [
                        'success' => '',
                    ];
    
                    if ($facultyname == '') {
                        $error['facultyname'] = "Faculty name cannot be empty!";
                    }
                    if (username_exist($facultyname)) {
                        $error['facultyname'] = "This Faculty already exists, pick another another.";
                    }
                    if ($description == '') {
                        $error['description'] = "Description cannot be empty!";
                    }
    
                    foreach ($error as $key => $value) {
                        if (empty($value)) {
                            unset($error[$key]);
                        }
                    }
    
                    if (empty($error)) {
                        $success['success'] = "The faculty has been updated! <a href='faculty.php'>View Faculties</a>";
                        update_faculty($facultyname, $description, $faculty_id);
                        
                    }
                }
            }
            
            else {
                header("Location: ../admin/faculty.php");
            }
            ?>
			<h2 class="form-title mb-3">Update Faculty</h2>

			<div class="form-textbox-addUser">
				<div class="wrapper__input-field" style="position:relative;">
					<label for="name">Faculty name</label>
					<input type="text" name="facultyname" id="facultyname" class="input-addUser mb-2" value="<?php echo $facultyname ?>" autocomplete="on" />
				</div>
				<p style="color: red;" href=""><?php echo isset($error['facultyname']) ? $error['facultyname'] : '' ?></p>
			</div>

			<div class="form-group">
				<textarea style="resize:none; height: 150px" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Description" name="description" id="description"><?php echo $description ?></textarea>
			</div>
			<p style="color: red;" href=""><?php echo isset($error['description']) ? $error['description'] : '' ?></p>
            <p style="color: green;" id="success"><?php echo isset($success['success']) ? $success['success'] : '' ?></p>

			<div class="form-textbox-addUser">
				<input type="submit" name="submit" id="submit" class="submit-addUser" value="Update" />
			</div>
		</form>
	</div>
</div>