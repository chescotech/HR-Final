<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Other Information</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <?php include '../navigation_panel/authenticated_user_header.php'; ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <?php
        $user_id = $_SESSION['job_user_id'];
        if (isset($_POST['update'])) {

            $location = $_POST['location'];
            $lang1 = $_POST['lang1'];
            $lang2 = $_POST['lang2'];
            $lang3 = $_POST['lang3'];
            $marital_status = $_POST['marital_status'];
            $disabilities = $_POST['disabilities'];
            $memberships = $_POST['memberships'];
            $awards = $_POST['awards'];
            $links = $_POST['links'];

            $salary = $_POST['salary'];
            $currency = $_POST['currency'];
            $expected_benefits = $_POST['expected_benefits'];
            $can_relocate = $_POST['can_relocate'];
            $can_travel = $_POST['can_travel'];
            $notice_period = $_POST['notice_period'];


            mysqli_query($link, "UPDATE `jobs_user_info` SET `location`='$location',`lang1`='$lang1',`lang2`='$lang2',`lang3`='$lang3',
                    `marital_status`='$marital_status',`disabilities`='$disabilities',`memberships`='$memberships',
                    `awards`='$awards',`links`='$links',
                    `salary` = '$salary', `currency`='$currency',`expected_benefits` = '$expected_benefits',
                    `can_relocate`='$can_relocate', `can_travel`='$can_travel',`notice_period`='$notice_period'
                     WHERE user_id = '$user_id' 
                ") or die("Error 101: " . mysqli_error($link));

            $stateMessage = "Employee information Successully updated !!";
        }
        ?>

        <div class="content-wrapper">

            <section class="content">

                <div class="row container">

                    <div class="col-md-8">
                        <div class="nav-tabs-custom">
                            <div class="tab-content">
                                <?php
                                if (isset($_POST['update'])) {
                                    // return var_dump($_FILES["img"]["name"]);
                                }
                                ?>
                                <?php
                                $empQuery = mysqli_query($link, "SELECT * FROM jobs_user_info where user_id='$user_id' ") or die(mysqli_error($link));

                                while ($rows = mysqli_fetch_array($empQuery)) {
                                ?>
                                    <form enctype="multipart/form-data" method="post">
                                        <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <center>
                                                    <?php
                                                    if (isset($_POST['update'])) {
                                                        echo ' <center>
                                                                <h3 style="color: green" class="box-title"><b>' . $stateMessage . '</b></h3>
                                                                </center>';
                                                    } else {
                                                        echo ' <center>
                                                                <h3 class="box-title"><b>Other Information</b></h3>
                                                                </center>';
                                                    }
                                                    ?>
                                                </center>
                                            </div>

                                            <div class="form-group has-feedback">
                                                <label class="">Current Location</label>
                                                <input name="location" type="text" value="<?php echo $rows['location'] ?>" class="form-control">
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">First Language</label>
                                                <input name="lang1" type="text" value="<?php echo $rows['lang1'] ?>" class="form-control">
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">Second Language</label>
                                                <input name="lang2" type="text" value="<?php echo $rows['lang2'] ?>" class="form-control">
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">Other Languages</label>
                                                <input name="lang3" type="text" value="<?php echo $rows['lang3'] ?>" class="form-control">
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">Marital Status</label>
                                                <select name="marital_status" class="form-control">
                                                    <option value="<?php echo $rows['marital_status'] ?>"> <?php echo $rows['marital_status'] ?> </option>
                                                    <option value="Married">Married</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Widowed">Widowed</option>
                                                </select>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">Impaired/Disabled? (Leave Blank If Not)</label>
                                                <input name="disabilities" type="text" value="<?php echo $rows['disabilities'] ?>" placeholder="Please specify if Yes" class="form-control">
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">Professional Memberships (Include Membership No.)</label>
                                                <textarea name="memberships" class="form-control" cols="30" rows="3"><?php echo $rows['memberships'] ?></textarea>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">Professional Awards / Achievements</label>
                                                <textarea name="awards" class="form-control" cols="30" rows="3"><?php echo $rows['awards'] ?></textarea>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class=""> Journals/Research Papers/ Newspaper Articles (Add link or title) </label>
                                                <textarea name="links" class="form-control" cols="30" rows="3"><?php echo $rows['links'] ?></textarea>
                                            </div>

                                            <br>
                                            <h3>If Currently in employment, enter your current info bellow </h3>
                                            <br>

                                            <div class="form-group has-feedback">
                                                <label class="">Salary</label>
                                                <input name="salary" type="text" value="<?php echo $rows['salary'] ?>" placeholder="" class="form-control">
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">Currency</label>
                                                <input name="currency" type="text" value="<?php echo $rows['currency'] ?>" placeholder="ZMK | USD etc" class="form-control">
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">Expected Benefits</label>
                                                <input name="expected_benefits" type="text" value="<?php echo $rows['expected_benefits'] ?>" class="form-control">
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">Notice Period</label>
                                                <input name="notice_period" type="text" value="<?php echo $rows['notice_period'] ?>" class="form-control">
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">Are You Willing To Relocate</label>
                                                <select name="can_relocate" class="form-control">
                                                    <option value="<?php echo $rows['can_relocate'] ?>"><?php echo $rows['can_relocate'] ?></option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="form-group has-feedback">
                                                <label class="">Are You Willing To Travel</label>
                                                <select name="can_travel" class="form-control">
                                                    <option value="<?php echo $rows['can_travel'] ?>"><?php echo $rows['can_travel'] ?></option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>

                                            <div class="box-footer">
                                                <div class="pull-right">
                                                    <button name="update" type="submit" class="btn btn-primary"></i>Update</button>
                                                </div>
                                                <button onclick="window.history.back();" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
                                            </div>
                                        </div>
                                    </form>

                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>

        <?php include '../footer/footer.php'; ?>

    </div>

    <script src="../plugins/jQuery/jQuery-2.1.4.min.js"></script>

    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <script src="../plugins/fastclick/fastclick.min.js"></script>

    <script src="../dist/js/app.min.js"></script>

    <script src="../dist/js/demo.js"></script>

</body>

</html>