<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Leave Application</title>
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
        include_once '../Classes/Leave.php';
        $leaveObject = new Leave();
        include_once '../../Admin/Classes/Company.php';
        $CompanyObject = new Company();
        require_once('../../PHPmailer/sendmail.php');
        include '../navigation_panel/authenticated_user_header.php';
        $companyId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['apply'])) {
            $mssage = "";
            $LeaveStartdate = $_POST['start_date'];
            $leaveEndDate = $_POST['end_date'];
            $leaveType = $_POST['leave_type'];
            $reasonLeave = $_POST['leave_reason'];
            // new feilds..
            $contact = $_POST['contact'];
            $contact_person = $_POST['contact_person'];
            $address_on_leave = $_POST['address_on_leave'];

            // attachment .. 

            $file = rand(10000000, 10000000) . "-" . $_FILES['file']['name'];
            $file_loc = $_FILES['file']['tmp_name'];
            $file_size = $_FILES['file']['size'];
            $file_type = $_FILES['file']['type'];
            $folder = "../leave-attachments/";

            // image

            $Image_size = $_FILES['file']['size'];
            $Image_type = $_FILES['file']['type'];
            $Image_folder = "../leave-attachments/";

            // new file size in KB
            $new_size = $file_size / 1024000;
            $image_size = $file_size / 1024000;
            // new file size in KB

            $new_file_name = strtolower($file);

            $final_file = str_replace(' ', '-', $new_file_name);

            // convert date format to y-m-d
            $startDate = strtotime($LeaveStartdate);
            $startDateConverted = date('Y-m-d', $startDate);

            $EndDate = strtotime($leaveEndDate);
            $EndDateConverted = date('Y-m-d', $EndDate);

            $empno = $_SESSION['employee_id'];
            $LeaveQuery = $leaveObject->checkLeaveDays($empno);
            $leaveInfo = mysql_fetch_array($LeaveQuery);
            $leaveDaysAvailiable = $leaveInfo['available'];

            $start = new DateTime($startDateConverted);
            $end = new DateTime($EndDateConverted);

            $end->modify('+1 day');

            $interval = $end->diff($start);

            $days = $interval->days;

            $period = new DatePeriod($start, new DateInterval('P1D'), $end);

            foreach ($period as $dt) {
                $curr = $dt->format('D');
                // substract if Saturday or Sunday
                if ($curr == 'Sat' || $curr == 'Sun') {
                    $days--;
                }
            }

            $LeaveApplicatantQuery = $leaveObject->getLeaveApplicantDetails($empno);
            $ApplicatRows = mysql_fetch_array($LeaveApplicatantQuery);
            $fname = $ApplicatRows['fname'];
            $lname = $ApplicatRows['lname'];
            $postition = $ApplicatRows['position'];

            if ($leaveType == "Annual Leave" || $leaveType == "Casual Leave") {
                if (mysql_num_rows($LeaveQuery) == 0 || $leaveDaysAvailiable == 0) {
                    $mssage = "You do not have suffient leave days to apply for a leave!!";
        ?>
                    <?php
                } else {

                    if ($leaveObject->checkIfApplicatantisHod($empno) != "true") {
                        $supervisorsEmial = "lombe@crystaline.co.zm"; //$leaveObject->getEmployeeSupervisor($empno);

                        $em = new email();
                        $image = '<img src="' . $CompanyObject->getCompanyLogo4($companyId) . '" width="100%" height="290" class="img-thumbnail" />';

                        $message = "Greetings from Crystaline Technologies." . "<br>" . "<br>"
                            . "You have a leave application request from " . "$fname" . " " . "$lname" . " , "
                            . "   please login  http://212.71.251.244/crystalpay/PayrollHr/
 to your account to Approve or Decline this request ,"
                            . "<br>" . "<br>" . " Kind Regards ."
                            . "<br>" . "<br>" . "<br>" . "<br>"
                            . $image;

                        $Subject = "Leave Aplication";

                        $em->send_mail($supervisorsEmial, $message, $Subject);

                        if (move_uploaded_file($file_loc, $folder . $final_file)) {
                            $leaveObject->applyLeave($LeaveStartdate, $leaveEndDate, $leaveType, $empno, $reasonLeave, $contact, $contact_person, $address_on_leave, $final_file);
                            $mssage = "success, please wait for your supervisor to respond to your request.";
                        } else {
                            $leaveObject->applyLeaveWithoutAtatachments($LeaveStartdate, $leaveEndDate, $leaveType, $empno, $reasonLeave, $contact, $contact_person, $address_on_leave);
                            $mssage = "success, please wait for your supervisor to respond to your request.";
                        }
                    } else {
                        $supervisorsEmial = "lombe@crystaline.co.zm";
                        $em = new email();
                        $image = '<img src="' . $CompanyObject->getCompanyLogo4($companyId) . '" width="100%" height="290" class="img-thumbnail" />';

                        $message = "Greetings from Crystaline Technologies." . "<br>" . "<br>"
                            . "You have a leave application request from " . "$fname" . " " . "$lname" . " , "
                            . "   please login to your account to Approve or Decline this request ,"
                            . "<br>" . "<br>" . " Kind Regards ."
                            . "<br>" . "<br>" . "<br>" . "<br>"
                            . $image;

                        $Subject = "Leave Aplication";

                        $em->send_mail($supervisorsEmial, $message, $Subject);

                        if (move_uploaded_file($file_loc, $folder . $final_file)) {
                            $leaveObject->applyLeave($LeaveStartdate, $leaveEndDate, $leaveType, $empno, $reasonLeave, $contact, $contact_person, $address_on_leave, $final_file);
                            $mssage = "success, please wait for your supervisor to respond to your request.";
                        } else {
                            $leaveObject->applyLeaveWithoutAtatachments($LeaveStartdate, $leaveEndDate, $leaveType, $empno, $reasonLeave, $contact, $contact_person, $address_on_leave);
                            $mssage = "success, please wait for your supervisor to respond to your request.";
                        }

                    ?>
                <?php
                    }
                }
            } else {
                $supervisorsEmial = "lombe@crystaline.co.zm";
                $em = new email();
                $image = '<img src="' . $CompanyObject->getCompanyLogo4($companyId) . '" width="100%" height="290" class="img-thumbnail" />';

                $message = "Greetings from Crystaline Technologies." . "<br>" . "<br>"
                    . "You have a leave application request from " . "$fname" . " " . "$lname" . " , "
                    . "   please login to your account to Approve or Decline this request ,"
                    . "<br>" . "<br>" . " Kind Regards ."
                    . "<br>" . "<br>" . "<br>" . "<br>"
                    . $image;

                $Subject = "Leave Aplication";

                $em->send_mail($supervisorsEmial, $message, $Subject);

                if (move_uploaded_file($file_loc, $folder . $final_file)) {
                    $leaveObject->applyLeave($LeaveStartdate, $leaveEndDate, $leaveType, $empno, $reasonLeave, $contact, $contact_person, $address_on_leave, $final_file);
                    $mssage = "success, please wait for your supervisor to respond to your request.";
                } else {
                    $leaveObject->applyLeaveWithoutAtatachments($LeaveStartdate, $leaveEndDate, $leaveType, $empno, $reasonLeave, $contact, $contact_person, $address_on_leave);
                    $mssage = "success, please wait for your supervisor to respond to your request.";
                }
                ?>

        <?php
            }
        }
        ?>

        <div class="content-wrapper">
            <section class="content-header">
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="../index.php" class="btn btn-primary btn-block margin-bottom">Back</a>
                        <div class="box box-solid">
                            <div hidden="hidden" id="no_leave_selected" class="box-header with-border">
                                <span style="color: green" id="leave_period"><b></b></span>
                                <?php
                                $employeeId = $_SESSION['employee_id'];
                                $leaveDays = "";
                                $result = mysql_query("SELECT * FROM leave_days WHERE empno='$employeeId' ") or die(mysql_error());
                                $row = mysql_fetch_array($result);
                                if (mysql_num_rows($result) == 0) {
                                    $leaveDays = "0";
                                } else {
                                    $leaveDays = $row['available'];
                                }
                                ?>
                                <input type="hidden" value="<?php echo $leaveDays; ?>" id="no_days_avail" name="end_date" class="form-control">
                            </div>

                            <div class="box-header with-border">
                                <span style="color: black" id="leave_period"><b>
                                        <?php
                                        $employeeId = $_SESSION['employee_id'];
                                        $result = mysql_query("SELECT * FROM leave_days WHERE empno='$employeeId' ") or die(mysql_error());
                                        $row = mysql_fetch_array($result);
                                        if (mysql_num_rows($result) == 0) {
                                            echo "No leave days available";
                                        } else {
                                            echo $row['available'] . "  Leave days available";
                                        }
                                        ?>
                                    </b></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <center>
                                        <?php
                                        if (isset($_POST['apply'])) {
                                            if ($mssage == "success, please wait for your supervisor to respond to your request.") {
                                                echo '<h3 style="color: green" class="box-title"><b>                                                    
                                                    ' . $mssage . '                                               
                                                </b></h3>';
                                            } else {
                                                echo '<h3 style="color: red" class="box-title"><b>                                                    
                                                    ' . $mssage . '                                               
                                                </b></h3>';
                                            }
                                        } else {
                                            echo '<h3 style="color: black" class="box-title"><b>                                                    
                                                    PLease Fill in the form to Apply                                                
                                                </b></h3>';
                                        }
                                        ?>

                                    </center>
                                </div>
                                <div class="box-body">

                                    <div class="form-group">
                                        <label>Leave Starting date:</label>
                                        <input type="text" required="required" id="datepicker" name="start_date" class="form-control" placeholder="Leave Starting Date:">
                                    </div>

                                    <div class="form-group">
                                        <label>Leave Ending date:</label>
                                        <input required="required" id="end_datepicker" name="end_date" class="form-control" placeholder="Leave Ending Date:">
                                    </div>
                                    <div class="form-group">
                                        <label>Select Leave Type:</label>
                                        <select id="leave_type" name="leave_type" class="form-control">
                                            <option>--Select Leave Type--</option>
                                            <?php
                                            $comp_ID = $_SESSION['company_ID'];
                                            $AllDepartments = $leaveObject->getLeaveTypes($comp_ID);
                                            while ($row = mysql_fetch_array($AllDepartments)) {
                                            ?>
                                                <option value="<?php echo $row['leave_type'] ?>">
                                                    <?php echo $row['leave_type']; ?>
                                                </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Contact number:</label>
                                        <input type="text" required="required" id="datepicker" name="contact" class="form-control" placeholder="Contact number in case you are not reachable:">
                                    </div>

                                    <div class="form-group">
                                        <label>Contact person:</label>
                                        <input type="text" required="required" id="datepicker" name="contact_person" class="form-control" placeholder="Contact persons name in case you are not reachable:">
                                    </div>

                                    <div class="form-group">
                                        <label>Address while on Leave:</label>
                                        <textarea placeholder="Address to be used whilst on Leave..." required="required" id="compose-textarea" name="address_on_leave" class="form-control" style="height: 50px"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>State reasons for your Leave:</label>
                                        <textarea placeholder="State the reason for your leave..." required="required" id="compose-textarea" name="leave_reason" class="form-control" style="height: 150px"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label>Attach proof when applying for Sick, Maternity and Study Leave</label>
                                        <input name="file" type="file" />
                                    </div>

                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
                                        <button name="apply" type="submit" class="btn btn-primary"></i>Apply</button>
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

    <script>
        $(document).ready(function() {
            Date.bizdays = function(d1, d2) {
                var bd = 0,
                    dd, incr = d1.getDate();
                while (d1 < d2) {
                    d1.setDate(++incr);
                    dd = d1.getDay();
                    if (dd % 6)
                        ++bd;
                }
                return bd;
            };

            $("#datepicker").datepicker();
            $("#end_datepicker").datepicker();
            $("#leave_type").blur(function() {
                var startDate = new Date($("#datepicker").val());
                var EndDate = new Date($("#end_datepicker").val());

                console.log('date1', startDate);
                console.log('date2', EndDate);

                var timeDiff = Math.abs(startDate.getTime() - EndDate.getTime());
                var diffDays = Date.bizdays(startDate, EndDate);

                var availableDays = $("#no_days_avail").val();
                //alert('Days'+availableDays);

                $checkLeaveType = $("#leave_type").val();
                $("#no_leave_selected").slideDown("slow", function() {
                    if ($checkLeaveType === "Annual Leave" || $checkLeaveType === "Casual Leave") {
                        if (availableDays >= diffDays) {
                            $("#leave_period").css('color', 'green');
                            $("#leave_period").html("Applying for " + diffDays + " Days " + $checkLeaveType);
                        } else {
                            $("#leave_period").css('color', 'red');
                            $("#leave_period").html("Cannot apply for " + diffDays + " days Leave");
                        }
                    } else {
                        $("#leave_period").css('color', 'green');
                        $("#leave_period").html("Applying for " + diffDays + " Days " + $checkLeaveType);
                    }
                });

            });
        });
    </script>

</body>

</html>