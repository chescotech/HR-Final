<?php

class UIDao {

    public function addProspectCustomer($type, $name, $contact_person, $location, $cell_one, $cell_two, $landline, $email, $clients_email, $date_of_contact, $item, $no_projects, $last_quoted_amount, $amount_invoiced_to_date, $project_manager, $userId, $prospect, $probability) {

        $res = mysql_query("INSERT INTO customer_prospects_tb(type,name,contact_person,"
                . "location,cell_number,cell_number2,landline,email_address,client_address,"
                . "date_of_first_contact,item,number_of_projects,last_quoted_amount,"
                . "amount_invoiced_to_date,project_manager,last_updated_by,prospect,probability) "
                . "VALUES('$type','$name','$contact_person','$location','$cell_one',"
                . "'$cell_two','$landline','$email','$clients_email','$date_of_contact'"
                . ",'$item','$no_projects','$last_quoted_amount','$amount_invoiced_to_date','$project_manager','$userId','$prospect','$probability')");
        return $res;
    }

    public function updateProspectCustomer($type, $name, $contact_person, $location, $cell_one, $cell_two, $landline, $email, $clients_email, $date_of_contact, $item, $no_projects, $last_quoted_amount, $amount_invoiced_to_date, $project_manager, $Id, $prospect, $probability) {
        $result = mysql_query("UPDATE customer_prospects_tb SET type ='$type',name='$name',"
                . "contact_person='$contact_person',location='$location',cell_number='$cell_one'"
                . ", cell_number2='$cell_two',"
                . "landline='$landline',email_address='$email',client_address='$clients_email'"
                . ",date_of_first_contact='$date_of_contact',item= '$item',number_of_projects='$no_projects'"
                . ",last_quoted_amount='$last_quoted_amount',amount_invoiced_to_date='$amount_invoiced_to_date'"
                . ",project_manager='$project_manager',prospect='$prospect',probability='$probability' WHERE id= '$Id'");
        return $result;
    }

