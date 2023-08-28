
<?php
function getMappedLocation($minlocation) {
    $query = mysql_query(" SELECT * FROM test_tb");
    while ($row = mysql_fetch_array($query)) {
        $location = $row['location'];
    }
}

function google_getCountry($jsondata) {
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"]);
}

function google_getProvince($jsondata) {
    return Find_Long_Name_Given_Type("administrative_area_level_1", $jsondata["results"][0]["address_components"], true);
}

function google_getCity($jsondata) {
    return Find_Long_Name_Given_Type("locality", $jsondata["results"][0]["address_components"]);
}

function google_getStreet($jsondata) {
    return Find_Long_Name_Given_Type("street_number", $jsondata["results"][0]["address_components"]) . ' ' . Find_Long_Name_Given_Type("route", $jsondata["results"][0]["address_components"]);
}

function google_getPostalCode($jsondata) {
    return Find_Long_Name_Given_Type("postal_code", $jsondata["results"][0]["address_components"]);
}

function google_getCountryCode($jsondata) {
    return Find_Long_Name_Given_Type("country", $jsondata["results"][0]["address_components"], true);
}

function google_getAddress($jsondata) {
    return $jsondata["results"][0]["formatted_address"];
}

function Find_Long_Name_Given_Type($type, $array, $short_name = false) {
    foreach ($array as $value) {
        if (in_array($type, $value["types"])) {
            if ($short_name)
                return $value["short_name"];
            return $value["long_name"];
        }
    }
}

function check_status($jsondata) {
    if ($jsondata["status"] == "OK")
        return true;
    return false;
}

function getCategoryNames($catid) {
    $query = mysql_query("SELECT * FROM tutor_category_tb WHERE id = '$catid'");
    $rows = mysql_fetch_array($query);
    $categoryName = $rows['name'];
    return $categoryName;
}

function getTutoringSubjects($id) {

    $message = "";
    $query = mysql_query("SELECT * FROM tutor_details_tb WHERE id = '$id'");
    $rows = mysql_fetch_array($query);
    $subtCateOne = $rows['sub_category_id'];
    $subCatTwo = $rows['sub_category_two'];
    $subCatThree = $rows['sub_category_three'];

    // first cat..
    $query2 = mysql_query(" SELECT * FROM sub_categories WHERE id = '$subtCateOne' ");
    $subRow1 = mysql_fetch_array($query2);

    // second cat...
    $query3 = mysql_query(" SELECT * FROM sub_categories WHERE id = '$subCatTwo' ");
    $subRow2 = mysql_fetch_array($query3);

    // cat three...

    $query4 = mysql_query(" SELECT * FROM sub_categories WHERE id = '$subCatThree' ");
    $subRow3 = mysql_fetch_array($query4);

    if ($subRow3['name'] != "" && $subRow2['name'] != "" && $subRow1['name'] != "") {
        $message = "<p>&#10004; " . $subRow3['name'] . " <br>" . "<p>&#10004; " . $subRow2['name'] . " <br>" . "<p>&#10004; " . $subRow1['name'];
    } elseif ($subRow3['name'] != "" && $subRow2['name'] == "" && $subRow1['name'] == "") {
        $message = "<p>&#10004; " . $subRow3['name'];
    } elseif ($subRow3['name'] != "" && $subRow2['name'] != "" && $subRow1['name'] == "") {
        $message = "<p>&#10004; " . $subRow3['name'] . " <br>" . "<p>&#10004; " . $subRow2['name'];
    } elseif ($subRow3['name'] == "" && $subRow2['name'] == "" && $subRow1['name'] != "") {
        $message = "<p>&#10004; " . $subRow1['name'];
    }

    return $message;
}

function getTutoringSubjects2($id) {
    $subjects = array();
    $query = mysql_query("SELECT * FROM tutor_details_tb WHERE id = '$id'");
    $rows = mysql_fetch_array($query);
    $subtCateOne = $rows['sub_category_id'];
    $subCatTwo = $rows['sub_category_two'];
    $subCatThree = $rows['sub_category_three'];

    // first cat..
    $query2 = mysql_query("SELECT * FROM sub_categories WHERE id = '$subtCateOne'");
    $subRow1 = mysql_fetch_array($query2);

    // second cat...
    $query3 = mysql_query("SELECT * FROM sub_categories WHERE id = '$subCatTwo'");
    $subRow2 = mysql_fetch_array($query3);

    // cat three...
    $query4 = mysql_query("SELECT * FROM sub_categories WHERE id = '$subCatThree'");
    $subRow3 = mysql_fetch_array($query4);

    if ($subRow1['name'] != "") {
        $subjects[] = $subRow1['name'];
    }
    if ($subRow2['name'] != "") {
        $subjects[] = $subRow2['name'];
    }
    if ($subRow3['name'] != "") {
        $subjects[] = $subRow3['name'];
    }

    return $subjects;
}


