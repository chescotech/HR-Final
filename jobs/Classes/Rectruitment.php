<?php

include_once 'DBClass.php';

class Rectruitment {

    function __construct() {
        $conn = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('db connection problem' . mysql_error());
        mysql_select_db(DB_NAME, $conn);
    }

    public function countTalentMembers($pool_id) {
        $res = mysql_query("SELECT COUNT(*) AS nomembers FROM `jobs_user_applications` where talent_pool_id='$pool_id'");
        $rows = mysql_fetch_array($res);
        $nomembers = $rows['nomembers'];
        return $nomembers;
    }

}