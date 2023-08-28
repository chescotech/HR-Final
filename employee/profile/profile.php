<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php include '../navigation_panel/authenticated_user_header.php'; ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['update'])) {
            require_once '../../Admin/Classes/Employees.php';
            $EmployeeObject = new Employee();

            $stateMessage = "";
            $id = $_POST['id'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
            $init = $_POST['init'];

            $dob_timestamp = strtotime($_POST['bdate']);
            $bdate = date('Y-m-d', $dob_timestamp);

            $position = $_POST['position'];
            $bank = $_POST['bank'];
            $account = $_POST['account'];
            $social = $_POST['social'];

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

            $gross_pay = $_POST['basic_pay'] + $house_allowance + $transport_allowance + $lunch_allowance;
            $empno = $_POST['empno'];
            $leaveworkflow_id = $_POST['leaveworkflow_id'];
            $gatuity_amount = $_POST['gatuity_amount'];
            // newer items added
            $NRC = $_POST['NRC'];
            $email = $_POST['email'];
            $personal_email = $_POST['personal_email'];
            // newer items added end
            // Next of Kin
            $nok_name = $_POST['nok_name'];
            $nok_relationship = $_POST['nok_relationship'];
            $nok_email = $_POST['nok_email'];
            $nok_address = $_POST['nok_address'];
            $nok_phone = $_POST['nok_phone'];
            $phone = $_POST['phone'];

            // upload profile image
            if ($_FILES["img"]["name"] != "") {
                $img = $_FILES["img"]["name"];
                $target_dir = "../../images/employees/";
                $target_file = $target_dir . basename($img);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    // echo "The file " . htmlspecialchars(basename($img)) . " has been uploaded.";
                } else {
                    //echo "Sorry, there was an error uploading your file.";
                }
            } else {
                $img = $_POST['defaultimg'];
            }

            if ($_FILES["nrc_file"]["name"] != "") {
                $nrc_file = $_FILES["nrc_file"]["name"];
                $target_dir = "../../images/employees/";
                $target_file_ = $target_dir . basename($nrc_file);
                $imageFileType = strtolower(pathinfo($target_file_, PATHINFO_EXTENSION));
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    //echo "The file " . htmlspecialchars(basename($nrc_file)) . " has been uploaded.";
                } else {
                    // echo "Sorry, there was an error uploading your file.";
                }
            } else {
                $nrc_file = $_POST['defaultimg'];
            }


            if ($leaveworkflow_id == "") {
                $result = mysql_query("UPDATE emp_info SET fname ='$fname',lname='$lname',
                init='$init',bdate='$bdate',position='$position', bank='$bank',
                account='$account',date_joined='$dateJoined',date_left='$date_left'
                ,gross_pay='$gross_pay',payment_method='$payment_method',basic_pay='$basic_pay',
                social='$social',branch_code='$branch_code',photo = '$img',
                nok_name='$nok_name', nok_relationship='$nok_relationship', nok_email='$nok_email', nok_address='$nok_address', nok_phone='$nok_phone',
                gatuity_amount='$gatuity_amount',phone='$phone', NRC = '$NRC', email='$email', personal_email='$personal_email',nrc_file='$nrc_file'
                 WHERE id= '$id'") or die("Error.." . mysql_error());
            } else {
                $result = mysql_query("UPDATE emp_info SET fname ='$fname',lname='$lname',
                init='$init',bdate='$bdate',position='$position', bank='$bank',
                account='$account',date_joined='$dateJoined',date_left='$date_left'
                ,gross_pay='$gross_pay',payment_method='$payment_method',basic_pay='$basic_pay',
                social='$social',branch_code='$branch_code',leaveworkflow_id='$leaveworkflow_id',
                nok_name='$nok_name', nok_relationship='$nok_relationship', nok_email='$nok_email', nok_address='$nok_address', nok_phone='$nok_phone',
                photo = '$img', gatuity_amount='$gatuity_amount',phone='$phone', NRC = '$NRC', email='$email', personal_email='$personal_email',nrc_file='$nrc_file'
                 WHERE id= '$id'") or die("Error.." . mysql_error());
            }


            $stateMessage = "Employee information Successully updated !!";
        }
        ?>

        <div class="content-wrapper">

            <section class="content">

                <div class="row">
                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <?php
                                $result = mysql_query("SELECT * FROM emp_info where empno='$employeeId' ") or die(mysql_error());
                                $row = mysql_fetch_array($result);
                                $position = $row['position'];
                                if ($row["photo"] != "") {
                                    $picname = $row["photo"];
                                } else {
                                    $picname = 'default.png';
                                }
                                $emp_name = $row['fname'] . "-" . $row['lname'];
                                echo '<img src="../../images/employees/' . $picname . '" width="250px" style="border-radius:30px">';
                                ?>

                                <h3 style="color: black" class="profile-username text-center"><b>

                                        <?php
                                        echo $emp_name;
                                        ?>
                                    </b>
                                </h3>

                                <p class="text-muted text-center">
                                    <strong style="color: black"><b><?php echo $position; ?></b></strong>
                                </p>

                            </div>
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                    <div class="col-md-6">
                        <div class="nav-tabs-custom">

                            <div class="tab-content">

                                <div class="col-md-9">
                                    <?php
                                    if (isset($_POST['update'])) {
                                        // return var_dump($_FILES["img"]["name"]);
                                    }
                                    ?>
                                    <?php
                                    $empQuery = mysql_query("SELECT * FROM emp_info where empno='$employeeId' ") or die(mysql_error());

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
                                                                <h3 class="box-title"><b>Update Your Profile</b></h3>
                                                                </center>';
                                                        }
                                                        ?>
                                                    </center>
                                                </div>

                                                <div class="box-body">
                                                    <label>Employee Number</label>
                                                    <div class="form-group">
                                                        <input readonly type="text" required="required" value="<?php echo $rows['empno']; ?>" name="empno" class="form-control">
                                                        <input readonly type="hidden" required="required" value="<?php echo $rows['id']; ?>" name="id" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="box-body">
                                                    <label>Employee Title</label>
                                                    <div class="form-group">
                                                        <input readonly type="text" required="required" value="<?php echo $rows['position']; ?>" name="position" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="box-body">
                                                    <label>Employee Grade</label>
                                                    <div class="form-group">
                                                        <input readonly type="text" required="required" value="<?php echo $rows['employee_grade']; ?>" name="employee_grade" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="box-body">
                                                    <label>First name</label>
                                                    <div class="form-group">
                                                        <input readonly required="required" value="<?php echo $rows['fname']; ?>" name="fname" class="form-control" placeholder="Enter First Name:">
                                                    </div>
                                                </div>

                                                <div class="box-body">
                                                    <label for="lname">Last name</label>
                                                    <div class="form-group">
                                                        <input readonly id="lname" required="required" value="<?php echo $rows['lname']; ?>" name="lname" class="form-control" placeholder="Enter Last Name:">
                                                    </div>
                                                </div>

                                                <div class="box-body">
                                                    <label>Work Email</label>
                                                    <div class="form-group">
                                                        <input readonly value="<?php echo $rows['email']; ?>" type="text" name="email" class="form-control" placeholder="Enter Work Email:">
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <label>Personal Email</label>
                                                    <div class="form-group">
                                                        <input readonly value="<?php echo $rows['personal_email']; ?>" type="text" name="personal_email" class="form-control" placeholder="Enter Personal Email:">
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <label>Initials</label>
                                                    <div class="form-group">
                                                        <input readonly value="<?php echo $rows['init']; ?>" max="1" name="init" class="form-control" placeholder="Enter Initial:">
                                                    </div>
                                                </div>

                                                <div class="box-body">
                                                    <label>ID Number (NRC or Passpart)</label>
                                                    <div class="form-group">
                                                        <input readonly value="<?php echo $rows['NRC']; ?>" max="1" name="NRC" class="form-control" placeholder="Enter ID:">
                                                    </div>
                                                </div>

                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <label>Birth date</label>
                                                        <input readonly value="<?php echo $rows['bdate']; ?>" id="birthday_picker" name="bdate" class="form-control" placeholder="Date Of Birth:">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Position</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value=" <?php echo $rows['position']; ?>" name="position" class="form-control" placeholder="Position">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Bank</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value="<?php echo $rows['bank']; ?>" name="bank" class="form-control" placeholder="Bank Name">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Branch Code:</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value="<?php echo $rows['branch_code']; ?>" name="branch_code" class="form-control" placeholder="Branch Code">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Account Number:</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value="<?php echo $rows['account']; ?>" name="account" class="form-control" placeholder="Account Number">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Social Security Number:</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value=" <?php echo $rows['social']; ?>" name="social" class="form-control" placeholder="Social Security Number">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Date Joined</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value="<?php echo $rows['date_joined']; ?>" type="date" name="date_joined" class="form-control" placeholder="Date Joined">
                                                    </div>
                                                </div>

                                                <div hidden="hidden" class="box-body" hidden="">
                                                    <label>Date Left</label>
                                                    <div class="form-horizontal">
                                                        <input readonly type="date" value="<?php echo $rows['date_left']; ?>" id="datepicker_" name="date_left" class="form-control" placeholder="Date Left">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Basic Pay</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value="<?php echo $rows['basic_pay']; ?>" name="basic_pay" class="form-control" placeholder="Gross Pay">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Housing Allowance:</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value="<?php echo $allowanceRows['house_allowance']; ?>" type="number" name="house_allowance" class="form-control" placeholder="Enter House Allowance">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Transport Allowance:</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value="<?php echo $allowanceRows['transport_allowance']; ?>" type="number" name="transport_allowance" class="form-control" placeholder="Enter Transport Allowance">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Lunch Allowance:</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value="<?php echo $allowanceRows['lunch_allowance']; ?>" type="number" name="lunch_allowance" class="form-control" placeholder="Enter Lunch Allowance">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Payment Method</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value="<?php echo $rows['payment_method']; ?>" name="payment_method" class="form-control" placeholder="Payment Method">
                                                    </div>
                                                </div>

                                                <div class="box-body" hidden="">
                                                    <label>Gratuity in %</label>
                                                    <div class="form-horizontal">
                                                        <input readonly value="<?php echo $rows['gatuity_amount']; ?>" name="gatuity_amount" class="form-control" placeholder="Payment Method">
                                                    </div>
                                                </div>

                                                <div class="box-body">
                                                    <label>Phone Number:</label><span style="color:red; font-size: large;" title="Required">* </span>
                                                    <div class="form-horizontal">
                                                        <input readonly required="required" value="<?php echo $rows['phone']; ?>" id="numeric" name="phone" class="form-control" placeholder="Phone">
                                                    </div>
                                                </div>

                                                <div class="box-body">
                                                    <label>Leave Approver Group:</label>
                                                    <div class="form-group" hidden="">
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

                                                    <div class="box-body">
                                                        <label>Choose Profile Image:</label>
                                                        <div class="form-horizontal">
                                                            <input readonly type="text" name="img" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="box-body">
                                                        <label>Upload Employee NRC or Passport Identity :</label>
                                                        <div class="form-horizontal">
                                                            <input readonly type="text" name="nrc_file" class="form-control">
                                                        </div>
                                                    </div>

                                                    <input readonly value="<?php echo $image; ?>" name="defaultimg" type="hidden">


                                                    <h4 style="text-decoration:underline"><b>Next Of Kin Details</b></h4>


                                                    <div class="box-body">
                                                        <label>Next Of Kin (Full Names):</label>
                                                        <div class="form-horizontal">
                                                            <input readonly required="required" name="nok_name" class="form-control" value="<?php echo $rows['nok_name']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <label>Next Of Kin (Relationship):</label>
                                                        <div class="form-horizontal">
                                                            <input readonly required="required" name="nok_relationship" class="form-control" value="<?php echo $rows['nok_relationship']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <label>Next Of Kin (Email):</label>
                                                        <div class="form-horizontal">
                                                            <input readonly required="required" name="nok_email" class="form-control" value="<?php echo $rows['nok_email']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="box-body">
                                                        <label>Next Of Kin (Address):</label>
                                                        <div class="form-horizontal">
                                                            <input readonly required="required" name="nok_address" class="form-control" value="<?php echo $rows['nok_address']; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="box-body">
                                                        <label>Next Of Kin (Phone Number):</label>
                                                        <div class="form-horizontal">
                                                            <input readonly required="required" name="nok_phone" class="form-control" value="<?php echo $rows['nok_phone']; ?>">
                                                        </div>
                                                    </div>


                                                </div>

                                                <div class="box-footer" hidden>
                                                    <div class="pull-right">
                                                        <button name="update" type="submit" class="btn btn-primary"></i>Update</button>
                                                    </div>
                                                    <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                                </div><!-- /.box-footer -->
                                            </div><!-- /. box -->

                                        </form>

                                    <?php } ?>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>

        <?php include '../footer/footer.php'; ?>

    </div>

    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <script src="../plugins/fastclick/fastclick.min.js"></script>

    <script src="../dist/js/app.min.js"></script>

    <script src="../dist/js/demo.js"></script>

</body>

</html>