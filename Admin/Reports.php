<?php include '../include/dbconnection.php'  ?>


<?php
$currentDate = date("Y-m-d");


$query3 = mysql_query("SELECT gender, COUNT(*) AS count, COUNT(*) * 100 / (SELECT COUNT(*) FROM emp_info) AS percentage FROM emp_info WHERE gender IN ('male', 'female') GROUP BY gender;") or die(mysql_error());
$query4 = mysql_query(" SELECT DISTINCT dept FROM emp_info WHERE company_id ='$companyId' ");
$sum = 0;
$department = array();
while ($row4 = mysql_fetch_array($query4)) {
    $departmentId = $row4['dept'];
    $departmentName = $LoanObject->getDepartmentById($departmentId);
    $empCount = $LoanObject->getEmployeeCountByDepartment($departmentId);
    $sum += $empCount;
    $department[] = array('count' => $empCount, 'departmentNames' => $departmentName, 'sum' => $sum);
}
$query5 = mysql_query("SELECT empno, bdate, TIMESTAMPDIFF(YEAR, bdate, CURDATE()) AS age FROM emp_info;") or die(mysql_error());
$query6 = mysql_query("SELECT gross_pay FROM emp_info") or die(mysql_error());
$query7 = mysql_query("SELECT DATE(login_time) AS login_date, COUNT(*) AS late_login_count FROM attendance_logs WHERE DATE(login_time) >= CURDATE() - INTERVAL 5 DAY AND TIME(login_time) > '08:00:00' GROUP BY DATE(login_time) ORDER BY login_date;") or die(mysql_error());
$query8 = mysql_query("SELECT YEAR(STR_TO_DATE(date_of_exit, '%m/%d/%Y')) AS exit_year, COUNT(*) AS employee_count FROM employee_exits_tb WHERE STR_TO_DATE(date_of_exit, '%m/%d/%Y') >= DATE_SUB(CURDATE(), INTERVAL 20 YEAR) GROUP BY exit_year ORDER BY exit_year;") or die(mysql_error());
$earlyQuery = mysql_query("SELECT SUM(CASE WHEN TIME(login_time) <= '08:00:00' THEN 1 ELSE 0 END) AS total_early_login_count FROM attendance_logs") or die(mysql_error());
$lateQuery = mysql_query("SELECT SUM(CASE WHEN TIME(login_time) > '08:00:00' THEN 1 ELSE 0 END) AS total_late_login_count FROM attendance_logs") or die(mysql_error());



if (mysql_num_rows($query3) > 0) {
    $gender = array();
    $totalGenderCount = 0;
    $totalFemalePercentage = 0;
    $totalMalePercentage = 0;

    while ($row3 = mysql_fetch_array($query3)) {
        $gender_count = $row3['count'];
        $gender_percentage = $row3['percentage'];
        $gender_type = $row3['gender']; // Assuming you have a gender_type column in your query result

        $totalGenderCount += $gender_count;

        if ($gender_type === 'female') {
            $totalFemalePercentage += $gender_percentage;
        } else if ($gender_type === 'male') {
            $totalMalePercentage += $gender_percentage;
        }

        // Store the data in the array
        $gender[] = array('count' => $gender_count, 'percentage' => $gender_percentage);
    }
}

// Convert the total percentages to percentage format
$totalFemalePercentageFormatted = number_format($totalFemalePercentage, 2) . '%';
$totalMalePercentageFormatted = number_format($totalMalePercentage, 2) . '%';


if (mysql_num_rows($query5) > 0) {
    $ageGroups = array(
        '18-25' => 0,
        '26-35' => 0,
        '36-45' => 0,
        '46+' => 0
    );

    while ($row5 = mysql_fetch_array($query5)) {
        $age = $row5['age'];

        // Determine the age group and update the count
        if ($age >= 18 && $age <= 25) {
            $ageGroups['18-25']++;
        } elseif ($age >= 26 && $age <= 35) {
            $ageGroups['26-35']++;
        } elseif ($age >= 36 && $age <= 45) {
            $ageGroups['36-45']++;
        } else {
            $ageGroups['46+']++;
        }
    }
}


if (mysql_num_rows($query6) > 0) {
    $grossPayGroups = array(
        '1 - 2000' => 0,
        '2001 - 4800' => 0,
        '4801 - 6000' => 0,
        '6001 - 9999' => 0,
        '10000 - 15000' => 0,
        '15001 - 20000' => 0,
        '20001 - 30000' => 0,
        '30001 - 60000' => 0,
        '60000+' => 0
    );

    while ($row6 = mysql_fetch_array($query6)) {
        $grossPay = $row6['gross_pay'];

        if ($grossPay <= 2000) {
            $grossPayGroups['1 - 2000']++;
        } elseif ($grossPay <= 4800) {
            $grossPayGroups['2001 - 4800']++;
        } elseif ($grossPay <= 6000) {
            $grossPayGroups['4801 - 6000']++;
        } elseif ($grossPay <= 9999) {
            $grossPayGroups['6001 - 9999']++;
        } elseif ($grossPay <= 15000) {
            $grossPayGroups['10000 - 15000']++;
        } elseif ($grossPay <= 20000) {
            $grossPayGroups['15001 - 20000']++;
        } elseif ($grossPay <= 30000) {
            $grossPayGroups['20001 - 30000']++;
        } elseif ($grossPay <= 60000) {
            $grossPayGroups['30001 - 60000']++;
        } else {
            $grossPayGroups['60000+']++;
        }
    }
};



$rowEarly = mysql_fetch_array($earlyQuery);
$rowLate = mysql_fetch_array($lateQuery);

$totalEarlyArrivals = $rowEarly['total_early_login_count'];
$totalLateArrivals = $rowLate['total_late_login_count'];

mysql_free_result($earlyQuery);
mysql_free_result($lateQuery);



if (mysql_num_rows($query8) > 0) {
    $years = array();
    $counts = array();

    while ($row8 = mysql_fetch_array($query8)) {
        $years[] = $row8['exit_year']; // Assuming you have a column name 'exit_year' in the query result
        $counts[] = $row8['employee_count']; // Assuming you have a column name 'employee_count' in the query result
    }
}




?>