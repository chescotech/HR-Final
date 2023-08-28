<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jobs - HR and Payroll.</title>
    </title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../bootstrap-5.1.3-dist/css/bootstrap-grid.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../../../dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../../plugins/iCheck/flat/blue.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../../DataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" />

    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.5/datatables.min.js"></script>

    <!-- Morris chart -->
    <link rel="stylesheet" href="../../../plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="../../../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="../../../plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../../plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="../../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

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
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css" />
    <script type="text/javascript"
        src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js">
    </script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
    $(document).ready(function() {
        $("#datepicker").datepicker();
        $("#datepicker_").datepicker();
    });
    </script>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <a href="" class="logo">
                <span class="logo-lg"><b>

                        <?php
                        // error_reporting(0);
                        session_start();
                        $_SESSION['activeLink'] = 'jobs';

                        if (isset($_SESSION['job_username'])) {
                        } else {
                            echo "<script> window.location='../jobs/login.php' </script>";
                        }
                        ?>


                    </b></span>
            </a>
            <?php include '../../navigation_panel/main_menu.php'; ?>
            </nav>
        </header>

        <aside class="main-sidebar">
            <section class="sidebar">
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i
                                    class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>

                <?php include '../../navigation_panel/authenticated_side_navigation_bar.php'; ?>

            </section>
        </aside>

        <head>
            <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
            <link rel="stylesheet" type="text/css" href="../../css/dataTables.bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="../../css/buttons.dataTables.min.css">
            <link rel="stylesheet" type="text/css" href="../../css/style.css">

        </head>

        <div class="content-wrapper">
            <div>
                <ol class="breadcrumb">
                    <li><a href="#">Reports</a></li>
                    <li class="active">Jobs Overview</li>
                </ol>
            </div>
            <div class="panel panel-default">
                <div class="panel-body" style="font-size:14px;">

                    <div style="padding-bottom:10px">
                        <form action="job-insights" method="post">
                            <table cellpadding="" border="0" class="se">
                                <tr>
                                    <td>
                                        <input required="required" id="datepicker" name="from" class="form-control"
                                            placeholder="Select From Date" autocomplete="off">
                                    </td>
                                    <td>
                                        <input required="required" id="datepicker_" name="to" class="form-control"
                                            placeholder="Select To Date" autocomplete="off">
                                    </td>
                                    <div class="form-group  col-md-3">
                                        <select name="filter" class="form-control">
                                            <option value="all">-- All Jobs --</option>
                                            <?php
                                        $qq1 = mysql_query("SELECT * FROM `jobs_postings`");
                                        while ($rr1 = mysql_fetch_array($qq1)) {
                                        ?>
                                            <option value="<?php echo $rr1['id']; ?>"> <?php echo $rr1['title']; ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                        </select>
                                    </div>
                                    <td>
                                        <button type="submit" name="search" id="save" type="button"
                                            class="btn btn-default"><span class="glyphicon glyphicon-search"></span>
                                            Search
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <br>
                    </div>

                    <h3> Job Review by Candidates</h3>

                    <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Job </th>
                                <th>Number of Applicants</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                    if(isset($_POST['search'])){
                        $filter = $_POST['filter'];
                        $reportDate = $_POST['from'];
                        $arr = explode("/", $reportDate);
                        list($Getmonth, $Getday, $GetYear) = $arr;

                        $year = $GetYear;
                        $month = $Getmonth;
                        $day = $Getday;

                        // to date.. 
                        $toDate = $_POST['to'];
                        $arr2 = explode("/", $toDate);
                        list($Getmonth2, $Getday2, $GetYear2) = $arr2;
                        $year2 = $GetYear2;
                        $month2 = $Getmonth2;
                        $day2 = $Getday2;

                      if($filter=="all"){
                        $user_q = mysql_query("SELECT COUNT(*) as number,jobs_postings.title as job FROM `jobs_user_applications`
                        inner join jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id
                        inner join department on department.dep_id=jobs_postings.dep_id 
                        WHERE DATE(jobs_user_applications.date) BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2' 
                        GROUP BY jobs_postings.title
                    ") or die(mysql_error());

                   // echo 'from '.$year.'-'.$month.'-'.$day;
                      }else{
                        $user_q = mysql_query("SELECT COUNT(*) as number,jobs_postings.title as job FROM `jobs_user_applications`
                        inner join jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id
                        inner join department on department.dep_id=jobs_postings.dep_id 
                        WHERE jobs_postings.id='$filter' AND DATE(jobs_user_applications.date) BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2' 
                        GROUP BY jobs_postings.title

                    ") or die(mysql_error());
                    //echo 'eh';
                      }
                     
                    }else{
                     
                        $user_q = mysql_query("SELECT COUNT(*) as number,jobs_postings.title as job FROM `jobs_user_applications`
                        inner join jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id
                        inner join department on department.dep_id=jobs_postings.dep_id 
                        GROUP BY jobs_postings.title") or die(mysql_error());
                    
                    }
                    $total=0;
                    while ($row = mysql_fetch_array($user_q)) {
                        $number = $row['number'];
                        
                        $job_status= $row['job'];
                        $total +=$number; 
                        echo '
                            <tr>
                                <td>' . $job_status . '</td>
                                <td>'.$number.'</td>
                              
                            </tr>';
                            ?>
                            <?php
                        }

                        echo '
                            <tr>
                                <td>Total</td>
                                <td>'.$total.'</td>
                            </tr>';
                        ?>

                        </tbody>
                    </table>


                    <h3> Active Jobs per department</h3>

                    <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Department </th>
                                <th>Number of Jobs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        if(isset($_POST['search'])){
                            $filter = $_POST['filter'];
                            $reportDate = $_POST['from'];
                            $arr = explode("/", $reportDate);
                            list($Getmonth, $Getday, $GetYear) = $arr;

                            $year = $GetYear;
                            $month = $Getmonth;
                            $day = $Getday;

                            // to date.. 
                            $toDate = $_POST['to'];
                            $arr2 = explode("/", $toDate);
                            list($Getmonth2, $Getday2, $GetYear2) = $arr2;
                            $year2 = $GetYear2;
                            $month2 = $Getmonth2;
                            $day2 = $Getday2;

                        if($filter=="all"){
                            $user_q = mysql_query("SELECT COUNT(*) as number,jobs_postings.title as job FROM `jobs_user_applications`
                            inner join jobs_postings on jobs_postings.id=jobs_user_applications.jobs_job_id
                            inner join department on department.dep_id=jobs_postings.dep_id 
                            WHERE DATE(jobs_user_applications.date) BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2' 
                            GROUP BY jobs_postings.title
                        ") or die(mysql_error());

                        // echo 'from '.$year.'-'.$month.'-'.$day;
                        }else{
                          
                        $user_q = mysql_query("SELECT COUNT(*) as number,department.department as department FROM `jobs_postings`
                        inner join department on department.dep_id=jobs_postings.dep_id 
                        where DATE(NOW()) <=DATE(expires)
                        AND jobs_postings.date BETWEEN '$year-$month-$day'  AND  '$year2-$month2-$day2' 
                        GROUP BY department.department") or die(mysql_error());
                        //echo 'eh';
                        }
                        
                        }else{
                        
                            $user_q = mysql_query("SELECT COUNT(*) as number,department.department as department FROM `jobs_postings`
                            inner join department on department.dep_id=jobs_postings.dep_id 
                            where DATE(NOW()) <=DATE(expires)
                            GROUP BY department.department") or die(mysql_error());

                        }
                        $total=0;
                        while ($row = mysql_fetch_array($user_q)) {
                            $number = $row['number'];
                            
                            $job_status= $row['department'];
                            $total +=$number; 
                            echo '
                                <tr>
                                    <td>' . $job_status . '</td>
                                    <td>'.$number.'</td>
                                
                                </tr>';
                                ?>
                            <?php
                            }

                            echo '
                                <tr>
                                    <td>Total</td>
                                    <td>'.$total.'</td>
                                </tr>';
                            ?>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>


        <?php include '../../../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div>
    <!-- <script src="../../../plugins/jQuery/jQuery-2.1.4.min.js"></script> -->

    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <script>
    $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="../../../bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../../../plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="../../../plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="../../../plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="../../../plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../../../plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="../../../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="../../../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../../../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="../../../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../../../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../../../dist/js/pages/dashboard.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../../dist/js/demo.js"></script>
</body>

</html>