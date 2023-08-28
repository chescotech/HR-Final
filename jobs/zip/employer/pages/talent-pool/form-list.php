<head>
    <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">

</head>

<div class="content-wrapper">
    <div>
        <ol class="breadcrumb">
            <li><a href="#">Applicant</a></li>
            <li class="active">List</li>
        </ol>
    </div>
    <div class="panel panel-default">
        <div class="panel-body" style="font-size:14px;">

            <div style="padding-bottom:10px">
                <a class="btn btn-primary" href="create-talent-pool">Add Talent Pool</a>
            </div>

            <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Talent Pool Name</th>
                        <th>Department</th>
                        <th>Talent Description</th>
                        <th>Date Created</th>
                        <th>No Candidates</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $Rectruitment = new Rectruitment();
                        $user_q = mysql_query("SELECT id,title,description,date_created, department FROM `talent_pool`

                        inner join department on department.dep_id=talent_pool.department_id
                    ") or die(mysql_error());                     
                    
                    while ($row = mysql_fetch_array($user_q)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $department = $row['department'];
                        $description = $row['description'];
                        $date_created = $row['date_created'];
                       
                        echo '
                            <tr>
                                <td>' . $title . '</td>
                                <td>' . $department . '</td>
                                <td>' . $description . '</td>
                                <td>' . $date_created . '</td>
                                <td>'.$Rectruitment->countTalentMembers($id).'</td>
                                <td>
                                <a class="btn btn-primary" style="padding:2px; padding-left: 10px; padding-right:10px;" href="talent-pool-candidates.php?pool_id=' . $id . '">View Candidates</a>
                                  
                                <a class="btn btn-info" style="padding:2px; padding-left: 10px; padding-right:10px;" href="job-editor.php?id=' . $id . '">Edit</a>
                                <a class="btn btn-danger" style="padding:2px; padding-left: 10px; padding-right:10px;" href="delete-job.php?id=' . $id . '">Delete</a>
                                </td>
                            </tr>';
                            ?>

                    <div class="modal fade" id="exampleModal<?php echo $id ?>" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Update Applicant Status</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="#save">
                                        <div class="form-group">
                                            <label for="pwd">Update Applicant Status:</label>
                                            <select name="status" class="form-control">
                                                <option value="Phone Interview">Phone Interview</option>
                                                <option value="Onsite Interview">Onsite Interview</option>
                                                <option value="Evaluation">Evaluation</option>
                                                <option value="Offer">Offer</option>
                                                <option value="Hired">Hired</option>
                                            </select>
                                        </div>

                                        <input hidden="" name="app_id" value="<?php echo $appcant_user_id ?>">
                                        <input hidden="" name="job" value="<?php echo $id; ?>">

                                        <button type="submit" name="update_status"
                                            class="btn btn-default">Update</button>
                                    </form>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="meeting<?php echo $id ?>" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New Meeting</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="#save">
                                        <div class="form-group">
                                            <label for="pwd">Update Applicant Status:</label>
                                            <select name="status" class="form-control">
                                                <option value="Phone Interview">Phone Interview</option>
                                                <option value="Onsite Interview">Onsite Interview</option>
                                                <option value="Evaluation">Evaluation</option>
                                                <option value="Offer">Offer</option>
                                                <option value="Hired">Hired</option>
                                            </select>
                                        </div>

                                        <input hidden="" name="app_id" value="<?php echo $appcant_user_id ?>">
                                        <input hidden="" name="job" value="<?php echo $id; ?>">

                                        <button type="submit" name="update_status"
                                            class="btn btn-default">Update</button>
                                    </form>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>



                    <?php
                        }
                        ?>

                </tbody>


                <?php
          
            
            if (isset($_POST["update_status"])) {
                $status = $_POST["status"];
                $app_id = $_POST["app_id"];
                $job_id = $_POST['job'];
                //return var_dump($job_id,$app_id);

                mysql_query("UPDATE jobs_user_applications SET job_status = '$status' WHERE  id='$job_id' ")
                    or die("Err11 " . mysql_error());

                echo "<script> document.location='applicant-list.php' </script>";
            }
        ?>
                <tfoot style="background-color: #c0c0c0; color: #ffffff; font-size: 0.9em; ">
                    <tr>
                        <th>Talent Pool Name</th>
                        <th>Talent Description</th>
                        <th>Date Created</th>
                        <th>No Candidates</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
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