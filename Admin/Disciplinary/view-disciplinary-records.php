<?php
error_reporting(0);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Disciplinary Report</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Department.php';
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Tax.php';
        $TaxObject = new Tax();
        $LoanObject = new Loans();

        $DepartmentObject = new Department();
        $compId = $_SESSION['company_ID'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    if (isset($_POST['search_date'])) {
                        $date = $_POST['search_date'];
                        $mydate = strtoTime($date);
                        $printdate = date('F d, Y', $mydate);
                        echo 'NAPSA Report for ' . $printdate;
                    } else {
                        echo 'Employee Disciplinary Records';
                    }
                    ?>
                </h1>
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-6">
                        <form action="add-disciplinary-record" method="post">
                            <table cellpadding="" cellspacing="10" border="0" class="se">
                                <tr>
                                    <td>
                                        <a href="add-disciplinary-record"><button type="submit" id="save" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>Add Record
                                            </button></a>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <table cellpadding="" border="0" class="se">
                            <tr>
                                <td>
                                    <form target="_blank" action="napsa-pdf-report" method="post">
                                        <input hidden="hidden" name="search_date" value="<?php
                                                                                            if (isset($_POST['search_date'])) {
                                                                                                echo $_POST['search_date'];
                                                                                            }
                                                                                            ?>">
                                        <?php
                                        if (isset($_POST['search_date'])) {
                                            echo ' <button type="submit"  name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Pdf
                                            </button';
                                        }
                                        ?>
                                    </form>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br></br>
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body">
                                <table id="employee_data" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Empno</th>
                                            <th>Names</th>
                                            <th>Date Charged</th>
                                            <th>Charged Valid Till</th>
                                            <th>Offence Commited</th>
                                            <th>Documents</th>
                                            <th>Case Status</th>
                                            <th>Punishment Given</th>
                                            <th>Charged By</th>
                                            <th>Edit</th>
                                            <th>Close Case</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $query = "SELECT * FROM employee_discplinary_records";

                                        $result = mysql_query($query, $link) or die(mysql_error());

                                        $sum = 0;
                                        $closeStatus = "";
                                        while ($row = mysql_fetch_array($result)) {
                                            $id = $row['id'];
                                            $datePrinted = strtoTime($row['date_charged']);
                                            $datePrint = date('F d, Y', $datePrinted);
                                            $datePrinted_till = strtoTime($row['charged_til']);
                                            $datePrint_till = date('F d, Y', $datePrinted_till);

                                            $caseStatus = $row['case_status'];

                                            $today = date("m/d/Y");
                                            if (strtotime($today) >= strtotime($datePrint_till) && $caseStatus != "expired") {
                                                // Update status
                                                mysql_query("UPDATE employee_discplinary_records SET case_status = 'expired' WHERE id = '$id' ") or die(mysql_error());
                                                echo "<script> window.location='view-disciplinary-records' </script>";
                                            }
                                            // return var_dump($caseStatus);
                                            if ($caseStatus == "closed") {
                                                $closeStatus = "";
                                                $status = '<span class="label label-success arrowed-in arrowed-in-right">' . $caseStatus . '</span>';
                                            } elseif ($caseStatus == "expired") {
                                                $status = '<span class="label label-primary">' . $caseStatus . '</span>';
                                            } else {
                                                $closeStatus = "Close Case";
                                                $status = '<span class="label label-warning">' . $caseStatus . '</span>';
                                            }
                                            $file = $row['file'];
                                            $file_path = "<a href='../../files/disciplinary/" . $file . "' class='label label-primary' >File</a>";

                                            echo '
                                                <tr>  
                                                    <td>' . $row['empno'] . '</td>  
                                                    <td>' . $DepartmentObject->getEmployeeDetailsById($row['empno']) . '</td>
                                                    <td>' . $datePrint . '</td>                                                              
                                                    <td>' . $datePrint_till . '</td>                                                              
                                                    <td>' . $row['offence_commited'] . '</td>                                                          
                                                    <td>' . $file_path . '</td>                                                          
                                                    <td>' . $status . '</td>                                                    
                                                    <td>' . $row['punishment'] . '</td>
                                                    <td>' . $row['charged_by'] . '</td>
                                                    <td><a href=' . "edit-discpline.php?id=" . $id . '>Edit</a></td>
                                                    <td><a href=' . "close-case.php?id=" . $id . '>' . $closeStatus . '</a></td>
                                                    <td><a href=' . "delete-displine.php?id=" . $id . '>Delete</a></td>
                                                </tr>  
                                                ';
                                        }
                                        ?>

                                </table>
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
            $('#employee_data').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'print'
                ]
            });

            $("#datepicker").datepicker();
        });
    </script>

</body>

</html>