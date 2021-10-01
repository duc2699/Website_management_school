<div class="wrapper__maindashboard p-3">
    <div class="container-fluid mt-5" style="width: 520px;background: #fff; margin: 0 auto;">
        <div class="sign-up-content">
            <form method="POST" class="signup-form">
                <?php
                if (isset($_GET['p_id'])) {
                    $the_topic_id = escape($_GET['p_id']);

                    $query = "SELECT * FROM topics WHERE topic_id = {$the_topic_id}";

                    $select_topic_query = mysqli_query($connection, $query);

                    if (!$select_topic_query) {
                        die("Query Failed!" . mysqli_error($connection));
                    }

                    if (mysqli_num_rows($select_topic_query) == 1) {
                        $row = mysqli_fetch_array($select_topic_query, MYSQLI_ASSOC);

                        $topicname      =       $row['topic_name'];
                        $description    =       $row['description'];
                        $topic_id       =       $row['topic_id'];
                        $start          =       $row['start'];
                        $deadline_1          =       $row['deadline_1'];
                        $deadline_2          =       $row['deadline_2'];
                    }
                    if (isset($_POST['submit'])) {
                        $upDate1 = $_POST['startdate'];
                        $upDate2 = $_POST['enddate'];
                        $upDate3 = $_POST['editdate'];
    
                        $new_startdate      = date("Y-m-d H:i:s", strtotime($upDate1));
                        $new_enddate        = date("Y-m-d H:i:s", strtotime($upDate2));
                        $new_editdate       = date("Y-m-d H:i:s", strtotime($upDate3));
                        $new_nametopic      = escape($_POST['nametopic']);
                        $new_description    = escape($_POST['description']);
    
    
                        $error = [
                            'startdate'     =>  '',
                            'enddate'       =>  '',
                            'editdate'      =>  '',
                            'nametopic'     =>  '',
                            'description'   =>  ''
                        ];
    
                        $success = [
                            'success' => '',
                        ];
    
                        if (((strtotime($new_enddate) - strtotime($new_startdate)) / 60 / 60 / 24) <= 14) {
                            $error['enddate'] = "The End Date must be more than 14 days from Start Date!";
                        }
                        if (((strtotime($new_editdate) - strtotime($new_enddate)) / 60 / 60 / 24) <= 7) {
                            $error['editdate'] = "The Edit Date must be more than 7 days from End Date!";
                        }
                        if ($new_startdate == '') {
                            $error['startdate'] = "Start Date cannot be empty!";
                        }
                        if ($new_enddate == '') {
                            $error['enddate'] = "End Date cannot be empty!";
                        }
                        if ($new_editdate == '') {
                            $error['editdate']    = "Edit Date cannot be empty!";
                        }
                        if ($new_nametopic == '') {
                            $error['nametopic'] = "Topic name cannot be empty!";
                        }
                        if ($new_description == '') {
                            $error['description'] = "Description cannot be empty!";
                        }
    
                        foreach ($error as $key => $value) {
                            if (empty($value)) {
                                unset($error[$key]);
                            }
                        }
    
                        if (empty($error)) {
                            update_topic($new_startdate, $new_enddate, $new_editdate, $new_nametopic, $new_description, $topic_id);
                            $success['success'] = "The Topic has been updated! <a href='topic.php'>View Topics</a>";
                        }
                    }
                }
                
                else {
                    header("Location: ../admin/topic.php");
                }
                ?>

                <h2 class="form-title mb-3">Update Topic</h2>

                <!-- DATETIME PICKER "DATE START" -->
                <div class="form-textbox-addUser mb-3 mt-3">
                    <div class="wrapper__inputfield">
                        <label class="tit__dl" style="z-index: 10;" for="datestart">Start Time</label>
                        <div class='input-group date'>
                            <input value='<?php echo $start ?>' type='text' class="input-addUser" id='calendar1' name="startdate">
                        </div>
                    </div>
                    <span style="color: red;" href=""><?php echo isset($error['startdate']) ? $error['startdate'] : '' ?></span>
                </div>
                <!-- --------------- -->

                <!-- DATETIME PICKER "DATE END" -->
                <div class="form-textbox-addUser mb-3 mt-3">
                    <div class="wrapper__inputfield">
                        <label class="tit__dl" style="z-index: 10;" for="dateend">Contribute Deadline</label>
                        <div class='input-group date'>
                            <input value='<?php echo $deadline_1 ?>' type='text' class="input-addUser" id='calendar2' name="enddate">
                        </div>
                    </div>
                    <span style="color: red;" href=""><?php echo isset($error['enddate']) ? $error['enddate'] : '' ?></span>
                </div>
                <!-- --------------- -->

                <!-- DATETIME PICKER "EDIT END" -->
                <div class="form-textbox-addUser mb-3 mt-3">
                    <div class="wrapper__inputfield">
                        <label class="tit__dl" style="z-index: 10;" for="editend">Edit Deadline</label>
                        <div class='input-group date'>
                            <input value='<?php echo $deadline_2 ?>' type='text' class="input-addUser" id='calendar3' name="editdate">
                        </div>
                    </div>
                    <span style="color: red;" href=""><?php echo isset($error['editdate']) ? $error['editdate'] : '' ?></span>
                </div>
                <!-- --------------- -->

                <div class="form-textbox-addUser">
                    <div class="wrapper__inputfield">
                        <label for="name">Topic name</label>
                        <input type="text" name="nametopic" id="nametopic" class="input-addUser mb-3" value="<?php echo $topicname; ?>" />
                    </div>
                    <p style="color: red;" href=""><?php echo isset($error['nametopic']) ? $error['nametopic'] : '' ?></p>
                </div>

                <div class="form-group">
                    <textarea style="resize:none; height: 150px" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Description" name="description" id="description"><?php echo $description; ?></textarea>
                </div>
                <p style="color: red;" href=""><?php echo isset($error['description']) ? $error['description'] : '' ?></p>
                <p style="color: green;" id="success"><?php echo isset($success['success']) ? $success['success'] : '' ?></p>

                <div class="form-textbox-addUser">
                    <input type="submit" name="submit" id="submit" class="submit-addUser" value="Update" />
                </div>
            </form>
        </div>
    </div>
</div>