<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Education Info</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
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

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Department.php';
        $EmployeeObject = new Department();

        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        $empno = $_GET['empid'];
        ?>

        <div class="content-wrapper">
            <section class="content-header">
            </section>

            <section class="content">
                <div class="row">
                    <?php //include 'employee-workhist-menu.php'; 
                    ?>
                    <div class="col-md-9">
                        <?php
                        $sql = mysqli_query($link, "SELECT * FROM emp_edu_info_tb where emp_id='$empno'");
                        $rows = mysqli_fetch_array($sql);
                        ?>
                        <h3><?php echo 'Viewing Qualifications and Employment History for ' . $EmployeeObject->getEmployeeDetailsById($empno); ?>
                        </h3>
                        <ul class="nav nav-pills">

                            <li class="active"><a data-toggle="pill" href="#home">Academic History</a></li>
                            <li><a data-toggle="pill" href="#menu1">Employment History </a></li>
                            <li><a data-toggle="pill" href="#menu2">Documents</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <?php
                                $sql1 = mysqli_query($link, "SELECT * FROM emp_edu_info_tb where emp_id='$empno' ORDER BY id DESC ");
                                while ($rows1 = mysqli_fetch_array($sql1)) {
                                ?>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <div style="color: black"><b>Highest Qualification: </b>
                                                <span> <?php echo $rows1['highest_qualifications']; ?> </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div style="color: black"><b>Qualifications: </b>
                                                <span> <?php echo $rows1['qualifications']; ?> </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div style="color: black"><b>University / Tertiary Attended: </b>
                                                <span> <?php echo $rows1['university']; ?> </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div style="color: black"><b>Secondary School Attended: </b>
                                                <span> <?php echo $rows1['secondary_school']; ?> </span>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                <?php
                                }
                                ?>

                            </div>
                            <div id="menu1" class="tab-pane fade">

                                <?php
                                $sql = mysqli_query($link, "SELECT * FROM emp_history_tb where emp_id='$empno'");
                                $rows = mysqli_fetch_array($sql);
                                ?>

                                <div class="box-body">
                                    <div class="form-group">
                                        <div style="color: black"><b>Previous Employer (1): </b>
                                            <span> <?php echo $rows['employer_one']; ?> </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div style="color: black"><b>Position: </b>
                                            <span> <?php echo $rows['position_one']; ?> </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div style="color: black"><b>Working Period</b>
                                            <span> <?php echo $rows['date_start_one']; ?> </span>
                                            <b> To: </b> <span> <?php echo $rows['date_end_one']; ?> </span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="box-body">
                                    <div class="form-group">
                                        <div style="color: black"><b>Previous Employer (2): </b>
                                            <span> <?php echo $rows['employer_two']; ?> </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div style="color: black"><b>Position: </b>
                                            <span> <?php echo $rows['position_two']; ?> </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div style="color: black"><b>Working Period</b>
                                            <span> <?php echo $rows['date_start_two']; ?> </span>
                                            <b> To: </b> <span> <?php echo $rows['date_end_two']; ?> </span>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="box-body">
                                    <div class="form-group">
                                        <div style="color: black"><b>Previous Employer (3): </b>
                                            <span> <?php echo $rows['employer_three']; ?> </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div style="color: black"><b>Position: </b>
                                            <span> <?php echo $rows['position_three']; ?> </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div style="color: black"><b>Working Period</b>
                                            <span> <?php echo $rows['date_start_three']; ?> </span>
                                            <b> To: </b> <span> <?php echo $rows['date_end_three']; ?> </span>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="box-body">
                                    <div class="form-group">
                                        <div style="color: black"><b>Previous Employer (4): </b>
                                            <span> <?php echo $rows['employer_four']; ?> </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div style="color: black"><b>Position: </b>
                                            <span> <?php echo $rows['position_four']; ?> </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div style="color: black"><b>Working Period</b>
                                            <span> <?php echo $rows['date_start_four']; ?> </span>
                                            <b> To: </b> <span> <?php echo $rows['date_end_four']; ?> </span>
                                        </div>
                                    </div>
                                </div>

                                <br>
                                <div class="box-body">
                                    <div class="form-group">
                                        <div style="color: black"><b>Previous Employer (5): </b>
                                            <span> <?php echo $rows['employer_five']; ?> </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div style="color: black"><b>Position: </b>
                                            <span> <?php echo $rows['position_five']; ?> </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div style="color: black"><b>Working Period</b>
                                            <span> <?php echo $rows['date_start_five']; ?> </span>
                                            <b> To: </b> <span> <?php echo $rows['date_end_five']; ?> </span>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="menu2" class="tab-pane fade">

                                <?php
                                $cv = "";
                                $certificate = "";

                                $res = mysqli_query($link, " SELECT * FROM certificates_tb where empno='$empno' AND id = ( SELECT MAX(id) FROM certificates_tb WHERE empno='$empno' ) ");
                                $rows = mysqli_fetch_array($res);
                                if (mysqli_num_rows($res) != 0) {
                                    $qualifications = $rows['qualifications'];
                                    // return $qualifications;
                                    $certificate = "../../employee/uploads/" . $qualifications;

                                    echo ' - <a href="' . $certificate . '" width="100%">Download Certificate </a>
                            <br>';
                                } else {
                                    echo ' - No Certificate Uploaded
                            <br>';
                                }

                                $res = mysqli_query($link, " SELECT * FROM certificates_tb where empno='$empno' AND id = ( SELECT MAX(id) FROM certificates_tb WHERE empno='$empno' ) ");
                                $rows = mysqli_fetch_array($res);
                                if (mysqli_num_rows($res) != 0) {
                                    $cv = $rows['cv'];
                                    // return $cv;
                                    $cv_file = "../../employee/uploads/" . $cv;
                                    echo '  - <a href="' . $cv_file . '" width="100%">Download CV </a>
                            ';
                                } else {
                                    echo ' - No CV Uploaded
                            <br>';
                                }
                                ?>

                            </div>
                        </div>
                    </div>


                </div><!-- /.col -->
        </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include '../footer/footer.php'; ?>

    <div class="control-sidebar-bg"></div>
    </div>

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>

</body>

</html>
<?php
