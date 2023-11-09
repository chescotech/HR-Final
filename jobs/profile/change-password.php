<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include '../navigation_panel/authenticated_user_header.php'; ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['update_profile'])) {
            $message = "";
            include_once '../../Admin/Classes/Employees.php';
            $EmployeeObject = new Employee();
            $empId = $_SESSION['employee_id'];
            $oldPassword = $_POST['old_password'];
            $newPassword = $_POST['new_password'];
            $reEnterPassword = $_POST['re_new_password'];
            $checkRecods = $EmployeeObject->checkIfEmployeeExsists($oldPassword, $empId);
            if (mysqli_num_rows($checkRecods) > 0 && $newPassword == $reEnterPassword) {
                $EmployeeObject->changePasssword($newPassword, $empId);
                $message = "Your Password has been changed Sucessfully!!";
        ?>
            <?php
            }
            if (mysqli_num_rows($checkRecods) == 0) {
                $message = "Invalid Old Password Entered!!";
            ?>
            <?php
            } else if ($newPassword != $reEnterPassword) {
                $message = "Passwords Do not Match, Please re-enter the passwords!";
            ?>
        <?php
            }
        }
        ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <?php
                                $result = mysqli_query($link, "SELECT * FROM emp_info where empno='$employeeId' ") or die(mysqli_error($link));
                                $row = mysqli_fetch_array($result);
                                $position = $row['position'];
                                if ($row["photo"] != "") {
                                    $picname = $row["photo"];
                                } else {
                                    $picname = 'default.png';
                                }
                                $emp_name = $row['fname'] . "-" . $row['lname'];
                                echo '<img src="../../images/employees/' . $picname . '" width="250px" style="border-radius:30px">';
                                ?>

                                <h3 style="color: black" class="profile-username text-center"><b>

                                        <?php
                                        echo $emp_name;
                                        ?>
                                    </b>
                                </h3>

                                <p class="text-muted text-center">
                                    <strong style="color: black"><b><?php echo $position; ?></b></strong>
                                </p>

                            </div>
                        </div><!-- /.box -->
                    </div>
                    <div class="col-md-9">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#activity" data-toggle="tab">
                                        <?php
                                        if (isset($_POST['update_profile'])) {
                                            if ($message == "Your Password has been changed Sucessfully!!") {
                                                echo '<strong style="color: green"><b>' . $message . '</b></strong>';
                                            } else {
                                                echo '<strong style="color: red"><b>' . $message . '</b></strong>';
                                            }
                                        } else {
                                            echo 'Change Your Account Password';
                                        }
                                        ?>
                                    </a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Old Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="old_password" class="form-control" id="inputName" placeholder="Enter Old Password" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">New Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="new_password" type="text" class="form-control" id="inputName" placeholder="Enter New Password" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail" class="col-sm-2 control-label">Re enter Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="re_new_password" type="text" class="form-control" id="inputEmail" placeholder="Re enter New Password" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button name="update_profile" type="submit" class="btn btn-danger">Change Password</button>
                                            </div>
                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>

        <?php include '../footer/footer.php'; ?>

    </div>

    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <script src="../plugins/fastclick/fastclick.min.js"></script>

    <script src="../dist/js/app.min.js"></script>

    <script src="../dist/js/demo.js"></script>

</body>

</html>