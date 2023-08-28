<?php
$date = date_create('2017-01-31');
date_add($date, date_interval_create_from_date_string('1 month'));
//echo date_format($date, 'Y-m-d');

  function checkNousers($_key) {
        $no_users_allowed = substr($_key, 15, 4);
        return $no_users_allowed;
    }
    
      function checkExpiryDate($_key) {

        $duration = substr($_key, 12, 2);
        $no_users_allowed = substr($_key, 15, 4);
        $date = substr($_key, 20, 4);
        $year = substr($_key, 25, 4);
        $no_months = intval($duration);
        $date_created = substr($date, 0, 2) . "-" . substr($date, 2, 2) . "-" . $year;
        // echo $date_created = date('Y-m-d', strtotime($date_created_str));
        // $expiry_date = $date_created;
        $expiry_date = date('d M Y', strtotime($date_created . "+ $no_months Month"));

        //echo "<hr/>." . date('d M Y') . ". exp date = " . $expiry_date . "<br>";
        if (strtotime(date('d M Y')) > strtotime($expiry_date)) {
            //$fatal_error = "Your license is valid";
            $fatal_error = date('d M Y') ;
        }
        if (isset($fatal_error)) {
            return $fatal_error;
        } else {
            return $expiry_date;
        }
    }
    
    echo checkExpiryDate("5913-1950-0012-0155-2702-2022");