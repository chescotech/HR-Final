<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Band Rates</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
    <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include_once '../Classes/Tax.php';
        include '../navigation_panel/authenticated_user_header.php';
        $companyId = $_SESSION['company_ID'];
        $TaxObject = new Tax();
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        if (isset($_POST['save'])) {

            $message = "";
            $band_top1 = $_POST['band_top1'];
            $band_top2 = $_POST['band_top2'];
            $band_top3 = $_POST['band_top3'];
            $band_rate1 = $_POST['band_rate1'];
            $band_rate2 = $_POST['band_rate2'];
            $band_rate3 = $_POST['band_rate3'];
            $band_rate4 = $_POST['band_rate4'];
            $napsa_ceiling = $_POST['napsa_ceiling'];

            // validate numbers ..

            if ($TaxObject->checkIfTaxExsists($companyId) != "true") {
                if (
                    is_numeric($band_top1) && is_numeric($band_top2) &&
                    is_numeric($band_top3) && is_numeric($band_rate1) && is_numeric($band_rate2) && is_numeric($band_rate3) && is_numeric($band_rate4)
                ) {
                    $TaxObject->addtaxBand($band_top1, $band_top2, $band_top3, $band_rate1, $band_rate2, $band_rate3, $band_rate4, $companyId);
                    $message = "records Inserted sucessfully";
                } else {
                    $message = "Error, Only numbers accepted for input!!";
                }
            } else {
                if (
                    is_numeric($band_top1) && is_numeric($band_top2) &&
                    is_numeric($band_top3) && is_numeric($band_rate1) && is_numeric($band_rate2) && is_numeric($band_rate3) && is_numeric($band_rate4)
                ) {
                    $TaxObject->updateTaxBand($band_top1, $band_top2, $band_top3, $band_rate1, $band_rate2, $band_rate3, $band_rate4, $companyId, $napsa_ceiling);
                    $message = "records Updated sucessfully";
                } else {
                    $message = "Error, Only numbers accepted for input!!";
                }
            }
        ?>

        <?php
        }
        ?>

        <div class="content-wrapper">
            <section class="content-header">
            </section>
            <section class="content">
                <div class="row">
                    <?php include 'menu.php'; ?>
                    <div class="col-md-5">

                        <?php
                        $rows = mysql_fetch_array($TaxObject->getTaxDetails($companyId));
                        ?>

                        <form enctype="multipart/form-data" method="post">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <?php
                                    if (isset($_POST['save'])) {

                                        if ($message == "records Inserted sucessfully" || $message == "records Updated sucessfully") {
                                            echo ' <center>
                                            <h3 style="color: green" class="box-title"><b>' . $message . '</b></h3>
                                        </center>';
                                        } else {
                                            echo ' <center>
                                            <h3 style="color: red" class="box-title"><b>' . $message . '</b></h3>
                                        </center>';
                                        }
                                    } else {
                                        echo ' <center>
                                            <h3 style="color: black" class="box-title"><b>Your Tax Settings</b></h3>
                                        </center>';
                                    }
                                    ?>
                                </div>
                                <div class="box-body">
                                    <div class="form-group">
                                        <h5 style="color: black"><b>Top Band 1</b></h5>
                                        <input required="required" value="<?php echo $rows['band_top1']; ?>" name="band_top1" class="form-control" placeholder="Enter Top Band One :">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Top Band 2</b></h5>
                                        <input required="required" value="<?php echo $rows['band_top2']; ?>" name="band_top2" class="form-control" placeholder="Enter Top Band Two:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Top Band 3</b></h5>
                                        <input required="required" value="<?php echo $rows['band_top3']; ?>" name="band_top3" class="form-control" placeholder="Enter Top Band Three:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Band Rate One</b></h5>
                                        <input required="required" value="<?php echo $rows['band_rate1']; ?>" name="band_rate1" class="form-control" placeholder="Enter Band Rate One:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Band Rate Two</b></h5>
                                        <input required="required" value="<?php echo $rows['band_rate2']; ?>" name="band_rate2" class="form-control" placeholder="Enter Band Rate Two:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Band Rate Three</b></h5>
                                        <input required="required" value="<?php echo $rows['band_rate3']; ?>" name="band_rate3" class="form-control" placeholder="Enter Band Rate Three:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>Band Rate Four</b></h5>
                                        <input required="required" value="<?php echo $rows['band_rate4']; ?>" name="band_rate4" class="form-control" placeholder="Enter Band Rate Four:">
                                    </div>

                                    <div class="form-group">
                                        <h5 style="color: black"><b>NAPSA Ceiling</b></h5>
                                        <input required="required" value="<?php echo $rows['napsa_ceiling']; ?>" name="napsa_ceiling" class="form-control" placeholder="Enter Band Rate Four:">
                                    </div>

                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button>
                                        <button name="save" type="submit" class="btn btn-primary"></i>Save</button>
                                    </div>
                                    <button class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                </div>
                            </div>
                        </form>

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>

        <div class="control-sidebar-bg"></div>
    </div>

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>

</body>

</html>
<?php
