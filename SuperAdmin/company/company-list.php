
<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Company List</title>
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
                <!-- Logo -->
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
                    <?php include '../navigation_panel/side_navigation_bar.php'; ?>
                </section>
            </aside>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>  
                        Crystaline Technologies List of companies using HR & Payroll Software                                              
                    </h1>                   
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-4">
                            <form action="add-company">
                                <table  cellpadding=""  border="0" class="se">
                                    <tr>
                                        <td>
                                            <button  type="submit" id="save" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Add Company</button>
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
                                                        <th>Company Name</th>                                                                                            
                                                        <th>Physical Address</th>                                                            
                                                        <th>Phone Number</th>
                                                        <th>Email Address</th>
                                                        <th>Date Of Registration</th>
                                                        <th>Status</th>  
                                                        <th>Activate/Suspend</th> 
                                                        <th>Edit</th>
                                                        <th>Delete</th>      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $query = "SELECT * FROM company ";
                                                    $result = mysql_query($query, $link) or die(mysql_error());
                                                    while ($row = mysql_fetch_array($result)) {
                                                        $id = $row['company_ID'];
                                                        $datePrinted = strtoTime($row['date_registration']);
                                                        $datePrint = date('F d, Y', $datePrinted);
                                                        $Status = $row['status'];
                                                        if ($Status == "active") {
                                                            $companyStatus = '<span class="label label-success arrowed-in arrowed-in-right">' . $Status . '</span>';
                                                        } else if ($Status == "Suspended") {
                                                            $companyStatus = '<span class="label label-warning">' . $Status . '</span>';
                                                        }
                                                        if($Status =="active"){
                                                            $text = "Suspend";
                                                        }else{
                                                             $text = "activate";
                                                        }
                                                        $activeStatus = "";
                                                        ?>
                                                        <?php
                                                        echo '  
                                                            <tr>                                                            
                                                            <td>' . $row['name'] . '</td>                                                          
                                                            <td>' . $row['address'] . '</td>                                                            
                                                            <td>' . $row['phone'] . '</td>
                                                            <td>' . $row['email'] . '</td>
                                                            <td>' . $datePrint . '</td> 
                                                            <td>' . $companyStatus . '</td> 
                                                            <td><a href=' . "activate-suspend-company?id=".$id.'&status='.$text.' >'.$text.'</a></td>    
                                                            <td><a href=' . "edit-company?id=" . $id . '>Edit</a></td>
                                                            <td><a href=' . "delete-company?id=" . $id . '>Delete</a></td>         
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
