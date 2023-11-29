<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Recruitment</title>
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
        include_once '../Classes/Employee.php';
        $EmployeeObject = new Employee();

        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo $_SESSION['name'] . ' - Postings';
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-17">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                            Create New Posting
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Create Posting</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <form method="POST" action="#save">
                                            <div class="form-group">
                                                <label for="title">Job Title:</label>
                                                <input type="text" class="form-control" name="title">
                                            </div>
                                            <div class="form-group">
                                                <label>Department:</label>
                                                <select name="dep_id" class="form-control">
                                                    <option>--Select Department--</option>
                                                    <?php
                                                    $departmentquery = mysqli_query($link, "SELECT * FROM department ");
                                                    while ($row = mysqli_fetch_array($departmentquery)) {
                                                    ?>
                                                        <option value="<?php echo $row['dep_id']; ?>"> <?php echo $row['department']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd">Job Type:</label>
                                                <select name="type" class="form-control">
                                                    <option value="Contract">Contract</option>
                                                    <option value="Part Time">Part Time</option>
                                                    <option value="Full Time">Full Time</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd">Number Of Vacancies:</label>
                                                <input type="number" class="form-control" name="vacancies">
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd">Salary:</label>
                                                <input type="text" class="form-control" name="salary">
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd">Required Qualifications:</label>
                                                <input type="text" class="form-control" name="qualifications">
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd">Required Years Of Experience:</label>
                                                <input type="text" class="form-control" name="experience">
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd">Date Posted:</label>
                                                <input type="date" class="form-control" name="date">
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd">Last Date to Apply:</label>
                                                <input type="date" class="form-control" name="expires">
                                            </div>
                                            <div class="form-group">
                                                <label for="pwd">Additional Info:</label>
                                                <textarea name="info" class="form-control"></textarea>
                                            </div>
                                            <button type="submit" name="create_posting" class="btn btn-default">Submit</button>
                                        </form>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box">
                            <div class="box-body">

                                <div class="table-responsive">
                                    <table id="employee_data" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Job Title</td>
                                                <td>Department</td>
                                                <td>Vacancies</td>
                                                <td>Date Posted</td>
                                                <td>Status</td>
                                                <td>Actions</td>
                                            </tr>
                                        </thead>
                                        <?php
                                        $compID = $_SESSION['company_ID'];
                                        $query = "SELECT * FROM postings 
                                                LEFT JOIN department ON department.dep_id = postings.dep_id";
                                        $result = mysqli_query($link, $query);
                                        $view_details = "";
                                        while ($row = mysqli_fetch_array($result)) {
                                            $id_ = $row['id'];
                                            $title = $row['title'];
                                            $department = $row['department'];
                                            $dep_id = $row['dep_id'];
                                            $vacancies = $row['vacancies'];
                                            $status = $row['status'];
                                            $rawdate = $row['date'];
                                            $salary = $row['salary'];
                                            $qualifications = $row['qualifications'];
                                            $experience = $row['experience'];
                                            $info = $row['info'];
                                            $expires = $row['expires'];

                                            $date = date("Y-m-d", strtotime($rawdate));

                                            if ($status == 'Published') {
                                                $view_details = '<a target="_blank" href="../../job_details?job=' . $id_ . '" title="View Details &amp; Apply Now" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip"><i class="fa fa-paper-plane"></i></a>';
                                            } elseif ($status == 'Unpublished') {
                                                $view_details = '<a title="Publish To View Details &amp Apply" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip"><i class="fa fa-paper-plane"></i></a>';
                                            }

                                            echo '  
                                                    <tr>
                                                        <td>' . $title . '</td>  
                                                        <td>' . $department . '</td>                                                                      
                                                        <td>' . $vacancies . '</td> 
                                                        <td>' . $date . '</td>
                                                        <td>' . $status . '</td>
                                                        <td>
                                                            ' . $view_details . '
                                                            <a href="applications?id_=' . $id_ . '" title="All Application for this job" class="btn btn-primary btn-xs" data-toggle="tooltip"><span class="fa fa-list-alt"></span></a>
                                                            <button type="button" class="btn btn-primary label" data-toggle="modal" data-target="#exampleModal' . $id_ . '">
                                                                Status
                                                            </button>
                                                            <button type="button" class="btn btn-primary label" data-toggle="modal" data-target="#edit' . $id_ . '">
                                                                <span class="fa fa-edit"></span>
                                                            </button>
                                                            <a onclick="return alert("Are you sure you want to delete ?")" href="?del=' . $id_ . '" class="btn label-danger label" >
                                                                <span class="fa fa-trash"></span>
                                                            </a>
                                                        </td>
                                                    </tr>  
                                                    ';
                                        ?>
                                            <!-- Status Modal -->
                                            <div class="modal fade" id="exampleModal<?php echo $id_ ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Create Posting</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form method="POST" action="#save">

                                                                <div class="form-group">
                                                                    <label for="pwd">Update Status:</label>
                                                                    <select name="status" class="form-control">
                                                                        <option value="Published">Published</option>
                                                                        <option value="Unpublished">Unpublished</option>
                                                                    </select>
                                                                </div>

                                                                <input type="hidden" name="app_id" value="<?php echo $id_ ?>">

                                                                <button type="submit" name="update_status" class="btn btn-default">Update</button>
                                                            </form>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Modal -->
                                            <div class="modal fade" id="edit<?php echo $id_ ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Posting</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form method="POST" action="#update">
                                                                <div class="form-group">
                                                                    <label for="title">Job Title:</label>
                                                                    <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
                                                                    <input type="hidden" name="id_" value="<?php echo $id_ ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Department:</label>
                                                                    <select name="dep_id" class="form-control">
                                                                        <option value="<?php echo $dep_id ?>"> <?php echo $department ?> </option>
                                                                        <?php
                                                                        $departmentquery = mysqli_query($link, "SELECT * FROM department ");
                                                                        while ($row = mysqli_fetch_array($departmentquery)) {
                                                                        ?>
                                                                            <option value="<?php echo $row['dep_id']; ?>"> <?php echo $row['department']; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="pwd">Job Type:</label>
                                                                    <select name="type" class="form-control">
                                                                        <option value="<?php echo $dep_id ?>"> <?php echo $dep_id ?> </option>
                                                                        <option value="Contract">Contract</option>
                                                                        <option value="Part Time">Part Time</option>
                                                                        <option value="Full Time">Full Time</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="pwd">Number Of Vacancies:</label>
                                                                    <input type="number" class="form-control" name="vacancies" value="<?php echo $vacancies ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="pwd">Salary:</label>
                                                                    <input type="text" class="form-control" name="salary" value="<?php echo $salary ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="pwd">Required Qualifications:</label>
                                                                    <input type="text" class="form-control" name="qualifications" value="<?php echo $qualifications ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="pwd">Required Years Of Experience:</label>
                                                                    <input type="text" class="form-control" name="experience" value="<?php echo $experience ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="pwd">Date Posted:</label>
                                                                    <input type="date" class="form-control" name="date" value="<?php echo $rawdate ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="pwd">Last Date to Apply:</label>
                                                                    <input type="date" class="form-control" name="expires" value="<?php echo $expires ?>">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="pwd">Additional Info:</label>
                                                                    <textarea name="info" class="form-control"><?php echo $info ?> </textarea>
                                                                </div>
                                                                <button type="submit" name="update_posting" class="btn btn-default">Update</button>
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

                                    </table>
                                </div>
                            </div><!-- /.box-body -->
                        </div>
                    </div>
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div>

        <?php
        if (isset($_POST["create_posting"])) {
            // return var_dump($link);
            $title = $_POST["title"];
            $dep_id = $_POST["dep_id"];
            $type = $_POST["type"];
            $vacancies = $_POST["vacancies"];
            $salary = $_POST["salary"];
            $experience = $_POST["experience"];
            $date = $_POST["date"];
            $expires = $_POST["expires"];
            $info = $_POST["info"];
            $qualifications = $_POST["qualifications"];

            mysqli_query($link, "INSERT INTO postings (title, dep_id, type, vacancies, salary, experience, date, expires,info,qualifications,status)
                                            VALUES('$title', '$dep_id', '$type', '$vacancies', '$salary', '$experience', '$date', '$expires', '$info','$qualifications','Unpublished')")
                or die("Err11 " . mysqli_error($link));

            echo "<script>document.location='postings'</script>";
        }

        if (isset($_POST["update_status"])) {
            $status = $_POST["status"];
            $app_id = $_POST["app_id"];
            // return var_dump($status,$app_id);

            mysqli_query($link, "UPDATE postings SET status = '$status' WHERE id = '$app_id' ")
                or die("Err11 " . mysqli_error($link));

            echo "<script> document.location='postings.php' </script>";
        }

        if (isset($_GET['del'])) {
            $id = $_GET['del'];
            mysqli_query($link, "DELETE FROM postings WHERE id = '$id' ") or die(mysqli_error($link));

            echo "<script>document.location='postings'</script>";
        }

        if (isset($_POST["update_posting"])) {
            // return var_dump($link);
            $title = $_POST["title"];
            $dep_id = $_POST["dep_id"];
            $type = $_POST["type"];
            $vacancies = $_POST["vacancies"];
            $salary = $_POST["salary"];
            $experience = $_POST["experience"];
            $date = $_POST["date"];
            $expires = $_POST["expires"];
            $info = $_POST["info"];
            $qualifications = $_POST["qualifications"];
            $id_ = $_POST["id_"];

            mysqli_query($link, "UPDATE postings SET title = '$title', dep_id='$dep_id', type='$type', vacancies='$vacancies',
                            salary='$salary', experience='$experience', date='$date', expires='$expires', info='$info',
                            qualifications='$qualifications', status='Unpublished' WHERE id = '$id_' ")
                or die("Err22 " . mysqli_error($link));

            echo "<script>document.location='postings'</script>";
        }

        ?>



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
                    'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
</body>

</html>