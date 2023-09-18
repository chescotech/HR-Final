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
                        $compID = $_SESSION['company_ID'];
                        echo $_SESSION['name'] . ' Employee Deductions';
                        $method_nam = '';
                        ?>
                 </h1>
             </section>

             <?php
                if (isset($_POST['add_'])) {
                    $name = $_POST['name'];
                    $type = $_POST['type'];
                    $status = $_POST['status'];
                    $percent = $_POST['percent'];
                    $percent_of = $_POST['percent_of'];

                    // return var_dump($slug);
                    $add_q = mysql_query("INSERT INTO deductions (name, type, status,percent,percent_of)
                        VALUES('$name','$type','$status','$percent', '$percent_of' )") or die(mysql_error());

                    if ($add_q) {
                        echo "<script> alert('Added Successfuly') </script>";
                        echo "<script> window.location.href='deductions' </script>";
                    }
                }
                if (isset($_POST['create_'])) {
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
                        // insert fixed amounts into deductions
                        $fixed_quer = mysql_query("INSERT INTO deductions(name, company_ID, type, emp_fixed, comp_fixed, comp_lower_bound, comp_lower_bound_amnt, comp_upper_bound, comp_upper_bound_amnt, emp_lower_bound, emp_lower_bound_amnt, emp_upper_bound, emp_upper_bound_amnt) VALUES('$name', '$compID', '$type', '$emp_fixed', '$comp_fixed', '$comp_lb','$comp_lb_amnt','$comp_ub','$comp_ub_amnt','$emp_lb', '$emp_lb_amnt','$emp_ub','$emp_ub_amnt')") or die(mysql_error());
                        // if calculating, save percentages
                    } else {
                        // insert calculation items
                        $fixed_quer = mysql_query("INSERT INTO deductions(name, company_ID, type, emp_calc_num, emp_calc_deno, comp_calc_num, comp_calc_deno, comp_lower_bound, comp_lower_bound_amnt, comp_upper_bound, comp_upper_bound_amnt, emp_lower_bound, emp_lower_bound_amnt, emp_upper_bound, emp_upper_bound_amnt) VALUES('$name', '$compID', '$type', '$emp_numerator', '$emp_denominator', $comp_numerator, $comp_denominator, '$comp_lb','$comp_lb_amnt','$comp_ub','$comp_ub_amnt','$emp_lb', '$emp_lb_amnt','$emp_ub','$emp_ub_amnt')") or die(mysql_error());
                    }

                    // add to employee_deductions table
                    // add column to employee_earnings table
                    $sanitized_name = str_replace(" ", "_", strtolower($name));
                    $update_table = mysql_query("ALTER TABLE `employee_deductions` ADD `$sanitized_name` int(20) NULL;");

                    // if 
                }

                if (isset($_POST['delete'])) {
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $name = $_POST['name'];

                    $add_q = mysql_query("DELETE FROM deductions WHERE ded_id = '$id' ") or die(mysql_error());

                    if ($add_q) {

                        $sanitized_name = str_replace(" ", "_", strtolower($name));
                        $update_table = mysql_query("ALTER TABLE `employee_deductions` DROP `$sanitized_name`;");
                        echo "<script> alert('Deleted Successfuly') </script>";
                        echo "<script> window.location.href='deductions' </script>";
                    }
                }
                ?>

             <section class="content container">
                 <div class="row center">
                     <div class="col-xs-9 col-md-12">
                         <div class="box box-primary">
                             <div class="box-header">
                                 <h3 class="box-title">Deductions List</h3>
                             </div><!-- /.box-header -->
                             <div class="box-body">
                                 <table id="example1" class="table table-bordered table-striped">
                                     <thead>
                                         <tr>
                                             <th>Name</th>
                                             <th>Type</th>
                                             <th>Fixed Contribution Company</th>
                                             <th>Fixed Contribution Employee</th>
                                             <th>Company Contribution</th>
                                             <th>Employee Contribution</th>
                                             <th>Maximum Calculated Deduction (Company, Employee)</th>
                                             <th>Minimum Calculated Deduction (Company, Employee)</th>
                                             <th>Actions</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         <?php
                                            $query = mysql_query("SELECT * FROM deductions WHERE company_ID = '$compID'") or die(mysql_error());
                                            while ($row = mysql_fetch_array($query)) {
                                            ?>
                                             <tr>
                                                 <td><?php echo $row['name']; ?></td>
                                                 <td><?php echo $row['type']; ?></td>
                                                 <td><?php echo $row['comp_fixed']; ?></td>
                                                 <td><?php echo $row['emp_fixed']; ?></td>
                                                 <td>
                                                     <?php echo $row['comp_calc_num'] . " / " . $row['emp_calc_deno']; ?>
                                                 </td>
                                                 <td>
                                                     <?php echo $row['emp_calc_num'] . " / " . $row['emp_calc_deno']; ?>
                                                 </td>
                                                 <td>
                                                     <?php echo $row['comp_upper_bound'] . ' , ' . $row['emp_upper_bound']; ?>
                                                 </td>
                                                 <td>
                                                     <?php echo $row['comp_lower_bound'] . ' , ' . $row['emp_lower_bound']; ?>
                                                 </td>
                                                 <td>
                                                     <a href="edit-deduction?id=<?php echo $row['ded_id']; ?>" style="color:#fff;" class="btn btn-primary btn-sm">Edit</i></a>
                                                     <a href="#delete<?php echo $row['ded_id']; ?>" data-target="#delete<?php echo $row['ded_id']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-danger btn-sm">Delete</a>
                                                 </td>
                                             </tr>
                                             <div id="updateordinance<?php echo $row['ded_id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                 <div class="modal-dialog">
                                                     <div class="modal-content" style="height:auto">
                                                         <div class="modal-header">
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                 <span aria-hidden="true">×</span></button>
                                                             <h4 class="modal-title">Update Deductions</h4>
                                                         </div>
                                                         <div class="modal-body">
                                                             <form action="#" method="post">
                                                                 <div class="container">
                                                                     <p>
                                                                         Method (*Select One)
                                                                     </p>
                                                                     <label>
                                                                         <input type="radio" id="calculated" name="method"> Calculated
                                                                     </label>
                                                                     <br>

                                                                     <label>
                                                                         <input type="radio" id="fixed" name="method"> Fixed
                                                                     </label>
                                                                     <br><br>
                                                                 </div>
                                                                 <div class="row">
                                                                     <div class="container">
                                                                         <div class="col-md-6">
                                                                             <p style="padding: 4px 0px;">Method Number: <?= $method_nam ? $method_nam : '' ?></p>

                                                                             <p for="fixed_amount" class="p-3" style="padding: 8px 0px;">Fixed Amount</p>
                                                                             <p class="p-3" style="padding: 8px 0px;">The formula for calculated amount</p>
                                                                         </div>
                                                                         <!-- emp contr -->
                                                                         <div class="col-md-3">
                                                                             <h5>Employee Deduction</h5>
                                                                             <div class="row">
                                                                                 <div class="form-group">
                                                                                     <input class="form-control" type="text" name="fixed_amount_emp" id="fixed_amount_emp">
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
                                                                                     <input class="form-control" type="text" name="numerator_emp" id="numerator_emp" placeholder="1.0000">
                                                                                 </div>
                                                                             </div>
                                                                             <div class="row">
                                                                                 <div class="form-group">
                                                                                     /
                                                                                     <input class="form-control" type="text" name="denominator_emp" id="denominator_emp" placeholder="100.0000">
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
                                                                                         <input class="form-control" type="text" name="fixed_amount_comp" id="fixed_amount_comp">
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
                                                                                         <input class="form-control" type="text" name="numerator_comp" id="numerator_comp" placeholder="1.0000">
                                                                                     </div>
                                                                                 </div>
                                                                                 <div class="row">
                                                                                     <div class="form-group">
                                                                                         /
                                                                                         <input class="form-control" type="text" name="denominator_comp" id="denominator_comp" placeholder="100.0000">
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
                                                                                 <button type="submit" name="create_" class="btn btn-primary">
                                                                                     Save
                                                                                 </button>
                                                                                 <button type="submit" class="btn btn-danger">
                                                                                     Clear
                                                                                 </button>
                                                                             </div>
                                                                         </div>
                                                                         <!-- employee column -->
                                                                         <div class="col-md-3">
                                                                             <div class="row">
                                                                                 <div class="form-group">
                                                                                     <input class="form-control" type="text" name="emp_lower_bound" id="" placeholder='0.00'>
                                                                                 </div>
                                                                             </div>
                                                                             <div class="row">
                                                                                 <div class="form-group">
                                                                                     <input class="form-control" type="text" name="emp_lower_bound_amnt" id="" placeholder='0.00'>
                                                                                 </div>
                                                                             </div>
                                                                             <div class="row">
                                                                                 <div class="form-group">
                                                                                     <input class="form-control" type="text" name="emp_upper_bound" id="" placeholder='0.00'>
                                                                                 </div>
                                                                             </div>
                                                                             <div class="row">
                                                                                 <div class="form-group">
                                                                                     <input class="form-control" type="text" name="emp_upper_bound_amnt" id="" placeholder='0.00'>
                                                                                 </div>
                                                                             </div>
                                                                             <div class="row">
                                                                                 <div class="form-group">
                                                                                     <input name="short_desc" class="form-control" type="text" name="" id="">
                                                                                 </div>
                                                                             </div>
                                                                         </div>
                                                                         <!-- company column -->
                                                                         <div class="col-md-3 container-fluid">
                                                                             <div class="row">
                                                                                 <div class="form-group">
                                                                                     <input class="form-control" type="text" name="comp_lower_bound" id="" placeholder='0.00'>
                                                                                 </div>
                                                                             </div>
                                                                             <div class="row">
                                                                                 <div class="form-group">
                                                                                     <input class="form-control" type="text" name="comp_lower_bound_amnt" id="" placeholder='0.00'>
                                                                                 </div>
                                                                             </div>
                                                                             <div class="row">
                                                                                 <div class="form-group">
                                                                                     <input class="form-control" type="text" name="comp_upper_bound" id="" placeholder='0.00'>
                                                                                 </div>
                                                                             </div>
                                                                             <div class="row">
                                                                                 <div class="form-group">
                                                                                     <input class="form-control" type="text" name="comp_upper_bound_amnt" id="" placeholder='0.00'>
                                                                                 </div>
                                                                             </div>

                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                             </form>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <!--end of modal-dialog-->
                                             </div>


                                             <div id="delete<?php echo $row['ded_id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                 <div class="modal-dialog">
                                                     <div class="modal-content" style="height:auto">
                                                         <div class="modal-header">
                                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                 <span aria-hidden="true">×</span></button>
                                                             <h4 class="modal-title">Are you sure you want to delete this field ??
                                                             </h4>
                                                         </div>
                                                         <form class="form-horizontal" method="post" action="#delete" enctype='multipart/form-data'>
                                                             <div class="modal-body" hidden="">
                                                                 <div class="form-group">
                                                                     <div class="col-lg-9">
                                                                         <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['ded_id']; ?>" required>
                                                                         <input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>" required>
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                             <!-- <hr> -->
                                                             <div class="modal-footer">
                                                                 <button type="submit" class="btn btn-primary" name="delete">Delete</button>
                                                                 <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                             </div>
                                                         </form>
                                                     </div>

                                                 </div>
                                                 <!--end of modal-dialog-->
                                             </div>

                                             <!--end of modal-->
                                         <?php } ?>
                                     </tbody>
                                 </table>
                             </div><!-- /.box-body -->

                         </div><!-- /.col -->



                         <div>
                             <div class="row">
                                 <div class="box box-primary">
                                     <div class="box-header">
                                         <h3 class="box-title">Add New Deduction</h3>
                                     </div>
                                     <div class="box-body">
                                         <form action="#" method="post">
                                             <div class="container">
                                                 <p>
                                                     Method (*Select One)
                                                 </p>
                                                 <label>
                                                     <input type="checkbox" id="calculated" name="calculated"> Calculated
                                                 </label>
                                                 <br>

                                                 <label>
                                                     <input type="checkbox" id="fixed" name="fixed"> Fixed
                                                 </label>
                                                 <br><br>
                                             </div>
                                             <div class="row">
                                                 <div class="container">
                                                     <div class="col-md-6">
                                                         <p style="padding: 4px 0px;">Method Number: <?= $method_nam ?></p>
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
                                                                 <input class="form-control" type="text" name="fixed_amount_emp" id="fixed_amount_emp">
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
                                                                 <input class="form-control" type="text" name="numerator_emp" id="numerator_emp" placeholder="1.0000">
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="form-group">
                                                                 /
                                                                 <input class="form-control" type="text" name="denominator_emp" id="denominator_emp" placeholder="100.0000">
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
                                                                     <input class="form-control" type="text" name="fixed_amount_comp" id="fixed_amount_comp">
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
                                                                     <input class="form-control" type="text" name="numerator_comp" id="numerator_comp" placeholder="1.0000">
                                                                 </div>
                                                             </div>
                                                             <div class="row">
                                                                 <div class="form-group">
                                                                     /
                                                                     <input class="form-control" type="text" name="denominator_comp" id="denominator_comp" placeholder="100.0000">
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
                                                             <button type="submit" name="create_" class="btn btn-primary">
                                                                 Save
                                                             </button>
                                                             <button type="submit" class="btn btn-danger">
                                                                 Clear
                                                             </button>
                                                         </div>
                                                     </div>
                                                     <!-- employee column -->
                                                     <div class="col-md-3">
                                                         <div class="row">
                                                             <div class="form-group">
                                                                 <input class="form-control" type="text" name="emp_lower_bound" id="" placeholder='0.00'>
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="form-group">
                                                                 <input class="form-control" type="text" name="emp_lower_bound_amnt" id="" placeholder='0.00'>
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="form-group">
                                                                 <input class="form-control" type="text" name="emp_upper_bound" id="" placeholder='0.00'>
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="form-group">
                                                                 <input class="form-control" type="text" name="emp_upper_bound_amnt" id="" placeholder='0.00'>
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="form-group">
                                                                 <input name="short_desc" class="form-control" type="text" name="" id="">
                                                             </div>
                                                         </div>
                                                     </div>
                                                     <!-- company column -->
                                                     <div class="col-md-3 container-fluid">
                                                         <div class="row">
                                                             <div class="form-group">
                                                                 <input class="form-control" type="text" name="comp_lower_bound" id="" placeholder='0.00'>
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="form-group">
                                                                 <input class="form-control" type="text" name="comp_lower_bound_amnt" id="" placeholder='0.00'>
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="form-group">
                                                                 <input class="form-control" type="text" name="comp_upper_bound" id="" placeholder='0.00'>
                                                             </div>
                                                         </div>
                                                         <div class="row">
                                                             <div class="form-group">
                                                                 <input class="form-control" type="text" name="comp_upper_bound_amnt" id="" placeholder='0.00'>
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