<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pay Slips</title>
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

    <script>
        $(document).ready(function() {
            $("#datepicker").datepicker();
        });
    </script>

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">
        <?php

        include_once '../Classes/Department.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';

        $LoanObject = new Loans();
        $DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();

        include '../navigation_panel/authenticated_user_header.php';
        $companyId = $_SESSION['company_ID'];

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
                        echo 'Pay slip Distribution for ' . $printdate;
                    } else {
                        echo 'Automated Pay slip Distribution';
                    }
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-md-4">
                        <form action="payslip-distribution.php" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <input required="required" id="datepicker" name="search_date" class="form-control" placeholder="Select Date">
                                    </td>
                                    <td>
                                        <button type="submit" name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>Generate
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>

                    <div class="col-md-4">

                        <table cellpadding="" border="0" class="se">
                            <tr>

                                <td>
                                    <form target="_blank" action="distribute-all.php" method="post">
                                        <input hidden="hidden" name="search_date" value="<?php
                                                                                            if (isset($_POST['search_date'])) {
                                                                                                echo $_POST['search_date'];
                                                                                            }
                                                                                            ?>">
                                        <input hidden="hidden" name="company_name" value="<?php
                                                                                            if (isset($_POST['search_date'])) {
                                                                                                echo $companyId;
                                                                                            }
                                                                                            ?>">

                                        <?php
                                        if (isset($_POST['search_date'])) {
                                            echo '<button type="submit"  name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-share"></span> Send To All
                                            </button>';
                                        }

                                        ?>

                                    </form>
                                </td>
                            </tr>
                        </table>

                    </div>
                    <br></br>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body">
                                    <table id="employee_data" class="table table-bordered table-fixed">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>First name</th>
                                                <th>Last Name</th>
                                                <th>Position</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Distribute</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            if (isset($_POST['search_date'])) {

                                                $search_date = $_POST['search_date'];
                                                $reportDate = $search_date;
                                                $arr = explode("/", $reportDate);
                                                list($Getmonth, $Getday, $GetYear) = $arr;

                                                $year = $GetYear;
                                                $month = $Getmonth;
                                                $day = $Getday;

                                                $query = "SELECT * FROM employee WHERE time = '$year-$month-$day' AND company_id='$companyId'  ";

                                                $result = mysql_query($query, $link) or die(mysql_error());

                                                if (mysql_num_rows($result) == 0) {
                                                    echo '<tr>
                                                    <td style="vertical-align:middle" align="left">No records found for your search</td>
                                                    </tr>';
                                                }
                                                $sum = 0;
                                                while ($row = mysql_fetch_array($result)) {
                                                    $id_ = $row['id'];
                                                    $empNo = $row['empno'];
                                                    $query2 = "SELECT * FROM emp_info WHERE empno= '$empNo' ";
                                                    $result2 = mysql_query($query2, $link) or die(mysql_error());
                                                    $row2 = mysql_fetch_array($result2);

                                            ?>
                                                    <?php
                                                    echo '  
                                                        <tr>  
                                                            <td>' . $row["empno"] . '</td>  
                                                            <td>' . $row2["fname"] . '</td> 
                                                            <td>' . $row2["lname"] . '</td> 
                                                            <td>' . $row2["position"] . '</td>
                                                            <td>' . $row2["email"] . '</td>                                                                                                                                          
                                                            <td>' . $row2['phone'] . '</td>                                                                                                                        
                                                            <td><a target="_blank" href=' . "single-distribution.php?id=" . $id_ . '&empno=' . $empNo . '&date=' . $search_date . '&email=' . $row2["email"] . '&companyId=' . $companyId . '>Email Pay Slip</a></td>
                                                        </tr>  

                                                        ';
                                                    ?>

                                            <?php
                                                }
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
    </div><!-- ./wrapper -->
    <!-- Bootstrap 3.3.5 -->
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
            $('#employee_data').DataTable();
        });
    </script>

</body>

</html>