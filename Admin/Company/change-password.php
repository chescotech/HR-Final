<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Company Record</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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
            $compId = $_SESSION['company_ID'];
            $message = "";
            $old_password = md5($_POST['old_password']);
            $new_password = md5($_POST['new_password']);
            $re_new_password = md5($_POST['re_new_password']);
            $user_id = $_SESSION['user_session'];

            include_once '../../Admin/Classes/Company.php';
            $CompanyObject = new Company();

            if ($CompanyObject->checkIfPasswordExsists($user_id, $old_password) == "true" && $new_password == $re_new_password) {
                $checkRecods = $CompanyObject->changePassword($user_id, $new_password);
                $message = "Password updated sucessfully !!!";
            } else if ($CompanyObject->checkIfPasswordExsists($user_id, $old_password) != "true" && $new_password == $re_new_password) {
                $message = "Your old password is not correct, please re-enter password!";
            } else if ($new_password != $re_new_password) {
                $message = "New passwords do not match, please re-enter passwords!";
            }

        ?>
        <?php
        }
        ?>

        <div class="content-wrapper">

            <section class="content">

                <div class="row">
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <?php
                                $compId = $_SESSION['company_ID'];
                                $user_query = mysql_query("SELECT * FROM company where company_ID='$compId'") or die(mysql_error());
                                while ($row = mysql_fetch_array($user_query)) {
                                    $id = $row['company_ID'];
                                ?>

                                    <?php
                                    $photo = "../company_logos/" . $row['logo'];
                                    $check_pic = $row['logo'];
                                    if (!file_exists($photo) || $check_pic == false) {
                                        $photo = "../company_logos/logo.png";
                                    }
                                    ?>

                                    <img src="<?php echo $photo; ?>" width="100%">

                                <?php
                                }
                                ?>
                                <br> </br>
                                <p class="text-muted text-center">
                                    <a class="btn btn-primary btn-block"><b>

                                            <?php
                                            $result = mysql_query("SELECT * FROM company where company_ID='$compId'") or die(mysql_error());
                                            $row = mysql_fetch_array($result);
                                            $companyName = $row['name'];
                                            echo $row['name'];
                                            ?>
                                        </b></a>
                                </p>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                    <div class="col-md-9">
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <?php
                                if (isset($_POST['update_profile'])) {
                                    if ($message == "Password updated sucessfully !!!") {
                                        echo ' <li class="active"><a data-toggle="tab"><h4 style="color: green"><b>' . $message . '</b></h4></a></li>';
                                    } else {
                                        echo ' <li class="active"><a data-toggle="tab"><h4 style="color: red"><b>' . $message . '</b></h4></a></li>';
                                    }
                                } else {
                                    echo '<li style="color: green" class="active"><a data-toggle="tab"><b>Change Account Password for ' . $companyName . '</b></a></li>';
                                }
                                ?>

                            </ul>
                            <div class="tab-content">

                                <div class="active tab-pane" id="activity">
                                    <?php
                                    $compId = $_SESSION['company_ID'];
                                    $sql = "SELECT * FROM company where company_ID='$compId'";
                                    $result2 = mysql_query($sql);
                                    $rows = mysql_fetch_array($result2);
                                    ?>

                                    <form method="post" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">Old Password</label>
                                            <div class="col-sm-5">
                                                <input name="old_password" type="password" class="form-control" id="inputName" placeholder="Old Password" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputName" class="col-sm-2 control-label">New Password</label>
                                            <div class="col-sm-5">
                                                <input name="new_password" type="password" type="text" class="form-control" id="inputName" placeholder="New Password" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail" class="col-sm-2 control-label">Re-enter New Password</label>
                                            <div class="col-sm-5">
                                                <input name="re_new_password" type="password" type="text" class="form-control" id="inputEmail" placeholder="Re-enter new Password" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button name="update_profile" type="submit" class="btn btn-primary">Change Password</button>
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