function getCategoryIdFromSubCat($subCatId) {
    $query = mysql_query("SELECT * FROM sub_categories WHERE id = '$subCatId'");
    $rows = mysql_fetch_array($query);
    $category_id = $rows['category_id'];
    return $category_id;
}

function getCoordinates($address) {

// Get JSON results from this request
    $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');

// Convert the JSON to an array
    $geo = json_decode($geo, true);

    if ($geo['status'] == 'OK') {
        // Get Lat & Long
        $latitude = $geo['results'][0]['geometry']['location']['lat'];
        $longitude = $geo['results'][0]['geometry']['location']['lng'];
    }
    return -15.420562 . "," . $longitude;
}

function computeNearestTutionCentre($lat1, $lon1, $categoryId) {

    $cart = array();
    $location = array();
    $result = mysql_query("SELECT * FROM tution_centers_tb WHERE category_one='$categoryId' "
            . "OR category_two='$categoryId' OR category_three ='$categoryId' AND status = 'Approved' ");
    while ($row = mysql_fetch_array($result)) {
        // compute distance between each tution centre and the users location, 
        // keep each distance in a list and then find the min distance. 
        // return the tution centres location..  
        $address = "Chindo Rd, Lusaka, Zambia"; //$row['physical_address'];

        $arr2 = explode(",", getCoordinates($address));
        list($lat2, $lon2) = $arr2;
        $unit = "N";
        $distance = distance($lat1, $lon1, $lat2, $lon2, $unit);
        array_push($cart, round($distance));
        array_push($location, $address);
    }

    // find the minimum distance .. 
    for ($i = 0; $i < count($cart); $i++) {
        //Find maximum number by max function.
        if ($cart[$i] == max($cart)) {
            //Print maximum number.
            $max = $cart[$i];
        }
        //Find minimum number by min function.
        elseif ($cart[$i] == min($cart)) {
            //Print minimum  number.
            $min = $cart[$i];
            $minLocation = $location[$i];
        }
        echo getCoordinates($minLocation);
    }
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function checkForCentreInDb($usersLocation) {
    $status = "";
    $result = mysql_query("SELECT * FROM tution_centers_tb WHERE physical_address = '$usersLocation' ");
    if (mysql_num_rows($result) == 0) {
        $status = "true";
    } else {
        $status = "false";
    }
    return $status;
}

if (!empty($_POST['latitude']) && !empty($_POST['longitude'])) {

    $lat = $_POST['latitude'];
    $lon = $_POST['longitude'];

    $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lon&sensor=false";

    $data = @file_get_contents($url);

    $jsondata = json_decode($data, true);

    if (!check_status($jsondata))
        return array();

    $address = array(
        'country' => google_getCountry($jsondata),
        'province' => google_getProvince($jsondata),
        'city' => google_getCity($jsondata),
        'street' => google_getStreet($jsondata),
        'postal_code' => google_getPostalCode($jsondata),
        'country_code' => google_getCountryCode($jsondata),
        'formatted_address' => google_getAddress($jsondata),
    );

    $UsersPhysicalAddress = $address['formatted_address'];

    // where city = > and province => and street =>  
    // check for approved tution centres by category..
    $categoryId = 1;
    $result = mysql_query("SELECT * FROM tution_centers_tb WHERE category_one='$categoryId' AND status = 'Approved' ");

    $row = mysql_fetch_array($result);

    $PysicalLocation = $row['physical_address'];
    $Town = $row['town'];
    $Email = $row['email_address'];
    $phone = $row['phone_number'];
    // check for tuition centre by physical address...
    $result2 = mysql_query("SELECT * FROM tution_centers_tb WHERE physical_address = 'Chindo Rd, Lusaka, Zambia' AND  category_one='$categoryId' OR category_two='$categoryId' OR category_three='$categoryId'");
    if (mysql_num_rows($result) != 0 && mysql_fetch_array($result2) != 0) {
        $row = mysql_fetch_array($result2);
        $address = $row['physical_address'];
        echo getCoordinates($address);
    } else {
        computeNearestTutionCentre($lat, $lon, $categoryId);
    }
}
?>