    public function checkCustomerType($refId) {
        $status = "";
        $result = mysql_query("SELECT type FROM customer_prospects_tb WHERE id = (SELECT quote_to FROM quote_tmp_tb where ref_id = '$refId' )");
        $rows = mysql_fetch_array($result);
        $Type = $rows['type'];
        if ($Type == "Individual") {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    public function checkLabourStatus($refNo) {
        $status = "";
        $query = mysql_query("SELECT * FROM labour_tb WHERE ref_id = '$refNo' ");
        if (mysql_num_rows($query) != 0) {
            $status = "true";
        } else {
            $status = "false";
        }
        return $status;
    }

    public function getCustomerDetailsById($refId) {
        $result = mysql_query("SELECT * FROM customer_prospects_tb WHERE id = ( SELECT quote_to FROM quote_tmp_tb where ref_id = '$refId'  ) ");
        $rows = mysql_fetch_array($result);
        $details = $rows['contact_person'];
        return $details;
    }

    public function getClientsAddress($refId) {
        $result = mysql_query("SELECT * FROM customer_prospects_tb WHERE id = ( SELECT quote_to FROM quote_tmp_tb where ref_id = '$refId'  ) ");
        $rows = mysql_fetch_array($result);
        $details = $rows['client_address'];
        return $details;
    }

    public function getClientsPhoneNumber($refId) {
        $result = mysql_query("SELECT * FROM customer_prospects_tb WHERE id = ( SELECT quote_to FROM quote_tmp_tb where ref_id = '$refId'  ) ");
        $rows = mysql_fetch_array($result);
        $details = $rows['cell_number'];
        return $details;
    }

    public function checkIfPasswordExsists($userId, $password) {
        $status = "";
        $pass = md5($password);
        $result = mysql_query("SELECT * FROM users_tb WHERE password = '$pass' AND id = '$userId'");
        if (mysql_num_rows($result) == 0) {
            $status = "false";
        } else {
            $status = "true";
        }
        return $status;
    }

    public function changePassword($userId, $password) {
        $pass = md5($password);
        $result = mysql_query("UPDATE users_tb SET password ='$pass' WHERE id = '$userId'");
        return $result;
    }

    public function UploadedBy($user_id) {
        $query = mysql_query(" SELECT * FROM users_tb WHERE id = '$user_id'");
        $row = mysql_fetch_array($query);
        $fname = $row['firstname'];
        $lname = $row['lastname'];
        $details = $fname . " " . $lname;
        return $details;
    }

    public function getProspectCustomers() {
        $query = mysql_query(" SELECT * FROM customer_prospects_tb ");
        return $query;
    }

    public function addCostings($item_name, $description, $unit_measure, $latest_price, $latest_price_source, $previous_price, $previous_price_source, $alternate_price, $alternate_price_source, $today, $userId, $supplier_name, $brand) {

        $res = mysql_query("INSERT INTO costings_tb(item_name,description,unit_of_measure,"
                . "latest_price,latest_price_source,previous_price,previous_price_source,"
                . "alternate_price,alternate_price_source,last_updated,user_id,supplier_name,brand) "
                . "VALUES('$item_name','$description','$unit_measure','$latest_price','$latest_price_source',"
                . "'$previous_price','$previous_price_source','$alternate_price','$alternate_price_source','$today','$userId','$supplier_name','$brand')");
        return $res;
    }

    public function addQuoteData($quote_to, $po_ref_no, $sales_person, $sales_location, $refNo, $delivery_period, $quotationValidity, $quotation_for, $payment_terms, $quotationDate) {
        $res = mysql_query("INSERT INTO quote_tmp_tb(quote_to,po_ref_no,sales_location,sales_person,ref_id,delivery_period,quotation_validity,quotation_for,payment_terms,date_quotation) "
                . "VALUES('$quote_to','$po_ref_no','$sales_location','$sales_person','$refNo','$delivery_period','$quotationValidity','$quotation_for','$payment_terms','$quotationDate')");
        return $res;
    }

    public function addQuoteItems($quote_item, $dimensions, $qty, $sqm, $refNo, $over_ride_pricing, $estimated_days) {
        $res = mysql_query("INSERT INTO quote_items_temp_tb(item_description,dimensions,qty,"
                . "SQM,ref_id,price_per_sqm,estimated_days) "
                . "VALUES('$quote_item','$dimensions','$qty','$sqm','$refNo','$over_ride_pricing','$estimated_days')");
        return $res;
    }

    public function addLabour($labourDescription, $labourCharge, $estimatedDays, $refId) {
        $res = mysql_query("INSERT INTO labour_tb(labour_description,labour_charge,estimated_days,"
                . "ref_id) "
                . "VALUES('$labourDescription','$labourCharge','$estimatedDays','$refId')");
        return $res;
    }

    public function getQuoteItems() {
        $res = mysql_query("SELECT * FROM pricing_tb");
        return $res;
    }

    public function addPricing($job_type, $description, $item_type
    , $unit_of_measure, $unit_price, $max_discount, $date_added, $last_updated, $last_updatedby, $approved_by) {
        $res = mysql_query("INSERT INTO pricing_tb(job_type,description,item_type,"
                . "unit_of_measure,unit_price,max_discount,date_added,"
                . "last_updated,last_updatedby,approved_by) "
                . "VALUES('$job_type','$description','$item_type','$unit_of_measure','$unit_price',"
                . "'$max_discount','$date_added','$last_updated','$last_updatedby','$approved_by')");
        return $res;
    }

    public function updatePricing($job_type, $description, $item_type
    , $unit_of_measure, $unit_price, $max_discount, $date_added, $last_updated, $last_updatedby, $approved_by, $Id) {
        $result = mysql_query("UPDATE pricing_tb SET job_type ='$job_type',description='$description',"
                . "item_type='$item_type',unit_of_measure='$unit_of_measure',unit_price='$unit_price'"
                . ", max_discount='$max_discount',"
                . "date_added='$date_added',last_updated='$last_updated',last_updatedby='$last_updatedby'"
                . ",last_updated='$approved_by' WHERE id= '$Id'");
        return $result;
    }

    public function getLastUpdateduserDetails() {
        
    }

    public function updateCosting($item_name, $description, $unit_measure, $latest_price, $latest_price_source, $previous_price, $previous_price_source, $alternate_price, $alternate_price_source, $today, $Id, $supplier_name, $brand) {
        $result = mysql_query("UPDATE costings_tb SET item_name ='$item_name',description='$description',"
                . "unit_of_measure='$unit_measure',latest_price='$latest_price',latest_price_source='$latest_price_source'"
                . ", previous_price='$previous_price',"
                . "previous_price_source='$previous_price_source',alternate_price='$alternate_price',alternate_price_source='$alternate_price_source'"
                . ",last_updated='$today',supplier_name ='$supplier_name',brand='$brand' WHERE id= '$Id'");
        return $result;
    }

}
