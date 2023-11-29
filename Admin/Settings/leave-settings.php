<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Leave Settings</title>
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
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Department.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Tax.php';

        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();
        $TaxObject = new Tax();


        $compId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php echo $_SESSION['name']; ?> Leave Policy Settings
                </h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-4">
                        <form action="add-leave-rating" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <button type="submit" name="save" id="save" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Leave Rating</button>
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
                                                    <th>Employee Grade</th>
                                                    <th>Pay Range</th>
                                                    <th>Leave Days Acquired Monthly</th>
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                $query = "SELECT * FROM leave_ratings_tb WHERE companyID='$compId'  ";
                                                $result = mysqli_query($link, $query) or die(mysqli_error($link));
                                                while ($row = mysqli_fetch_array($result)) {
                                                ?>

                                                    <?php
                                                    $id = $row['id'];
                                                    $grade_id = $row['grade_id'];

                                                    $monthly_leave_days = $row['monthly_leave_days'];
                                                    $PayRange = $DepartmentObject->getGradeRatings($grade_id, $compId);

                                                    echo '  
                                                            <tr>  
                                                            <td>' . $grade_id . '</td>  
                                                            <td>' . $PayRange . '</td> 
                                                            <td>' . $monthly_leave_days . '</td>                                                             
                                                            <td><a href=' . "delete-leave-rating.php?id=" . $id . '>Delete</a></td>
                                                        </tr>  
                                                        ';
                                                    ?>

                                                <?php
                                                }
                                                ?>

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