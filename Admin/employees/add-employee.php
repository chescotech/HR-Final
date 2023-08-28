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
        error_reporting(1);

        include_once '../Classes/Department.php';
        include_once '../Classes/Company.php';
        require_once('../../PHPmailer/sendmail.php');

        $DepartmentObject = new Department();
        $CompanyObject = new Company();

        include '../navigation_panel/authenticated_user_header.php';
        $_key = $_SESSION['_key'];
        $companyId = $_SESSION['company_ID'];

        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save'])) {
            // return var_dump($_POST);
            $stateMessage = "";

            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $init = $_POST['init'];
            $gender = $_POST['gender'];
            $employee_type = $_POST['employee_type'];

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
            $social = $_POST['social'];
            $prefx = $CompanyObject->getCompanyPrefix($companyId);
            $password = md5("ctl@2020");
            $gatuity_amount = $_POST['gatuity_amount'];

            // upload profile image
            $img = $_FILES["img"]["name"];
            $tpin = $_POST['tpin'];

            // check if the image is there or not..

            if ($img != "") {
                $target_dir = "../../images/employees/";
                $target_file = $target_dir . basename($img);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    //echo "The file " . htmlspecialchars(basename($img)) . " has been uploaded.";
                } else {
                    return "Sorry, there was an error uploading your file.";
                }
            }

            $nrc_file = $_FILES["nrc_file"]["name"];
            // upload NRC.                
            if ($nrc_file != "") {

                $target_dir_ = "../../images/employees/";
                $target_file_ = $target_dir_ . basename($nrc_file);
                $imageFileType_ = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if (move_uploaded_file($_FILES["nrc_file"]["tmp_name"], $target_file_)) {
                    //echo "The file " . htmlspecialchars(basename($nrc_file)) . " has been uploaded.";
                } else {
                    return "Sorry, there was an error uploading your file.";
                }
            }

            $leaveDays = 0;
            $EmployeeCount = $DepartmentObject->getEmpCount($companyId);
            $empSum = $EmployeeCount + 1;

            $empno = $prefx . "0" . $empSum;

            // process values for allowances
            $formData = $_POST;

            $columnNames = array();
            $columnValues = array();



            foreach ($formData as $key => $value) {
                if (strpos($key, "earning_") === 0) {
                    // Extract the earning name without "earning_"
                    $earningName = substr($key, strlen("earning_"));

                    // Convert to lowercase and replace spaces with underscores
                    $sanitized = strtolower(str_replace(" ", "_", $earningName));

                    // Add the sanitized earning name to the array of column names
                    $columnNames[] = $sanitized;

                    // Add the value to the array of column values
                    $columnValues[] = $value;
                }
            }

            $gross_pay = 0;
            foreach ($columnValues as $key => $value) {
                # code...
                $gross_pay += $value;
            }

            $house_allowance = $_POST['house_allowance'];
            $transport_allowance = $_POST['transport_allowance'];
            $lunch_allowance = $_POST['lunch_allowance'];
            // $gross_pay = $_POST['gross_pay'] + $house_allowance + $transport_allowance + $lunch_allowance;
            $basicPay = $_POST['gross_pay'];
            $branch_code = $_POST['branch_code'];
            $has_gratuity = $_POST['has_gratuity'];

            // Next of Kin
            $nok_name = $_POST['nok_name'];
            $nok_relationship = $_POST['nok_relationship'];
            $nok_email = $_POST['nok_email'];
            $nok_address = $_POST['nok_address'];
            $nok_phone = $_POST['nok_phone'];

            $new_employee = $DepartmentObject->addEmployee(
                trim($empno),
                $fname,
                $lname,
                $init,
                $gender,
                $dob,
                $dept,
                $position,
                $phone,
                $p_address,
                $email,
                $bank,
                $account,
                $dateJoined,
                $dateLeft,
                $EmployeeGrade,
                $mStatus,
                $payment_method,
                $leaveDays,
                $companyId,
                $password,
                $gross_pay,
                $employment_type,
                $nok_name,
                $nok_relationship,
                $nok_email,
                $nok_address,
                $nok_phone,
                $probation_deadline,
                $employee_type,
                $basicPay,
                $social,
                $branch_code,
                $has_gratuity,
                $gatuity_amount,
                $img,
                $_POST['NRC'],
                $_FILES["nrc_file"]["name"],
                $tpin
            );

            // save employee earnings
            $new_emp_id = mysql_insert_id();



            $cn_imploded = implode(", ", $columnNames);
            // $cv_imploded = implode(", ", $columnValues);
            $cv_imploded = "'" . implode("', '", $columnValues) . "'";

            // Arrays to hold deduction names and values
            $deductionColumns = array();
            $deductionValues = array();

            // Loop through the $_POST array
            foreach ($formData as $key => $value) {
                // Check if the key starts with "deduction_"
                if (strpos($key, "deduction_") === 0) {
                    // Extract the deduction name without "deduction_"
                    $deductionName = substr($key, strlen("deduction_"));
                    // Sanitize and format the deduction name
                    $sanitizedDeductionName = strtolower(str_replace(" ", "_", $deductionName));

                    // Add deduction name to columns array and TRUE value to values array
                    $deductionColumns[] = $sanitizedDeductionName;
                    $deductionValues[] = "TRUE";
                }
            }
            // Build the SQL query
            if (!empty($deductionColumns)) {
                $columnsString = implode(", ", $deductionColumns);
                $valuesString = implode(", ", $deductionValues);

                $query = mysql_query("INSERT INTO employee_deductions(employee_id, employee_no, company_id, $columnsString) VALUES ('$new_emp_id', 'trim($empno)', '$companyId', $valuesString)") or die(mysql_error());
            }


            $earnings_item = mysql_query("INSERT INTO employee_earnings(employee_id, employee_no company_id, $cn_imploded) VALUES('$new_emp_id', 'trim($empno)','$companyId', $cv_imploded)") or die(mysql_error());

            // log user creation
            $action = "Create Employee";
            $empl = $_SESSION['user_session'];
            // return var_dump($_SESSION);
            $emp_log = mysql_query("INSERT INTO emp_log(company_id, action, action_user) VALUES('$companyId','$action','$empl')") or die(mysql_error());

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
                                <h4 style="text-decoration:underline"><b>Personal Information.</b></h4>
                                <div class="box-body">
                                    <label>Title:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <select name="init" class="form-control">
                                            <option value="Mr">Mr.</option>
                                            <option value="Ms">Ms.</option>
                                            <option value="Mrs">Mrs.</option>
                                            <option value="Dr">Dr.</option>
                                            <option value="Prof">Prof.</option>
                                            <option value="Miss">Miss.</option>
                                        </select>
                                        <!-- <input required="required" name="init" onkeypress="return onlyAlphabets(event, this);" class="form-control" placeholder="Enter Initial:"> -->
                                    </div>
                                </div>
                                <div class="box-body">
                                    <label>First Name:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <input required="required" name="fname" class="form-control" onkeypress="return onlyAlphabets(event, this);" placeholder="Enter First Name:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Last Name:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <input required="required" name="lname" onkeypress="return onlyAlphabets(event, this);" class="form-control" placeholder="Enter Last Name:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>ID Number(NRC or Passport):</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <input required="required" name="NRC" class="form-control" placeholder="Enter NRC Number:">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Gender:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <select name="gender" class="form-control">
                                            <option>--Select Gender--</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Date Of Birth:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <input type="date" required="required" name="dob" class="form-control" placeholder="DOB">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Marital Status:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <select name="marital_status" class="form-control">
                                            <option>--Select Marital Status--</option>
                                            <option value="Married">Married</option>
                                            <option value="Single">Single</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Phone Number:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input type="text" name="phone" class="form-control" maxlength="13">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Physical Address:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" name="p_address" class="form-control" placeholder="Physical Address">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Email:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" name="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>

                                <h4 style="text-decoration:underline"><b>Job Related Information.</b></h4>

                                <div class="box-body">
                                    <label>Date Joined:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input type="date" required="required" id="" name="date_join" class="form-control" placeholder="Date Joined">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Position:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" name="position" class="form-control" placeholder="Position">
                                    </div>
                                </div>
                                <div class="box-body">
                                    <label>Employment Type:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <select name="employee_type" class="form-control">
                                            <option>--Select Employment Type --</option>
                                            <option value="Full Time">Full Time</option>
                                            <option value="Temporary">Temporary</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Nature of Employment:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <select id="employment_type" name="employment_type" class="form-control">
                                            <option>--Select Nature of Employment--</option>
                                            <option value="Permanent">Permanent</option>
                                            <option value="Contract">Contract</option>
                                            <option value="Internship">Internship</option>
                                        </select>
                                    </div>
                                </div>


                                <div id="eligibility" class="box-body" hidden="hidden">
                                    <label>Is Employee Eligible for Gratuity ? :</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <select id="has_gratuity" name="has_gratuity" class="form-control">
                                            <option>--Is Employee Eligible for Gratuity ?--</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="gatuity_amount_" class="box-body" hidden="hidden">
                                    <label>Gratuity Amount in %:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input name="gatuity_amount" class="form-control" placeholder="Gratuity Amount in %">
                                    </div>
                                </div>

                                <div id="contract_expire_date" hidden="hidden" class="box-body">
                                    <label>Date When Contract Expires:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input id="birthday_picker" name="date_leave" class="form-control" placeholder="Date When Contract Expires">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Is Employee on Probation ? :</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <select id="probation_status" class="form-control">
                                            <option>--Is Employee on Probation ?--</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="probation_duration" hidden="hidden" class="box-body">
                                    <label>Date When Probation Ends:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input name="probation_deadline" id="probation_deadline" class="form-control" placeholder="Date When Probation Ends">
                                    </div>
                                </div>


                                <div class="box-body">
                                    <label>Department:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-group">
                                        <select name="department" class="form-control">
                                            <option>--Select Department--</option>
                                            <?php
                                            $departmentquery = $DepartmentObject->GetAllDepartmentsByCompany($compId);
                                            while ($row = mysql_fetch_array($departmentquery)) {
                                            ?>
                                                <option value="<?php echo $row['dep_id']; ?>"> <?php echo $row['department']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Social Security Number:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input name="social" class="form-control" placeholder="Social Security Number">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Employee Grade:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <select name="emp_grade" class="form-control">
                                            <option>--Select employee Grade--</option>
                                            <?php
                                            $compName = $_SESSION['username'];
                                            $CompanyQuery = $CompanyObject->getEmployeGrade($compId);
                                            while ($row = mysql_fetch_array($CompanyQuery)) {
                                            ?>
                                                <option value="<?php echo $row['grade']; ?>"> <?php echo $row['grade']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <h4 style="text-decoration:underline"><b>Bank Details Information.</b></h4>


                                <div class="box-body">
                                    <label>Bank Details:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" name="bank_name" class="form-control" placeholder="Bank Name">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Payment method:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" name="payment_method" class="form-control" placeholder="Cash Or Bank Transfer">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Branch Code:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" name="branch_code" class="form-control" placeholder="Branch Code">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Account Number:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" id="numeric" name="account_no" class="form-control" placeholder="Account Number">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>TPIN Number:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" id="numeric" name="tpin" class="form-control" placeholder="TPIN Number">
                                    </div>
                                </div>


                                <h4 style="text-decoration:underline"><b>Employee Earnings.</b></h4>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#earningsModal">
                                    Add Earnings
                                </button>

                                <!-- Earnings Modal -->
                                <!-- Modal -->
                                <div class="modal fade" id="earningsModal" tabindex="-1" role="dialog" aria-labelledby="earningsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="earningsModalLabel">Select Earnings</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <?php
                                            $earnings = mysql_query("SELECT * FROM earnings WHERE company_id = '$companyId'");
                                            ?>
                                            <div class="modal-body" style="overflow-y: scroll;">
                                                <?php
                                                while ($row = mysql_fetch_array($earnings)) {
                                                    # code...
                                                ?>
                                                    <div class="box-body">
                                                        <label><input type="checkbox" name="earning_<?= $row['name'] ?>" id="" value="<?= $row['id'] ?>" onchange="toggleInput(this)"> <?= $row['name'] ?><br> </label></span>
                                                        <div class="form-horizontal">
                                                            <input type="text" id="earning_<?= $row['id'] ?>" name="earning_<?= $row['name'] ?>" class="form-control" placeholder="<?= $row['name'] ?>" disabled>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h4 style="text-decoration:underline"><b>Employee Deductions.</b></h4>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#deductionsModal">
                                    Add Deductions
                                </button>

                                <!-- deductions modal -->
                                <!-- Modal -->
                                <div class="modal fade" id="deductionsModal" tabindex="-1" role="dialog" aria-labelledby="deductionsModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="deductionsModalLabel">Select Deductions</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <?php
                                                $deductions = mysql_query(
                                                    "SELECT * from `deductions` WHERE company_ID = '$companyId  '"
                                                );

                                                while ($ded_row = mysql_fetch_array($deductions)) {
                                                ?>
                                                    <p><label><input type="checkbox" name="deduction_<?= $ded_row['name'] ?>" id="" value="<?= $ded_row['ded_id'] ?>"> <?= $ded_row['name'] ?><br> </label></p>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <h4 style="text-decoration:underline"><b>Upload Employee Picture and NRC.</b></h4>

                                <div class="box-body">
                                    <label>Choose Profile Image:</label><span style="color:red; font-size: large;" title="Required"> </span>
                                    <div class="form-horizontal">
                                        <input type="file" name="img" class="form-control">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Upload Employee NRC or Passport Identity:</label><span style="color:red; font-size: large;" title="Required"></span>
                                    <div class="form-horizontal">
                                        <input type="file" name="nrc_file" class="form-control">
                                    </div>
                                </div>

                                <hr>

                                <h4 style="text-decoration:underline"><b>Next Of Kin Details</b></h4>


                                <div class="box-body">
                                    <label>Next Of Kin (Full Names):</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" id="numeric" name="nok_name" class="form-control" placeholder="Next Of Kin name">
                                    </div>
                                </div>
                                <div class="box-body">
                                    <label>Next Of Kin (Relationship):</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" id="numeric" name="nok_relationship" class="form-control" placeholder="Next Of Kin relationship">
                                    </div>
                                </div>
                                <div class="box-body">
                                    <label>Next Of Kin (Email):</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" id="numeric" name="nok_email" class="form-control" placeholder="Next Of Kin email">
                                    </div>
                                </div>
                                <div class="box-body">
                                    <label>Next Of Kin (Address):</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" id="numeric" name="nok_address" class="form-control" placeholder="Next Of Kin address">
                                    </div>
                                </div>

                                <div class="box-body">
                                    <label>Next Of Kin (Phone Number):</label><span style="color:red; font-size: large;" title="Required">* </span>
                                    <div class="form-horizontal">
                                        <input required="required" id="numeric" name="nok_phone" class="form-control" placeholder="Next Of Kin Phone number">
                                    </div>
                                </div>

                                <div class="box-footer">
                                    <div class="pull-right">
                                        <?php
                                        if ($CompanyObject->getNoUsersInCompany() <= $CompanyObject->checkNousers($_key)) {
                                            echo '<button name="save" type="submit" class="btn btn-primary"></i>Save</button>';
                                        } else {
                                            echo '<a class="btn btn-danger"></i>You can not add any more users, please check your license package.</a>';
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>

                        </form>
                        <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>

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
    <script>
        function toggleInput(checkbox) {
            var id = "earning_" + checkbox.value;
            console.log(id);
            var inputField = document.getElementById(id);
            if (checkbox.checked) {
                inputField.required = true;
                inputField.disabled = false;
            } else {
                inputField.required = false;
                inputField.disabled = true;
            }
        }
    </script>

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
                if ($("#employment_type").val() === "Contract") {
                    $("#contract_expire_date").slideDown("slow", function() {});
                    $("#eligibility").slideDown("slow", function() {});
                    console.log('emp type..');
                } else {
                    $("#contract_expire_date").slideUp("slow", function() {
                        $("#contract_expire_date").val("");

                        console.log('emp type.. else');
                    });
                }
            });

            $("#has_gratuity").blur(function() {
                if ($("#has_gratuity").val() === "Yes") {
                    $("#gatuity_amount_").slideDown("slow", function() {});
                    console.log('gratuity.');
                } else {
                    $("#gatuity_amount_").slideUp("slow", function() {});
                }
            });

            $("#probation_status").blur(function() {
                if ($("#probation_status").val() === "Yes") {
                    $("#probation_duration").slideDown("slow", function() {});
                    console.log('probation status.');
                } else {
                    $("#probation_duration").slideUp("slow", function() {
                        $("#contraprobation_durationct_expire_date").val("");
                        console.log('probation duration.');
                    });
                }
            });

        });
    </script>

</body>

</html>