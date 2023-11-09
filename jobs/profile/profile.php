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
        if (isset($_POST['update'])) {
            $stateMessage = "";

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $dob = $_POST['dob'];
            $gender = $_POST['gender'];

            mysqli_query($link, "UPDATE jobs_users SET fname = '$fname', lname = '$lname', email = '$email',
                                    phone = '$phone', dob = '$dob', gender = '$gender'
                         WHERE  username = '$username' ") or die("An error occure" . mysqli_error($link));

            $stateMessage = "Employee information Successully updated !!";
        }
        ?>

        <div class="content-wrapper">

            <section class="content">

                <div class="row">
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <?php
                                $username = $_SESSION['job_username'];
                                $result = mysqli_query($link, "SELECT * FROM jobs_users where username='$username' ") or die(mysqli_error($link));
                                $row = mysqli_fetch_array($result);

                                $picname = 'default.png';
                                $emp_name = $row['fname'] . "-" . $row['lname'];
                                echo '<img src="../../images/employees/' . $picname . '" width="250px" style="border-radius:30px">';
                                ?>

                                <h3 style="color: black" class="profile-username text-center"><b>

                                        <?php
                                        echo $emp_name;
                                        ?>
                                    </b>
                                </h3>


                            </div>
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                    <div class="col-md-8">
                        <div class="box box-primary">

                            <div class="box-body box-profile">

                                <div class="col-md-12">
                                    <?php
                                    if (isset($_POST['update'])) {
                                        // return var_dump($_FILES["img"]["name"]);
                                    }
                                    ?>
                                    <?php
                                    $empQuery = mysqli_query($link, "SELECT * FROM jobs_users where username='$username' ") or die(mysqli_error($link));

                                    while ($rows = mysqli_fetch_array($empQuery)) {
                                    ?>
                                        <form enctype="multipart/form-data" method="post">
                                            <div class="">
                                                <div class="">
                                                    <center>
                                                        <?php
                                                        if (isset($_POST['update'])) {
                                                            echo ' <center>
                                                                <h3 style="color: green" class="box-title"><b>' . $stateMessage . '</b></h3>
                                                                </center>';
                                                        } else {
                                                            echo ' <center>
                                                                <h3 class="box-title"><b>Update Your Profile</b></h3>
                                                                </center>';
                                                        }
                                                        ?>
                                                    </center>
                                                </div>

                                                <div class="form-group has-feedback">
                                                    <label class="">First Name</label>
                                                    <input name="fname" type="text" value="<?php echo $rows['fname'] ?>" required="required" class="form-control">
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label class="">Last Name</label>
                                                    <input name="lname" type="text" value="<?php echo $rows['lname'] ?>" required="required" class="form-control">
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label class="">User Name</label>
                                                    <input name="username" type="text" value="<?php echo $rows['username'] ?>" required="required" class="form-control">
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label class="">Email</label>
                                                    <input name="email" type="email" value="<?php echo $rows['email'] ?>" required="required" class="form-control">
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label class="">Phone Number</label>
                                                    <input name="phone" type="text" value="<?php echo $rows['phone'] ?>" required="required" class="form-control">
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label class="">Date of Birth</label>
                                                    <input name="dob" type="date" value="<?php echo $rows['dob'] ?>" required="required" class="form-control">
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <label class="">Gender</label>
                                                    <select name="gender" class="form-control">
                                                        <option value="<?php echo $rows['gender'] ?>"> <?php echo $rows['gender'] ?> </option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                                <!-- <div class="form-group has-feedback">
                                                    <label class="">New Password (Leave as is if you're keeping the old one)</label>
                                                    <input name="password" type="password" value="<?php //echo $rows['password'] 
                                                                                                    ?>" required="required" class="form-control">
                                                </div> -->

                                                <div class="box-footer">
                                                    <div class="pull-right">
                                                        <button name="update" type="submit" class="btn btn-primary"></i>Update</button>
                                                    </div>
                                                    <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                                </div>
                                            </div>
                                        </form>


                                    <?php } ?>

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