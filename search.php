<?php
// Inialize session
include 'include/dbconnection.php';
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
    header('Location:index.html');
}
?>
<?php
if (isset($_GET['id']) && !isset($_GET['field'])) {

    $id = $_GET['id'];
    $query = "DELETE FROM employee WHERE id ='$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $msg = "Record deleted!";
}
$msg = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Crystal Pay</title>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- css -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="src/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="src/css/style.css" rel="stylesheet" media="screen">
    <link href="src/css/color/default.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="src/js/jquery.js"></script>
    <link href="src/css/main.css" rel="stylesheet" type="text/css" />
    <link href="src/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="src/css/nivo-slider.css" type="text/css" media="screen" />
    <script type="text/javascript" src="src/js/jquery.nivo.slider.pack.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<style type="text/css">
    .se {
        margin-left: 20px;
    }

    input[type=button],
    input.button {
        width: 200px;
        background: white;
        #999;
        color: #CCC;
        font-weight: bold;
        margin-top: 15px;
        cursor: pointer;
        width: 200px;
        -moz-border-radius: 5px;
        -webkit-border-radius: 5px;
        padding: 4px;
    }

    input[type=button]:hover,
    input[type=button]:focus,
    input.submit:hover,
    input.submit:focus {
        background: #CCC;
        color: #000;
    }
</style>

