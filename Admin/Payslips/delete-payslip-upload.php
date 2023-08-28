<?php

$dbms = "mysql";
$dbhost = "localhost";
$dbname = "chescote_nobility";
$dbuser = "chescote_pamodzi";
$dbpasswd = "Kaluba1love@1992";

$link = mysql_connect($dbhost, $dbuser, $dbpasswd)
        or die(mysql_error());

$status = mysql_select_db($dbname, $link) or die(mysql_error());

$query = mysql_query("SELECT empno,(SUM(pay+otrate+allow)*0.02) AS Uion FROM `employee` where time='2023-01-31' group by empno") or die(mysql_error()); #
while ($row = mysql_fetch_array($query)) {
    $empno = $row['empno'];
    $Uion = $row['Uion'];
    echo '$empno' . $empno.'<br>';
    mysql_query("UPDATE employee SET insurance='$Uion' where empno='$empno'") or die(mysql_error()); #
}

?>