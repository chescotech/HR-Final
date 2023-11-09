<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Add Employee</title>
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
            $("#probation_deadline").datepicker();
            $("#birthday_picker").datepicker();
            $(document).ready(function() {
                // numeric validation.. 
                $("#numeric").keydown(function(event) {
                    if (event.keyCode == 46 || event.keyCode == 8) {
                        // let it happen, don't do anything
                    } else {
                        if (event.keyCode < 48 || event.keyCode > 57) {
                            event.preventDefault();
                        }
                    }
                });


            });
        });
    </script>

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Department.php';
        include_once '../Classes/Company.php';
        require_once('../../PHPmailer/sendmail.php');

        $DepartmentObject = new Department();
        $CompanyObject = new Company();

        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save'])) {
            $stateMessage = "";
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $init = $_POST['init'];
            $gender = $_POST['gender'];
            $employee_type = $_POST['employee_type'];
            $next_kin_phone = $_POST['next_kin_phone'];

            $dob_timestamp = strtotime($_POST['dob']);
            $dob = date('Y-m-d', $dob_timestamp);

            $dept = $_POST['department'];
            $position = $_POST['position'];
            $phone = $_POST['phone'];
            $p_address = $_POST['p_address'];
            $email = $_POST['email'];
            $bank = $_POST['bank_name'];
            $account = $_POST['account_no'];
            $probation_deadline = $_POST['probation_deadline'];

            $date_joined_timestamp = strtotime($_POST['date_join']);
            $dateJoined = date('Y-m-d', $date_joined_timestamp);
            $date_left_timestamp = strtotime($_POST['date_leave']);
            $dateLeft = date('Y-m-d', $date_left_timestamp);

            $EmployeeGrade = $_POST['emp_grade'];

            $mStatus = $_POST['marital_status'];
            $payment_method = $_POST['payment_method'];
            //new feilds..
            $NRC = $_POST['NRC'];
            $employment_type = $_POST['employment_type'];

            $companyId = $_SESSION['company_ID'];
            $prefx = $CompanyObject->getCompanyPrefix($companyId);
            $password = md5("ctl@2020");

            $leaveDays = 0;
            $EmployeeCount = $DepartmentObject->getEmpCount($companyId);
            $empSum = $EmployeeCount + 1;

            $empno = $prefx . "0" . $empSum;

            $house_allowance = $_POST['house_allowance'];
            $transport_allowance = $_POST['transport_allowance'];
            $lunch_allowance = $_POST['lunch_allowance'];
            $gross_pay = $_POST['gross_pay'] + $house_allowance + $transport_allowance + $lunch_allowance;
            $basicPay = $_POST['gross_pay'];
            $DepartmentObject->addEmployee($empno, $fname, $lname, $init, $gender, $dob, $dept, $position, $phone, $p_address, $email, $bank, $account, $dateJoined, $dateLeft, $EmployeeGrade, $mStatus, $payment_method, $leaveDays, $companyId, $password, $gross_pay, $next_kin_phone, $NRC, $employment_type, $probation_deadline, $employee_type, $basicPay);
            $DepartmentObject->addEmployeeAllowances($companyId, $house_allowance, $transport_allowance, $lunch_allowance, $empno);

            $em = new email();

            $image = '<img src="' . $CompanyObject->getCompanyLogo2($companyId) . '" width="100%" height="290" class="img-thumbnail" />';

            $CompanyName = $_SESSION['name'];

            $stateMessage = "Employee Successully added !!";
        ?>

        <?php
        }
        ?>

        <div class="content-wrapper">
            <section class="content">
                <div class="row">
                    <div class="col-md-3">
                        <a href="employees.php" class="btn btn-primary btn-block margin-bottom">Back</a>
                    </div>
                    <div class="col-md-5">
                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <?php
                                    $compId = $_SESSION['company_ID'];
                                    if (isset($_POST['save'])) {
                                        echo ' <center>
                                            <h3 style="color: green" class="box-title"><b>' . $stateMessage . '</b></h3>
                                        </center>';
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Add Employee</b></h3>
                                        </center>';
                                    }
                                    ?>
                                </div>
                                <div class="box-body">
                                    <label>First Name:</label>
                                    <div class="form-group">
                                        <input required="required" name="fname" class="form-control" onkeypress="return onlyAlphabets(event, this);" placeholder="Enter First Name:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Last Name:</label>
                                    <div class="form-group">
                                        <input required="required" name="lname" onkeypress="return onlyAlphabets(event, this);" class="form-control" placeholder="Enter Last Name:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>NRC Number:</label>
                                    <div class="form-group">
                                        <input required="required" name="NRC" class="form-control" placeholder="Enter NRC Number:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Initials:</label>
                                    <div class="form-group">
                                        <input required="required" name="init" onkeypress="return onlyAlphabets(event, this);" class="form-control" placeholder="Enter Initial:">
                                    </div>
                                </div>
                                <div class="box-body">
                                    <label>Employment Type:</label>
                                    <div class="form-group">
                                        <select name="employee_type" class="form-control">
                                            <option>--Select Employment Type --</option>
                                            <option value="Full Time">Full Time</option>
                                            <option value="Casual Worker">Casual Worker</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Nature of Employment:</label>
                                    <div class="form-group">
                                        <select id="employment_type" name="employment_type" class="form-control">
                                            <option>--Select Nature of Employment--</option>
                                            <option value="Temporary">Temporary</option>
                                            <option value="Permanent">Permanent</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="contract_expire_date" hidden="hidden" class="box-body">
                                    <label>Date When Contract Expires:</label>
                                    <div class="form-horizontal">
                                        <input id="birthday_picker" name="date_leave" class="form-control" placeholder="Date When Contract Expires">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Is Employee on Probation ? :</label>
                                    <div class="form-group">
                                        <select id="probation_status" class="form-control">
                                            <option>--Is Employee on Probation ?--</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="probation_duration" hidden="hidden" class="box-body">
                                    <label>Date When Probation Ends:</label>
                                    <div class="form-horizontal">
                                        <input name="probation_deadline" id="probation_deadline" class="form-control" placeholder="Date When Probation Ends">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Gender:</label>
                                    <div class="form-group">
                                        <select name="gender" class="form-control">
                                            <option>--Select Gender--</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Date Of Birth:</label>
                                    <div class="form-group">
                                        <input required="required" name="dob" class="form-control" placeholder="mm/dd/year:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Department:</label>

                                    <div class="form-group">

                                        <select name="department" class="form-control">
                                            <option>--Select Department--</option>
                                            <?php
                                            $departmentquery = $DepartmentObject->GetAllDepartmentsByCompany($compId);
                                            while ($row = mysqli_fetch_array($departmentquery)) {
                                            ?>
                                                <option value="<?php echo $row['dep_id']; ?>"> <?php echo $row['department']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                </div>

                                <div class="box-body">
                                    <label>Position:</label>
                                    <div class="form-horizontal">
                                        <input required="required" name="position" class="form-control" placeholder="Position">
                                    </div>
                                </div>


                                <div class="box-body">
                                    <label>Phone Number:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="numeric" name="phone" class="form-control" placeholder="Phone">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Physical Address:</label>
                                    <div class="form-horizontal">
                                        <input required="required" name="p_address" class="form-control" placeholder="Physical Address">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Next Of Kin Phone Number:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="numeric" name="next_kin_phone" class="form-control" placeholder="Next Of Kin Phone number">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Email:</label>
                                    <div class="form-horizontal">
                                        <input required="required" name="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Bank Details:</label>
                                    <div class="form-horizontal">
                                        <input required="required" name="bank_name" class="form-control" placeholder="Bank Name">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Account Number:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="numeric" name="account_no" class="form-control" placeholder="Account Number">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Date Joined:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="datepicker_" name="date_join" class="form-control" placeholder="Date Joined">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Employee Grade:</label>
                                    <div class="form-horizontal">
                                        <select name="emp_grade" class="form-control">
                                            <option>--Select employee Grade--</option>
                                            <?php
                                            $compName = $_SESSION['username'];
                                            $CompanyQuery = $CompanyObject->getEmployeGrade($compId);
                                            while ($row = mysqli_fetch_array($CompanyQuery)) {
                                            ?>
                                                <option value="<?php echo $row['grade']; ?>"> <?php echo $row['grade']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Basic Pay:</label>
                                    <div class="form-horizontal">
                                        <input required="required" id="numeric" name="gross_pay" class="form-control" placeholder="Basic Pay">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Marital Status:</label>
                                    <div class="form-group">
                                        <select name="marital_status" class="form-control">
                                            <option>--Select Marital Status--</option>
                                            <option value="Married">Married</option>
                                            <option value="Single">Single</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Payment method:</label>
                                    <div class="form-horizontal">
                                        <input required="required" name="payment_method" class="form-control" placeholder="Cash Or Bank Transfer">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Housing Allowance:</label>
                                    <div class="form-horizontal">
                                        <input required="required" type="number" name="house_allowance" class="form-control" placeholder="Enter House Allowance">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Transport Allowance:</label>
                                    <div class="form-horizontal">
                                        <input required="required" type="number" name="transport_allowance" class="form-control" placeholder="Enter Transport Allowance">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Lunch Allowance:</label>
                                    <div class="form-horizontal">
                                        <input required="required" type="number" name="lunch_allowance" class="form-control" placeholder="Enter Lunch Allowance">
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button name="save" type="submit" class="btn btn-primary"></i>Save</button>
                                    </div>
                                    <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                </div>

                            </div>

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

    <script language="Javascript" type="text/javascript">
        function onlyAlphabets(e, t) {
            try {
                if (window.event) {
                    var charCode = window.event.keyCode;
                } else if (e) {
                    var charCode = e.which;
                } else {
                    return true;
                }
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || e.keyCode === 46 || e.keyCode === 8)
                    return true;
                else
                    return false;
            } catch (err) {
                alert(err.Description);
            }
        }

        function validateEmail() {
            var sEmail = $('#txtEmail').val();
            var filter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                alert('Invalid Email Address');
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $("#employment_type").blur(function() {
                if ($("#employment_type").val() === "Temporary") {
                    $("#contract_expire_date").slideDown("slow", function() {});
                } else {
                    $("#contract_expire_date").slideUp("slow", function() {
                        $("#contract_expire_date").val("");
                    });
                }

            });

            $("#probation_status").blur(function() {
                if ($("#probation_status").val() === "Yes") {
                    $("#probation_duration").slideDown("slow", function() {});
                } else {
                    $("#probation_duration").slideUp("slow", function() {
                        $("#contraprobation_durationct_expire_date").val("");
                    });
                }
            });

        });
    </script>

</body>

</html>