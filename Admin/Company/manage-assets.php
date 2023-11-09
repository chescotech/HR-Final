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

<?php
include_once '../Classes/Asset.php';
include_once '../Classes/Employee.php';
$EmployeeObject = new Employee();
$AssetObject = new Asset();
?>

<?php
if (isset($_POST['save_asset'])) {
    // return var_dump($_POST);
    $admin_id = $_SESSION['user_session'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $identifier = $_POST['identifier'];
    $type_id = $_POST['asset_type'];
    $company_id = $_POST['company_id'];

    $result = $AssetObject->saveAsset($admin_id, $name, $description, $identifier, $type_id, $company_id);

    if (!$result) {
        echo '<script>alert("Something went wrong. Please try again.")</script>';
    }

    echo '<script>window.location = "manage-assets.php"</script>';
}
?>
<?php
if (isset($_POST['assign'])) {
    $emp_id = $_POST['emp_select'];
    $asset_id = $_POST['asset_id'];
    $admin_id = $_SESSION['user_session'];
    $company_id = $_POST['company_id'];

    $result = $AssetObject->assignAsset($emp_id, $asset_id, $admin_id, $company_id);

    if (!$result) {
        echo '<script>alert("Something went wrong. Please try again.")</script>';
    }

    echo '<script>window.location = "manage-assets.php"</script>';
}
?>

<?php
if (isset($_POST['delete'])) {
    $asset_id = $_POST['asset_id'];
    $admin_id = $_SESSION['user_session'];
    $company_id = $_POST['company_id'];

    $result = $AssetObject->deleteAsset($admin_id, $company_id, $asset_id);

    if (!$result) {
        echo '<script>alert("Something went wrong. Please try again.")</script>';
    }

    echo '<script>window.location = "manage-assets.php"</script>';
}
?>

<?php
if (isset($_POST['return'])) {
    $asset_id = $_POST['asset_id'];
    $comments = $_POST['comments'];
    $admin_id = $_SESSION['user_session'];
    $company_id = $_POST['company_id'];

    $result = $AssetObject->returnAsset($admin_id, $asset_id, $comments, $company_id);

    if (!$result) {
        echo '<script>alert("Something went wrong. Please try again.")</script>';
    }

    echo '<script>window.location = "manage-assets.php"</script>';
}
?>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
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
                <div class="row">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAssetModal">
                        <i class="fa fa-plus"></i> Add Asset
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="addAssetModal" tabindex="-1" role="dialog" aria-labelledby="addAssetModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="" method="post">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addAssetModalLabel">Add Asset</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input type="text" id="name" class="form-control" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="identifier">Unique Identifier</label>
                                                <input id="identifier" type="text" class="form-control" name="identifier" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="asset_type" class="form-label">Asset Type</label>
                                                <select name="asset_type" class="form-control" id="asset_type" required>
                                                    <option value="" style="text-transform: capitalize;">--- Select an Asset Type ---</option>
                                                    <?php
                                                    $assetClasses = $AssetObject->getAssetTypes($companyId);

                                                    while ($row = mysqli_fetch_assoc($assetClasses)) {
                                                    ?>
                                                        <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                                                    <?php

                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <input type="hidden" name="company_id" value="<?= $companyId ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Description</label>
                                            <textarea class="form-control" name="description"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="save_asset">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-success row col-md-12">
                    <table class="table table-bordered" style="margin-top: 2rem; background-color: white;">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Identifier</th>
                                <th scope="col">Type</th>
                                <th scope="col">Assigned To</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $assets = $AssetObject->getAssets($companyId);

                            while ($row = mysqli_fetch_assoc($assets)) {
                            ?>
                                <tr>
                                    <td>
                                        <?= $row['id']; ?>
                                    </td>
                                    <td>
                                        <?= $row['name'] ?>
                                    </td>
                                    <td>
                                        <?= $row['description'] ?>
                                    </td>
                                    <td>
                                        <?= $row['identifier'] ?>
                                    </td>
                                    <td>
                                        <?php
                                        $typeResult = $AssetObject->getAssetTypeById($row['type_id']);

                                        echo $typeResult['name'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($row['assigned_to'])) {
                                            $empResult = $EmployeeObject->getEmployeeProfileByEmpNo($row['assigned_to']);

                                            $employee = mysqli_fetch_assoc($empResult);

                                            echo $employee['fname'] . " " . $employee['lname'];
                                            echo '
                                                <button class="btn btn-danger" style="float: right;" data-toggle="modal" data-target="#returnAssetModal' . $row['id'] . '">Return</button>

                                                <div class="modal fade" id="returnAssetModal' . $row['id'] . '" tabindex="-1" role="dialog" aria-labelledby="returnAssetModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <form method="post" action="">
                                                                <div class="modal-header"
                                                                    <h5 class="modal-title" id="returnAssetModalLabel">Add Asset</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p class="alert alert-warning">Are you sure you want to return this asset?</p>

                                                                    <div class="form-group">
                                                                        <label htmlFor="comments">Comments</label>
                                                                        <textarea class="form-control" name="comments" id="comments" required></textarea>
                                                                    </div>
                                                                    <input type="hidden" name="company_id" value=" ' . $companyId  . ' ">
                                                                    <input type="hidden" name="asset_id" value=" ' . $row['id']  . ' ">
                                                                    </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-primary" name="return">Save</button>
                                                                </div>
                                                            </form>
                                                        </div
                                                    </div>
                                                </div>
                                            ';
                                        } else {
                                        ?>
                                            <button class="btn btn-success" data-toggle="modal" data-target="#assignEmployeeModal<?= $row['id']; ?>">
                                                <i class="fa fa-plus-circle"></i> Assign
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="assignEmployeeModal<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="assignEmployeeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <form action="" method="post">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="assignEmployeeModalLabel">Assign Asset</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <label for="emp_select">Select Employee</label>
                                                                    <select name="emp_select" class="form-control" id="emp_select" required>
                                                                        <option value="" style="text-transform: capitalize;">--- Select an Employee ---</option>
                                                                        <?php

                                                                        $employeesResult = $EmployeeObject->getAllEmployeesByCompany($companyId);
                                                                        while ($emps = mysqli_fetch_assoc($employeesResult)) {
                                                                        ?>
                                                                            <option value="<?= $emps['empno'] ?>">
                                                                                <?= $emps['empno']  . " " . $emps['lname']; ?>
                                                                            </option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <input type="hidden" name="asset_id" value="<?= $row['id']; ?>">
                                                                <input type="hidden" name="company_id" value="<?= $companyId ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" name="assign">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteAssetModal<?= $row['id']; ?>"><i class="fa fa-trash">Delete</i></button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteAssetModal<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="deleteAssetModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="" method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteAssetModalLabel">Delete Asset</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p class="alert alert-danger">Are you sure you want to delete this asset?</p>
                                                        </div>
                                                        <input type="hidden" name="asset_id" value="<?= $row['id']; ?>">
                                                        <input type="hidden" name="company_id" value="<?= $companyId ?>">

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
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
</body>

</html>