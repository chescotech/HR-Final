<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Supervisor Perfomance Appraisal</title>
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
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>


        <div class="content-wrapper">

            <?php
            $app_id = $_GET['app_id'];
            $empno = $_GET['empno'];

            require_once('../../PHPmailer/sendmail.php');

            $em = new email();

            if (isset($_POST['save'])) {
                $ass_app_ids = $_POST['ass_app_id'];
                $boss_scores = $_POST['boss_score'];
                $total_scores = $_POST['total_score'];

                // return var_dump($ass_app_ids, $empno, $own_scores, $comments);
                array_map(function ($ass_app_id, $boss_score, $total_score) {
                    global $empno;
                    // return var_dump($empno);
                    mysqli_query($link, " UPDATE ass_emp_appraisals SET boss_score = '$boss_score', total_score = '$total_score'
                            WHERE ass_app_id = '$ass_app_id' AND empno='$empno'
                        ") or die("Error Saving Data " . mysqli_error($link));
                    // return var_dump($mysql_query);
                }, $ass_app_ids, $boss_scores, $total_scores);

                // notofy the employee that there is a new comment made on the appraisal.

                $Subject = "Appraisal Alert";
                $message = " Hello, <br>
                    There is a new Submission on your Appraisal from your Supervisor.
                    <br>Log into the System to check.
                    <br><br> <hr>
                    Regards.
                ";

                function getEmployeeEmail($employeeId)
                {
                    $getHodDataQuery = mysqli_query($link, "SELECT * FROM emp_info WHERE empno='$employeeId'");
                    $hodsInfoRows = mysqli_fetch_array($getHodDataQuery);
                    $hodsEmail = $hodsInfoRows['email'];
                    return $hodsEmail;
                }

                $em->send_mail(getEmployeeEmail($empno), $message, $Subject);
            }

            if (isset($_POST['boss_comment'])) {
                $ass_app_id = $app_id;
                $boss_comment = ($_POST['boss_comment']);

                mysqli_query($link, " UPDATE ass_emp_appraisals SET boss_comment = '$boss_comment'
                        WHERE ass_app_id = '$ass_app_id' AND empno='$empno'
                    ") or die("Error Saving Data " . mysqli_error($link));
            }
            ?>
            <div style="padding-left: 70px; padding-top: 20px;">
                <button class="btn btn-sm btn-primary" onclick="javascript:printDiv('printablediv')">Print</button>
            </div>
            <div id="printablediv">
                <section class="content container">

                    <hr>

                    <div class="row center">
                        <div class="col-xs-10 col-md-12 ">
                            <div class="box box-primary">
                                <div class="box-header">
                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <center> <img src="<?php
                                                        include_once '../../Admin/Classes/Company.php';
                                                        $CompanyObject = new Company();
                                                        $companyId = $_SESSION['company_ID'];
                                                        echo $CompanyObject->getCompanyLogo4($companyId)
                                                        ?>" width="70%" height="290" class="img-thumbnail"></img>
                                    </center>

                                    <table id="example1" class="table table-bordered table-striped">
                                        <?php
                                        $empq = mysqli_query($link, "SELECT emp_info.fname AS fname , emp_info.lname AS lname, emp_info.position AS position, emp_info.empno AS empno,
                                        department.department FROM emp_info 
                                        LEFT JOIN department ON department.dep_id = emp_info.dept 
                                        WHERE emp_info.empno = '$empno'
                                        ");
                                        $empr = mysqli_fetch_array($empq);



                                        $query1 = mysqli_query($link, "SELECT emp_info.fname AS fname , emp_info.lname AS lname, emp_info.position AS position, emp_info.empno AS empno,
                                                    department.department, ass_periods.name AS periods, ass_appraisals.date AS app_date,ass_appraisals.bossno ,
                                                    ass_periods.id AS periods_id,ass_periods.date AS p_to, ass_periods.date_from AS p_from
                                                FROM ass_appraisals
                                                LEFT JOIN emp_info ON emp_info.empno = ass_appraisals.bossno 
                                                LEFT JOIN department ON department.dep_id = emp_info.dept 
                                                LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                WHERE ass_appraisals.id = '$app_id'
                                                ") or die("Error Getting Data 2 " . mysqli_error($link));
                                        while ($row1 = mysqli_fetch_array($query1)) {
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
                                    <!-- <h3 class="box-title"> Print </h3> -->
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th> Objective </th>
                                                <th>Weight </th>
                                                <th> Parameter </th>
                                                <th>Target Score</th>
                                                <th>Own Score</th>
                                                <th>Supervisor Score</th>
                                                <th>Agreed Score</th>
                                                <th>Appraisee's Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // var_dump($bossno, $empno);
                                            $query = mysqli_query($link, "SELECT ass_appraisals.id AS ass_app_id,
                                                        ass_params.name AS params, ass_params.id AS params_id, ass_params.weight AS weight,
                                                        ass_factors.name AS objective, ass_factors.target AS target,
                                                        ass_periods.name, emp_info.empno
                                                    FROM ass_appraisals
                                                    LEFT JOIN emp_info ON emp_info.empno = ass_appraisals.bossno 
                                                    LEFT JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                    LEFT JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id
                                                    LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                    LEFT JOIN ass_emp_appraisals ON ass_emp_appraisals.ass_app_id = ass_appraisals.id 
                                                    WHERE ass_periods.name = '$period' AND emp_info.empno = '$bossno' AND weight >0
                                                    
                                                     AND ass_emp_appraisals.empno = '$empno'
                                                    
                                                    ") or die("Error Getting Data 3 " . mysqli_error($link));


                                            while ($row = mysqli_fetch_array($query)) {
                                                $ass_app_id = $row['ass_app_id'];
                                                $emp_q = mysqli_query($link, "SELECT own_score, boss_score, total_score, comment 
                                                FROM ass_emp_appraisals WHERE empno = '$empno' AND ass_app_id = '$ass_app_id'  
                                                ") or die("Error Getting Data 4 " . mysqli_error($link));


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
                                                        while ($emp_r = mysqli_fetch_array($emp_q)) {
                                                            $own_score = $emp_r['own_score'];
                                                            $boss_score = $emp_r['boss_score'];
                                                            $total_score = $emp_r['total_score'];
                                                            $comment = $emp_r['comment'];

                                                            if ($boss_score == '' || $total_score == "") {
                                                        ?>
                                                                <td> <?php echo $own_score ?> </td>
                                                                <td>
                                                                    <input type="text" name="boss_score[]" value="<?php echo $boss_score; ?>">
                                                                    <input type="hidden" name="ass_app_id[]" value="<?php echo $ass_app_id; ?>">
                                                                </td>
                                                                <td> <input type="text" name="total_score[]" value="<?php echo $total_score; ?>"> </td>
                                                                <td><?php echo $comment ?> </td>
                                                            <?php
                                                                $hide = "";
                                                            } else {
                                                                $hide = "hidden";
                                                            ?>
                                                                <td><?php echo $own_score; ?></td>
                                                                <td><?php echo $boss_score; ?></td>
                                                                <td> <?php echo $total_score; ?></td>
                                                                <td> <?php echo $comment ?> </td>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            <td> <button class="<?php echo $hide; ?>" name="save" type="submit">Save</button> </td>
                                            </form>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->

                            </div><!-- /.col -->
                        </div><!-- /.row -->
                </section>

                <section class="content container">
                    <br>
                    <br>
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
                                            $query = mysqli_query($link, "SELECT from_,to_ ,rank FROM `app_rating`") or die(mysqli_error($link));
                                            while ($row = mysqli_fetch_array($query)) {
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
                                                <th>Parameter </th>
                                                <th>Weight </th>
                                                <th>Achieved Score </th>
                                                <th>Ranking </th>
                                                <th>Recommendation </th>
                                                <th>Comments </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($link, "SELECT ass_appraisals.id AS ass_app_id,
                                                        ass_params.name AS params, ass_params.id AS params_id, ass_params.weight AS weight,
                                                        ass_factors.name AS objective, ass_factors.target AS target,
                                                        ass_periods.name, emp_info.empno
                                                    FROM ass_appraisals
                                                    LEFT JOIN emp_info ON emp_info.empno = ass_appraisals.bossno 
                                                    LEFT JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                    LEFT JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id
                                                    LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                    LEFT JOIN ass_emp_appraisals ON ass_emp_appraisals.ass_app_id = ass_appraisals.id 
                                                    WHERE ass_periods.name = '$period' AND emp_info.empno = '$bossno'
                                                   
                                                    
                                                     AND ass_emp_appraisals.empno = '$empno'
                                                     GROUP BY params
                                                    ") or die("Error Getting Data 3 " . mysqli_error($link));
                                            $total_weight = 0;
                                            while ($row = mysqli_fetch_array($query)) {
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
                                                    $emp_q = mysqli_query($link, "SELECT own_score, boss_score, total_score, comment 
                                                            FROM ass_emp_appraisals WHERE empno = '$empno' AND ass_app_id = '$ass_app_id'
                                                        ") or die("Error Getting Data 4 " . mysqli_error($link));

                                                    $total_archieved_score = 0;
                                                    while ($emp_r = mysqli_fetch_array($emp_q)) {
                                                        $total_score = $emp_r['total_score'];
                                                        $total_archieved_score += $total_score;
                                                        //Get Percentage
                                                        $total_score_percent = $total_score / $weight * 100;
                                                        $total_score_percent = intval($total_score_percent);
                                                        $comment = $emp_r['comment'];
                                                        // Get Ranking
                                                        $r_q = mysqli_query($link, "SELECT * FROM app_rating
                                                                WHERE from_ <= '$total_score_percent' AND to_ >= '$total_score_percent' 
                                                                ") or die(mysqli_error($link));
                                                        $r_row = mysqli_fetch_array($r_q);
                                                        $from_ = intval($r_row['from_']);
                                                        $to_ = intval($r_row['to_']);
                                                        $recommendation = $r_row['recommendation'];

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
                                                            <td> <?php echo $recommendation; ?></td>
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
                                    $empex_q = mysqli_query($link, "SELECT emp_expectation,ass_appraisals.id AS ass_app_id,
                                                        ass_params.name AS params, ass_params.id AS params_id, ass_params.weight AS weight,
                                                        ass_factors.name AS objective, ass_factors.target AS target,
                                                        ass_periods.name, emp_info.empno
                                                    FROM ass_appraisals
                                                    LEFT JOIN emp_info ON emp_info.empno = ass_appraisals.bossno 
                                                    LEFT JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                    LEFT JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id
                                                    LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                    LEFT JOIN ass_emp_appraisals ON ass_emp_appraisals.ass_app_id = ass_appraisals.id 
                                                    WHERE ass_periods.name = '$period' AND emp_info.empno = '$bossno' AND weight >0
                                                    
                                                     AND ass_emp_appraisals.empno = '$empno' and emp_expectation!=''
                                                    
                                                    ") or die("Error" . mysqli_error($link));


                                    $empex_r = mysqli_fetch_array($empex_q);
                                    $empex_exists = $empex_r['emp_expectation'];

                                    echo '
                                        <h4>Appraisee-Expectations </h4>
                                        <textarea readonly disabled cols="50" rows="7">' . $empex_exists . '</textarea>
                                        ';
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
                                    $bosscom_q = mysqli_query($link, "SELECT boss_comment,ass_appraisals.id AS ass_app_id,
                                                        ass_params.name AS params, ass_params.id AS params_id, ass_params.weight AS weight,
                                                        ass_factors.name AS objective, ass_factors.target AS target,
                                                        ass_periods.name, emp_info.empno
                                                    FROM ass_appraisals
                                                    LEFT JOIN emp_info ON emp_info.empno = ass_appraisals.bossno 
                                                    LEFT JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                    LEFT JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id
                                                    LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                    LEFT JOIN ass_emp_appraisals ON ass_emp_appraisals.ass_app_id = ass_appraisals.id 
                                                    WHERE ass_periods.name = '$period' AND emp_info.empno = '$bossno' AND weight >0
                                                    
                                                     AND ass_emp_appraisals.empno = '$empno'
                                                    
                                                    
                                        ") or die("Error" . mysqli_error($link));

                                    echo "SELECT boss_comment,ass_appraisals.id AS ass_app_id,
                                                        ass_params.name AS params, ass_params.id AS params_id, ass_params.weight AS weight,
                                                        ass_factors.name AS objective, ass_factors.target AS target,
                                                        ass_periods.name, emp_info.empno
                                                    FROM ass_appraisals
                                                    LEFT JOIN emp_info ON emp_info.empno = ass_appraisals.bossno 
                                                    LEFT JOIN ass_params ON ass_params.id = ass_appraisals.params_id 
                                                    LEFT JOIN ass_factors ON ass_factors.id = ass_appraisals.factor_id
                                                    LEFT JOIN ass_periods ON ass_periods.id = ass_appraisals.period_id 
                                                    LEFT JOIN ass_emp_appraisals ON ass_emp_appraisals.ass_app_id = ass_appraisals.id 
                                                    WHERE ass_periods.name = '$period' AND emp_info.empno = '$bossno' AND weight >0
                                                    
                                                     AND ass_emp_appraisals.empno = '$empno'
                                                    
                                                    
                                        ";
                                    $bosscom_r = mysqli_fetch_array($bosscom_q);
                                    $bosscom_exists = $bosscom_r['boss_comment'];
                                    // return var_dump($bosscom_exists);
                                    if ($bosscom_exists == '') {
                                    ?>
                                        <form action="" method="post">
                                            <h4>Head of Department Comments <button type="submit">Add</button></h4>
                                            <textarea name="boss_comment" id="" cols="50" rows="7"></textarea>
                                            <input type="hidden" name="ass_app_id[]" value="<?php echo $ass_app_id; ?>">
                                        </form>
                                    <?php
                                    } else {
                                        echo '
                                        <h4>Head of Department Comments</h4>
                                        <textarea readonly disabled cols="50" rows="7">' . $bosscom_exists . '</textarea>
                                        ';
                                    }
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