<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Employee Info</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script>
        $(function() {
            $("#datepicker").datepicker();
            $("#datepicker_").datepicker();
            $("#birthday_picker").datepicker();
        });
    </script>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Employee.php';
        $EmployeeObject = new Employee();
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['update'])) {
            $stateMessage = "";
            $id = $_GET['id'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $init = $_POST['init'];
            $social = $_POST['social'];

            $dob_timestamp = strtotime($_POST['bdate']);
            $bdate = date('Y-m-d', $dob_timestamp);

            $position = $_POST['position'];
            $bank = $_POST['bank'];
            $account = $_POST['account'];

            $date_joined_timestamp = strtotime($_POST['date_joined']);
            $dateJoined = date('Y-m-d', $date_joined_timestamp);

            $date_left_timestamp = strtotime($_POST['date_left']);
            $date_left = date('Y-m-d', $date_joined_timestamp);

            $gross_pay = $_POST['gross_pay'];
            $payment_method = $_POST['payment_method'];

            $EmployeeObject->updateEmpInfo(
                $fname,
                $lname,
                $init,
                $bdate,
                $position,
                $bank,
                $account,
                $dateJoined,
                $date_left,
                $gross_pay,
                $payment_method,
                $id,
                $social
            );

            $stateMessage = "Employee information Successully updated !!";
        ?>
        <?php
        }
        ?>

        <div class="content-wrapper">
            <section class="content-header">
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="employees.php" class="btn btn-primary btn-block margin-bottom">Back</a>

                    </div>
                    <div class="col-md-5">
                        <?php
                        $id = $_GET['id'];
                        $empQuery = $EmployeeObject->getEmployeeById($id);
                        while ($rows = mysql_fetch_array($empQuery)) {
                        ?>
                            <form enctype="multipart/form-data" method="post">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <center>
                                            <?php
                                            if (isset($_POST['update'])) {
                                                echo ' <center>
                                                    <h3 style="color: green" class="box-title"><b>' . $stateMessage . '</b></h3>
                                                </center>';
                                            } else {
                                                echo ' <center>
                                                    <h3 style="color: black" class="box-title"><b>Edit Employee Information</b></h3>
                                                </center>';
                                            }
                                            ?>
                                        </center>
                                    </div>
                                    <div class="box-body">
                                        <label>First name</label>
                                        <div class="form-group">
                                            <input required="required" value="<?php echo $rows['fname']; ?>" name="fname" class="form-control" placeholder="Enter First Name:">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label for="lname">Last name</label>
                                        <div class="form-group">
                                            <input id="lname" required="required" value="<?php echo $rows['lname']; ?>" name="lname" class="form-control" placeholder="Enter Last Name:">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Initials</label>
                                        <div class="form-group">
                                            <input value="<?php echo $rows['init']; ?>" max="1" name="init" class="form-control" placeholder="Enter Initial:">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Birth date</label>
                                            <input value="<?php echo $rows['bdate']; ?>" id="birthday_picker" required="required" name="bdate" class="form-control" placeholder="Date Of Birth:">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Position</label>
                                        <div class="form-horizontal">
                                            <input value=" <?php echo $rows['position']; ?>" required="required" name="position" class="form-control" placeholder="Position">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Social Security Number:</label>
                                        <div class="form-horizontal">
                                            <input value=" <?php echo $rows['social']; ?>" required="required" name="social" class="form-control" placeholder="Position">
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <label>Bank</label>
                                        <div class="form-horizontal">
                                            <input value="<?php echo $rows['bank']; ?>" name="bank" class="form-control" placeholder="Bank Name">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Account Number:</label>
                                        <div class="form-horizontal">
                                            <input value="<?php echo $rows['account']; ?>" name="account" class="form-control" placeholder="Account Number">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Date Joined</label>
                                        <div class="form-horizontal">
                                            <input value="<?php echo $rows['date_joined']; ?>" id="datepicker" name="date_joined" class="form-control" placeholder="Date Joined">
                                        </div>
                                    </div>

                                    <div hidden="hidden" class="box-body">
                                        <label>Date Left</label>
                                        <div class="form-horizontal">
                                            <input value="<?php echo $rows['date_left']; ?>" id="datepicker_" name="date_left" class="form-control" placeholder="Date Left">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Gross Pay</label>
                                        <div class="form-horizontal">
                                            <input value="<?php echo $rows['gross_pay']; ?>" required="required" name="gross_pay" class="form-control" placeholder="Gross Pay">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Payment Method</label>
                                        <div class="form-horizontal">
                                            <input value="<?php echo $rows['payment_method']; ?>" name="payment_method" class="form-control" placeholder="Payment Method">
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <div class="pull-right">
                                            <button name="update" type="submit" class="btn btn-primary"></i>Update</button>
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

</body>

</html>
<?php
                        }
