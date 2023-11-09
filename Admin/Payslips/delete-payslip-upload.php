<?php

$dbms = "mysql";
$dbhost = "localhost";
$dbname = "chescote_nobility";
$dbuser = "chescote_pamodzi";
$dbpasswd = "Kaluba1love@1992";

$link = mysqli_connect($dbhost, $dbuser, $dbpasswd, $dbname)
    or die(mysqli_connect_error());

$query = mysqli_query($link, "SELECT empno,(SUM(pay+otrate+allow)*0.02) AS Uion FROM `employee` where time='2023-01-31' group by empno") or die(mysqli_error($link)); #
while ($row = mysqli_fetch_array($query)) {
    $empno = $row['empno'];
    $Uion = $row['Uion'];
    echo '$empno' . $empno . '<br>';
    mysqli_query($link, "UPDATE employee SET insurance='$Uion' where empno='$empno'") or die(mysqli_error($link)); #
}
