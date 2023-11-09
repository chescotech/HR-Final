<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'org-struct-test');
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($link));
$database = mysql_select_db(DB_DATABASE) or die(mysqli_error($link));
$query = mysqli_query($link, "select emp, manager from employee") or die(mysqli_error($link));

# Collect the results
while ($obj = mysql_fetch_object($query)) {
    $arr[] = $obj;
}

# JSON-encode the response
$json_response = json_encode($arr);

// # Return the response
echo $json_response;
