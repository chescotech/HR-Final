<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Employees</title>
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
        include_once '../Classes/Employee.php';
        $EmployeeObject = new Employee();
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>


        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo $_SESSION['name'] . ' Employee Perfomance';

                    ?>
                </h1>
            </section>
            <div style="padding-left: 70px; padding-top: 20px;">
                <button class="btn btn-sm btn-primary" onclick="javascript:printDiv('printablediv')">Print</button>
            </div>
            <section class="content" id="printablediv">

                <div class="col-xs-6 col-md-6 ">
                    <div class="box box-primary">
                        <div class="box-header">

                        </div>
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Parameter </th>
                                        <th>Weight </th>
                                        <th>Achieved Score </th>
                                        <!-- <th>Ranking </th> -->
                                        <th>Average Achieved Score </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $period = $_GET['period'];
                                    $empno = $_GET['empno'];
                                    $query = mysqli_query($link, "SELECT ass_appraisals.id AS ass_app_id,
                                                            ass_params.name AS params, ass_params.id AS params_id, ass_params.weight AS weight,
                                                            ass_factors.name AS objective, ass_factors.target AS target,
                                                            ass_periods.name, emp_info.empno
                                                        FROM ass_appraisals
                                                        LEFT JOIN emp_info ON emp_info.empno = ass_appraisals.bossno 
                                                        LEFT JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                        LEFT JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id
                                                        LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                        WHERE ass_periods.name = '$period'
                                                        GROUP BY params
                                                        
                                                        ") or die("Error Getting Data 3 " . mysqli_error($link));
                                    $total_weight = 0;
                                    while ($row = mysqli_fetch_array($query)) {
                                        $ass_app_id = $row['ass_app_id'];

                                        // Check if employee has appraisal for this period
                                        $emp_q = mysqli_query($link, "SELECT id
                                                            FROM ass_emp_appraisals WHERE empno = '$empno' AND ass_app_id = '$ass_app_id'
                                                        ") or die("Error Getting Data 4 " . mysqli_error($link));
                                        if (mysqli_num_rows($emp_q) == 0) {

                                            echo "<h3>Appraisal not found for this employee and period</h3>";
                                            return;
                                        }



                                        $params = $row['params'];
                                        $weight = $row['weight'];
                                        $objective = $row['objective'];
                                        $target = $row['target'];
                                    ?>
                                        <tr>
                                            <td><?php echo $params; ?></td>
                                            <td><?php echo $weight; ?></td>
                                            <?php

                                            $emp_q = mysqli_query($link, "SELECT own_score, total_score, AVG(total_score) AS avg 
                                                            FROM ass_emp_appraisals WHERE empno = '$empno' AND ass_app_id = '$ass_app_id'
                                                        ") or die("Error Getting Data 4 " . mysqli_error($link));

                                            $total_archieved_score = 0;
                                            // if(mysqli_num_rows($emp_q) > 0){}
                                            while ($emp_r = mysqli_fetch_array($emp_q)) {
                                                $total_score = $emp_r['total_score'];
                                                $total_archieved_score += $total_score;
                                                //Get Percentage
                                                $total_score_percent = $total_score / $weight * 100;
                                                $total_score_percent = intval($total_score_percent);
                                                $avg = $emp_r['avg'];
                                                // Get Ranking
                                                $r_q = mysqli_query($link, "SELECT * FROM app_rating
                                                                WHERE from_ <= '$total_score_percent' AND to_ >= '$total_score_percent' 
                                                                ") or die(mysqli_error($link));
                                                $r_row = mysqli_fetch_array($r_q);
                                                $from_ = intval($r_row['from_']);
                                                $to_ = intval($r_row['to_']);

                                                if ($from_ >= $total_score_percent and $to_ <= $total_score_percent) {
                                                    $rank = $r_row['rank'];
                                                } else {
                                                    $rank = $r_row['rank'];
                                                }

                                            ?>
                                                <td> <?php echo $total_score . " (" . $total_score_percent . "%)"; ?></td>
                                                <!-- <td> <?php //echo $rank; 
                                                            ?></td> -->
                                                <td> <?php echo $avg ?> </td>
                                        <?php
                                                $ts_arr[] = $total_score;
                                            }
                                            $total_weight += $weight;
                                        }
                                        $ts = array_sum($ts_arr);
                                        $ts_percent = $ts / $total_weight * 100;
                                        // var_dump($ts);
                                        ?>
                                        </tr>
                                        <?php ?>
                                </tbody>
                                <tfoot>
                                    </tr>
                                    <th>Total</th>
                                    <th><?php echo $total_weight; ?></th>
                                    <th><?php echo $ts . " (" . $ts_percent . "%)" ?></th>
                                    <tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </section><!-- /.content -->
        </div>
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div>

    <script language="javascript" type="text/javascript">
        function printDiv(divID) {
            //Get the HTML of div
            var divElements = document.getElementById(divID).innerHTML;
            //Get the HTML of whole page
            var oldPage = document.body.innerHTML;

            //Reset the page's HTML with div's HTML only
            document.body.innerHTML =
                "<html><head><title></title></head><body>" +
                divElements + "</body>";

            //Print Page
            window.print();

            //Restore orignal HTML
            document.body.innerHTML = oldPage;


        }
    </script>

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
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>