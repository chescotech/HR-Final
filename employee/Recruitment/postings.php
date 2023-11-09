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
                    echo $_SESSION['company_name'] . ' - Postings';
                    ?>
                </h1>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-17">

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
                                        $result = mysqli_query($link, "SELECT * FROM postings 
                                                LEFT JOIN department ON department.dep_id = postings.dep_id
                                                WHERE status = 'Published'
                                                AND DATE(expires) > DATE(NOW())
                                                ") or die(mysqli_error($link));
                                        $view_details = "";
                                        while ($row = mysqli_fetch_array($result)) {
                                            $id_ = $row['id'];
                                            $title = $row['title'];
                                            $department = $row['department'];
                                            $vacancies = $row['vacancies'];
                                            $status = $row['status'];
                                            $rawdate = $row['date'];

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
                                                    <td>' . $view_details . '</td>
                                                </tr>  
                                                ';
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