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
        $mssage = "";
        include_once '../Classes/EmployeeHistory.php';
        $EmployeeHistoryObject = new EmployeeHistory();

        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save'])) {
            $mssage = "";
            $highest_qualification = $_POST['highest_qualification'];
            $qualifications = $_POST['qualifications'];
            $university = $_POST['university'];
            $secondary_school = $_POST['secondary_school'];
            $employeeId = $_SESSION['employee_id'];

            $empno = $_SESSION['employee_id'];
            $sql = $EmployeeHistoryObject->getEduInfo($empno);

            if (mysql_num_rows($sql) == 0) {
                $EmployeeHistoryObject->addEduInfo($employeeId, $highest_qualification, $qualifications, $university, $secondary_school);
            } else {
                $EmployeeHistoryObject->updateEduInfo($employeeId, $highest_qualification, $qualifications, $university, $secondary_school);
            }

            $mssage = "Your education information has been added successfully!!";
        ?>

        <?php
        }

        if (isset($_POST['save_quali'])) {
            include_once '../Classes/EmployeeHistory.php';
            $EmployeeHistoryObject = new EmployeeHistory();

            $highest_qualifications = $_POST['highest_qualifications'];
            $qualifications = $_POST['qualifications'];
            $university = $_POST['university'];
            $secondary_school = $_POST['secondary_school'];
            $id = $_POST['id'];

            $EmployeeHistoryObject->updateEduInfoByID($id, $highest_qualifications, $qualifications, $university, $secondary_school);

            $mssage = "Your education information has been added successfully!!";
        }
        ?>

        <div class="content-wrapper">
            <section class="content-header">
            </section>

            <section class="content">
                <div class="row">
                    <?php include 'employee-workhist-menu.php';

                    echo '<h3 style="color: green" class="box-title"><b>                                                    
                                                    ' . $mssage . '                                               
                                                </b></h3>';
                    ?>
                    <div class="col-md-9">
                        <?php
                        $empno = $_SESSION['employee_id'];
                        $sql = $EmployeeHistoryObject->getEduInfo($empno);
                        $rows = mysql_fetch_array($sql);
                        ?>

                        <ul class="nav nav-pills">
                            <li class="active"><a data-toggle="pill" href="#home">Accademic History</a></li>
                            <li><a data-toggle="pill" href="#menu1">Employment History </a></li>
                            <li><a data-toggle="pill" href="#menu2">Documents</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <?php
                                $sql1 = mysql_query("SELECT * FROM emp_edu_info_tb where emp_id='$empno' ORDER BY id DESC ");
                                while ($rows1 = mysql_fetch_array($sql1)) {
                                        //echo 'ID' . $rows1['id'];
                                    ;
                                ?>
                                    <form action="" method="POST">

                                        <div class="box-body">
                                            <div hidden="">
                                                <input type="text" name="id" class="form-control" value="<?php echo $rows1['id']; ?>" placeholder="Highest Qualification:">
                                            </div>
                                            <div class="form-group">
                                                <div style="color: black"><b>Highest Qualification: </b>
                                                    <input type="text" name="highest_qualifications" class="form-control" value="<?php echo $rows1['highest_qualifications']; ?>" placeholder="Highest Qualification:">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div style="color: black"><b>Qualifications: </b>
                                                    <input type="text" name="qualifications" class="form-control" value="<?php echo $rows1['qualifications']; ?>" placeholder="Qualifications:">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div style="color: black"><b>University / Tertiary Attended: </b>

                                                    <input type="text" name="university" class="form-control" value="<?php echo $rows1['university']; ?>" placeholder="University:">

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div style="color: black"><b>Secondary School Attended: </b>

                                                    <input type="text" name="secondary_school" class="form-control" value="<?php echo $rows1['secondary_school']; ?>" placeholder="Secondary School Attended:">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <div class="pull-right">

                                                <button name="save_quali" type="submit" class="btn btn-primary"></i>Save</button>
                                            </div>

                                        </div>
                                    </form>
                                    <br>
                                <?php
                                }
                                ?>

                            </div>
                            <div id="menu1" class="tab-pane fade">

                                <?php
                                $sql = $EmployeeHistoryObject->getHistoryInfo($empno);
                                $rows = mysql_fetch_array($sql);
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
                                $certificate = "../uploads/" . $leaveObject->checkIfCertificateExsists($employeeId);
                                $cv = "../uploads/" . $leaveObject->checkIfCvExsists($employeeId);

                                if (file_exists($cv) && $leaveObject->checkIfCvExsists($employeeId) != "") {
                                    echo ' <br>
                                        - <a href="' . $cv . '" width="100%">Download CV </a><br>';
                                } else {
                                    echo 'No CV Found<br>';
                                }

                                if (file_exists($certificate) && $leaveObject->checkIfCertificateExsists($employeeId) != "") {
                                    echo '- <a href="' . $certificate . '" width="100%">Download Certificate </a>';
                                } else {
                                    echo 'No Certificate Found';
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