<body>

    <?php include 'site_menu/navigation-menu.php'; ?>

    <div class="profile5">

        <form method="post" action="search.php">
            <center>
                <table cellpadding="" border="0" class="se">
                    <tr>
                        <td>
                            <select name="key" class="form-control">

                                <option>--Select Employee to Search--</option>

                                <?php
                                $company_id = $_SESSION['username'];
                                $query = mysqli_query($link, "select * from emp_info WHERE company_ID = '$company_id' ") or die(mysqli_error($link));
                                while ($row = mysqli_fetch_array($query)) {
                                ?>

                                    <option value="<?php echo $row['empno']; ?>"> <?php echo $row['fname'] . "  " . $row['lname'] . " - " . $row['position'] . "-" . $row['empno']; ?></option>

                                <?php
                                }
                                ?>
                            </select>
                        </td>
                        <td>

                            <button type="submit" name="save" id="save" type="button" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Search
                            </button>
                        </td>
                    </tr>
                </table>
    </div>

    <div class="body">
        <?php
        //-------------------------------------------search----------------------------------//
        if (isset($_POST["key"])) {
            $key = strtoupper($_POST["key"]);
            // $field = $_POST["field"];
            $companyId = $_SESSION['username'];

            $query = "SELECT * FROM employee WHERE empno = '$key' AND company_id='$companyId'  ";
            $result = mysqli_query($link, $query) or die(mysqli_error($link));

            $query2 = "SELECT * FROM emp_info WHERE empno = '$key' AND company_id='$companyId'  ";
            $result2 = mysqli_query($link, $query2) or die(mysqli_error($link));

            if (mysqli_num_rows($result) != 0) {

                while ($row = mysqli_fetch_array($result2, MYSQLI_ASSOC)) {
        ?>
                    <?php
                    //@$image=$row ['photo'];
                    ?>
                    <style type="text/css">
                        .a {
                            width: auto;
                            margin-left: -1.5em;
                            float: right;
                        }

                        input[class=id_empno],
                        input.id_empno {
                            background: #CCC;
                        }

                        .src_img {
                            float: left;
                            margin-left: 5px;
                        }

                        .tb {
                            margin-letf: -1em;
                        }

                        .font_info {
                            font-size: 16px;
                        }
                    </style>
                    <br /><br />
                    <div class="">
                        <table border="0" class="tb" align="center" cellspacing="0">
                            <td>

                            </td>
                            <td>
                                <div class="a">
                                    <legend>
                                        <table border="" align="center" cellspacing="0" style="border:gray 1px solid">
                                            <td><?php
                                                echo "<a href='edit_info.php?empno=" . $row['empno'] . "'><img src='images/edit.png' height='20'width='25' border='0' title='Edit'>";
                                                ?></td>
                                        </table>
                                    </legend>

                                    <table align="center" border="0" cellspacing="3" class="pro">

                                        <tr>
                                            <td rowspan="4">

                                            <td class="font_info">Employee
                                            <td>:</td>
                            </td>
                            <td width="20"><?php echo '<td  class="font_info">' . $row['empno'] . '</td>';
                                            ?></td>
                            <td width="100"></td>
                            <td class="font_info">Last Name
                            <td>:</td>
                            </td>
                            <td width="20" class="font_info"><?php echo '<td bordercolor="#FFFFFF"  class="font_info">' . $row['lname'] . ''; ?></td>

                            </tr>

                            <tr>
                                <td class="font_info">Department
                                <td>:</td>
                                </td>
                                <td width="20" class="font_info"><?php echo '<td  class="font_info">' . $row['dept'] . '</td>'; ?></td>
                                <td></td>
                                <td class="font_info">First Name
                                <td>:</td>
                                </td>
                                <td><?php echo '<td bordercolor="#FFFFFF"  class="font_info" >' . $row['fname'] . ''; ?></td>
                            </tr>
                            <tr>
                                <td class="font_info">Position
                                <td>:</td>
                                </td>
                                <td class="font_info"><?php echo '<td  class="font_info">
  ' . $row['position'] . '</td>'; ?></td>
                                <td></td>
                                <td class="font_info">Middle Initial:
                                <td>:</td>
                                </td>
                                <td class="font_info"><?php echo '<td bordercolor="#FFFFFF"  class="font_info">' . $row['init'] . ''; ?></td>
                            </tr>
                            <tr>
                                </p>
                    <?php
                    echo '</table>';
                }
            }
        }
                    ?>
                    <hr width="" align="center">
                    <?php //----------------------search ---------------------  
                    ?>

                    <table border="3" cellspacing="4" width="100" align="center" class="table" bordercolor="#000000">
                        <tr bgcolor="gray">
                            <th>Emp_ID</th>
                            <th>Date Period</th>
                            <th>Days Worked</th>
                            <th>Overtime Rate/Hr</th>
                            <th>OT Hours</th>
                            <th>Allowances</th>
                            <th>Comission</th>
                            <th>Gross Pay</th>
                            <th>Taxable Amount</th>
                            <th>Napsa Contribution</th>
                            <th>Advances</th>
                            <th>Insurance</th>
                            <th>Total Deductions</th>
                            <th>Net Pay</th>
                            <th colspan="3">Action</th>

                        <tr>
                            <?php
                            if (isset($_POST["key"])) {
                                $key = strtoupper($_POST["key"]);
                                //$field = $_POST["field"];
                                $companyId = $_SESSION['username'];

                                $query = "SELECT * FROM employee WHERE empno = '$key' AND company_id='$companyId'  ";

                                $result = mysqli_query($link, $query) or die(mysqli_error($link));
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    $gross = ($row['pay']) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];

                                    $napsa = $gross * 0.05;
                                    if ($napsa >= 843)
                                        $napsa = 843;

                                    $napsa_calc = "";
                                    if ($napsa >= 255)
                                        $napsa_calc = 255;


                                    //the tops of each tax band
                                    $band1_top = 3000;
                                    $band2_top = 3800;
                                    $band3_top = 5900;
                                    //no top of band 4
                                    //the tax rates of each band
                                    $band1_rate = 0;
                                    $band2_rate = 0.25;
                                    $band3_rate = 0.30;
                                    $band4_rate = 0.35;

                                    //$starting_income = $income = ""; //set this to your income

                                    $starting_income = $income = $gross - $napsa;

                                    $band1 = $band2 = $band3 = $band4 = 0;

                                    if ($income > $band3_top) {
                                        $band4 = ($income - $band3_top) * $band4_rate;
                                        $income = $band3_top;
                                    }

                                    if ($income > $band2_top) {
                                        $band3 = ($income - $band2_top) * $band3_rate;
                                        $income = $band2_top;
                                    }

                                    if ($income > $band1_top) {
                                        $band2 = ($income - $band1_top) * $band2_rate;
                                        $income = $band1_top;
                                    }

                                    $band1 = $income * $band1_rate;

                                    $total_tax_paid = $band1 + $band2 + $band3 + $band4;

                                    //echo "Tax paid on $starting_income is $total_tax_paid";

                                    $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;
                                    $netpay = $gross - $totdeduct;
                            ?>
                                    <script type="text/javascript">
                                        function proceed() {
                                            return confirm('Delete this record?');

                                        }
                                    </script>
                            <?php
                                    //echo '<div class="id">'.$row['id'].'</div>';
                                    $date_timestamp = strtotime($row['time']);
                                    $date = date('m-d-Y', $date_timestamp);

                                    echo '<td bgcolor="#CCCCCC">' . $row['empno'] . '</td>';
                                    echo '<td>' . $date . '</td>';
                                    echo '<td>' . $row['dayswork'] . '</td>';
                                    echo '<td>' . $row['otrate'] . '</td>';
                                    echo '<td>' . $row['othrs'] . '</td>';
                                    echo '<td>' . $row['allow'] . '</td>';
                                    echo '<td>' . $row['comission'] . '</td>';
                                    echo '<td><i>';
                                    echo number_format("$gross", 2);
                                    '</i></td>';
                                    echo '<td>' . number_format($starting_income) . '</td>';
                                    echo '<td>' . number_format($napsa) . '</td>';
                                    echo '<td>' . $row['advances'] . '</td>';
                                    echo '<td>' . $row['insurance'] . '</td>';
                                    echo '<td>';
                                    echo number_format("$total_tax_paid", 2);
                                    '</td>';
                                    echo '<td><b>';
                                    echo number_format("$netpay", 2);
                                    '</b></td>';

                                    echo "<td><a href='edit.php?id=" . $row['id'] . "&empno=" . $row['empno'] . "'><img src='images/edit.png' height='20'width='25' border='0' title='Edit'></td>";
                                    echo '';

                                    echo "<td><a href='print.php?id=" . $row['id'] . "&empno=" . $row['empno'] . "'><img src='images/print.png' height='20'width='25' border='0' title='Print'></td>";
                                    //echo "<td><a href='search.php?dele&empno=".$row['empno']."'>Delete</td>";
                                    echo "<td><a href='search.php?id=";
                                    echo $row['id'];
                                    echo "' onclick=";
                                    echo "'return proceed()";
                                    echo "'><img src='images/delete.png' title='Delete' height='20'width='25' border='0' '></td> </tr>";;
                                }
                                echo "<strong><center>" . mysqli_num_rows($result) . " record(s).</center></strong></p>";

                                echo '</table>';
                            }
                            ?>

                    </table>

                    </div>


    </div>
</body>

</html>