<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add User</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <script src="../../js/jquery.min.js"></script>

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <!-- Left side column. contains the logo and sidebar -->
        <?php
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Department.php';
        include_once '../Classes/Group.php';
        $GroupObject = new Group();
        $DepartmentObject = new Department();
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save_post'])) {
            $stateMessage = "";
            $user_name = $_POST['user_name'];
            $firstname = $_POST['firstname'];
            $lastname = $_POST['lastname'];
            $email_address = $_POST['email_address'];
            $status = $_POST['status'];
            $password = md5($_POST['password']);
            $repassword = md5($_POST['repassword']);
            $usergroup = $_POST['group_selection'];
            $company_id = $_SESSION['company_ID'];

            // Check if the user already exists
            if ($DepartmentObject->checkUser($user_name, $company_id) == "true") {
                // Perform the update only if the user exists
                $updateQuery = "UPDATE users_tb SET 
                firstname = '$firstname',
                lastname = '$lastname',
                email_address = '$email_address',
                status = '$status',
                password = '$password',
                user_type = 'HR Admin',
                group_id = '$usergroup'
                WHERE user_name = '$user_name' AND company_id = '$company_id'";

                $res = mysqli_query($link, $updateQuery);

                if ($res) {
                    $stateMessage = "User has been updated successfully!";
                } else {
                    $stateMessage = "Error updating user: " . mysqli_error($link);
                }
            } else {
                $stateMessage = "The username selected does not exist. Please provide a valid username.";
            }
        }
        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <!-- fetch user -->
                <?php
                $user_id = $_GET["id"];
                $user_query = mysqli_query($link, "SELECT * FROM users_tb WHERE id='$user_id'");

                $user_row = mysqli_fetch_array($user_query);
                ?>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="users" class="btn btn-primary btn-block margin-bottom">Back</a>
                        <div class="box box-solid">
                        </div><!-- /. box -->

                    </div><!-- /.col -->
                    <div class="col-md-5">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <?php
                                    if (isset($_POST['save_post']) && $stateMessage == "User has been added sucessfully!!") {
                                        echo ' <center>
                                            <h3 style="color: green" class="box-title"><b>' . $stateMessage . '</b></h3>
                                        </center>';
                                    } else if (isset($_POST['save_post']) && $stateMessage != "User has been added sucessfully!!") {
                                        echo ' <center>
                                            <h3 style="color: red" class="box-title"><b>' . $stateMessage . '</b></h3>
                                        </center>';
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Add New User</b></h3>
                                        </center>';
                                    }
                                    ?>
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="form-group">
                                        <h5 style="color: black"><b>First Name</b></h5>
                                        <input required="required" name="firstname" class="form-control" placeholder="First Name:" value="<?= $user_row['firstname'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Last Name</b></h5>
                                        <input required="required" name="lastname" class="form-control" placeholder="Last Name:" value="<?= $user_row['lastname'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Email</b></h5>
                                        <input required="required" name="email_address" class="form-control" placeholder="Enter Email:" value="<?= $user_row['email_address'] ?>">
                                    </div>
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Username</b></h5>
                                        <input required="required" name="user_name" class="form-control" placeholder="Enter User Name:" value="<?= $user_row['user_name'] ?>">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Password</b></h5>
                                        <input required="required" type="password" name="password" class="form-control" placeholder="Change password:" value="<?= md5($user_row['password']) ?>">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Re Enter password</b></h5>
                                        <input required="required" type="password" name="repassword" class="form-control" placeholder="Re Enter password:" value="<?= md5($user_row['password']) ?>">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Group</b></h5>

                                        <select name="group_selection" class="dropdown" style="border: 0px; padding: 8px; ">
                                            <option value="<?= $user_row['group_id'] ?>"><span>---Select an Option---</span></option>
                                            <?php
                                            $groupList = $GroupObject->getGroups($_SESSION['company_ID']);


                                            while ($group_row = mysqli_fetch_array($groupList)) {
                                            ?>
                                                <option class="list-menu-item" value="<?= $group_row['id'] ?>"><?= $group_row['name'] ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="box-body">
                                        <label>Status:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-group">
                                            <select name="status" class="form-control">
                                                <option value="Active">Active</option>
                                                <option value="Not Active">Not Active</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button name="save_post" type="submit" class="btn btn-primary"></i>Save</button>
                                    </div>
                                    <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                </div><!-- /.box-footer -->
                            </div><!-- /. box -->

                        </form>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- iCheck -->
    <script src="../plugins/iCheck/icheck.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Page Script -->
    <script>
        $(function() {
            //Add text editor
            $("#compose-textarea").wysihtml5();
        });
    </script>
</body>

</html>