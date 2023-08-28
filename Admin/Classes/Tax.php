<?php

class Tax {

    public function addtaxBand($band_top1, $band_top2, $band_top3, $band_rate1, $band_rate2, $band_rate3, $band_rate4, $company_ID) {
        $res = mysql_query("INSERT INTO tax_bands(band_top1,band_top2,band_top3,band_rate1,"
                . "band_rate2,band_rate3,band_rate4,company_ID) "
                . "VALUES('$band_top1','$band_top2','$band_top3','$band_rate1','$band_rate2',"
                . "'$band_rate3','$band_rate4','$company_ID')");
        return $res;
    }

    public function updatetaxbands() {
        
    }

    function updateGratuity($amount) {
        $result = mysql_query("UPDATE gratuity_settings_tb SET rating='$amount'");
        return $result;
    }

    function updateNhimaSettings($amount, $status) {
        $result = mysql_query("UPDATE  nhima_tb SET amount='$amount',status='$status' ");
        return $result;
    }

    public function updateTaxBand($band_top1, $band_top2, $band_top3, $band_rate1, $band_rate2, $band_rate3, $band_rate4, $company_ID,$napsa_ceiling) {
        $result = mysql_query("UPDATE tax_bands SET band_top1 ='$band_top1',band_top2='$band_top2',"
                . "band_top3='$band_top3',band_rate1='$band_rate1',band_rate2='$band_rate2', band_rate3='$band_rate3',"
                . "band_rate4='$band_rate4', napsa_ceiling='$napsa_ceiling' WHERE company_ID= '$company_ID'");
        return $result;
    }

    public function getTaxDetails($company_ID) {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        return $query;
    }

    public function getGratuitySettings() {
        $query = mysql_query("SELECT * FROM gratuity_settings_tb ");
        return $query;
    }

    public function getNationalHealthSchemeSettings() {
        $query = mysql_query("SELECT * FROM nhima_tb ");
        return $query;
    }
    
    public function getPensions() {
         $query = mysql_query("SELECT * FROM pensions_tb ");
        return $query;
    }

    public function checkIfTaxExsists($company_ID) {
        $status = "";
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        if (mysql_num_rows($query) == 0) {
            $status = "false";
        } else {
            $status = "true";
        }
        return $status;
    }

    public function getTopBand1($company_ID) {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $bandTop1 = $row['band_top1'];
        return $bandTop1;
    }
    
  

    public function getNapsaCeiling($company_ID) {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $napsa_ceiling = $row['napsa_ceiling'];
        return $napsa_ceiling;
    }

    public function getEmployeeAge($empno) {
        $query = mysql_query("SELECT bdate FROM emp_info WHERE empno = '$empno'");
        $row = mysql_fetch_array($query);
        $dob = $row['bdate'];
        $from = new DateTime($dob);
        $to = new DateTime('today');
        $age = $from->diff($to)->y;
        return $age;
    }

    public function getTopBand2($company_ID) {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $bandTop1 = $row['band_top2'];
        return $bandTop1;
    }

    public function getTopBand3($company_ID) {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $bandTop1 = $row['band_top3'];
        return $bandTop1;
    }

    public function getBandRate1($company_ID) {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $band_rate1 = $row['band_rate1'];
        return $band_rate1;
    }

    public function getBandRate2($company_ID) {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $band_rate2 = $row['band_rate2'];
        return $band_rate2;
    }

    public function getCompanyLogo($companyId) {
        $user_query = mysql_query("SELECT * FROM company where company_ID='$companyId'") or die(mysql_error());
        $row = mysql_fetch_array($user_query);

        $photo = "../company_logos/" . $row['logo'];
        $check_pic = $row['logo'];
        if (!file_exists($photo) || $check_pic == false) {
            $photo = "../company_logos/logo.png";
        }
        return $photo;
    }

    public function getBandRate3($company_ID) {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $band_rate3 = $row['band_rate3'];
        return $band_rate3;
    }

    public function getBandRate4($company_ID) {
        $query = mysql_query("SELECT * FROM tax_bands WHERE company_ID = '$company_ID'");
        $row = mysql_fetch_array($query);
        $band_rate4 = $row['band_rate4'];
        return $band_rate4;
    }

    function TaxCal($pay, $compId) {

        $band2_total = 0;
        $band3_total = 0;
        $band4_total = 0;
        $band5_total = 0;
        //$band1 = 0;
        $band2 = $this->getBandRate2($compId) / 100;
        $band3 = $this->getBandRate3($compId) / 100;
        $band4 = $this->getBandRate4($compId) / 100;

        $band1Setting = $this->getTopBand1($compId);
        $band2Setting = $this->getTopBand2($compId);
        $band3Setting = $this->getTopBand3($compId);

        //$band4Setting = 0.375;
        // compute band 2..

        if ($pay > $band1Setting) {
            if ($pay > $band2Setting) {
                $band2_total = ($band2Setting - $band1Setting) * $band2;
            } elseif ($pay < $band2Setting) {
                $band2_total = ($pay - $band1Setting) * $band2;
            }
            //echo '$band2_total  '.$band2_total;
        }

        // compute band 3....
        if ($pay > $band2Setting) {
            if ($pay > $band3Setting) {
                $band3_total = ($band3Setting - $band2Setting) * $band3;
            } elseif ($pay < $band3Setting) {
                $band3_total = ($pay - $band2Setting) * $band3;
            }
            // echo '$band3_total  ' . $band3_total;
        }

        // compute band 4...
        if ($pay >= $band3Setting) {

            if ($pay > $band2Setting && $pay <= $band3Setting) {
                $band4_total = ($pay - $band2Setting) * $band3;
                //echo '$band4_total  '.' '.$band4_total;
            } else if ($pay >= $band3Setting) {
                $band5_total = ($pay - $band3Setting) * $band4;
            }
        }
        $totalTax = $band2_total + $band3_total + $band4_total + $band5_total;
        return $totalTax;
    }

}
