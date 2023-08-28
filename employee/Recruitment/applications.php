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
        include_once '../Classes/Employee.php';
        $EmployeeObject = new Employee();
        //include_once '../Classes/Department.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Tax.php';

        $LoanObject = new Loans();
        //$DepartmentObject = new Department();
        $PaySlipsObject = new Payslips();
        $TaxObject = new Tax();
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo $_SESSION['name'] . ' - Applications';
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-17">

                        <div class="box">
                            <div class="box-body">

                                <div class="table-responsive">
                                    <div class="col-md-2">
                                        <form action="applications" method="post">
                                            <table cellpadding="" border="0" class="se">
                                                <tr>
                                                    <select name="job" class="form-control">
                                                        <option>-- Filter By Job Title --</option>
                                                        <option value="All">All Jobs</option>
                                                        <?php
                                                        $result = mysql_query("SELECT * FROM postings  ");;
                                                        while ($row = mysql_fetch_array($result)) {
                                                            $fname = $row['title'];
                                                        ?>
                                                            <option value="<?php echo $row['id']; ?>"> <?php echo $fname ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>

                                                    <select name="status" class="form-control">
                                                        <option>-- Filter By Status --</option>
                                                        <option value="All">All Statuses</option>
                                                        <?php
                                                        $result = mysql_query("SELECT DISTINCT status,id FROM `applications` GROUP BY status  ");;
                                                        while ($row = mysql_fetch_array($result)) {
                                                            $fname = $row['status'];
                                                        ?>
                                                            <option value="<?php echo $fname; ?>"> <?php echo $fname ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                    <td>
                                                        <button type="submit" name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>Generate
                                                        </button>
                                                    </td>
                                                </tr>
                                            </table>

                                        </form>
                                    </div>
                                    <br></br>
                                    <table id="employee_data" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <td>Job Title</td>
                                                <td>Applicant</td>
                                                <td>Email</td>
                                                <td>Phone</td>
                                                <td>Cover Letter</td>
                                                <td>CV</td>
                                                <td>Date Applied</td>
                                                <td>Status</td>
                                                <td>Actions</td>
                                            </tr>
                                        </thead>
                                        <?php
                                        if (isset($_POST['job'])) {
                                            $job = $_POST['job'];
                                            $status = $_POST['status'];

                                            if ($job == "All" && $status == "All") {
                                                $query = "SELECT *,applications.status AS app_status,applications.id AS app_id FROM applications 
                                                LEFT JOIN postings ON applications.posting_id = postings.id
                                                 ";
                                            } elseif ($job == "All" && $status != "All") {
                                                $query = "SELECT *,applications.status AS app_status,applications.id AS app_id FROM applications 
                                                LEFT JOIN postings ON applications.posting_id = postings.id
                                                WHERE applications.status='$status'
                                                 ";
                                            } else if ($job != "All" && $status != "All") {
                                                $query = "SELECT *,applications.status AS app_status,applications.id AS app_id FROM applications 
                                                LEFT JOIN postings ON applications.posting_id = postings.id
                                                WHERE applications.status='$status' AND posting_id='$job'
                                                 ";
                                            }
                                        } else {
                                            if (isset($_GET['id_'])) {
                                                $posting_id = $_GET['id_'];
                                                $get_for_single_job = " WHERE posting_id = '$posting_id' ";
                                            } else {
                                                $get_for_single_job = "";
                                            }

                                            $query = "SELECT *,applications.status AS app_status,applications.id AS app_id FROM applications 
                                                LEFT JOIN postings ON applications.posting_id = postings.id
                                                $get_for_single_job LIMIT 50 ";
                                        }

                                        $result = mysql_query($query);
                                        while ($row = mysql_fetch_array($result)) {
                                            $app_id = $row['app_id'];
                                            $title = $row['title'];
                                            $name = $row['name'];
                                            $email = $row['email'];
                                            $mobile = $row['mobile'];
                                            $cover = $row['cover'];
                                            $cv = $row['cv'];
                                            $status = $row['app_status'];
                                            $rawdate = $row['date'];

                                            $date = date("Y-m-d", strtotime($rawdate));

                                            echo '  
                                                    <tr>
                                                        <td>' . $title . '</td>  
                                                        <td>' . $name . '</td>                                                                      
                                                        <td>' . $email . '</td> 
                                                        <td>' . $mobile . '</td>
                                                        <td><a href="../../files/covers/' . $cover . '">Download </a> </td>
                                                        <td><a href="../../files/cv/' . $cv . '">Download </a> </td>
                                                        <td>' . $date . '</td>
                                                        <td>' . $status . '</td>
                                                        <td>
                                                            <button type="button" class="btn btn-primary label" data-toggle="modal" data-target="#exampleModal' . $app_id . '">
                                                                Status
                                                            </button>
                                                        </td>
                                                    </tr>  

                                                    ';
                                        ?>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?php echo $app_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                        <option value="Unread">Unread</option>
                                                                        <option value="Call For Interview">Call For Interview</option>
                                                                        <option value="Approved">Approved</option>
                                                                        <option value="Rejected">Rejected</option>
                                                                    </select>
                                                                </div>

                                                                <input type="hidden" name="app_id" value="<?php echo $app_id ?>">

                                                                <button type="submit" name="update_status" class="btn btn-default">Update</button>
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
        if (isset($_POST["update_status"])) {
            // return var_dump($link);
            $status = $_POST["status"];
            $app_id = $_POST["app_id"];

            mysql_query("UPDATE applications SET status = '$status' WHERE id = '$app_id' ")
                or die("Err11 " . mysql_error());

            echo "<script> document.location='applications.php' </script>";
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