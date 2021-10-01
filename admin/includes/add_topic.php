<div class="wrapper__maindashboard p-3">
    <div class="container-fluid mt-5" style="width: 520px;background: #fff; margin: 0 auto;">
        <div class="sign-up-content">
            <form method="POST" class="signup-form">
                <?php
                if (isset($_POST['submit'])) {
                    $newDate1 = escape($_POST['startdate']);
                    $newDate2 = escape($_POST['enddate']);
                    $newDate3 = escape($_POST['editdate']);

                    $startdate      = date("Y-m-d H:i:s", strtotime($newDate1));
                    $enddate        = date("Y-m-d H:i:s", strtotime($newDate2));
                    $editdate       = date("Y-m-d H:i:s", strtotime($newDate3));
                    $nametopic      = escape($_POST['nametopic']);
                    $description    = escape($_POST['description']);


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

                    if (((strtotime($newDate2) - strtotime($newDate1)) / 60 / 60 / 24) <= 14) {
                        $error['enddate'] = "The End Date must be more than 14 days from Start Date!";
                    }
                    if (((strtotime($newDate3) - strtotime($newDate2)) / 60 / 60 / 24) <= 7) {
                        $error['editdate'] = "The Edit Date must be more than 7 days from End Date!";
                    }
                    if ($startdate == '1970-01-01 01:00:00') {
                        $error['startdate'] = "Start Date cannot be empty!";
                    }
                    if ($enddate == '1970-01-01 01:00:00') {
                        $error['enddate'] = "End Date cannot be empty!";
                    }
                    if ($editdate == '1970-01-01 01:00:00') {
                        $error['editdate']    = "Edit Date cannot be empty!";
                    }
                    if ($nametopic == '') {
                        $error['nametopic'] = "Topic name cannot be empty!";
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
                        add_topic($startdate, $enddate, $editdate, $nametopic, $description);
                        $success['success'] = "The Topic has been created! <a href='topic.php'>View Topics</a>";
                    }
                }
                ?>

                <h2 class="form-title mb-3">New Topic</h2>

                <!-- DATETIME PICKER "DATE START" -->
                <div class="form-textbox-addUser mb-3 mt-3">
                    <div class="wrapper__inputfield">
                        <label class="tit__dl" style="z-index: 10;" for="datestart">Start Time</label>
                        <div class='input-group date'>
                            <input type='text' class="input-addUser" id='calendar1' name="startdate">
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
                            <input type='text' class="input-addUser" id='calendar2' name="enddate">
                        </div>
                    </div>
                    <span id="enddate" style="color: red;" href=""><?php echo isset($error['enddate']) ? $error['enddate'] : '' ?></span>
                </div>
                <!-- --------------- -->

                <!-- DATETIME PICKER "EDIT END" -->
                <div class="form-textbox-addUser mb-3 mt-3">
                    <div class="wrapper__inputfield">
                        <label class="tit__dl" style="z-index: 10;" for="editend">Edit Deadline</label>
                        <div class='input-group date'>
                            <input type='text' class="input-addUser" id='calendar3' name="editdate">
                        </div>
                    </div>
                    <span id="editdate" style="color: red;" href=""><?php echo isset($error['editdate']) ? $error['editdate'] : '' ?></span>
                </div>
                <!-- --------------- -->

                <div class="form-textbox-addUser">
                    <div class="wrapper__inputfield">
                        <label for="name">Topic name</label>
                        <input type="text" name="nametopic" id="nametopic" class="input-addUser mb-3" />
                    </div>
                    <span style="color: red;" href=""><?php echo isset($error['nametopic']) ? $error['nametopic'] : '' ?></span>
                </div>

                <div class="form-group">
                    <textarea style="resize:none; height: 150px" class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Description" name="description" id="description"></textarea>
                </div>
                <span style="color: red;" href=""><?php echo isset($error['description']) ? $error['description'] : '' ?></span>
                <p style="color: green;" id="success"><?php echo isset($success['success']) ? $success['success'] : '' ?></p>

                <div class="form-textbox-addUser">
                    <input type="submit" name="submit" id="submit" class="submit-addUser" value="Create topic" />
                </div>
            </form>
        </div>
    </div>
</div>