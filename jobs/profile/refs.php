<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Applicant's Experience </title>
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

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    <?php
                    echo " Appicant's Experience";
                    ?>
                </h1>
            </section>

            <?php
            $user_id = $_SESSION['job_user_id'];
            if (isset($_POST['add_'])) {
                $name = mysql_real_escape_string($_POST['name']);
                $gender = mysql_real_escape_string($_POST['gender']);
                $company = mysql_real_escape_string($_POST['company']);
                $position = mysql_real_escape_string($_POST['position']);
                $country = mysql_real_escape_string($_POST['country']);
                $province = mysql_real_escape_string($_POST['province']);
                $town = mysql_real_escape_string($_POST['town']);
                $phone = mysql_real_escape_string($_POST['phone']);
                $email = mysql_real_escape_string($_POST['email']);
                $address = mysql_real_escape_string($_POST['address']);


                $add_q = mysql_query("INSERT INTO jobs_user_refs (name, gender, company, position, country, province,
                                        town, phone, email, address,user_id)
                                    VALUES('$name','$gender','$company','$position','$country','$province','$town','$phone',
                                        '$email','$address','$user_id')") or die("Error: ".mysql_error());

                if ($add_q) {
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location='refs' </script>";
                }
            }
            if (isset($_POST['update'])) {
                $employer = $_POST['employer'];
                $comp_name = $_POST['comp_name'];
                $phone = $_POST['phone'];
                $position = $_POST['position'];
                $starts = $_POST['starts'];
                $ends = $_POST['ends'];
                $reasons_for_leavng = $_POST['reasons_for_leavng'];
                $duties = $_POST['duties'];
                $achievement = $_POST['achievement'];
                $id = $_POST['id'];

                $add_q = mysql_query("UPDATE jobs_user_refs SET school = '$school', qualification = '$qualification',
                                            award='$award', starts = '$starts', ends = '$ends'
                                    WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Updated Successfuly') </script>";
                    echo "<script> window.location='refs' </script>";
                }
            }
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];

                $add_q = mysql_query("DELETE FROM jobs_user_refs WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Deleted Successfuly') </script>";
                    echo "<script> window.location='refs' </script>";
                }
            }
            ?>

            <section class="content container">
                <div class="row center">

                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Add New Reference </h3>
                            </div>
                            <div class="box-body">
                                <!-- Date range -->

                                <form method="post" action="#add_skill" enctype="multipart/form-data">

                                    <div class="form-group ">
                                        <label class="">Name</label>
                                        <input type="text" class="form-control pull-right" name="name" placeholder="" required>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Gender</label>
                                        <select name="gender" class="form-control pull-right" >
                                            <option value="">Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Company</label>
                                        <input type="text" class="form-control pull-right" name="company" placeholder="" required>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Position</label>
                                        <input type="text" class="form-control pull-right" name="position" placeholder="" required>
                                    </div>

                                    <div class="form-group ">
                                        <label class="">Country</label>
                                        <input type="text" class="form-control pull-right" name="country" placeholder="" required>

                                    </div>
                                    <div class="form-group ">
                                        <label class="">Province</label>
                                        <input type="text" class="form-control pull-right" name="province" placeholder="" required>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Town</label>
                                        <input type="text" class="form-control pull-right" name="town" placeholder="" required>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Contact Number</label>
                                        <input type="text" class="form-control pull-right" name="phone" placeholder="" required>
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Email</label>
                                        <input type="email" class="form-control pull-right" name="email" placeholder="" required>
                                    </div>

                                    <div class="form-group ">
                                        <label class="">Address</label>
                                        <input type="text" class="form-control pull-right" name="address" placeholder="" required>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <button class="btn btn-primary" id="daterange-btn" name="add_">
                                                Save
                                            </button>
                                            <button class="btn" id="daterange-btn">
                                                Clear
                                            </button>
                                        </div>
                                    </div><!-- /.form group -->
                                </form>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>

                    <div class="col-xs-9 col-md-8 ">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">My References </h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Company</th>
                                            <th>Position</th>
                                           
                                            <th>Town</th>
                                            
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysql_query("SELECT * FROM jobs_user_refs WHERE user_id = '$user_id' ") or die(mysql_error());
                                        while ($row = mysql_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['gender']; ?></td>
                                                <td><?php echo $row['company']; ?></td>
                                                <td><?php echo $row['position']; ?></td>
                                                
                                                <td><?php echo $row['town']; ?></td>
                                                <td><?php echo $row['phone']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['address']; ?></td>
                                                <td>
                                                    <!-- <a href="#updateordinance<?php echo $row['id']; ?>" data-target="#updateordinance<?php echo $row['id']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-primary btn-sm">Edit</i></a> -->
                                                
                                                    <a href="#delete<?php echo $row['id']; ?>" data-target="#delete<?php echo $row['id']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-danger btn-sm">Delete</a>
                                                </td>
                                            </tr>
                                            <div id="updateordinance<?php echo $row['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content" style="height:auto">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span></button>
                                                            <h4 class="modal-title">Update Skill</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="form-horizontal" method="post" action="#update" enctype='multipart/form-data'>


                                                                <div class="form-group ">
                                                                    <label class="">Institution</label>
                                                                    <input type="text" class="form-control pull-right" name="school" value="<?php echo $row['school']; ?>" required>

                                                                </div>
                                                                <div class="form-group ">
                                                                    <label class="">Qualification</label>
                                                                    <input type="text" class="form-control pull-right" name="qualification" value="<?php echo $row['qualification']; ?>" required>

                                                                </div>

                                                                <div class="form-group ">
                                                                    <label class="">Award</label>
                                                                    <input type="text" class="form-control pull-right" name="award" value="<?php echo $row['award']; ?>" required>

                                                                </div>

                                                                <div class="form-group ">
                                                                    <label class="">Date Started</label>
                                                                    <input type="date" class="form-control pull-right" name="starts" value="<?php echo $row['starts']; ?>" required>
                                                                </div>

                                                                <div class="form-group ">
                                                                    <label class="">Date Finished</label>
                                                                    <input type="date" class="form-control pull-right" name="ends" value="<?php echo $row['ends']; ?>" required>
                                                                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                </div>


                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" name="update">Save changes</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                        </form>
                                                    </div>

                                                </div>
                                                <!--end of modal-dialog-->
                                            </div>

                                            <div id="delete<?php echo $row['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content" style="height:auto">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span></button>
                                                            <h4 class="modal-title">Are u sure you want to delete this field ??
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body" hidden="">
                                                            <form class="form-horizontal" method="post" action="#delete" enctype='multipart/form-data'>
                                                                <div class="form-group">
                                                                    <div class="col-lg-9"><input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                        <input type="text" class="form-control" id="name" name="id" value="<?php echo $row['id']; ?>" required>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <hr>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" name="delete">Delete</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                        </form>
                                                    </div>

                                                </div>
                                                <!--end of modal-dialog-->
                                            </div>

                                            <!--end of modal-->
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div><!-- /.box-body -->

                        </div>
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
            $('#employee_data').DataTable();
        });
    </script>
</body>

</html>