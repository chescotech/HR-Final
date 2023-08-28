<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Edit Disciplinary Record</title>
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
        include_once '../Classes/Department.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';

        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();

        include '../navigation_panel/authenticated_user_header.php';

        $compId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save'])) {

            $message = "";
            $id = $_GET['id'];
            $empno = $_POST['empno'];
            $date_charged = $_POST['date_charged'];
            $offense_commited = $_POST['offense_commited'];
            $punishment = $_POST['punishment'];
            $charged_by = $_POST['charged_by'];
            $case_status = $_POST['case_status'];
            $PaySlipsObject->updateDiscplineRecord($empno, $date_charged, $offense_commited, $case_status, $punishment, $charged_by, $id);

            $message = "record update sucess";
        ?>

        <?php
        }
        ?>

        <div class="content-wrapper">

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="" class="btn btn-primary btn-block margin-bottom">Back</a>
                    </div>
                    <div class="col-md-5">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <?php
                                    $query = mysql_query("SELECT * FROM employee_discplinary_records");
                                    $rows = mysql_fetch_array($query);

                                    if (isset($_POST['save'])) {
                                        echo ' <center>
                                            <h3 style="color: green" class="box-title"><b>' . $message . '</b></h3>
                                        </center>';
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Edit Displinary Record</b></h3>
                                        </center>';
                                    }

                                    ?>
                                </div>
                                <div class="box-body">
                                    <label>Employee Name:</label>
                                    <div class="form-group">
                                        <select name="empno" class="form-control">
                                            <option><?php echo $rows['empno']; ?></option>
                                            <?php
                                            $departmentquery = $DepartmentObject->getAllEmployeesByCompany($compId);
                                            while ($row = mysql_fetch_array($departmentquery)) {
                                                $fname = $row['fname'];
                                                $lname = $row['lname'];
                                                $position = $row['position'];
                                            ?>
                                                <option value="<?php echo $row['empno']; ?>"> <?php echo $fname . " " . $lname . " - " . $position ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="box-body">
                                    <label>Date Charged:</label>
                                    <div class="form-group">
                                        <input value="<?php echo $rows['date_charged']; ?>" required="required" name="date_charged" id="datepicker" class="form-control" placeholder="Date Charged:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Offence Commited:</label>
                                    <div class="form-group">
                                        <input value="<?php echo $rows['offence_commited']; ?>" required="required" name="offense_commited" id="numeric2" class="form-control" placeholder="Offence Commited:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Case Status:</label>
                                    <div class="form-group">
                                        <select name="case_status" class="form-control">
                                            <option><?php echo $rows['case_status']; ?></option>
                                            <option value="Awaiting Trail">Awaiting Trail</option>
                                            <option value="Closed -Guilty">Closed - Guilty</option>
                                            <option value="Closed -Not Guilty">Closed - Not Guilty</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Punishment:</label>
                                    <div class="form-horizontal">
                                        <input required="required" value="<?php echo $rows['punishment']; ?>" name="punishment" class="form-control" placeholder="Enter Punishment :">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Charged By:</label>
                                    <div class="form-horizontal">
                                        <input required="required" value=" <?php echo $rows['charged_by']; ?>" name="charged_by" class="form-control" placeholder="Charged By :">
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button name="save" type="submit" class="btn btn-primary"></i>Update Record</button>
                                    </div>
                                    <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div>
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div>
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