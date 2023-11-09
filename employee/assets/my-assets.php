<!DOCTYPE html>


<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My Assets</title>
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

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">
        <?php
        include '../navigation_panel/authenticated_user_header.php';

        include_once '../Classes/Asset.php';
        $AssetObject = new Asset();

        $EmployeeId = $_SESSION['employee_id'];
        $companyId = $_SESSION['company_ID'];
        $compId = $companyId;
        ?>
        <?php include '../navigation_panel/side_navigation_bar.php'; ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="row">

                    <div class="col-xs-15">
                        <div class="box-header with-border">
                            <center>
                                <h3 style="color: black" class="box-title"><b>Your Assigned Assets </b></h3>
                            </center>
                        </div>
                        <div class="form-group">
                        </div>
                        <div class="box">
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table id="employee_data" cellspacing="0" class="table table-bordered table-fixed">
                                        <thead>

                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Type</th>
                                                <th>Identifier</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $AssetsResult = $AssetObject->getMyAssets($EmployeeId);
                                            while ($row = mysqli_fetch_array($AssetsResult)) {
                                                // return var_dump($row);
                                                $id = $row['id'];
                                                $assetName = $row['name'];
                                                $assetDescription = $row['description'];
                                                $assetTypeId = $row['type_id'];
                                                $assetID = $row['identifier'];

                                                $assetType = $AssetObject->getAssetTypeById($assetTypeId)['name'];

                                                echo '  
                                                        <tr>  
                                                            <td>' . $id . '</td>  
                                                          
                                                            <td>' . $assetName . '</td>
                                                            <td>' . $assetDescription . '</td>
                                                            <td>' . $assetType . '</td>
                                                            <td>' . $assetID . '</td>
                                                        </tr>  

                                                        ';
                                            }
                                            ?>

                                    </table>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>

        <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

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