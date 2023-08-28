<head>
    <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
</head>

<?php
// Get applicant's info
$user_id = $_GET['user_id'];
$get_user = mysql_query("SELECT * FROM jobs_users WHERE id = '$user_id' ") or die(mysql_error());
$user_info = mysql_fetch_array($get_user);

$fname = $user_info['fname'];
$lname = $user_info['lname'];
$username = $user_info['username'];
$email = $user_info['email'];
$phone = $user_info['phone'];
$dob = $user_info['dob'];
$gender = $user_info['gender'];

$user_full_names = $fname .' '. $lname;

?>

<div class="content-wrapper" style="overflow:auto; height:80vh">
    <section class="content container">
        <div class="row center">

            <div class="col-md-11">


                <!-- Page Container -->
                <div class="w3-content" style="max-width:1400px; margin-top:36px">

                    <!-- The Grid -->
                    <div class="w3-row-padding">

                        <!-- Left Column -->
                        <div class="w3-third">

                            <div class="w3-white w3-text-grey w3-card-4" style="padding:10px; border-radius: 5px;">
                                <h3><?php echo  $user_full_names ?></h3>
                                <hr>
                                <div>
                                    <h4>Interview set</h4>
                                    <div style="color:#AAAAAA">
                                        No Interview has been set
                                    </div>
                                </div>
                                <hr>
                                <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $email ?> </p>
                                <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $phone ?> </p>
                                <p><i class="fa fa-calendar-minus-o fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $dob ?> </p>
                                <p><i class="fa fa-venus-mars fa-fw w3-margin-right w3-large w3-text-blue"></i> <?php echo $gender ?> </p>
                                <hr>
                            </div><br>

                            <!-- End Left Column -->
                        </div>

                        <!-- Right Column -->
                        <div class="w3-twothird" style="max-height: 70vh; overflow: auto;">
                            <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Interview Name</th>
                                        <th>Duration </th>
                                        <th>Questions</th>
                                        <th>Attempts</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $user_q = mysql_query("SELECT * FROM savsoft_quiz ") or die(mysql_error());
                                    while ($row = mysql_fetch_array($user_q)) {
                                        $quiz_name = $row['quiz_name'];
                                        $duration = $row['duration'];
                                        $noq = $row['noq'];
                                        $maximum_attempts = $row['maximum_attempts'];
                                       

                                        echo '
                                            <tr>
                                                <td>' . $quiz_name . '</td>
                                                <td>' . $duration . ' (min.)</td>
                                                <td>' . $noq . '</td>
                                                <td>' . $maximum_attempts . '</td>
                                                <td>
                                                    <a class="btn btn-primary" style="padding:2px; padding-left: 10px; padding-right:10px;" href="user-editor.php?id=' . $user_id . '">Set</a>
                                                    <a class="btn btn-danger" style="padding:2px; padding-left: 10px; padding-right:10px;" href="deleteuser.php?id=' . $user_id . '">Unset</a>
                                                </td>
                                            </tr>';
                                    }
                                    ?>
                                   
                                </tbody>
                            </table>
                            <!-- End Right Column -->
                        </div>

                        <!-- End Grid -->
                    </div>

                    <!-- End Page Container -->
                </div>


            </div>

    </section>
</div>

<script type="text/javascript" src="../../js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../../js/jszip.min.js"></script>
<script type="text/javascript" src="../../js/pdfmake.min.js"></script>
<script type="text/javascript" src="../../js/vfs_fonts.js"></script>
<script type="text/javascript" src="../../js/buttons.html5.min.js"></script>
<script type="text/javascript" src="../../js/buttons.print.min.js"></script>
<script type="text/javascript" src="../../js/app.js"></script>
<script type="text/javascript" src="../../js/jquery.mark.min.js"></script>
<script type="text/javascript" src="../../js/datatables.mark.js"></script>
<script type="text/javascript" src="../../js/buttons.colVis.min.js"></script>