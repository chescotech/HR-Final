<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Leave Types</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">
        <?php
        include_once '../Classes/Department.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Tax.php';

        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();
        $TaxObject = new Tax();

        include '../navigation_panel/authenticated_user_header.php';

        $compId = $_SESSION['company_ID'];
        ?>

        <?php
        include '../navigation_panel/side_navigation_bar.php';

        if (isset($_POST['update'])) {

            $leave_type = $_POST['leave_type'];
            $max_leave_days = $_POST['max_leave_days'];
            $required_atttachement = $_POST['required_atttachement'];
            $is_deductible = $_POST['is_deductible'];
            $id = $_POST['id'];

            $add_q = mysql_query("UPDATE leave_tb SET leave_type = '$leave_type',max_leave_days='$max_leave_days',
                        required_atttachement = '$required_atttachement', is_deductible = '$is_deductible' WHERE id = '$id' ") or die(mysql_error());

            if ($add_q) {
                echo "<script> alert('Updated Successfuly') </script>";
                echo "<script> window.location='leave-types' </script>";
            }
        }
        ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php echo $_SESSION['name']; ?> Leave Types
                </h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-4">
                        <form action="add-leave-type" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <button type="submit" name="save" id="save" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Leave Type</button>
                                    </td>
                                </tr>
                            </table>

                        </form>
                    </div>
                    <br></br>

                    <div class="row">
                        <div class="col-xs-15">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table id="employee_data" class="table table-bordered table-fixed">
                                            <thead>
                                                <tr>
                                                    <th>Leave Type</th>
                                                    <th>Max Leave Days</th>
                                                    <th>Is Deductible</th>
                                                    <th>Requires Attachment</th>
                                                    <th>Edit</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $query = "SELECT * FROM leave_tb WHERE companyID='$compId'  ";
                                                $result = mysql_query($query, $link) or die(mysql_error());
                                                while ($row = mysql_fetch_array($result)) {

                                                    $id = $row['id'];
                                                    $leave_type = $row['leave_type'];
                                                    $max_leave_days = $row['max_leave_days'];
                                                    $required_atttachement = $row['required_atttachement'];
                                                    $is_deductible = $row['is_deductible'];
                                                ?>

                                                    <tr>
                                                        <td><?php echo $leave_type; ?></td>
                                                        <td><?php echo $max_leave_days; ?></td>
                                                        <td><?php echo $is_deductible; ?></td>
                                                        <td><?php echo $required_atttachement; ?></td>
                                                        <td>
                                                            <a href="#updateordinance<?php echo $id; ?>" data-target="#updateordinance<?php echo $id; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-primary btn-sm">Edit</i></a>
                                                        </td>
                                                        <td><a href="delete-leave.php?id=<?php echo $id; ?>">Delete</a></td>
                                                    </tr>


                                                    <div id="updateordinance<?php echo $id ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content" style="height:auto">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">×</span></button>
                                                                    <h4 class="modal-title">Update Leave Details </h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="form-horizontal" method="post" action="#update" enctype='multipart/form-data'>

                                                                        <div class="form-group">
                                                                            <label>Leave Type</label>
                                                                            <div class="input-group col-md-12">
                                                                                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $id ?>" required>
                                                                                <input type="text" class="form-control pull-right" name="leave_type" value="<?php echo $leave_type ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Max Leave Days</label>
                                                                            <div class="input-group col-md-12">
                                                                                <input type="text" class="form-control pull-right" name="max_leave_days" value="<?php echo $max_leave_days; ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Is Deductible</label>
                                                                            <div class="input-group col-md-12">
                                                                                <select name="is_deductible" class="form-control">
                                                                                    <option value="<?php echo $is_deductible; ?>"> <?php echo 'Current Status - ' . $is_deductible; ?></option>
                                                                                    <option value="Yes"> Yes</option>
                                                                                    <option value="No"> No</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label>Requires Attachment</label>
                                                                            <div class="input-group col-md-12">
                                                                                <select name="required_atttachement" class="form-control">
                                                                                    <option value="<?php echo $required_atttachement; ?>"> <?php echo 'Current Status - ' . $required_atttachement; ?></option>
                                                                                    <option value="Yes"> Yes</option>
                                                                                    <option value="No"> No</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary" name="update">Save changes</button>
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                        <!--end of modal-dialog-->
                                                    </div>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                        </div><!-- /.col -->
                    </div><!-- /.row -->
            </section><!-- /.content -->
        </div>
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div>
    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>

    <script src="../plugins/fastclick/fastclick.min.js"></script>

    <script src="../dist/js/app.min.js"></script>

    <script src="../dist/js/demo.js"></script>

    <script>
        $(document).ready(function() {
            $('#employee_data').DataTable({});
        });
    </script>

</body>

</html>