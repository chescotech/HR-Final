
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>User List</title>
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
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/r/dt/jq-2.1.4,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.9,af-2.0.0,b-1.0.3,b-colvis-1.0.3,b-html5-1.0.3,b-print-1.0.3,se-1.0.1/datatables.min.js"></script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">              
                <a href="" class="logo">    
                    <span class="logo-lg"><b></b></span>
                </a>
                <?php include '../navigation_panel/authenticated_user_header.php'; ?>        
                </nav>
            </header>

            <aside class="main-sidebar">        
                <section class="sidebar">         
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <?php
                    $company_id = $_SESSION['companyID'];
                    include '../navigation_panel/side_navigation_bar.php';
                    ?>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>  
                        Crystaline Technologies User List                                             
                    </h1>                   
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-4">
                            <form action="add-user">
                                <table  cellpadding=""  border="0" class="se">
                                    <tr>
                                        <td>
                                            <button  type="submit" id="save" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add User</button>
                                        </td>                                        
                                    </tr>
                                </table>
                            </form>
                        </div>                        
                        <br></br>
                        <div class="row">                            
                            <div class="col-xs-15">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table id="employee_data" class="table table-bordered table-fixed">
                                                <thead>                                            
                                                    <tr>                                                       
                                                        <th>Company</th>                                                                                            
                                                        <th>User Type</th>                                                            
                                                        <th>Name</th>                                                        
                                                        <th>Email address</th>        
                                                        <th>Edit</th> 
                                                        <th>Delete</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include_once '../Classes/Company.php';
                                                    $query = "SELECT * FROM users_tb WHERE company_id = '$company_id' AND user_type != 'superadmin'";
                                                    $result = mysql_query($query, $link) or die(mysql_error());
                                                    $fname = "";
                                                    $lname = "";
                                                    $email = "";
                                                    while ($row = mysql_fetch_array($result)) {
                                                        $id = $row['id'];
                                                        $companyID = $row['company_id'];
                                                        $companyObject = new Company();

                                                        if ($row['firstname'] == "") {
                                                            $fname = $companyObject->getFirstname($row['empno']);
                                                        } else {
                                                            $fname = $row['firstname'];
                                                        }
                                                        if ($row['lastname'] == "") {
                                                            $lname = $companyObject->getLastname($row['empno']);
                                                        } else {
                                                            $lname = $row['lastname'];
                                                        }
                                                        if ($row['email_address'] == "") {
                                                            $email = $companyObject->getEmployeeEmail($row['empno']);
                                                        } else {
                                                            $email = $row['email_address'];
                                                        }
                                                        ?>
                                                        <?php
                                                        echo '  
                                                            <tr>                                                            
                                                            <td>' . $companyObject->getCompnayNameById($companyID) . '</td>                                                          
                                                            <td>' . $row['user_type'] . '</td>                                                            
                                                            <td>' . $fname." ".$lname. '</td>                                                           
                                                            <td>' . $email . '</td>                                                                                                               
                                                            <td><a href=' . "edit-user?id=" . $id . '>Edit</a></td>
                                                            <td><a href=' . "delete-user?id=" . $id . '>Delete</a></td>      
                                                        </tr>  
                                                        ';
                                                        ?>
                                                        <?php
                                                    }
                                                    ?>
                                            </table>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->

                            </div><!-- /.col -->
                        </div><!-- /.row -->
                </section><!-- /.content -->
            </div>
            <?php include '../footer/footer.php'; ?>
            <div class="control-sidebar-bg"></div>
        </div>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

        <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../dist/js/demo.js"></script>

        <script>
            $(document).ready(function () {
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
