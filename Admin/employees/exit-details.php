<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Exit Employee</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
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

        });
    </script>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">
        <?php
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Department.php';

        $DepartmentObject = new Department();

        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        $comp_ID = $_SESSION['company_ID'];
        if (isset($_POST['save_post'])) {

            $savemessage = "";
            $empno = $_GET['empno'];
            $id = $_GET['id'];
            $reason_for_exit = $_POST['reason_for_exit'];
            $date_of_exit = $_POST['date_of_exit'];

            $DepartmentObject->exitEmployee($empno, $reason_for_exit, $date_of_exit, $id);
            $savemessage = "Record added sucessfully!!";
            //header('location:employees.php');
        ?>
            <script>
                window.location.href = "employees.php";
            </script>
        <?php
        }
        ?>
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">

            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="employees" class="btn btn-primary btn-block margin-bottom">Back</a>
                    </div>
                    <div class="col-md-5">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">

                                    <?php
                                    $empno = $_GET['empno'];
                                    $employeeDeatils = $DepartmentObject->getEmployeeDetailsById($empno);
                                    if (isset($_POST['save_post'])) {
                                        echo ' <center>
                                            <h3 style="color: green" class="box-title"><b>' . $savemessage . '</b></h3>
                                        </center>';
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title">Employee exit form for ' . $employeeDeatils . '</h3>
                                        </center>';
                                    }
                                    ?>

                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Please select reason for employee leaving</b></h5>
                                        <select name="reason_for_exit" class="form-control">
                                            <option>--Select reason for employee leaving--</option>
                                            <option value="Resignation"> Resignation</option>
                                            <option value="Discharge"> Discharge</option>
                                            <option value="Dismissed"> Dismissed</option>
                                            <option value="Death"> Death</option>
                                            <option value="Retirement"> Retirement</option>
                                            <option value="Retirement Induced"> Retirement Induced</option>
                                        </select>
                                    </div>

                                    <label>Date Of Exit:</label>
                                    <div class="form-group">
                                        <input required="required" id="datepicker" name="date_of_exit" class="form-control" placeholder="Date Of  Exit:">
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button name="save_post" type="submit" class="btn btn-primary"></i>Save</button>
                                    </div>
                                    <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                </div>
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