<?php
error_reporting(0);
?>

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
        include_once '../Classes/Company.php';
        $CompanyObject = new Company();
        include_once '../navigation_panel/authenticated_user_header.php';
        $empl_id = $_GET['id'];
        $companyId = $_SESSION['company_ID'];
        ?>

        <?php include_once '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['update'])) {
            $stateMessage = "";
            $id = $_GET['id'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $init = $_POST['init'];

            $dob_timestamp = strtotime($_POST['bdate']);
            $bdate = date('Y-m-d', $dob_timestamp);

            $position = $_POST['position'];
            $bank = $_POST['bank'];
            $account = $_POST['account'];
            $social = $_POST['social'];
            $department = $_POST['department'];

            $date_joined_timestamp = strtotime($_POST['date_joined']);
            $dateJoined = date('Y-m-d', $date_joined_timestamp);

            $date_left_timestamp = strtotime($_POST['date_left']);
            $date_left = date('Y-m-d', $date_joined_timestamp);

            $basic_pay = $_POST['basic_pay'];
            $payment_method = $_POST['payment_method'];

            $house_allowance = $_POST['house_allowance'];
            $transport_allowance = $_POST['transport_allowance'];
            $lunch_allowance = $_POST['lunch_allowance'];
            $branch_code = $_POST['branch_code'];

            // fetch the data for earnings
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

            $cn_imploded = implode(", ", $columnNames);
            // $cv_imploded = implode(", ", $columnValues);
            $cv_imploded = "'" . implode("', '", $columnValues) . "'";

            $cn_imploded = implode(', ', $columnNames);
            $cv_imploded = implode(', ', $columnValues);

            $updateQuery = "UPDATE employee_earnings SET ";

            // Build the SET part of the query using the formatted column names and values
            for ($i = 0; $i < count($columnNames); $i++) {
                $updateQuery .= "`" . $columnNames[$i] . "` = '" . $columnValues[$i] . "'";

                if ($i != count($columnNames) - 1) {
                    $updateQuery .= ", "; // Add a comma separator for the next column
                }
            }

            $gross_pay = 0;
            foreach ($columnValues as $key => $value) {
                # code...
                $gross_pay += $value;
            }
            // return var_dump($gross_pay);
            // $gross_pay = $_POST['basic_pay'] + $house_allowance + $transport_allowance + $lunch_allowance;
            $empno = $_POST['empno'];
            $leaveworkflow_id = $_POST['leaveworkflow_id'];
            $gatuity_amount = $_POST['gatuity_amount'];

            // Next of Kin
            $nok_name = $_POST['nok_name'];
            $nok_relationship = $_POST['nok_relationship'];
            $nok_email = $_POST['nok_email'];
            $nok_address = $_POST['nok_address'];
            $nok_phone = $_POST['nok_phone'];
            $phone = $_POST['phone'];
            $p_address = $_POST['p_address'];
            $email = $_POST['email'];
            $emp_grade = $_POST['emp_grade'];
            $employee_type = $_POST['employee_type'];
            $employment_type = $_POST['employment_type'];
            $nhima = $_POST['nhima'];
            $NRC = $_POST['NRC'];

            // upload profile image
            if ($_FILES["img"]["name"] != "") {
                $img = $_FILES["img"]["name"];
                $target_dir = "../../images/employees/";
                $target_file = $target_dir . basename($img);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($img)) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                $img = $_POST['defaultimg'];
            }

            if ($_FILES["nrc_file"]["name"] != "") {
                $nrc_file = $_FILES["nrc_file"]["name"];
                $target_dir = "../../images/employees/";
                $target_file_ = $target_dir . basename($nrc_file);
                $imageFileType = strtolower(pathinfo($target_file_, PATHINFO_EXTENSION));
                if (move_uploaded_file($_FILES["nrc_file"]["tmp_name"], $target_file_)) {
                    echo "The file " . htmlspecialchars(basename($nrc_file)) . " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                $nrc_file = $_POST['defaultimg'];
            }

            $tpin = $_POST['tpin'];

            $EmployeeObject->updateEmpInfos(
                $fname,
                $lname,
                $init,
                $bdate,
                $position,
                $bank,
                $account,
                $dateJoined,
                $date_left,
                $nok_name,
                $nok_relationship,
                $nok_email,
                $nok_address,
                $nok_phone,
                $basic_pay,
                $gross_pay,
                $payment_method,
                $id,
                $social,
                $branch_code,
                $leaveworkflow_id,
                $img,
                $gatuity_amount,
                $phone,
                $nrc_file,
                $department,
                $p_address,
                $email,
                $emp_grade,
                $employee_type,
                $employment_type,
                $nhima,
                $tpin,
                $NRC
            );
            //$EmployeeObject->updateEmployeeeAllowance($empno, $house_allowance, $transport_allowance, $lunch_allowance);
            // check if allowance exsists..

            // Add the condition for the update
            $updateQuery .= " WHERE employee_id = '$id'";

            // return var_dump($updateQuery);

            // Execute the query
            $earnings_item = mysql_query($updateQuery) or die(mysql_error());

            // Parse the deductions
            $deductionValues = array();

            // Loop through the $_POST array
            foreach ($formData as $key => $value) {
                // Check if the key starts with "deduction_"
                if (strpos($key, "deduction_") === 0) {
                    // Extract the deduction name without "deduction_"
                    $deductionName = substr($key, strlen("deduction_"));

                    // Sanitize and format the deduction name
                    $sanitizedDeductionName = mysql_real_escape_string(strtolower(str_replace(" ", "_", $deductionName)));
                    // Check if the deduction is selected (value is not empty)
                    $deductionValue = !empty($value) ? 'TRUE' : 'FALSE';

                    // Add deduction name and value to the array
                    $deductionValues[] = "`$sanitizedDeductionName` = $deductionValue";
                }
            }

            // List of columns to exclude
            $columns_to_exclude = array('id', 'employee_id', 'employee_no', 'company_id');

            // Get the list of column names from the table
            $query = "SHOW COLUMNS FROM `employee_deductions`";
            $result = mysql_query($query) or die(mysql_error());

            $update_columns = array();



            // Build the SET part of the query
            $setClause = implode(", ", $deductionValues);

            if ($result) {
                while ($row = mysql_fetch_assoc($result)) {

                    $column_name = $row['Field'];

                    // Exclude the columns you want to keep (first 4)
                    if (!in_array($column_name, $columns_to_exclude)) {
                        $clearClause[] = "`$column_name` = NULL";
                    }
                }

                // Construct the full query to clear this employee's deductions first
                $updateQuery = "UPDATE employee_deductions SET " . implode(", ", $clearClause) . " WHERE employee_id = '$id'";

                // Execute the clear statement
                $deductions_update = mysql_query($updateQuery) or die(mysql_error());
            } else {
                echo "Error: " . mysql_error();
            }

            // update the relevant deductions
            $updateQuery = mysql_query("UPDATE employee_deductions SET " . $setClause . " WHERE employee_id = '$id'");

            // log user creation
            $action = "Edit Employee";
            $emp_id = $_SESSION['user_session'];
            $emp_log = mysql_query("INSERT INTO emp_log(company_id, action, action_user) VALUES('$companyId','$action','$emp_id')") or die(mysql_error());


            $result = mysql_query("SELECT * FROM allowances_tb WHERE emp_no = '$empno' ");
            if (mysql_num_rows($result) > 0) {
                mysql_query("UPDATE allowances_tb SET house_allowance ='$house_allowance',transport_allowance='$transport_allowance',"
                    . "lunch_allowance='$lunch_allowance' WHERE emp_no= '$empno'");
            } else {
                mysql_query("INSERT allowances_tb(house_allowance,transport_allowance,lunch_allowance,emp_no,company_id) "
                    . "VALUES('$house_allowance','$transport_allowance','$lunch_allowance','$empno','4')");
            }

            $stateMessage = "Employee information Successully updated !!";
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
                        if (isset($_POST['update'])) {
                            // return var_dump($_FILES["img"]["name"]);
                        }
                        ?>
                        <?php
                        $id = $_GET['id'];
                        $empQuery = $EmployeeObject->getEmployeeById($id);

                        while ($rows = mysql_fetch_array($empQuery)) {
                            $image = $rows['photo'];
                        ?>
                            <form enctype="multipart/form-data" method="post">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <center>
                                            <?php
                                            $empno = $rows['empno'];
                                            $allowanceQuery = mysql_query("SELECT * FROM allowances_tb WHERE emp_no = '$empno'");
                                            $allowanceRows = mysql_fetch_array($allowanceQuery);
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
                                        <label>Title:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-group">
                                            <select name="init" class="form-control">
                                                <option value="<?php echo $rows['init']; ?>"><?php echo $rows['init']; ?></option>
                                                <option value="Mr">Mr.</option>
                                                <option value="Ms">Ms.</option>
                                                <option value="Mrs">Mrs.</option>
                                                <option value="Dr">Dr.</option>
                                                <option value="Prof">Prof.</option>
                                                <option value="Miss">Miss.</option>
                                            </select>
                                        </div>
                                    </div>

                                    <input required="required" value="<?php echo $rows['empno']; ?>" name="empno" type="hidden" placeholder="Empno">

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
                                        <label for="lname">Nhima Number</label>
                                        <div class="form-group">
                                            <input id="nhima" value="<?php echo $rows['nhima']; ?>" name="nhima" class="form-control" placeholder="Enter Nhima Number:">
                                        </div>
                                    </div>


                                    <div class="box-body">
                                        <label>ID Number(NRC or Passport):</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-group">
                                            <input required="required" name="NRC" class="form-control" value="<?php echo $rows['NRC']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Gender:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-group">
                                            <select name="gender" class="form-control">
                                                <option value="<?php echo $rows['gender']; ?>"><?php echo $rows['gender']; ?></option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Birth date</label>
                                            <input value="<?php echo $rows['bdate']; ?>" id="birthday_picker" required="required" name="bdate" class="form-control" placeholder="Date Of Birth:">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Marital Status:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-group">
                                            <select name="marital_status" class="form-control">
                                                <option value="<?php echo $rows['marital_status']; ?>"> <?php echo $rows['marital_status']; ?> </option>
                                                <option value="Married">Married</option>
                                                <option value="Single">Single</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="box-body">
                                        <label>Phone Number:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-horizontal">
                                            <input required="required" value="<?php echo $rows['phone']; ?>" id="numeric" name="phone" class="form-control" placeholder="Phone">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Physical Address:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-horizontal">
                                            <input required="required" name="p_address" class="form-control" value="<?php echo $rows['address']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Email:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-horizontal">
                                            <input required="required" name="email" class="form-control" value="<?php echo $rows['email']; ?>">
                                        </div>
                                    </div>

                                    <h4 style="text-decoration:underline"><b>Job Related Information.</b></h4>

                                    <div class="box-body">
                                        <label>Leave Approver Group:</label>
                                        <div class="form-group">
                                            <select name="leaveworkflow_id" class="form-control">
                                                <option value="<?php $rows['leaveworkflow_id'] ?>"><?php echo $CompanyObject->getApproverByID($rows['leaveworkflow_id']); ?></option>
                                                <?php
                                                $departmentquery = $CompanyObject->getApproverList();
                                                while ($row = mysql_fetch_array($departmentquery)) {
                                                ?>
                                                    <option value="<?php echo $row['id']; ?>"> <?php echo $row['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Date Joined</label>
                                        <div class="form-horizontal">
                                            <input value="<?php echo $rows['date_joined']; ?>" type="date" name="date_joined" class="form-control" placeholder="Date Joined">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Position</label>
                                        <div class="form-horizontal">
                                            <input value="<?php echo $rows['position']; ?>" required="required" name="position" class="form-control" placeholder="Position">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Employment Type:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-group">
                                            <select name="employee_type" class="form-control">
                                                <option value="<?php echo $rows['employee_type']; ?>"> <?php echo $rows['employee_type']; ?> </option>
                                                <option value="Full Time">Full Time</option>
                                                <option value="Temporary">Temporary</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Nature of Employment:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-group">
                                            <select name="employment_type" class="form-control">
                                                <option value="<?php echo $rows['employment_type'] ?>"> <?php echo $rows['employment_type'] ?> </option>
                                                <option value="Permanent">Permanent</option>
                                                <option value="Contract">Contract</option>
                                                <option value="Internship">Internship</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div id="eligibility" class="box-body" hidden="hidden">
                                        <label>Is Employee Eligible for Gratuity ? :</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-group">
                                            <select id="" name="has_gratuity" class="form-control">
                                                <option value="<?php echo $rows['has_gratuity'] ?>"> <?php echo $rows['has_gratuity'] ?> </option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="gatuity_amount" class="box-body" hidden="hidden">
                                        <label>Gratuity Amount in %:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-horizontal">
                                            <input name="gatuity_amount" class="form-control" value="<?php echo $rows['gatuity_amount'] ?>">
                                        </div>
                                    </div>

                                    <div id="contract_expire_date" hidden="hidden" class="box-body">
                                        <label>Date When Contract Expires:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-horizontal">
                                            <input id="birthday_picker" name="date_left" class="form-control" placeholder="<?php echo $rows['date_left'] ?>">
                                        </div>
                                    </div>


                                    <div id="probation_duration" hidden="hidden" class="box-body">
                                        <label>Date When Probation Ends:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-horizontal">
                                            <input name="probation_deadline" id="probation_deadline" class="form-control" value="<?php echo $rows['probation_deadline'] ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Department:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-group">
                                            <select name="department" class="form-control">
                                                <option value="<?php echo $rows['dept']; ?>">- Currently in <?php echo $EmployeeObject->getDepartmentDetails($rows['dept']); ?> -</option>
                                                <?php
                                                $departmentquery = mysql_query("SELECT * FROM department ");
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
                                            <input name="social" class="form-control" value="<?php echo $rows['social']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Employee Grade:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-horizontal">
                                            <select name="emp_grade" class="form-control">
                                                <option value="<?php echo $rows['grade']; ?>">- Currently in <?php echo $rows['employee_grade']; ?> -</option>
                                                <?php
                                                $compName = $_SESSION['username'];
                                                $CompanyQuery = mysql_query("SELECT grade FROM grade where company_ID='$companyId'") or die(mysql_error());
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
                                        <label>Bank</label>
                                        <div class="form-horizontal">
                                            <input value="<?php echo $rows['bank']; ?>" name="bank" class="form-control" placeholder="Bank Name">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Payment method:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                        <div class="form-horizontal">
                                            <input required="required" name="payment_method" class="form-control" value="<?php echo $rows['payment_method']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Branch Code:</label>
                                        <div class="form-horizontal">
                                            <input required="required" value="<?php echo $rows['branch_code']; ?>" name="branch_code" class="form-control" placeholder="Branch Code">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Account Number:</label>
                                        <div class="form-horizontal">
                                            <input value="<?php echo $rows['account']; ?>" name="account" class="form-control" placeholder="Account Number">
                                        </div>
                                    </div>


                                    <div class="box-body">
                                        <label>TPIN Number:</label>
                                        <div class="form-horizontal">
                                            <input value="<?php echo $rows['tpin']; ?>" name="tpin" class="form-control" placeholder="TPIN Number">
                                        </div>
                                    </div>

                                    <h4 style="text-decoration:underline"><b>Employee Earnings.</b></h4>

                                    <!-- Button trigger modal -->

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#earningsModal">
                                        Update Earnings
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
                                                // Assume $userId is the ID of the user you're editing
                                                // Retrieve the user's earnings from the employee_earnings table
                                                $earningsQuery = mysql_query("SELECT * FROM employee_earnings WHERE employee_id = '$empl_id '");
                                                $earningsData = array();

                                                if (mysql_num_rows($earningsQuery) > 0) {
                                                    $earningsRow = mysql_fetch_assoc($earningsQuery);
                                                    $earningsData = $earningsRow;
                                                }

                                                // Retrieve all earnings available for selection
                                                $earnings = mysql_query("SELECT * FROM earnings WHERE company_id = '$companyId'");
                                                ?>
                                                <div class="modal-body" style="overflow-y: scroll;">
                                                    <?php
                                                    while ($row = mysql_fetch_array($earnings)) {
                                                        $earningName = $row['name'];
                                                        $sanitizedEarningName = strtolower(str_replace(" ", "_", $earningName));
                                                        $earningAmount = isset($earningsData[$sanitizedEarningName]) ? $earningsData[$sanitizedEarningName] : ''; // Get the amount from the data array if available

                                                        // Render the form inputs
                                                    ?>
                                                        <div class="box-body">
                                                            <label><input type="checkbox" name="earning_<?= $row['name'] ?>" id="" value="<?= $row['id'] ?>" onchange="toggleInput(this)"> <?= $row['name'] ?><br></label>
                                                            <div class="form-horizontal">
                                                                <input type="text" id="earning_<?= $row['id'] ?>" name="earning_<?= $row['name'] ?>" class="form-control" placeholder="<?= $row['name'] ?>" value="<?= $earningAmount ?>" <?php if (!$earningAmount) {
                                                                                                                                                                                                                                                echo 'disabled';
                                                                                                                                                                                                                                            } ?>>
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

                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#deductionsModal">
                                        Update Deductions
                                    </button>

                                    <!-- Earnings Modal -->
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
                                                        "SELECT * FROM `deductions` WHERE company_ID = '$companyId'"
                                                    ) or die(mysql_error());

                                                    $deductionValues = array(); // Array to hold retrieved deduction values
                                                    // Retrieve deduction values for the employee from the database

                                                    $employeeDeductions = mysql_query(
                                                        "SELECT * FROM `employee_deductions` WHERE employee_id = '$empl_id' AND company_id = '$companyId'"
                                                    ) or die(mysql_error());
                                                    $deductionRow = mysql_fetch_assoc($employeeDeductions);
                                                    foreach ($deductionRow as $deductionColumn => $deductionValue) {
                                                        // Check if the deduction value is set
                                                        if ($deductionValue === '1') {
                                                            $deductionValues[] = $deductionColumn;
                                                        }
                                                    }

                                                    while ($ded_row = mysql_fetch_array($deductions)) {
                                                    ?>
                                                        <p>
                                                            <label>
                                                                <input type="checkbox" name="deduction_<?= $ded_row['name'] ?>" id="" value="<?= $ded_row['ded_id'] ?>" <?= in_array(strtolower(str_replace(" ", "_", $ded_row['name'])), $deductionValues) ? 'checked' : '' ?>>
                                                                <?= $ded_row['name'] ?>
                                                                <br>
                                                            </label>
                                                        </p>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <h4 style="text-decoration:underline"><b>Upload Employee Picture and NRC.</b></h4>

                                    <div class="box-body">
                                        <label>Choose Profile Image:</label>
                                        <div class="form-horizontal">
                                            <input type="file" name="img" class="form-control">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Upload Employee NRC or Passport Identity :</label>
                                        <div class="form-horizontal">
                                            <input type="file" name="nrc_file" class="form-control">
                                        </div>
                                    </div>

                                    <input value="<?php echo $image; ?>" name="defaultimg" type="hidden">


                                    <h4 style="text-decoration:underline"><b>Next Of Kin Details</b></h4>


                                    <div class="box-body">
                                        <label>Next Of Kin (Full Names):</label>
                                        <div class="form-horizontal">
                                            <input required="required" name="nok_name" class="form-control" value="<?php echo $rows['nok_name']; ?>">
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <label>Next Of Kin (Relationship):</label>
                                        <div class="form-horizontal">
                                            <input required="required" name="nok_relationship" class="form-control" value="<?php echo $rows['nok_relationship']; ?>">
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <label>Next Of Kin (Email):</label>
                                        <div class="form-horizontal">
                                            <input required="required" name="nok_email" class="form-control" value="<?php echo $rows['nok_email']; ?>">
                                        </div>
                                    </div>
                                    <div class="box-body">
                                        <label>Next Of Kin (Address):</label>
                                        <div class="form-horizontal">
                                            <input required="required" name="nok_address" class="form-control" value="<?php echo $rows['nok_address']; ?>">
                                        </div>
                                    </div>

                                    <div class="box-body">
                                        <label>Next Of Kin (Phone Number):</label>
                                        <div class="form-horizontal">
                                            <input required="required" name="nok_phone" class="form-control" value="<?php echo $rows['nok_phone']; ?>">
                                        </div>
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

                </div>
        </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <?php include '../footer/footer.php'; ?>

    <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <script>
        function toggleInput(checkbox) {
            var id = "earning_" + checkbox.value;
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
?>