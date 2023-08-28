<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Perfomance Appraisal</title>
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

    <style>
        table,
        th,
        td {
            border: 1px solid;
        }
    </style>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        error_reporting(0);
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">

            <?php
            require_once('../../PHPmailer/sendmail.php');

            $em = new email();
            if (isset($_POST['add_'])) {

                $empno = $_POST['empno'];
                $params_id = $_POST['params'];
                $period_id = $_POST['period'];
                $factor_id = $_POST['factor'];
                $own_score = $_POST['own_score'];
                $boss_score = $_POST['boss_score'];
                $total_score = $_POST['total_score'];
                $comment = $_POST['comment'];

                $add_q = mysql_query("INSERT INTO ass_appraisals (empno,params_id, period_id, factor_id, own_score, boss_score, total_score, comment)
                        VALUES('$empno', '$params_id', '$period_id', '$factor_id', '$own_score', '$boss_score', '$total_score', '$comment')") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location='appraisals' </script>";
                }
            }
            if (isset($_POST['update'])) {
                $name = $_POST['name'];
                $target = $_POST['target'];
                $id = $_POST['id'];

                $add_q = mysql_query("UPDATE ass_appraisals SET name = '$name',target='$target'
                        WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Updated Successfuly') </script>";
                    echo "<script> window.location='appraisals' </script>";
                }
            }
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];

                $add_q = mysql_query("DELETE FROM ass_appraisals WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Deleted Successfuly') </script>";
                    echo "<script> window.location='appraisals' </script>";
                }
            }

            $app_id = $_GET['app_id'];
            $empno = $_SESSION['empno'];

            if (isset($_POST['save'])) {
                $ass_app_ids = $_POST['ass_app_id'];
                $own_scores = $_POST['own_score'];
                $comments = $_POST['comment'];

                // return var_dump($ass_app_ids, $empno, $own_scores, $comments);
                array_map(function ($ass_app_id, $own_score, $comment) {
                    global $empno;
                    // return var_dump($empno);
                    mysql_query("INSERT INTO ass_emp_appraisals (ass_app_id, empno, own_score, comment)
                            VALUES('$ass_app_id', '$empno', '$own_score', '$comment')
                        ") or die("Error Saving Data " . mysql_error());
                    // return var_dump($mysql_query);
                }, $ass_app_ids, $own_scores, $comments);

                $Subject = "New Employee Appraisal Alert";
                $message = " Hello, <br>
                    There has been a new appraisal submitted by one of the employees in your department.
                    <br>Log into your HR system to check and grade them
                    <br><br> <hr>
                    Regards.
                ";

                function getEmployeeSupervisor($employeeId)
                {
                    $res = mysql_query("SELECT * FROM emp_info WHERE empno='$employeeId'");
                    $rows = mysql_fetch_array($res);
                    $department = $rows['dept'];

                    $hodQuery = mysql_query("SELECT * FROM hod_tb WHERE departmentId='$department'");
                    $hodRows = mysql_fetch_array($hodQuery);
                    $hodsEmpno = $hodRows['empno'];

                    $getHodDataQuery = mysql_query("SELECT * FROM emp_info WHERE empno='$hodsEmpno'");
                    $hodsInfoRows = mysql_fetch_array($getHodDataQuery);
                    $hodsEmail = $hodsInfoRows['email'];
                    return $hodsEmail;
                }

                $em->send_mail(getEmployeeSupervisor($empno), $message, $Subject);
            }

            if (isset($_POST['emp_expectation'])) {
                $ass_app_id = $app_id;
                $emp_expectation = mysql_real_escape_string($_POST['emp_expectation']);

                mysql_query(" UPDATE ass_emp_appraisals SET emp_expectation = '$emp_expectation'
                        WHERE ass_app_id = '$ass_app_id'  AND empno='$empno'
                    ") or die("Error Saving Data " . mysql_error());
            }
            ?>
            <div style="padding-left: 70px; padding-top: 20px;">
                <button class="btn btn-sm btn-primary" onclick="javascript:printDiv('printablediv')">Print</button>
            </div>
            <div id="printablediv">

                <section class="content container">

                    <br>
                    <hr>

                    <div class="row center">
                        <div class="col-xs-10 col-md-12 ">
                            <div class="box box-primary">
                                <div class="box-header">
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <center>
                                        <img src="<?php
                                                    include_once '../../Admin/Classes/Company.php';
                                                    $CompanyObject = new Company();
                                                    $companyId = $_SESSION['company_ID'];
                                                    echo $CompanyObject->getCompanyLogo4($companyId)
                                                    ?>" width="70%" height="290" class="img-thumbnail"></img>
                                    </center>

                                    <table id="example1" class="table table-bordered table-striped">
                                        <?php
                                        $empq = mysql_query("SELECT emp_info.fname AS fname , emp_info.lname AS lname, emp_info.position AS position, emp_info.empno AS empno,
                                        department.department FROM emp_info 
                                        LEFT JOIN department ON department.dep_id = emp_info.dept 
                                        WHERE emp_info.empno = '$empno' 
                                        ");
                                        $empr = mysql_fetch_array($empq);



                                        $query1 = mysql_query("SELECT emp_info.fname AS fname , emp_info.lname AS lname, emp_info.position AS position, emp_info.empno AS empno,
                                                    department.department, ass_periods.name AS periods, ass_appraisals.date AS app_date,ass_appraisals.bossno ,
                                                    ass_periods.id AS periods_id,ass_periods.date AS p_to, ass_periods.date_from AS p_from
                                                FROM ass_appraisals
                                                LEFT JOIN emp_info ON emp_info.empno = ass_appraisals.bossno 
                                                LEFT JOIN department ON department.dep_id = emp_info.dept 
                                                LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                WHERE ass_appraisals.id = '$app_id' 
                                                ") or die("Error Getting Data " . mysql_error());

                                        // get the employee group..

                                        $queryGroup = mysql_query("SELECT * FROM `ass_group` where empno='$empno'
                                                ") or die("Error Getting Data " . mysql_error());

                                        $rowGroup = mysql_fetch_array($queryGroup);
                                        $group = $rowGroup['name'];
                                        while ($row1 = mysql_fetch_array($query1)) {
                                            $boss_name = $row1['fname'] . " " . $row1['lname'];
                                            $bossno = $row1['bossno'];
                                            $period = $row1['periods'];

                                            $app_date = $row1['app_date'];
                                            $p_date = $row1['p_from'] . "-" . $row1['p_to'];
                                        }
                                        $emp_name = $empr['fname'] . " " . $empr['lname'];
                                        $department = $empr['department'];
                                        $position = $empr['position'];
                                        ?>
                                        <tr>
                                            <td>Employee Name: <b> <?php echo $emp_name ?></b> </td>
                                            <td>Job Title: <b> <?php echo $position ?></b> </td>
                                            <td>Employee#: <b> <?php echo $empno ?></b> </td>
                                            <td>Department: <b> <?php echo $department ?></b> </td>
                                        </tr>
                                        <tr>
                                            <td>Immediate Supervisor: <b> <?php echo $boss_name ?> </b> </td>
                                            <td>Head of Department: <b> <?php echo $boss_name ?> </b> </td>
                                            <td>Date: <b> <?php echo $app_date ?></b> </td>
                                            <td>Appraisal Period: <b> <?php echo $period . " (" . $p_date . ")"; ?></b> </td>
                                        </tr>
                                    </table>
                                </div><!-- /.box-body -->

                            </div><!-- /.col -->
                        </div><!-- /.row -->
                </section>

                <section class="content container">
                    <br>
                    <br>
                    <div class="row center">
                        <div class="col-xs-10 col-md-12 ">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <!-- <h3 class="box-title">General Expenses</h3> -->
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th> Objective </th>
                                                <th>Weight </th>
                                                <th>Parameter </th>
                                                <th>Target Score</th>
                                                <th>Own Score</th>
                                                <th>Supervisor Score</th>
                                                <th>Agreed Score</th>
                                                <th>Appraisee's Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysql_query("SELECT ass_appraisals.id AS ass_app_id,
                                                        ass_params.name AS params, ass_params.id AS params_id, ass_params.weight AS weight,
                                                        ass_factors.name AS objective, ass_factors.target AS target,
                                                        ass_periods.name, emp_info.empno
                                                    FROM ass_appraisals
                                                    LEFT JOIN emp_info ON emp_info.empno = ass_appraisals.bossno 
                                                    LEFT JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                    LEFT JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id
                                                    LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id
                                                    
                                                    -- LEFT JOIN ass_emp_appraisals ON ass_emp_appraisals.ass_app_id = ass_appraisals.id 
                                                    WHERE ass_periods.name = '$period' AND emp_info.empno = '$bossno' AND weight>0
                                                        AND ass_group='$group'
                                                    -- AND ass_emp_appraisals.empno = '$empno' AND weight>0
                                                    
                                                    ") or die("Error Getting Data " . mysql_error());


                                            while ($row = mysql_fetch_array($query)) {
                                                $ass_app_id = $row['ass_app_id'];
                                                $emp_q = mysql_query("SELECT own_score, boss_score, total_score, comment
                                                FROM ass_emp_appraisals
                                                INNER JOIN ass_appraisals ON ass_appraisals.id = ass_emp_appraisals.ass_app_id
                                                WHERE empno = '$empno' 
                                                AND ass_app_id = '$ass_app_id'
                                                ") or die("Error Getting Data " . mysql_error());


                                                $params = $row['params'];
                                                $weight = $row['weight'];
                                                $objective = $row['objective'];
                                                $target = $row['target'];
                                            ?>
                                                <tr>
                                                    <form action="" method="post">
                                                        <td><?php echo $objective; ?></td>
                                                        <td><?php echo $weight; ?></td>
                                                        <td><?php echo $params; ?></td>
                                                        <td><?php echo $target; ?></td>
                                                        <?php
                                                        if (mysql_num_rows($emp_q) > 0) {
                                                            while ($emp_r = mysql_fetch_array($emp_q)) {
                                                                $own_score = $emp_r['own_score'];
                                                                $boss_score = $emp_r['boss_score'];
                                                                $total_score = $emp_r['total_score'];
                                                                $comment = $emp_r['comment'];

                                                                $isss = "yes";
                                                        ?>
                                                                <td>
                                                                    <?php echo $own_score ?>
                                                                    <!-- <input type="hidden" name="ass_app_id[]" value="<?php //echo $ass_app_id; 
                                                                                                                            ?>"> -->
                                                                </td>
                                                                <td><?php echo $boss_score; ?></td>
                                                                <td><?php echo $total_score; ?></td>
                                                                <td> <?php echo $comment ?> </td>
                                                            <?php
                                                            }
                                                        } else {
                                                            $today = date("Y-m-d");
                                                            $ck_date_q = mysql_query("SELECT date, id FROM ass_periods
                                                            WHERE name = '$period' AND DATE(date) >= '$today'
                                                            ") or die(mysql_error());
                                                            if (mysql_num_rows($ck_date_q) > 0) {
                                                                $readonly = "disabled";
                                                            } else {
                                                                $readonly = "";
                                                            }
                                                            ?>
                                                            <td>
                                                                <input <?php echo $readonly ?> type="text" name="own_score[]" value="<?php // echo $own_score 
                                                                                                                                        ?>">
                                                                <input type="hidden" name="ass_app_id[]" value="<?php echo $ass_app_id; ?>">
                                                            </td>
                                                            <td><?php // echo $boss_score; 
                                                                ?></td>
                                                            <td><?php // echo $total_score; 
                                                                ?></td>
                                                            <td> <input <?php echo $readonly ?> type="text" name="comment[]" value="<?php // echo $comment 
                                                                                                                                    ?>"> </td>
                                                        <?php
                                                        }
                                                        ?>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <td> <button name="save" type="submit">Save</button> </td>
                                            </form>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->

                            </div><!-- /.col -->
                        </div><!-- /.row -->
                </section>

                <?php
                $emp_q1 = mysql_query("SELECT boss_score
                    FROM ass_emp_appraisals
                    INNER JOIN ass_appraisals ON ass_appraisals.id = ass_emp_appraisals.ass_app_id
                    WHERE empno = '$empno' 
                    AND ass_app_id = '$ass_app_id'
                    AND boss_score != ''
                ") or die("Error Getting Data " . mysql_error());
                if (mysql_num_rows($emp_q1) > 0) {
                    while ($emp_r1 = mysql_fetch_array($emp_q1)) {
                ?>
                        <section class="content container">
                            <br>
                            <br>
                            <div class="row center">
                                <div class="col-xs-12 col-md-12 ">
                                    <div class="box box-primary">
                                        <div class="box-header">
                                        </div>
                                        <div class="box-body">
                                            <!-- Trigger the modal with a button -->
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Click here to appeal your appraisal</button>
                                            <?php
                                            $app_exist_q = mysql_query("SELECT id FROM appeal_notices WHERE empno = '$empno' AND
                                                app_id = '$app_id' ") or die(mysql_error());
                                            if (mysql_num_rows($app_exist_q) > 0) {
                                                // echo "<script> alert('You have already appealed this appraisal. Kindly wait for the reasponse') </script>";
                                                echo $appealed = "<center><h4 class='text-warning'>Already Appealed!</h4></center>";
                                            }
                                            ?>
                                            <!-- Modal -->
                                            <div id="myModal" class="modal fade" role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Write an appeal notice</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="form-horizontal" method="post" action="#" enctype='multipart/form-data'>
                                                                <div class="form-group">
                                                                    <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                        <textarea name="appeal_notice" class="form-control" cols="30" rows="6"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                        <select name="appeal_bossno" class="form-control">
                                                                            <option>--Select superial To submit to--</option>
                                                                            <?php
                                                                            $company_id = $_SESSION['username'];
                                                                            $query = mysql_query("SELECT * FROM emp_info ") or die(mysql_error());
                                                                            while ($row = mysql_fetch_array($query)) {
                                                                            ?>

                                                                                <option value="<?php echo $row['empno']; ?>"> <?php echo $row['fname'] . "  " . $row['lname'] . " - " . $row['position']; ?></option>

                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <hr>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" name="appeal_notice_btn">Submit</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </section>
                <?php
                    }
                }
                // create appear..
                if (isset($_POST['appeal_notice_btn'])) {
                    $appeal_notice = $_POST['appeal_notice'];
                    $appeal_bossno = $_POST['appeal_bossno'];
                    // Get supervisor email..
                    $sup_m_q = mysql_query("SELECT email FROM emp_info WHERE empno = '$appeal_bossno' ") or die(mysql_error());
                    $sup_m_r = mysql_fetch_array($sup_m_q);
                    $appeal_bossmail = $sup_m_r['email'];

                    //Check if appeal exixts
                    $app_exist_q = mysql_query("SELECT id FROM appeal_notices WHERE empno = '$empno' AND
                                app_id = '$app_id' ") or die(mysql_error());
                    if (mysql_num_rows($app_exist_q) > 0) {
                        echo "<script> alert('You have already appealed this appraisal. Kindly wait for the reasponse') </script>";
                    } else {

                        // save to db
                        mysql_query("INSERT INTO appeal_notices (appeal_notice, empno, bossno,bossmail,app_id)
                                    VALUES ('$appeal_notice', '$empno','$bossno','$appeal_bossmail','$app_id')
                        ") or die(mysql_error());

                        // send email
                        $Subject = "New Appraisal Appeal Alert!";
                        $message = " Hello, <br>
                        An appraisal appeal has been made for the appraisal period of " . $period . " (" . $p_date . ")
                        by the employee " . $emp_name . ". Bellow is their concern <br>
                        _____________________________________
                        <br>" . $appeal_notice . "<br> <hr>
                        _____________________________________
                        <br> <hr>
                        Regards.
                        ";

                        $em->send_mail($appeal_bossmail, $message, $Subject);

                        echo "<center><h4 class='label label-success label-lg'>Appealed Successfully</h4></center>";
                    }
                }
                ?>


                <section class="content container">
                    <div class="row center">
                        <div class="col-xs-12 col-md-12 ">
                            <div class="box box-primary">
                                <div class="box-header">

                                </div>
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Rating </th>
                                                <th>Ranking </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysql_query("SELECT from_,to_ ,rank FROM `app_rating`") or die(mysql_error());
                                            while ($row = mysql_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $row['from_'] . '-' . $row['to_']; ?></td>
                                                    <td><?php echo $row['rank']; ?></td>
                                                </tr>
                                                <div id="updateordinance<?php echo $row['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content" style="height:auto">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span></button>
                                                                <h4 class="modal-title">Update </h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form class="form-horizontal" method="post" action="#update" enctype='multipart/form-data'>

                                                                    <div class="form-group">
                                                                        <label for="name">Factor / Objective</label>
                                                                        <div class="input-group col-md-12">
                                                                            <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                            <input type="text" class="form-control pull-right" id="date" name="name" value="<?php echo $row['name'] ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="date">Target Score</label>
                                                                        <div class="input-group col-md-12">
                                                                            <input type="text" class="form-control" id="name" name="target" value="<?php echo $row['target']; ?>" required>
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

                                                <div id="delete<?php echo $row['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content" style="height:auto">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span></button>
                                                                <h4 class="modal-title">Are u sure you want to delete this field ??
                                                                </h4>
                                                            </div>
                                                            <div class="modal-body" hidden="">
                                                                <form class="form-horizontal" method="post" action="#delete" enctype='multipart/form-data'>
                                                                    <div class="form-group">
                                                                        <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                            <input type="text" class="form-control" id="name" name="id" value="<?php echo $row['id']; ?>" required>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <hr>
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
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-12 col-md-12 ">
                            <div class="box box-primary">
                                <div class="box-header">

                                </div>
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Parameter</th>
                                                <th>Weight </th>
                                                <th>Achieved Score </th>
                                                <th>Ranking </th>
                                                <th>Comments </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysql_query("SELECT ass_appraisals.id AS ass_app_id,
                                                            ass_params.name AS params, ass_params.id AS params_id, ass_params.weight AS weight,
                                                            ass_factors.name AS objective, ass_factors.target AS target,
                                                            ass_periods.name, emp_info.empno
                                                        FROM ass_appraisals
                                                        LEFT JOIN emp_info ON emp_info.empno = ass_appraisals.bossno 
                                                        LEFT JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                        LEFT JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id
                                                        LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                        -- LEFT JOIN ass_emp_appraisals ON ass_emp_appraisals.ass_app_id = ass_appraisals.id 
                                                        WHERE ass_periods.name = '$period' AND emp_info.empno = '$bossno'
                                                             AND ass_group='$group'
                                                        GROUP BY params
                                                        
                                                        -- AND ass_emp_appraisals.empno = '$empno'
                                                        
                                                        ") or die("Error Getting Data 3 " . mysql_error());
                                            $total_weight = 0;
                                            while ($row = mysql_fetch_array($query)) {
                                                $ass_app_id = $row['ass_app_id'];

                                                $params = $row['params'];
                                                $weight = $row['weight'];
                                                $objective = $row['objective'];
                                                $target = $row['target'];
                                            ?>
                                                <tr>
                                                    <td><?php echo $params; ?></td>
                                                    <td><?php echo $weight; ?></td>
                                                    <?php
                                                    $emp_q = mysql_query("SELECT own_score, boss_score, total_score, comment 
                                                            FROM ass_emp_appraisals WHERE empno = '$empno' AND ass_app_id = '$ass_app_id'
                                                        ") or die("Error Getting Data 4 " . mysql_error());

                                                    $total_archieved_score = 0;
                                                    while ($emp_r = mysql_fetch_array($emp_q)) {
                                                        $total_score = $emp_r['total_score'];
                                                        $total_archieved_score += $total_score;
                                                        //Get Percentage
                                                        $total_score_percent = $total_score / $weight * 100;
                                                        $total_score_percent = intval($total_score_percent);
                                                        $comment = $emp_r['comment'];
                                                        // Get Ranking
                                                        $r_q = mysql_query("SELECT * FROM app_rating
                                                                WHERE from_ <= '$total_score_percent' AND to_ >= '$total_score_percent' 
                                                                ") or die(mysql_error());
                                                        $r_row = mysql_fetch_array($r_q);
                                                        $from_ = intval($r_row['from_']);
                                                        $to_ = intval($r_row['to_']);

                                                        if ($from_ >= $total_score_percent and $to_ <= $total_score_percent) {
                                                            $rank = $r_row['rank'];
                                                        } else {
                                                            $rank = $r_row['rank'];
                                                        }

                                                        if ($boss_score == '') {
                                                    ?>
                                                            <td> <?php echo $total_score; ?></td>
                                                            <td> <?php ?></td>
                                                            <td> </td>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <td> <?php echo $total_score . " (" . $total_score_percent . "%)"; ?></td>
                                                            <td> <?php echo $rank; ?></td>
                                                            <td> <?php echo $comment ?> </td>
                                                <?php
                                                        }
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
                </section>

                <section class="content container">
                    <br>
                    <br>
                    <div class="row center">
                        <div class="col-xs-6 col-md-6 ">
                            <div class="box box-primary">
                                <div class="box-header">

                                </div>
                                <div class="box-body">
                                    <?php
                                    $empex_q = mysql_query("SELECT emp_expectation FROM ass_emp_appraisals WHERE ass_app_id = '$app_id' 
                                        ") or die("Error" . mysql_error());
                                    $empex_r = mysql_fetch_array($empex_q);
                                    $empex_exists = $empex_r['emp_expectation'];
                                    // return var_dump($empex_exists);
                                    if ($empex_exists == '') {
                                    ?>
                                        <form action="" method="post">
                                            <h4>Appraisee-Expectations <button type="submit">Add</button></h4>
                                            <textarea name="emp_expectation" id="" cols="50" rows="7"></textarea>
                                        </form>
                                    <?php
                                    } else {
                                        echo '
                                        <h4>Appraisee-Expectations </h4>
                                        <textarea readonly disabled cols="50" rows="7">' . $empex_exists . '</textarea>
                                        ';
                                    }
                                    ?>
                                </div>

                            </div>
                        </div>
                        <div class="col-xs-6 col-md-6 ">
                            <div class="box box-primary">
                                <div class="box-header">

                                </div>
                                <div class="box-body">
                                    <?php
                                    $bosscom_q = mysql_query("SELECT boss_comment FROM ass_emp_appraisals WHERE ass_app_id = '$app_id' 
                                        ") or die("Error" . mysql_error());
                                    $bosscom_r = mysql_fetch_array($bosscom_q);
                                    $bosscom_exists = $bosscom_r['boss_comment'];

                                    echo '
                                        <h4>Head of Department Comments</h4>
                                        <textarea readonly disabled cols="50" rows="7">' . $bosscom_exists . '</textarea>
                                        ';
                                    ?>
                                </div>

                            </div>
                        </div>
                </section>
            </div>
        </div>
        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
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
</body>

</html>