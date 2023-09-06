<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Deductions</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Department.php';
        $DepartmentObject = new Department();
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    $ded_id = $_GET['id'];
                    $compID = $_SESSION['company_ID'];
                    echo $_SESSION['name'] . ' Employee Deductions';
                    $message = "";
                    ?>
                </h1>
            </section>

            <?php
            if (isset($_POST['update_'])) {
                // variable
                $type = $_POST['calculated'] == 'on' ? 'calculated' : 'fixed';
                // fixed amounts
                $emp_fixed = $_POST['fixed_amount_emp'];
                $comp_fixed = $_POST['fixed_amount_comp'];
                // calculations
                $emp_numerator = doubleval($_POST['numerator_emp']);
                $emp_denominator = $_POST['denominator_emp'];
                $comp_numerator = doubleval($_POST['numerator_comp']);
                $comp_denominator = $_POST['denominator_comp'];
                // bounds
                // employee
                $emp_lb = doubleval($_POST['emp_lower_bound']);
                $emp_lb_amnt = doubleval($_POST['emp_lower_bound_amnt']);
                $emp_ub = doubleval($_POST['emp_upper_bound']);
                $emp_ub_amnt = doubleval($_POST['emp_upper_bound_amnt']);
                // company
                $comp_lb = doubleval($_POST['comp_lower_bound']);
                $comp_lb_amnt = doubleval($_POST['comp_lower_bound_amnt']);
                $comp_ub = doubleval($_POST['comp_upper_bound']);
                $comp_ub_amnt = doubleval($_POST['comp_upper_bound_amnt']);
                $name = $_POST['short_desc'];
                // if fixed amount is set
                $variable = "not set";
                if ($type == 'fixed') {
                    // Update fixed amounts in deductions
                    $updateQuery = mysql_query("
                        UPDATE deductions SET
                        name = '$name',
                        emp_fixed = '$emp_fixed', comp_fixed = '$comp_fixed',
                        comp_lower_bound = '$comp_lb', comp_lower_bound_amnt = '$comp_lb_amnt',
                        comp_upper_bound = '$comp_ub', comp_upper_bound_amnt = '$comp_ub_amnt',
                        emp_lower_bound = '$emp_lb', emp_lower_bound_amnt = '$emp_lb_amnt',
                        emp_upper_bound = '$emp_ub', emp_upper_bound_amnt = '$emp_ub_amnt'
                        WHERE ded_id = '$ded_id'
                    ") or die(mysql_error());
                } else {
                    // Update calculation items in deductions
                    $updateQuery = mysql_query("
                        UPDATE deductions SET
                        emp_calc_num = '$emp_numerator', emp_calc_deno = '$emp_denominator',
                        comp_calc_num = '$comp_numerator', comp_calc_deno = '$comp_denominator',
                        comp_lower_bound = '$comp_lb', comp_lower_bound_amnt = '$comp_lb_amnt',
                        comp_upper_bound = '$comp_ub', comp_upper_bound_amnt = '$comp_ub_amnt',
                        emp_lower_bound = '$emp_lb', emp_lower_bound_amnt = '$emp_lb_amnt',
                        emp_upper_bound = '$emp_ub', emp_upper_bound_amnt = '$emp_ub_amnt', name = '$name'
                        WHERE ded_id = '$ded_id'
                    ") or die(mysql_error());
                }
                // redirect to dedcutions
                if ($updateQuery) {
                    $message = "Deduction information successfully updated.";
                } else {
                    $message = "Failed to update the deduction information.";
                }
                header("Location:edit-deduction.php?id='$ded_id'");
            }
            ?>

            <section class="content container">
                <div class="row center">
                    <div class="col-xs-9 col-md-12">

                        <?php
                        // return var_dump($ded_id);
                        $query = mysql_query("SELECT * FROM deductions WHERE ded_id = '$ded_id' AND company_ID = '$compID'") or die(mysql_error());
                        $row = mysql_fetch_array($query);
                        ?>



                    </div><!-- /.col -->



                    <div>
                        <a href="deductions" class="btn btn-primary">Back</a>
                        <div class="row">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Update a Deduction</h3>
                                </div>
                                <div>
                                    <?php
                                    // if (isset($message) && str_contains($message, "Fail")) {
                                    //     echo '<p class="bg-danger">' . $message . '</p>';
                                    // } else {
                                    //     echo '<p class="bg-success">' . $message . '</p>';
                                    // }
                                    ?>
                                </div>
                                <div class="box-body">
                                    <form action="#" method="post">
                                        <div class="container">
                                            <p>
                                                Method (*Select One)
                                            </p>
                                            <label>
                                                <input type="checkbox" id="calculated" name="calculated" <?php echo $row['type'] == 'calculated' ? 'checked' : '' ?>> Calculated
                                            </label>
                                            <br>

                                            <label>
                                                <input type="checkbox" id="fixed" name="fixed" <?php echo $row['type'] == 'fixed' ? 'checked' : '' ?>> Fixed
                                            </label>
                                            <br><br>
                                        </div>
                                        <div class="row">
                                            <div class="container">
                                                <div class="col-md-6">
                                                    <p style="padding: 4px 0px;">Method Number: <?= $row['name']; ?></p>
                                                    <!-- <div class="form-group">
                                                     <label name="calc_method" for="">Method</label>
                                                     <input type="checkbox" name="" id="">
                                                     <small id="helpId" class="text-muted">Help text</small>
                                                 </div> -->
                                                    <p for="fixed_amount" class="p-3" style="padding: 8px 0px;">Fixed Amount</p>
                                                    <p class="p-3" style="padding: 8px 0px;">The formula for calculated amount</p>
                                                </div>
                                                <!-- emp contr -->
                                                <div class="col-md-3">
                                                    <h5>Employee Deduction</h5>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="fixed_amount_emp" id="fixed_amount_emp" value="<?= $row['emp_fixed']; ?>">
                                                        </div>
                                                    </div>

                                                    <!-- <div class="row">
                                                 <div class="form-group">
                                                     +
                                                     <input class="form-control" type="text" name="plus_emp" id="">
                                                 </div>
                                             </div> -->
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="numerator_emp" id="numerator_emp" placeholder="1.0000" value="<?= $row['emp_calc_num']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class=" row">
                                                        <div class="form-group">
                                                            /
                                                            <input class="form-control" type="text" name="denominator_emp" id="denominator_emp" placeholder="100.0000" value="<?= $row['emp_calc_deno']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <p>
                                                            = calc amount
                                                        </p>
                                                    </div>
                                                    <div class="row">

                                                    </div>
                                                </div>
                                                <!-- comp contr -->
                                                <div class="col-md-3">
                                                    <h5>
                                                        Company Contribution
                                                    </h5>
                                                    <div class="row">

                                                        <div class="row">
                                                            <div class="form-group">
                                                                <input class="form-control" type="text" name="fixed_amount_comp" id="fixed_amount_comp" value="<?= $row['comp_fixed']; ?>">
                                                            </div>
                                                        </div>

                                                        <!-- <div class="row">
                                                     <div class="form-group">
                                                         +
                                                         <input class="form-control" type="text" name="plus_comp" id="">
                                                        </div>
                                                    </div> -->
                                                        <div class="row">
                                                            <div class="form-group">
                                                                <input class="form-control" type="text" name="numerator_comp" id="numerator_comp" placeholder="1.0000" value="<?= $row['comp_calc_num']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group">
                                                                /
                                                                <input class="form-control" type="text" name="denominator_comp" id="denominator_comp" placeholder="100.0000" value="<?= $row['comp_calc_deno']; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <p>
                                                                = calc amount
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="container">
                                                <!-- labels -->
                                                <div class="col-md-6">
                                                    <div class="row" style="padding: 10px 0px;">
                                                        <p>
                                                            If calc amount is less than
                                                        </p>
                                                    </div>
                                                    <div class="row py-2" style="padding: 10px 0px;">
                                                        <p>
                                                            The deduction must be
                                                        </p>
                                                    </div>
                                                    <div class="row py-2" style="padding: 10px 0px;">
                                                        <p>
                                                            If calc amount is greater than max of
                                                        </p>
                                                    </div>
                                                    <div class="row py-2" style="padding: 10px 0px;">
                                                        <p>
                                                            Then deduction must be
                                                        </p>
                                                    </div>
                                                    <div class="row py-2" style="padding: 10px 0px;">
                                                        <p>
                                                            Short Description
                                                        </p>
                                                    </div>
                                                    <div class="row py-2" style="padding: 10px 0px;">
                                                        <button type="submit" name="update_" class="btn btn-primary">
                                                            Update
                                                        </button>
                                                        <a href="deductions" class="btn btn-danger">
                                                            Cancel
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- employee column -->
                                                <div class="col-md-3">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="emp_lower_bound" id="" placeholder='0.00' value="<?= $row['emp_lower_bound']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="emp_lower_bound_amnt" id="" placeholder='0.00' value="<?= $row['emp_lower_bound_amnt']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="emp_upper_bound" id="" placeholder='0.00' value="<?= $row['emp_upper_bound']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="emp_upper_bound_amnt" id="" placeholder='0.00' value="<?= $row['emp_upper_bound_amnt']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input name="short_desc" class="form-control" type="text" value="<?= $row['name'] ?>" id="" value="<?= $row['short_desc']; ?>" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- company column -->
                                                <div class="col-md-3 container-fluid">
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="comp_lower_bound" id="" placeholder='0.00' value="<?= $row['comp_lower_bound']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="comp_lower_bound_amnt" id="" placeholder='0.00' value="<?= $row['comp_lower_bound_amnt']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="comp_upper_bound" id="" placeholder='0.00' value="<?= $row['comp_upper_bound']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group">
                                                            <input class="form-control" type="text" name="comp_upper_bound_amnt" id="" placeholder='0.00' value="<?= $row['comp_upper_bound_amnt']; ?>">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div> <!-- box body -->
                            </div>
                        </div>
                    </div>
            </section>

        </div>
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(document).ready(function() {
            $('#employee_data').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            // Initial state
            $("#fixed_amount_emp").prop("disabled", false);
            $("#fixed_amount_comp").prop("disabled", false);
            $("#numerator_comp").prop("disabled", false);
            $("#denominator_comp").prop("disabled", false);
            $("#numerator_emp").prop("disabled", false);
            $("#denominator_emp").prop("disabled", false);

            // Checkbox event handlers
            $("#fixed").on("change", function() {
                if ($(this).is(":checked")) {
                    $("#numerator_emp").prop("disabled", true);
                    $("#denominator_emp").prop("disabled", true);
                    $("#numerator_comp").prop("disabled", true);
                    $("#denominator_comp").prop("disabled", true);
                } else {
                    $("#numerator_comp").prop("disabled", false);
                    $("#denominator_comp").prop("disabled", false);
                    $("#numerator_emp").prop("disabled", false);
                    $("#denominator_emp").prop("disabled", false);
                }
            });
            //  calculated, disable fixed fields
            $("#calculated").on("change", function() {
                if ($(this).is(":checked")) {
                    $("#fixed_amount_comp").prop("disabled", true);
                    $("#fixed_amount_emp").prop("disabled", true);
                } else {
                    $("#fixed_amount_comp").prop("disabled", false);
                    $("#fixed_amount_emp").prop("disabled", false);
                }
            });
        });
    </script>
</body>

</html>