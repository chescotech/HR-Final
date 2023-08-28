<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Applicant's Skills </title>
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
                    echo " Appicant's Skills";
                    ?>
                </h1>
            </section>

            <?php
            $user_id = $_SESSION['job_user_id'];
            if (isset($_POST['add_skill'])) {
                $category = $_POST['category'];
                $name = $_POST['name'];
                $level = $_POST['level'];

                $add_q = mysql_query("INSERT INTO jobs_user_skills (category, name,level,user_id)
                        VALUES('$category', '$name','$level','$user_id')") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Added Successfuly') </script>";
                    echo "<script> window.location='skills' </script>";
                }
            }
            if (isset($_POST['update'])) {
                $category = $_POST['category'];
                $name = $_POST['name'];
                $level = $_POST['level'];

                $id = $_POST['id'];

                $add_q = mysql_query("UPDATE jobs_user_skills SET category = '$category', name = '$name',level='$level'
                        WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Updated Successfuly') </script>";
                    echo "<script> window.location='skills' </script>";
                }
            }
            if (isset($_POST['delete'])) {
                $id = $_POST['id'];

                $add_q = mysql_query("DELETE FROM jobs_user_skills WHERE id = '$id' ") or die(mysql_error());

                if ($add_q) {
                    echo "<script> alert('Deleted Successfuly') </script>";
                    echo "<script> window.location='skills' </script>";
                }
            }
            ?>

            <section class="content container">
                <div class="row center">

                    <div class="col-md-3">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">Add New Qualification</h3>
                            </div>
                            <div class="box-body">
                                <!-- Date range -->



                                <div class="card-body">
                                    <div id="ContentPlaceHolder1_UpdatePanel2">

                                        <div class="form-group row">

                                            <div class="col-md-4">
                                                <div class="row m-0 p-0">
                                                    <div class="col-md-8 m-0 p-0">
                                                        <span id="ContentPlaceHolder1_lblqalifiawagp" class="required">Quali./Award Grp:</span>
                                                    </div>
                                                    <div class="col-md-4 m-0 p-0 text-right">
                                                        <input id="ContentPlaceHolder1_chkqualificationgroup" type="checkbox" name="ctl00$ContentPlaceHolder1$chkqualificationgroup"><label for="ContentPlaceHolder1_chkqualificationgroup">Others</label>
                                                    </div>
                                                </div>

                                                <div class="row m-0 p-0">
                                                    <div class="col-md-12 m-0 p-0">
                                                        <div id="ContentPlaceHolder1_pnlQualficationGrp">

                                                            <div class="dropdown bootstrap-select form-control">
                                                                <select name="ctl00$ContentPlaceHolder1$ddlAwardgp" id="ContentPlaceHolder1_ddlAwardgp" class="selectpicker form-control" tabindex="null">
                                                                    <option selected="selected" value="0">Select</option>
                                                                    <option value="12">Advanced Certificate</option>
                                                                    <option value="13">Advanced Diploma</option>
                                                                    <option value="108">Associate Degree</option>
                                                                    <option value="17">Bachelors Degree</option>
                                                                    <option value="14">Certificate</option>
                                                                    <option value="16">Diploma</option>
                                                                    <option value="55">Doctorate Degree</option>
                                                                    <option value="19">Graduate Diploma</option>
                                                                    <option value="107">High School or Equivalent</option>
                                                                    <option value="20">Higher Diploma</option>
                                                                    <option value="25">Masters Degree</option>
                                                                    <option value="30">Post Graduate Diploma</option>
                                                                    <option value="31">Professional &amp; Technical Certification</option>

                                                                </select>
                                                               

                                                            <span id="ContentPlaceHolder1_lblAwardgpMsg" class="d-none">Please select qualification group.</span>

                                                        </div>


                                                    </div>
                                                </div>


                                            </div>

                                            <div class="col-md-4">
                                                <div class="row m-0 p-0">
                                                    <div class="col-md-8 m-0 p-0">
                                                        <span id="ContentPlaceHolder1_lblQuliAwrd" class="required">Quali./Award:</span>
                                                    </div>
                                                    <div class="col-md-4 m-0 p-0 text-right">
                                                        <input id="ContentPlaceHolder1_chkqualificationAward" type="checkbox" name="ctl00$ContentPlaceHolder1$chkqualificationAward"><label for="ContentPlaceHolder1_chkqualificationAward">Others</label>
                                                    </div>
                                                </div>

                                                <div class="row m-0 p-0">
                                                    <div class="col-md-12 m-0 p-0">
                                                        <div id="ContentPlaceHolder1_pnlQualficationAward">

                                                            <div class="dropdown bootstrap-select form-control">
                                                                <select name="ctl00$ContentPlaceHolder1$ddlAward" id="ContentPlaceHolder1_ddlAward" class="selectpicker form-control">
                                                                    <option selected="selected" value="0">Select</option>
                                                                    <option value="445">AAT - NVQ/SVQ</option>
                                                                    <option value="448">ACCA PART 1 (Fundamentals)</option>
                                                                    <option value="449">ACCA PART 2 (Intermediate)</option>
                                                                    <option value="450">ACCA PART 3 (Professional)</option>
                                                                    <option value="467">Agricultural Sciences</option>
                                                                    <option value="483">Agricultural Sciences</option>
                                                                    <option value="499">Agricultural Sciences</option>
                                                                    <option value="517">Agricultural Sciences</option>
                                                                    <option value="535">Agricultural Sciences</option>
                                                                    <option value="553">Agricultural Sciences</option>
                                                                    <option value="571">Agricultural Sciences</option>
                                                                    <option value="589">Agricultural Sciences</option>
                                                                    <option value="607">Agricultural Sciences</option>
                                                                    <option value="625">Agricultural Sciences</option>
                                                                    <option value="648">Agricultural Sciences</option>
                                                                    <option value="646">Arts</option>
                                                                    <option value="515">Arts</option>
                                                                    <option value="533">Arts</option>
                                                                    <option value="551">Arts</option>
                                                                    <option value="569">Arts</option>
                                                                    <option value="587">Arts</option>
                                                                    <option value="605">Arts</option>
                                                                    <option value="623">Arts</option>
                                                                    <option value="36">Arts</option>
                                                                    <option value="37">Arts</option>
                                                                    <option value="468">Astronomy &amp; Physics</option>
                                                                    <option value="500">Astronomy &amp; Physics</option>
                                                                    <option value="484">Astronomy &amp; Physics</option>
                                                                    <option value="572">Astronomy &amp; Physics</option>
                                                                    <option value="554">Astronomy &amp; Physics</option>
                                                                    <option value="536">Astronomy &amp; Physics</option>
                                                                    <option value="518">Astronomy &amp; Physics</option>
                                                                    <option value="626">Astronomy &amp; Physics</option>
                                                                    <option value="608">Astronomy &amp; Physics</option>
                                                                    <option value="590">Astronomy &amp; Physics</option>
                                                                    <option value="649">Astronomy &amp; Physics</option>
                                                                    <option value="39">Automotive Engineering</option>
                                                                    <option value="668">BCI</option>
                                                                    <option value="650">Behavioral &amp; Social Sciences</option>
                                                                    <option value="591">Behavioral &amp; Social Sciences</option>
                                                                    <option value="609">Behavioral &amp; Social Sciences</option>
                                                                    <option value="627">Behavioral &amp; Social Sciences</option>
                                                                    <option value="519">Behavioral &amp; Social Sciences</option>
                                                                    <option value="537">Behavioral &amp; Social Sciences</option>
                                                                    <option value="555">Behavioral &amp; Social Sciences</option>
                                                                    <option value="573">Behavioral &amp; Social Sciences</option>
                                                                    <option value="485">Behavioral &amp; Social Sciences</option>
                                                                    <option value="501">Behavioral &amp; Social Sciences</option>
                                                                    <option value="469">Behavioral &amp; Social Sciences</option>
                                                                    <option value="470">Biological Sciences </option>
                                                                    <option value="502">Biological Sciences </option>
                                                                    <option value="486">Biological Sciences </option>
                                                                    <option value="574">Biological Sciences </option>
                                                                    <option value="556">Biological Sciences </option>
                                                                    <option value="538">Biological Sciences </option>
                                                                    <option value="520">Biological Sciences </option>
                                                                    <option value="628">Biological Sciences </option>
                                                                    <option value="610">Biological Sciences </option>
                                                                    <option value="592">Biological Sciences </option>
                                                                    <option value="651">Biological Sciences </option>
                                                                    <option value="61">Business Admin &amp; Management Studies</option>
                                                                    <option value="652">Business Related</option>
                                                                    <option value="593">Business Related</option>
                                                                    <option value="611">Business Related</option>
                                                                    <option value="629">Business Related</option>
                                                                    <option value="521">Business Related</option>
                                                                    <option value="539">Business Related</option>
                                                                    <option value="557">Business Related</option>
                                                                    <option value="575">Business Related</option>
                                                                    <option value="487">Business Related</option>
                                                                    <option value="503">Business Related</option>
                                                                    <option value="471">Business Related</option>
                                                                    <option value="462">CAT Level 1</option>
                                                                    <option value="451">CAT Level 2</option>
                                                                    <option value="463">CAT Level 3</option>
                                                                    <option value="452">CAT Level 4</option>
                                                                    <option value="472">Chemical Sciences</option>
                                                                    <option value="504">Chemical Sciences</option>
                                                                    <option value="488">Chemical Sciences</option>
                                                                    <option value="576">Chemical Sciences</option>
                                                                    <option value="558">Chemical Sciences</option>
                                                                    <option value="540">Chemical Sciences</option>
                                                                    <option value="522">Chemical Sciences</option>
                                                                    <option value="630">Chemical Sciences</option>
                                                                    <option value="612">Chemical Sciences</option>
                                                                    <option value="594">Chemical Sciences</option>
                                                                    <option value="653">Chemical Sciences</option>
                                                                    <option value="455">CIMA Certificate Level</option>
                                                                    <option value="456">CIMA Management Level</option>
                                                                    <option value="461">CIMA Operational Level</option>
                                                                    <option value="447">CIMA Strategic Level</option>
                                                                    <option value="665">CIPS</option>
                                                                    <option value="464">CISA Level 1</option>
                                                                    <option value="466">CISA Level 2</option>
                                                                    <option value="465">CISA Level 3</option>
                                                                    <option value="453">CISA Level 4</option>
                                                                    <option value="473">Communication (Journalism &amp; Media)</option>
                                                                    <option value="489">Communication (Journalism &amp; Media)</option>
                                                                    <option value="505">Communication (Journalism &amp; Media)</option>
                                                                    <option value="523">Communication (Journalism &amp; Media)</option>
                                                                    <option value="541">Communication (Journalism &amp; Media)</option>
                                                                    <option value="559">Communication (Journalism &amp; Media)</option>
                                                                    <option value="577">Communication (Journalism &amp; Media)</option>
                                                                    <option value="654">Communication (Journalism &amp; Media)</option>
                                                                    <option value="631">Communication (Journalism &amp; Media)</option>
                                                                    <option value="595">Communication (Journalism &amp; Media)</option>
                                                                    <option value="613">Communication (Journalism &amp; Media)</option>
                                                                    <option value="614">Computer &amp; ICT Related</option>
                                                                    <option value="596">Computer &amp; ICT Related</option>
                                                                    <option value="632">Computer &amp; ICT Related</option>
                                                                    <option value="655">Computer &amp; ICT Related</option>
                                                                    <option value="578">Computer &amp; ICT Related</option>
                                                                    <option value="560">Computer &amp; ICT Related</option>
                                                                    <option value="542">Computer &amp; ICT Related</option>
                                                                    <option value="524">Computer &amp; ICT Related</option>
                                                                    <option value="506">Computer &amp; ICT Related</option>
                                                                    <option value="490">Computer &amp; ICT Related</option>
                                                                    <option value="474">Computer &amp; ICT Related</option>
                                                                    <option value="130">Computer Science</option>
                                                                    <option value="666">Computer Science or Equivalent Degree</option>
                                                                    <option value="667">CRISC</option>
                                                                    <option value="656">Earth &amp; Environmental Sciences</option>
                                                                    <option value="633">Earth &amp; Environmental Sciences</option>
                                                                    <option value="597">Earth &amp; Environmental Sciences</option>
                                                                    <option value="615">Earth &amp; Environmental Sciences</option>
                                                                    <option value="475">Earth &amp; Environmental Sciences</option>
                                                                    <option value="491">Earth &amp; Environmental Sciences</option>
                                                                    <option value="507">Earth &amp; Environmental Sciences</option>
                                                                    <option value="525">Earth &amp; Environmental Sciences</option>
                                                                    <option value="543">Earth &amp; Environmental Sciences</option>
                                                                    <option value="561">Earth &amp; Environmental Sciences</option>
                                                                    <option value="579">Earth &amp; Environmental Sciences</option>
                                                                    <option value="182">Education</option>
                                                                    <option value="183">Education</option>
                                                                    <option value="516">Education</option>
                                                                    <option value="552">Education</option>
                                                                    <option value="534">Education</option>
                                                                    <option value="624">Education</option>
                                                                    <option value="606">Education</option>
                                                                    <option value="588">Education</option>
                                                                    <option value="570">Education</option>
                                                                    <option value="647">Education</option>
                                                                    <option value="641">Education</option>
                                                                    <option value="657">Engineering &amp; Technology</option>
                                                                    <option value="634">Engineering &amp; Technology</option>
                                                                    <option value="616">Engineering &amp; Technology</option>
                                                                    <option value="598">Engineering &amp; Technology</option>
                                                                    <option value="476">Engineering &amp; Technology</option>
                                                                    <option value="508">Engineering &amp; Technology</option>
                                                                    <option value="492">Engineering &amp; Technology</option>
                                                                    <option value="580">Engineering &amp; Technology</option>
                                                                    <option value="562">Engineering &amp; Technology</option>
                                                                    <option value="544">Engineering &amp; Technology</option>
                                                                    <option value="526">Engineering &amp; Technology</option>
                                                                    <option value="645">Grade 12</option>
                                                                    <option value="643">Grade 7</option>
                                                                    <option value="644">Grade 9</option>
                                                                    <option value="658">Language &amp; Literature</option>
                                                                    <option value="599">Language &amp; Literature</option>
                                                                    <option value="617">Language &amp; Literature</option>
                                                                    <option value="635">Language &amp; Literature</option>
                                                                    <option value="527">Language &amp; Literature</option>
                                                                    <option value="545">Language &amp; Literature</option>
                                                                    <option value="563">Language &amp; Literature</option>
                                                                    <option value="581">Language &amp; Literature</option>
                                                                    <option value="493">Language &amp; Literature</option>
                                                                    <option value="509">Language &amp; Literature</option>
                                                                    <option value="477">Language &amp; Literature</option>
                                                                    <option value="478">Law &amp; Political Sciences</option>
                                                                    <option value="510">Law &amp; Political Sciences</option>
                                                                    <option value="494">Law &amp; Political Sciences</option>
                                                                    <option value="582">Law &amp; Political Sciences</option>
                                                                    <option value="564">Law &amp; Political Sciences</option>
                                                                    <option value="546">Law &amp; Political Sciences</option>
                                                                    <option value="528">Law &amp; Political Sciences</option>
                                                                    <option value="636">Law &amp; Political Sciences</option>
                                                                    <option value="618">Law &amp; Political Sciences</option>
                                                                    <option value="600">Law &amp; Political Sciences</option>
                                                                    <option value="659">Law &amp; Political Sciences</option>
                                                                    <option value="660">Mathematics, Statistics &amp; Probability</option>
                                                                    <option value="601">Mathematics, Statistics &amp; Probability</option>
                                                                    <option value="619">Mathematics, Statistics &amp; Probability</option>
                                                                    <option value="637">Mathematics, Statistics &amp; Probability</option>
                                                                    <option value="529">Mathematics, Statistics &amp; Probability</option>
                                                                    <option value="547">Mathematics, Statistics &amp; Probability</option>
                                                                    <option value="565">Mathematics, Statistics &amp; Probability</option>
                                                                    <option value="583">Mathematics, Statistics &amp; Probability</option>
                                                                    <option value="495">Mathematics, Statistics &amp; Probability</option>
                                                                    <option value="511">Mathematics, Statistics &amp; Probability</option>
                                                                    <option value="479">Mathematics, Statistics &amp; Probability</option>
                                                                    <option value="480">Medical &amp; Health Sciences </option>
                                                                    <option value="512">Medical &amp; Health Sciences </option>
                                                                    <option value="496">Medical &amp; Health Sciences </option>
                                                                    <option value="584">Medical &amp; Health Sciences </option>
                                                                    <option value="566">Medical &amp; Health Sciences </option>
                                                                    <option value="548">Medical &amp; Health Sciences </option>
                                                                    <option value="530">Medical &amp; Health Sciences </option>
                                                                    <option value="638">Medical &amp; Health Sciences </option>
                                                                    <option value="620">Medical &amp; Health Sciences </option>
                                                                    <option value="602">Medical &amp; Health Sciences </option>
                                                                    <option value="661">Medical &amp; Health Sciences </option>
                                                                    <option value="669">Operations Research</option>
                                                                    <option value="662">Philosophy &amp; Religion</option>
                                                                    <option value="603">Philosophy &amp; Religion</option>
                                                                    <option value="621">Philosophy &amp; Religion</option>
                                                                    <option value="639">Philosophy &amp; Religion</option>
                                                                    <option value="531">Philosophy &amp; Religion</option>
                                                                    <option value="549">Philosophy &amp; Religion</option>
                                                                    <option value="567">Philosophy &amp; Religion</option>
                                                                    <option value="585">Philosophy &amp; Religion</option>
                                                                    <option value="497">Philosophy &amp; Religion</option>
                                                                    <option value="513">Philosophy &amp; Religion</option>
                                                                    <option value="481">Philosophy &amp; Religion</option>
                                                                    <option value="482">Physical Sciences</option>
                                                                    <option value="514">Physical Sciences</option>
                                                                    <option value="498">Physical Sciences</option>
                                                                    <option value="586">Physical Sciences</option>
                                                                    <option value="568">Physical Sciences</option>
                                                                    <option value="550">Physical Sciences</option>
                                                                    <option value="532">Physical Sciences</option>
                                                                    <option value="640">Physical Sciences</option>
                                                                    <option value="622">Physical Sciences</option>
                                                                    <option value="604">Physical Sciences</option>
                                                                    <option value="663">Physical Sciences</option>
                                                                    <option value="362">Public Administration</option>
                                                                    <option value="672">Public Administrationn</option>
                                                                    <option value="446">TOPCIMA</option>
                                                                    <option value="443">ZICA Licentiate Level</option>
                                                                    <option value="460">ZICA Professional Level</option>
                                                                    <option value="444">ZICA Technician Level</option>

                                                                </select>
                                                                <button type="button" tabindex="-1" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-2" aria-haspopup="listbox" aria-expanded="false" data-id="ContentPlaceHolder1_ddlAward" title="Select">
                                                                    <div class="filter-option">
                                                                        <div class="filter-option-inner">
                                                                            <div class="filter-option-inner-inner">Select</div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <div class="dropdown-menu ">
                                                                    <div class="bs-searchbox"><input type="search" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-2" aria-autocomplete="list"></div>
                                                                    <div class="inner show" role="listbox" id="bs-select-2" tabindex="-1">
                                                                        <ul class="dropdown-menu inner show" role="presentation"></ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <span id="ContentPlaceHolder1_lblAwardMsg" class="d-none">Please select qualification.</span>

                                                        </div>


                                                    </div>
                                                </div>


                                            </div>

                                            <div class="col-md-4">
                                                <div class="row m-0 p-0">
                                                    <div class="col-md-8 m-0 p-0">
                                                        <span id="ContentPlaceHolder1_lblResult">Result:</span>
                                                    </div>
                                                    <div class="col-md-4 m-0 p-0 text-right">
                                                        <input id="ContentPlaceHolder1_chkResultCode" type="checkbox" name="ctl00$ContentPlaceHolder1$chkResultCode"><label for="ContentPlaceHolder1_chkResultCode">Others</label>
                                                    </div>
                                                </div>

                                                <div class="row m-0 p-0">
                                                    <div class="col-md-12 m-0 p-0">
                                                        <div id="ContentPlaceHolder1_pnlResultCode">

                                                            <div class="dropdown bootstrap-select form-control"><select name="ctl00$ContentPlaceHolder1$ddlResultCode" id="ContentPlaceHolder1_ddlResultCode" class="selectpicker form-control">
                                                                    <option selected="selected" value="0">Select</option>
                                                                    <option value="6">Credit</option>
                                                                    <option value="5">Distinction</option>
                                                                    <option value="11">Failed</option>
                                                                    <option value="1">First Class</option>
                                                                    <option value="3">Lower Second Class</option>
                                                                    <option value="7">Merit</option>
                                                                    <option value="9">Not Graded</option>
                                                                    <option value="8">Ongoing/Incomplete</option>
                                                                    <option value="4">Pass</option>
                                                                    <option value="10">Satisfactory</option>
                                                                    <option value="2">Upper Second Class</option>

                                                                </select><button type="button" tabindex="-1" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-3" aria-haspopup="listbox" aria-expanded="false" data-id="ContentPlaceHolder1_ddlResultCode" title="Select">
                                                                    <div class="filter-option">
                                                                        <div class="filter-option-inner">
                                                                            <div class="filter-option-inner-inner">Select</div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                                <div class="dropdown-menu ">
                                                                    <div class="bs-searchbox"><input type="search" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-3" aria-autocomplete="list"></div>
                                                                    <div class="inner show" role="listbox" id="bs-select-3" tabindex="-1">
                                                                        <ul class="dropdown-menu inner show" role="presentation"></ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <span id="ContentPlaceHolder1_lblResultCodeMsg" class="d-none">Please select result.</span>

                                                        </div>


                                                    </div>
                                                </div>


                                            </div>

                                        </div>


                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <div id="ContentPlaceHolder1_UpdatePanel3">

                                                    <div class="row m-0 p-0">
                                                        <div class="col-md-12 m-0 p-0">
                                                            <div class="row m-0 p-0">
                                                                <div class="col-md-8 m-0 p-0">
                                                                    <span id="ContentPlaceHolder1_lblInstitute">Institution:</span>
                                                                </div>
                                                                <div class="col-md-4 m-0 p-0 text-right">
                                                                    <input id="ContentPlaceHolder1_chkInstitute" type="checkbox" name="ctl00$ContentPlaceHolder1$chkInstitute"><label for="ContentPlaceHolder1_chkInstitute">Others</label>
                                                                </div>
                                                            </div>
                                                            <div class="row m-0 p-0">
                                                                <div class="col-md-12 m-0 p-0">
                                                                    <div id="ContentPlaceHolder1_pnlInstitute">

                                                                        <div class="dropdown bootstrap-select form-control"><select name="ctl00$ContentPlaceHolder1$drpInstitute" id="ContentPlaceHolder1_drpInstitute" class="selectpicker form-control" tabindex="null">
                                                                                <option selected="selected" value="0">Select</option>
                                                                                <option value="43">Australia Institute of Business &amp; Technology</option>
                                                                                <option value="77">Baobab College</option>
                                                                                <option value="44">Chainama Hills College Hospital, Lusaka</option>
                                                                                <option value="45">Charles Lwanga College of Education, Monze</option>
                                                                                <option value="83">Chengelo School</option>
                                                                                <option value="46">Chipata College of Education</option>
                                                                                <option value="47">Copperbelt Teachers Training College</option>
                                                                                <option value="26">Copperstone University</option>
                                                                                <option value="87">DK</option>
                                                                                <option value="80">Don Gordon</option>
                                                                                <option value="50">Evelyn Hone College of Applied Arts &amp; Commerce</option>
                                                                                <option value="92">High School</option>
                                                                                <option value="88">Hill Crest</option>
                                                                                <option value="51">Institute of Social Sciences</option>
                                                                                <option value="52">Kasama College of Education</option>
                                                                                <option value="53">Katete Centre of Marketing &amp; Co-operatives</option>
                                                                                <option value="54">Kitwe Teachers Training College</option>
                                                                                <option value="55">Livingstone Institute of Business &amp; Engineering Studies</option>
                                                                                <option value="10">Lusaka Apex Medical University</option>
                                                                                <option value="56">Malcom Moffat College</option>
                                                                                <option value="57">Mansa College of Education</option>
                                                                                <option value="42">Mansfield University College</option>
                                                                                <option value="84">Matero Boys</option>
                                                                                <option value="85">Matero Girls</option>
                                                                                <option value="58">Mongu College of Education</option>
                                                                                <option value="82">Mpelembe Secondary School</option>
                                                                                <option value="59">Mufulira College of Education</option>
                                                                                <option value="60">National In Service Teachers College -Chalimbana</option>
                                                                                <option value="61">National Institute of Public Administration (NIPA)</option>
                                                                                <option value="62">Natural Resources Development (NRDC)</option>
                                                                                <option value="63">Nortech College</option>
                                                                                <option value="78">Other or Not Listed</option>
                                                                                <option value="86">Roma Girls</option>
                                                                                <option value="64">Royal Tropical Institution (KIT)</option>
                                                                                <option value="89">Secondary School</option>
                                                                                <option value="65">Solwezi College of Education</option>
                                                                                <option value="81">St. Pauls</option>
                                                                                <option value="79">The Copperbelt University</option>
                                                                                <option value="3">The Copperbelt University (CBU)</option>
                                                                                <option value="66">TVTC of Luanshya</option>
                                                                                <option value="67">Universita Palacky</option>
                                                                                <option value="4">University of Lusaka (UNILUS)</option>
                                                                                <option value="68">University of Oxford</option>
                                                                                <option value="91">University of Sunderland</option>
                                                                                <option value="2">University of Zambia (UNZA)</option>
                                                                                <option value="69">Zambia Air Services Training Institute</option>
                                                                                <option value="70">Zambia College of Agriculture(ZCA), Lusaka</option>
                                                                                <option value="71">Zambia College of Pensions &amp; Insurance Trust (ZCPIT), Lusaka &amp; Ndola</option>
                                                                                <option value="72">Zambia Institute of Business Studies &amp; Industrial Practice, Kitwe</option>
                                                                                <option value="73">Zambia Institute of Marketing</option>
                                                                                <option value="74">Zambia Instute of Special Education</option>
                                                                                <option value="75">Zampost Staff Training College</option>
                                                                                <option value="76">Zamtel Staff Training College</option>
                                                                                <option value="90">ZICA</option>

                                                                            </select><button type="button" tabindex="-1" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-4" aria-haspopup="listbox" aria-expanded="false" data-id="ContentPlaceHolder1_drpInstitute" title="Select">
                                                                                <div class="filter-option">
                                                                                    <div class="filter-option-inner">
                                                                                        <div class="filter-option-inner-inner">Select</div>
                                                                                    </div>
                                                                                </div>
                                                                            </button>
                                                                            <div class="dropdown-menu" style="max-height: 522.812px; overflow: hidden; min-height: 162px;">
                                                                                <div class="bs-searchbox"><input type="search" class="form-control" autocomplete="off" role="combobox" aria-label="Search" aria-controls="bs-select-4" aria-autocomplete="list" aria-activedescendant="bs-select-4-0"></div>
                                                                                <div class="inner show" role="listbox" id="bs-select-4" tabindex="-1" style="max-height: 458.812px; overflow-y: auto; min-height: 98px;">
                                                                                    <ul class="dropdown-menu inner show" role="presentation" style="margin-top: 0px; margin-bottom: 0px;">
                                                                                        <li class="selected active"><a role="option" class="dropdown-item active selected" id="bs-select-4-0" tabindex="0" aria-setsize="55" aria-posinset="1" aria-selected="true"><span class="text">Select</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-1" tabindex="0"><span class="text">Australia Institute of Business &amp; Technology</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-2" tabindex="0"><span class="text">Baobab College</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-3" tabindex="0"><span class="text">Chainama Hills College Hospital, Lusaka</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-4" tabindex="0"><span class="text">Charles Lwanga College of Education, Monze</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-5" tabindex="0"><span class="text">Chengelo School</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-6" tabindex="0"><span class="text">Chipata College of Education</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-7" tabindex="0"><span class="text">Copperbelt Teachers Training College</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-8" tabindex="0"><span class="text">Copperstone University</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-9" tabindex="0"><span class="text">DK</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-10" tabindex="0"><span class="text">Don Gordon</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-11" tabindex="0"><span class="text">Evelyn Hone College of Applied Arts &amp; Commerce</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-12" tabindex="0"><span class="text">High School</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-13" tabindex="0"><span class="text">Hill Crest</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-14" tabindex="0"><span class="text">Institute of Social Sciences</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-15" tabindex="0"><span class="text">Kasama College of Education</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-16" tabindex="0"><span class="text">Katete Centre of Marketing &amp; Co-operatives</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-17" tabindex="0"><span class="text">Kitwe Teachers Training College</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-18" tabindex="0"><span class="text">Livingstone Institute of Business &amp; Engineering Studies</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-19" tabindex="0"><span class="text">Lusaka Apex Medical University</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-20" tabindex="0"><span class="text">Malcom Moffat College</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-21" tabindex="0"><span class="text">Mansa College of Education</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-22" tabindex="0"><span class="text">Mansfield University College</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-23" tabindex="0"><span class="text">Matero Boys</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-24" tabindex="0"><span class="text">Matero Girls</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-25" tabindex="0"><span class="text">Mongu College of Education</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-26" tabindex="0"><span class="text">Mpelembe Secondary School</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-27" tabindex="0"><span class="text">Mufulira College of Education</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-28" tabindex="0"><span class="text">National In Service Teachers College -Chalimbana</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-29" tabindex="0"><span class="text">National Institute of Public Administration (NIPA)</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-30" tabindex="0"><span class="text">Natural Resources Development (NRDC)</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-31" tabindex="0"><span class="text">Nortech College</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-32" tabindex="0"><span class="text">Other or Not Listed</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-33" tabindex="0"><span class="text">Roma Girls</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-34" tabindex="0"><span class="text">Royal Tropical Institution (KIT)</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-35" tabindex="0"><span class="text">Secondary School</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-36" tabindex="0"><span class="text">Solwezi College of Education</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-37" tabindex="0"><span class="text">St. Pauls</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-38" tabindex="0"><span class="text">The Copperbelt University</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-39" tabindex="0"><span class="text">The Copperbelt University (CBU)</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-40" tabindex="0"><span class="text">TVTC of Luanshya</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-41" tabindex="0"><span class="text">Universita Palacky</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-42" tabindex="0"><span class="text">University of Lusaka (UNILUS)</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-43" tabindex="0"><span class="text">University of Oxford</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-44" tabindex="0"><span class="text">University of Sunderland</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-45" tabindex="0"><span class="text">University of Zambia (UNZA)</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-46" tabindex="0"><span class="text">Zambia Air Services Training Institute</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-47" tabindex="0"><span class="text">Zambia College of Agriculture(ZCA), Lusaka</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-48" tabindex="0"><span class="text">Zambia College of Pensions &amp; Insurance Trust (ZCPIT), Lusaka &amp; Ndola</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-49" tabindex="0"><span class="text">Zambia Institute of Business Studies &amp; Industrial Practice, Kitwe</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-50" tabindex="0"><span class="text">Zambia Institute of Marketing</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-51" tabindex="0"><span class="text">Zambia Instute of Special Education</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-52" tabindex="0"><span class="text">Zampost Staff Training College</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-53" tabindex="0"><span class="text">Zamtel Staff Training College</span></a></li>
                                                                                        <li><a role="option" class="dropdown-item" id="bs-select-4-54" tabindex="0"><span class="text">ZICA</span></a></li>
                                                                                    </ul>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                            <div class="col-md-4 col-sm-12 col-md-offset-0">
                                                <span id="ContentPlaceHolder1_lblAwardDate">Start Date:</span>


                                                <div class="row m-0 p-0">
                                                    <div class="col-md-11 col-sm-11 pl-0">
                                                        <input name="ctl00$ContentPlaceHolder1$dtAwardDate$TxtDate" type="text" id="ContentPlaceHolder1_dtAwardDate_TxtDate" class="form-control">

                                                    </div>

                                                    <div class="col-md-1 col-sm-1 pl-0">
                                                        <input type="image" name="ctl00$ContentPlaceHolder1$dtAwardDate$Image1" id="ContentPlaceHolder1_dtAwardDate_Image1" class="width20px height20px " src="../images/PopUpCalendar.gif" alt="Click to show calendar" align="top">

                                                    </div>
                                                </div>



                                                <span id="ContentPlaceHolder1_lblAwardDateMsg" class="d-none">Please Enter Valid Qualification Start Date.</span>
                                            </div>

                                            <div class="col-md-4 col-sm-12  col-md-offset-0">
                                                <span id="ContentPlaceHolder1_lblDateto">Award Date:</span>


                                                <div class="row m-0 p-0">
                                                    <div class="col-md-11 col-sm-11 pl-0">
                                                        <input name="ctl00$ContentPlaceHolder1$dtdateto$TxtDate" type="text" id="ContentPlaceHolder1_dtdateto_TxtDate" class="form-control">

                                                    </div>

                                                    <div class="col-md-1 col-sm-1 pl-0">
                                                        <input type="image" name="ctl00$ContentPlaceHolder1$dtdateto$Image1" id="ContentPlaceHolder1_dtdateto_Image1" class="width20px height20px " src="../images/PopUpCalendar.gif" alt="Click to show calendar" align="top">

                                                    </div>
                                                </div>



                                                <span id="ContentPlaceHolder1_lblDatetoMsg" class="d-none">Please Enter Valid Qualification Award Date.</span>
                                                <span id="ContentPlaceHolder1_lblDatetoMsg2" class="d-none">Award date cannot be less or equal to start date.</span>
                                            </div>

                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <span id="ContentPlaceHolder1_lblGPA">GPA/Points:</span>
                                                <input name="ctl00$ContentPlaceHolder1$txtGPAcode" type="text" id="ContentPlaceHolder1_txtGPAcode" class="form-control">


                                                <span id="ContentPlaceHolder1_lblGPAMsg" class="d-none">GPA is compulsory information. Please either enter GPA or Tick on GPA Not Applicable option.</span>
                                                <span id="ContentPlaceHolder1_lblGPAMsg2" class="d-none">Please enter GPA between 1 to 999.</span>
                                            </div>

                                            <div class="col-md-4">
                                                <span id="ContentPlaceHolder1_lblCertiNo">Certificate No.</span>
                                                <input name="ctl00$ContentPlaceHolder1$txtCertiNo" type="text" id="ContentPlaceHolder1_txtCertiNo" class="form-control">
                                            </div>

                                            <div class="col-md-4">
                                                <span id="ContentPlaceHolder1_lblRemark">Remarks:</span>
                                                <textarea name="ctl00$ContentPlaceHolder1$txtQualiremark" rows="2" cols="20" id="ContentPlaceHolder1_txtQualiremark" class="form-control"></textarea>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4">

                                            <span id="ContentPlaceHolder1_lblGPNotApplicable" class="font-weight-bold">GPA Not Applicable</span>
                                            <span class="switch float-right">
                                                <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-on bootstrap-switch-id-ContentPlaceHolder1_chkNaGPA bootstrap-switch-animate" style="width: 89.5312px;">
                                                    <div class="bootstrap-switch-container" style="width: 131.297px; margin-left: 0px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 43.7812px;">Yes</span><span class="bootstrap-switch-label" style="width: 43.7812px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 43.7812px;">No</span><input id="ContentPlaceHolder1_chkNaGPA" type="checkbox" name="ctl00$ContentPlaceHolder1$chkNaGPA" checked="checked"></div>
                                                </div>
                                            </span>


                                        </div>

                                        <div class="col-md-4">
                                            <span id="ContentPlaceHolder1_lvlHigh" class="required">Highest Qualification</span>
                                            <span class="switch float-right">
                                                <div class="bootstrap-switch bootstrap-switch-wrapper bootstrap-switch-off bootstrap-switch-id-ContentPlaceHolder1_chkHighestqualification bootstrap-switch-animate" style="width: 89.5312px;">
                                                    <div class="bootstrap-switch-container" style="width: 131.297px; margin-left: -43.7656px;"><span class="bootstrap-switch-handle-on bootstrap-switch-primary" style="width: 43.7812px;">Yes</span><span class="bootstrap-switch-label" style="width: 43.7812px;">&nbsp;</span><span class="bootstrap-switch-handle-off bootstrap-switch-default" style="width: 43.7812px;">No</span><input id="ContentPlaceHolder1_chkHighestqualification" type="checkbox" name="ctl00$ContentPlaceHolder1$chkHighestqualification"></div>
                                                </div>
                                            </span>
                                        </div>

                                        <div class="col-md-4">
                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12 text-center">

                                        </div>
                                    </div>


                                </div>





                                <form method="post" action="#add_skill" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="date">Skill Category</label>
                                        <div class="input-group col-md-12">
                                            <input type="text" class="form-control pull-right" name="category" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Skill Name</label>
                                        <div class="input-group col-md-12">
                                            <input type="text" class="form-control pull-right" name="name" placeholder="" required>
                                        </div>
                                    </div> 
                                    <div class="form-group ">
                                        <label class="">Institution</label>
                                        <input type="text" class="form-control pull-right" name="school" placeholder="" required>
                                        
                                    </div>
                                    <div class="form-group ">
                                        <label class="">Qualification</label>
                                        <input type="text" class="form-control pull-right" name="qualification" placeholder="" required>
                                        
                                    </div>
                                    
                                    <div class="form-group ">
                                        <label class="">Award</label>
                                        <input type="text" class="form-control pull-right" name="award" placeholder="" required>
                                        
                                    </div>
                                    
                                    <div class="form-group ">
                                        <label class="">Date Started</label>
                                        <input type="date" class="form-control pull-right" name="starts" placeholder="" required>
                                    </div>
                                    
                                    <div class="form-group ">
                                        <label class="">Date Finished</label>
                                        <input type="date" class="form-control pull-right" name="ends" placeholder="" required>
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

                    <div class="col-xs-9 col-md-7 col-md-offset-1">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">My Skills</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Name</th>
                                            <th>Level</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = mysql_query("SELECT * FROM jobs_user_skills WHERE user_id = '$user_id' ") or die(mysql_error());
                                        while ($row = mysql_fetch_array($query)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['category']; ?></td>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['level']; ?></td>
                                                <td>
                                                    <a href="#updateordinance<?php echo $row['id']; ?>" data-target="#updateordinance<?php echo $row['id']; ?>" data-toggle="modal" style="color:#fff;" class="btn btn-primary btn-sm">Edit</i></a>
                                                </td>
                                                <td>
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

                                                                <div class="form-group">
                                                                    <label for="date">Category</label>
                                                                    <div class="input-group col-md-12">
                                                                        <input type="text" class="form-control" id="name" name="category" value="<?php echo $row['category']; ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="name">Name</label>
                                                                    <div class="input-group col-md-12">
                                                                        <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" required>
                                                                        <input type="text" class="form-control pull-right" name="name" value="<?php echo $row['name'] ?>" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <label class="">Level</label>
                                                                    <select name="level" class="form-control">
                                                                        <option value="<?php echo $row['level'] ?>"> <?php echo $row['level'] ?> </option>
                                                                        <option value="Beginner">Beginner</option>
                                                                        <option value="Intermediate">Intermediate</option>
                                                                        <option value="Expert">Expert</option>
                                                                    </select>
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

                        </div><!-- /.col -->


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