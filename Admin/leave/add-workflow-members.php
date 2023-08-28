<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Department</title>
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
        <?php
        error_reporting(0);

        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>



        <?php
        include_once '../Classes/Department.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Tax.php';
        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();
        $TaxObject = new Tax();

        //include '../navigation_panel/authenticated_user_header.php';
        //$companyId = $_SESSION['username'];
        $compId = $_SESSION['company_ID'];
        ?>

        <?php
        $comp_ID = $_SESSION['company_ID'];
        if (isset($_POST['save_post'])) {

            $savemessage = "";
            $level = $_POST['level'];
            $empno = $_POST['empno'];
            $workflow_id = $_GET['id'];

            // check if there is already a member on same level..

            if ($DepartmentObject->checkExsistingApprovers($empno, $level, $workflow_id) != "true") {
                $DepartmentObject->AddApprovers($empno, $level, $workflow_id);
                //               / header('Location:assign-to-workflow.php?id=1 ');
                echo "<script>document.location='assign-to-workflow.php?id=$workflow_id'</script>";
            } else {
                $savemessage = "Record already exisits for this Member.";
            }


        ?>

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
                        <a href="workflow-groups.php" class="btn btn-primary btn-block margin-bottom">Back</a>
                    </div>
                    <div class="col-md-5">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <?php
                                    if (isset($_POST['save_post'])) {
                                        echo ' <center>
                                            <h3 style="color: red" class="box-title"><b>' . $savemessage . '</b></h3>
                                        </center>';
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Add Approvers to ' . $_GET['name'] . '  </b></h3>
                                        </center>';
                                    }
                                    ?>

                                </div>
                                <div class="box-body">

                                    <div class="box-body">
                                        <label>Employee Name:</label>
                                        <div class="form-group">
                                            <select name="empno" class="form-control">
                                                <option>-- Select Employee to add --</option>
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
                                        <label>Level:</label>
                                        <div class="form-group">
                                            <select name="level" class="form-control">
                                                <option>-- Select Employee to add --</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>

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