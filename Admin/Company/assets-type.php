<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Manage Assets</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
</head>



<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php
        include_once '../Classes/Asset.php';
        $AssetObject = new Asset();
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    $compID = $_SESSION['company_ID'];
                    echo $_SESSION['name'] . ' Asset Management';
                    $method_nam = '';
                    ?>
                </h1>
            </section>

            <section class="content container">
                <div class="box box-success col-md-7">
                    <h3>
                        Asset types
                    </h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Count</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $assetTypes = $AssetObject->getAssetTypes($companyId);

                            while ($row = mysqli_fetch_assoc($assetTypes)) {
                            ?>
                                <tr>
                                    <td>
                                        <?= $row['id']; ?>
                                    </td>
                                    <td>
                                        <?= $row['name'] ?>
                                    </td>
                                    <td>
                                        <?php $count = $AssetObject->getAssetsInTypeCount($row['id']);
                                        echo $count; ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" data-toggle="modal" data-target="#editAssetTypeModal<?= $row['id']; ?>">
                                            <i class="fa fa-edit"></i> Edit
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="editAssetTypeModal<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editAssetTypeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editAssetTypeModalLabel">Add Asset</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="name">Name</label>
                                                                <input type="text" name="name" id="name" class="form-control" value="<?= $row['name']; ?>">
                                                            </div>

                                                            <input type="hidden" name="id" id="input" class="form-control" value="<?= $row['id']; ?>">

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary" name="update_type">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete -->
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteAssetTypeModal<?= $row['id']; ?>">
                                            <i class="fa fa-trash"></i> Delete
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteAssetTypeModal<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteAssetTypeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteAssetTypeModalLabel">Add Asset</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-danger">
                                                                NOTE: Deleting an asset type will delete <strong>all</strong> assets of that type.
                                                                <br /> <br />
                                                                Are you sure that you want to proceed with this action?
                                                            </div>
                                                        </div>

                                                        <input type="hidden" name="id" id="input" class="form-control" value="<?= $row['id'] ?>">

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-danger" name="delete_type">Confirm</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="box box-success col-md-4">
                    <h3>
                        New Asset Type
                    </h3>
                    <form action="" method="post" class="form-group">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" placeholder="Asset Type">
                        </div>
                        <input type="hidden" name="company_id" value="<?= $companyId ?>">
                        <button type="submit" name="save_type" class="btn btn-success">Save</button>
                    </form>
                </div>
            </section>

        </div>
        <?php include '../footer/footer.php'; ?>
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
            // Initial state
            $("#fixed_amount_emp").prop("disabled", false);
            $("#fixed_amount_comp").prop("disabled", false);
            $("#numerator_comp").prop("disabled", false);
            $("#denominator_comp").prop("disabled", false);
            $("#numerator_emp").prop("disabled", false);
            $("#denominator_emp").prop("disabled", false);

            // Checkbox event handlers
            $("#fixed").on("change", function() {
                if ($(this).is(":checked")) {
                    $("#numerator_emp").prop("disabled", true);
                    $("#denominator_emp").prop("disabled", true);
                    $("#numerator_comp").prop("disabled", true);
                    $("#denominator_comp").prop("disabled", true);
                } else {
                    $("#numerator_comp").prop("disabled", false);
                    $("#denominator_comp").prop("disabled", false);
                    $("#numerator_emp").prop("disabled", false);
                    $("#denominator_emp").prop("disabled", false);
                }
            });
            //  calculated, disable fixed fields
            $("#calculated").on("change", function() {
                if ($(this).is(":checked")) {
                    $("#fixed_amount_comp").prop("disabled", true);
                    $("#fixed_amount_emp").prop("disabled", true);
                } else {
                    $("#fixed_amount_comp").prop("disabled", false);
                    $("#fixed_amount_emp").prop("disabled", false);
                }
            });
        });
    </script>
</body>


<?php
if (isset($_POST['save_type'])) {
    $name = $_POST['name'];
    $company = $_POST['company_id'];

    $saveResult = $AssetObject->saveNewAssetType($name, $company);

    if (!$saveResult) {
        echo '<script> alert("Failed to save new asset type.")</script>';
    }

    echo '<script>window.location = "assets-type.php"</script>';
} else if (isset($_POST['update_type'])) {
    $name = $_POST['name'];
    $id = $_POST['id'];

    $updateResult = $AssetObject->updateAssetType($name, $id);

    if (!$updateResult) {
        echo '<script> alert("Failed to update new asset type.")</script>';
    }

    echo '<script>window.location = "assets-type.php"</script>';
} else if (isset($_POST['delete_type'])) {
    $id = $_POST['id'];

    $deleteResult = $AssetObject->deleteAssetType($id);

    if (!$deleteResult) {
        echo '<script> alert("Failed to save new asset type.")</script>';
    }

    echo '<script>window.location = "assets-type.php"</script>';
}
?>

</html>