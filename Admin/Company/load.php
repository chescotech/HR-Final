<?php

function getConnection() {
    $dbhost = "127.0.0.1";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "hr_fab";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}


$sql = "SELECT CASE  comp_structure.hod_id
   WHEN '13' THEN 1
  WHEN '1' THEN 18
   ELSE comp_structure.hod_id END memberId, CASE comp_structure.empno
   WHEN 'FAB425' THEN NULL  
   ELSE comp_structure.parent_id END  parentId ,comp_structure.otherInfo from comp_structure WHERE parent_id!=0  order by parentId,memberId";


/*
$sql = "SELECT 
CASE  hod_tb.id
   WHEN '13' THEN 1
  WHEN '1' THEN 18
   ELSE hod_tb.id END memberId
, CASE emp_info.empno
   WHEN 'FAB425' THEN NULL  
   ELSE hod_tb.parent_id
END  parentId   ,CONCAT(emp_info.fname,'  ' ,lname ,' - ',emp_info.position) AS otherInfo,department.department   from hod_tb
inner join department on department.dep_id=hod_tb.departmentId  LEFT JOIN emp_info on emp_info.dept=department.dep_id  order by parentId,memberId";
*/

try {
    $db = getConnection();
    $stmt = $db->query($sql);
    $wines = $stmt->fetchAll(PDO::FETCH_OBJ);
    $db = null;
    echo json_encode($wines);
} catch (PDOException $e) {
    echo '{"error":{"text":' . $e->getMessage() . '}}';
}
?>
