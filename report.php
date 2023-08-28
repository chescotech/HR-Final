<?php
// Inialize session
include 'include/dbconnection.php';
session_start();

// Check, if username session is NOT set then this page will jump to login page
if (!isset($_SESSION['username'])) {
    header('Location:index.html');
}

$reportDate = $_POST['whole_date_report'];
$arr = explode("/", $reportDate);
list($Getmonth, $Getday, $GetYear) = $arr;

$year = $GetYear;
$month = $Getmonth;
$day = $Getday;
$comp_ID = $_SESSION["username"];
?>
<?php
if (isset($_GET['id']) && !isset($_GET['field'])) {

    $id = $_GET['id'];
    $query = "DELETE FROM employee WHERE id ='$id'";
    $result = mysql_query($query, $link) or die(mysql_error());
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
            <link href="src/css/bootstrap.min.css" rel="stylesheet" media="screen">
                <link href="src/css/style.css" rel="stylesheet" media="screen">
                    <link href="src/css/color/default.css" rel="stylesheet" media="screen">
                        <script src="src/css/js/modernizr.custom.js"></script>
                        <script type="text/javascript" src="src/js/jquery.js"></script>
                        <link rel="stylesheet" href="default/default.css" type="text/css" media="screen" />

                        <link href="src/css/bootstrap.css" rel="stylesheet">
                            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                                <script type="text/javascript" src="src/js/jquery.nivo.slider.pack.js"></script>
                                </head>
                                <style>

                                    .responstable {
                                        margin: 1em 0;
                                        width: 100%;
                                        overflow: hidden;
                                        background: #FFF;
                                        color: #024457;
                                        border-radius: 10px;
                                        border: 1px solid #167F92;
                                    }
                                    .responstable tr {
                                        border: 1px solid #D9E4E6;
                                    }
                                    .responstable tr:nth-child(odd) {
                                        background-color: #EAF3F3;
                                    }
                                    .responstable th {
                                        display: none;
                                        border: 1px solid #FFF;
                                        background-color: #167F92;
                                        color: #FFF;
                                        padding: 1em;
                                    }
                                    .responstable th:first-child {
                                        display: table-cell;
                                        text-align: center;
                                    }
                                    .responstable th:nth-child(2) {
                                        display: table-cell;
                                    }
                                    .responstable th:nth-child(2) span {
                                        display: none;
                                    }
                                    .responstable th:nth-child(2):after {
                                        content: attr(data-th);
                                    }
                                    @media (min-width: 480px) {
                                        .responstable th:nth-child(2) span {
                                            display: block;
                                        }
                                        .responstable th:nth-child(2):after {
                                            display: none;
                                        }
                                    }
                                    .responstable td {
                                        display: block;
                                        word-wrap: break-word;
                                        max-width: 7em;
                                    }
                                    .responstable td:first-child {
                                        display: table-cell;
                                        text-align: center;
                                        border-right: 1px solid #D9E4E6;
                                    }
                                    @media (min-width: 480px) {
                                        .responstable td {
                                            border: 1px solid #D9E4E6;
                                        }
                                    }
                                    .responstable th, .responstable td {
                                        text-align: left;
                                        margin: .5em 1em;
                                    }
                                    @media (min-width: 480px) {
                                        .responstable th, .responstable td {
                                            display: table-cell;
                                            padding: 1em;
                                        }
                                    }

                                    body {
                                        padding: 0 2em;
                                        font-family: Arial, sans-serif;
                                        color: #024457;
                                        background: #f2f2f2;
                                    }

                                    h1 {
                                        font-family: Verdana;
                                        font-weight: normal;
                                        color: #024457;
                                    }
                                    h1 span {
                                        color: #167F92;
                                    }

                                </style>

                                <body>

                                    <?php
                                    include 'site_menu/reports_menu.php';
                                    ?>
                                    

                                    <script type="text/javascript">
                                        document.write('' + Date() + '');
                                    </script>

                                    <div class="profile5">

                                        <strong>PAYROLL REPORT FOR PERIOD <?php echo $month ?> 2016</strong>

                                        <div class="body">                                        
                                            <table class="responstable">
                                                <tr bgcolor="gray">
                                                    <th>Emp_ID</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Date Period</th>
                                                    <th>Basic Pay</th>
                                                    <th>Days Worked</th>
                                                    <th>Overtime</th>
                                                    <th>Allowances</th>
                                                    <th>Comission</th>
                                                    <th>Gross Pay</th>
                                                    <th>Tax</th>
                                                    <th>NAPSA</th>
                                                    <th>Advances</th>
                                                    <th>Loan</th>
                                                    <th>Insurance</th>
                                                    <th>Total Deductions</th>
                                                    <th>Net Pay</th>

                                                    <tr>
                                                        <?php
                                                        $query = "SELECT * FROM loan where company_id =  '$comp_ID'";
                                                        $result = mysql_query($query) or die($query . "<br/><br/>" . mysql_error());

                                                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                                                        $balance = $row['loan_amt'];
                                                        $interest = $row['interest'];
                                                        $months = $row['duration'];
                                                        $deduct = $row['monthly_deduct'];
                                                        $band1_top = "";
                                                        $band1_rate = "";
                                                        $band2_top = "";
                                                        $band2_rate = "";
                                                        $band3_top = "";
                                                        $band3_rate = "";
                                                        $band4_rate = "";

                                                        $query = "SELECT *
                                                    FROM employee em
                                                    INNER JOIN pay.emp_info n ON em.empno = n.empno                                                     
                                                    WHERE em.company_id =  '$comp_ID' and em.time = '$year-$month-$day'";

                                                        $result = mysql_query($query, $link) or die(mysql_error());
                                                        $sum = 0;
                                                        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                                            $gross = ($row['pay'] ) + ($row['otrate'] * $row['othrs']) + $row['allow'] + $row['comission'];
                                                            $empoyeeNo = $row['empno'];
                                                            $napsa = $gross * 0.05;
                                                            if ($napsa >= 843)
                                                                $napsa = 843;

                                                            $napsa_calc = "";
                                                            if ($napsa >= 255)
                                                            $napsa_calc = 255;

                                                            $band1_top = 3000;
                                                            $band2_top = 3800;
                                                            $band3_top = 5900;

                                                            $band1_rate = 0;
                                                            $band2_rate = 0.25;
                                                            $band3_rate = 0.30;
                                                            $band4_rate = 0.35;

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
                                                            $totdeduct = $total_tax_paid + $row['advances'] + $row['insurance'] + $napsa;
                                                            $netpay = $gross - $totdeduct;
                                                            ?>
                                                            <script type="text/javascript">
                                                                function proceed() {
                                                                    return confirm('Delete this record?');

                                                                }
                                                            </script>
                                                            <?php
                                                            
                                                            echo '<td bgcolor="#CCCCCC">' . $row['empno'] . '</td>';
                                                            echo '<td>' . $row['fname'] . '</td>';
                                                            echo '<td>' . $row['lname'] . '</td>';
                                                            echo '<td>' . $row['time'] . '</td>';
                                                            echo '<td>' . number_format($row['pay'], 2) . '</td>';
                                                            echo '<td>' . $row['dayswork'] . '</td>';
                                                            echo '<td>' . $row['otrate'] . '</td>';
                                                            echo '<td>' . $row['allow'] . '</td>';
                                                            echo '<td>' . $row['comission'] . '</td>';
                                                            echo '<td><i>';
                                                            echo number_format("$gross", 2);
                                                            '</i></td>';
                                                            echo '<td>' . $total_tax_paid . '</td>';
                                                            echo '<td>' . $napsa . '</td>';
                                                            echo '<td>' . $row['advances'] . '</td>';

                                                            $query2 = "SELECT * FROM loan where company_id =  '$comp_ID'  AND empno='$empoyeeNo'  ";
                                                            $result2 = mysql_query($query2) or die($query2 . "<br/><br/>" . mysql_error());

                                                            $row2 = mysql_fetch_array($result2, MYSQL_ASSOC);

                                                            if (mysql_num_rows($result2) > 0) {
                                                                $tototalMonthDed = $row2['monthly_deduct'];
                                                            } else {
                                                                $tototalMonthDed = 0;
                                                            }

                                                            echo '<td>' . "$tototalMonthDed" . '</td>';
                                                            echo '<td>' . $row['insurance'] . '</td>';
                                                            echo '<td>';
                                                            echo number_format("$totdeduct");
                                                            '</td>';
                                                            echo '<td><b>';
                                                            echo number_format("$netpay", 2);
                                                            '</b></td>';
                                                             echo '';
                                                          echo '</tr>';
                                                            $sum += $netpay;
                                                        }

                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td></td>';
                                                        echo '<td><b>Total:</b></td>';
                                                        echo '<td><b>';
                                                        echo number_format("$sum");
                                                        '</b></td>';
                                                        echo '</table>';
                                                        echo "<strong><br><center>" . mysql_num_rows($result) . " record(s) Found.</center></strong></p>";
                                                        ?>

                                                        </table>

                                                        </div>


                                                        </div>
                                                        </body>

                                                        </html>

