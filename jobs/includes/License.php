<?php

class License {

    function checkLicenseValidity($_key) {
        $duration = substr($_key, 12, 2);
        $no_users_allowed = substr($_key, 15, 4);
        $date = substr($_key, 20, 4);
        $year = substr($_key, 25, 4);
        $no_months = intval($duration);
        $date_created = substr($date, 0, 2) . "-" . substr($date, 3, 2) . "-" . $year;
        // echo $date_created = date('Y-m-d', strtotime($date_created_str));
        $expiry_date = date('d M Y - H:i:s', strtotime($date_created . "+$no_months Months"));

        // echo "<hr/> exp date = ".$expiry_date."<br>";
       if (strtotime(date('d M Y')) > strtotime($expiry_date)) {
            // License is valid.. so now check for the number of users allowed..
        } else {
            $fatal_error = "Your license has expired. Please renew the license key or contact system admin for more infomation.";
        }
        if (isset($fatal_error)) {
            return $fatal_error;
        } else {
            return "License Is Valid";
        }
    }

    public function checkUsers($con, $user_id, $user_table, $_key) {
        // $isValid 
        $duration = substr($_key, 12, 2);
        $no_users_allowed = substr($_key, 15, 4);
        $date = substr($_key, 20, 4);
        $year = substr($_key, 25, 4);
        $no_months = intval($duration);
        $date_created = substr($date, 0, 2) . "-" . substr($date, 3, 2) . "-" . $year;
        // echo $date_created = date('Y-m-d', strtotime($date_created_str));
        $expiry_date = date('d M Y - H:i:s', strtotime($date_created . "+$no_months Months"));
        if (strtotime($expiry_date) <= date('d M Y')) {
            // License is valid.. so now check for the number of users allowed..
            // Get no. of users allowed by the license
            $no_users_allowed = substr($_key, 15, 4);
            // Now get the no. of users registerd so far..
            $uzers_q = mysqli_query($con, "SELECT $user_id FROM $user_table WHERE _key='$_key' ") or die('Er. ' . mysqli_error($con));
            ;
            $no_reg_userz = mysqli_num_rows($uzers_q);

            if ($no_reg_userz <= 0) {
                $fatal_error = "Invlalid licence Key";
            } else {
                if ($no_reg_userz <= $no_users_allowed) {
                    // get remaining users
                    $remaining_users = $no_users_allowed - $no_reg_userz;
                } else {
                    $fatal_error = "You have reached the maximum number of users allowed by your licence";
                }
            }
        } else {
            $fatal_error = "Your license has expired. Please renew the license key or contact system admin for more infomation.";
        }

        // Validate
        if (isset($fatal_error)) {
            return $fatal_error;
        } else {
            return $no_users_allowed;
        }
    }

    public  function checkNousers($_key) {
        $no_users_allowed = substr($_key, 15, 4);
        return $no_users_allowed;
    }


    public function checkExpiryDate($_key) {

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
    
      public function checkVaiidty($_key, $name)
    {
        $company_code_key = substr($_key, 0, 4);
        $company_name = abs(crc32($name));
        $company_name_code = substr($company_name, 0, 4);
        if ($company_code_key == $company_name_code) {
            return "True";
        } else {
            return $fatal_error = "False";
        }
    }

    public function updateClientLicense($con, $key_column, $key_table, $_new_key) {
        $query = mysqli_query($con, "UPDATE $key_table SET $key_column = '$_new_key' ") or die('Er. ' . mysqli_error($con));
        if ($query) {
            $msg = "Updated Successfully";
        } else {
            $msg = mysqli_error($con);
        }
        return $msg;
    }

    public function updateServerLicense($con, $key_column, $key_table, $_new_key) {
        $query = mysqli_query($con, "UPDATE $key_table SET $key_column = '$_new_key' ") or die('Er. ' . mysqli_error($con));
        if ($query) {
            $msg = "Updated Successfully";
        } else {
            $msg = mysqli_error($con);
        }
        return $msg;
    }

}
