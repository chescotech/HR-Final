<?php

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
            $fatal_error = "expired";
        }
        if (isset($fatal_error)) {
            return $fatal_error; 
        } else {
            return "valid";
        }
    }
    
    
    echo ''.checkExpiryDate('');