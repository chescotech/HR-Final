<?php
session_start();
?>
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
        include '../navigation_panel/authenticated_user_header.php';

        include_once '../Classes/EmployeeHistory.php';
        $EmployeeHistoryObject = new EmployeeHistory();
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

            $EmployeeHistoryObject->addEduInfo($employeeId, $highest_qualification, $qualifications, $university, $secondary_school);

            $mssage = "Your education information has been added successfully!!";
        }
        if (isset($_POST['update'])) {
            $mssage = "";
            $highest_qualification = $_POST['highest_qualification'];
            $qualifications = $_POST['qualifications'];
            $university = $_POST['university'];
            $secondary_school = $_POST['secondary_school'];
            $employeeId = $_SESSION['employee_id'];

            $empno = $_SESSION['employee_id'];
            $sql = $EmployeeHistoryObject->getEduInfo($empno);

            if (mysqli_num_rows($sql) == 0) {
                $EmployeeHistoryObject->addEduInfo($employeeId, $highest_qualification, $qualifications, $university, $secondary_school);
            } else {
                $EmployeeHistoryObject->updateEduInfo($employeeId, $highest_qualification, $qualifications, $university, $secondary_school);
            }

            $mssage = "Your education information has been added successfully!!";
        }
        ?>

        <div class="content-wrapper">
            <section class="content-header">
            </section>

            <section class="content">

                <!-- Trigger the modal with a button -->


                <!-- Modal -->
                <div id="myModal" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Add New Education Info</h4>
                            </div>
                            <div class="modal-body">

                                <?php
                                $empno = $_SESSION['employee_id'];
                                $sql = $EmployeeHistoryObject->getEduInfo($empno);
                                $rows = mysqli_fetch_array($sql);
                                ?>

                                <form enctype="multipart/form-data" method="post">
                                    <div class="box box-primary">

                                        <div class="box-body">
                                            <div class="form-group">
                                                <h5 style="color: black"><b>Highest Qualification</b></h5>
                                                <select name="highest_qualification" class="form-control">

                                                    <option value="Grade 12">Grade 12</option>
                                                    <option value="Certificate">Certificate</option>
                                                    <option value="Diploma">Diploma</option>
                                                    <option value="Degree">Degree</option>
                                                    <option value="Masters Degree">Masters Degree</option>
                                                    <option value="Doctorate">Doctorate</option>
                                                    <option value="Professorship">Professorship</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <h5 style="color: black"><b>Qualifications</b></h5>
                                                <input name="qualifications" class="form-control" placeholder="Enter qualifications, e.g Bachelor Computer Science, Bachelor of English:">
                                            </div>

                                            <div class="form-group">
                                                <h5 style="color: black"><b>University / Tertiary Attended</b></h5>
                                                <input name="university" class="form-control" placeholder="University / Tertiary Attended:">
                                            </div>

                                            <div class="form-group">
                                                <h5 style="color: black"><b>Secondary School Attended</b></h5>
                                                <input name="secondary_school" class="form-control" placeholder="Secondary School Attended:">
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <div class="pull-right">
                                                <button name="save" type="submit" class="btn btn-primary"></i>Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">
                    <?php include 'employee-workhist-menu.php'; ?>
                    <div class="col-md-9">
                        <?php
                        $empno = $_SESSION['employee_id'];
                        $sql = mysqli_query($link, "SELECT * FROM emp_edu_info_tb where emp_id='$empno' ORDER BY id DESC LIMIT 1");
                        $rows = mysqli_fetch_array($sql);
                        ?>

                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">

                                    <?php
                                    if (isset($_POST['save'])) {
                                        echo ' <center>
                                            <h3 style="color: green" class="box-title"><b>' . $mssage . '</b></h3>
                                        </center>';
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Your Education Information</b></h3>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal"> Add New +</button>
                                        </center>';
                                    }
                                    ?>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Highest Qualification</b></h5>
                                        <select name="highest_qualification" class="form-control">
                                            <option>
                                                <?php
                                                $highestQualification = $rows['highest_qualifications'];
                                                if (!empty($highestQualification)) {
                                                    echo $rows['highest_qualifications'];
                                                } else {
                                                    echo "--select your highest qualification--";
                                                }
                                                ?>
                                            </option>
                                            <option value="Grade 12">Grade 12</option>
                                            <option value="Certificate">Certificate</option>
                                            <option value="Diploma">Diploma</option>
                                            <option value="Degree">Degree</option>
                                            <option value="Masters Degree">Masters Degree</option>
                                            <option value="Doctorate">Doctorate</option>
                                            <option value="Professorship">Professorship</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Qualifications</b></h5>
                                        <input value="<?php echo $rows['qualifications']; ?>" name="qualifications" class="form-control" placeholder="Enter qualifications, e.g Bachelor Computer Science, Bachelor of English:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>University / Tertiary Attended</b></h5>
                                        <input value="<?php echo $rows['university']; ?>" name="university" class="form-control" placeholder="University / Tertiary Attended:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Secondary School Attended</b></h5>
                                        <input value="<?php echo $rows['secondary_school']; ?>" name="secondary_school" class="form-control" placeholder="Secondary School Attended:">
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
                                        <button name="update" type="submit" class="btn btn-primary"></i>Update</button>
                                    </div>
                                    <button class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                </div>
                            </div>
                        </form>

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
