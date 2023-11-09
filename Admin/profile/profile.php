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

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php include '../navigation_panel/authenticated_user_header.php'; ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['update_profile'])) {

            $Username = $_POST['username'];
            $FirstName = $_POST['first_name'];
            $LastName = $_POST['last_name'];
            $Email = $_POST['email_address'];
            $phone = $_POST['phone_number'];
            $AuthorsProfile = $_POST['authors_profile'];
            $file = rand(10000000, 10000000) . "-" . $_FILES['file']['name'];
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            $folder = "../uploads/";

            // image

            $Image_size = $_FILES['file']['size'];
            $Image_type = $_FILES['file']['type'];
            $Image_folder = "../uploads/";

            // new file size in KB
            $new_size = $file_size / 1024000;
            $image_size = $file_size / 1024000;
            // new file size in KB

            $new_file_name = strtolower($file);

            $final_file = str_replace(' ', '-', $new_file_name);

            if (move_uploaded_file($file_loc, $folder . $final_file)) {

                mysqli_query($link, "UPDATE users_tb SET  profile_pic='$final_file',phone_number='$phone',username ='$Username',email_address='$Email', first_name='$FirstName',"
                    . "last_name='$LastName',authors_profile='$AuthorsProfile' WHERE id= '1'") or die(mysqli_error($link));
        ?>

                <script>
                    alert('Upload Success');
                </script>

            <?php
            } else {

                mysqli_query($link, "UPDATE users_tb SET phone_number='$phone',authors_profile='$AuthorsProfile',username ='$Username',email_address='$Email', first_name='$FirstName',last_name='$LastName' WHERE id= '1'") or die(mysqli_error($link));
            ?>

                <script>
                    alert('Done');
                </script>

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
                                $employeeId = $_SESSION['employee_id'];
                                $user_query = mysqli_query($link, "select * from emp_info where empno='$employeeId'") or die(mysqli_error($link));
                                while ($row = mysqli_fetch_array($user_query)) {
                                    $id = $row['id'];
                                ?>

                                    <?php
                                    $photo = "../uploads/" . $row['photo'];
                                    $check_pic = $row['photo'];
                                    if (!file_exists($photo) || $check_pic == false) {
                                        $photo = "../Images/icon.png";
                                    }
                                    ?>

                                    <img src="<?php echo $photo; ?>" width="185" height="255" class="profile-user-img img-responsive img-circle" alt="User Image">

                                <?php
                                }
                                ?>

                                <h3 class="profile-username text-center">

                                    <?php
                                    $result = mysqli_query($link, "SELECT * FROM emp_info where empno='$employeeId' ") or die(mysqli_error($link));
                                    $row = mysqli_fetch_array($result);
                                    $position = $row['position'];
                                    echo $row['fname'] . "-" . $row['lname'];
                                    ?>

                                </h3>

                                <p class="text-muted text-center">
                                    <strong><?php echo $position; ?></strong>
                                </p>

                                <a href="#" class="btn btn-primary btn-block"><b>Edit</b></a>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                    <div class="col-md-9">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">

                                <li class="active"><a href="#activity" data-toggle="tab">Edit Your Profile</a></li>

                            </ul>
                            <div class="tab-content">

                                <div class="active tab-pane" id="activity">

                                    <?php
                                    $sql = "SELECT * FROM emp_info where empno='$employeeId'";
                                    $result = mysqli_query($link, $sql);
                                    while ($rows = mysqli_fetch_array($result)) {
                                    ?>

                                        <form method="post" enctype="multipart/form-data" class="form-horizontal">

                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">First Name</label>
                                                <div class="col-sm-10">
                                                    <input name="first_name" value="<?php echo $rows['fname']; ?>" class="form-control" id="inputName" placeholder="First Name">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputName" class="col-sm-2 control-label">Last Name</label>
                                                <div class="col-sm-10">
                                                    <input name="last_name" value="<?php echo $rows['lname']; ?>" type="text" class="form-control" id="inputName" placeholder="Last Name">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                                <div class="col-sm-10">
                                                    <input name="email_address" value="<?php echo $rows['email']; ?>" type="text" class="form-control" id="inputEmail" placeholder="Email">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">Phone</label>
                                                <div class="col-sm-10">
                                                    <input name="phone_number" value="<?php echo $rows['phone']; ?>" type="text" class="form-control" id="inputEmail" placeholder="Email">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">Residential Address</label>
                                                <div class="col-sm-10">
                                                    <input name="phone_number" value="<?php echo $rows['address']; ?>" type="text" class="form-control" id="inputEmail" placeholder="Email">
                                                </div>
                                            </div>


                                            <div class="form-group">

                                            </div>

                                            <div class="form-group">
                                                <label for="inputEmail" class="col-sm-2 control-label">Profile Pic</label>
                                                <div class="col-sm-10">
                                                    <input name="file" type="file" />
                                                </div>
                                            </div>

                                            <div class="box-body">
                                                <label>Upload Employee NRC or Passport Identity :</label>
                                                <div class="form-horizontal">
                                                    <input type="file" name="nrc_file" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button name="update_profile" type="submit" class="btn btn-danger">Update Profile</button>
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

<?php
                                    }
