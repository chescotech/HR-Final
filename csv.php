<!DOCTYPE html>
<!--
    To change this license header, choose License Headers in Project Properties.
    To change this template file, choose Tools | Templates
    and open the template in the editor.
    -->
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <form method="post">
        <button type="submit" name="btn_export">Data Export</button>
        <button type="submit" name="btn_import">Data Import</button>
    </form>
    <?php
    $host = "localhost";
    $uname = "root";
    $pass = "";
    $database = "pay"; //Change Your Database Name
    $conn = new mysqli($host, $uname, $pass, $database) or die("No Connection");
    echo mysqli_error($link);
    //MYSQL MYADDMINPHP TO CSV
    if (isset($_REQUEST['btn_export'])) {
        $data_op = "";
        $sql = $conn->query("select * from users"); //Change Your Table Name          
        while ($row1 = $sql->fetch_field()) {
            $data_op .= '"' . $row1->name . '",';
        }
        $data_op .= "\n";
        while ($row = $sql->fetch_assoc()) {
            foreach ($row as $key => $value) {
                $data_op .= '"' . $value . '",';
            }
            $data_op .= "\n";
        }
        $filename = "Database.csv"; //Change File type CSV/TXT etc
        header('Content-type: application/csv'); //Change File type CSV/TXT etc
        header('Content-Disposition: attachment; filename=' . $filename);
        echo $data_op;
        exit;
    }
    //CSV To MYSQL MYADDMINPHP
    if (isset($_REQUEST['btn_import'])) {
        $filename = 'Database.csv';
        $fp = fopen($filename, "r");
        while (($row = fgetcsv($fp, "40", ",")) != FALSE) {
            $sql = "INSERT INTO users (name,pass,city,id) VALUES('" . implode("','", $row) . "')";
            if (!$conn->query($sql)) {
                echo '<br>Data No Insert<br>';
            }
        }
        fclose($fp);
    }
    ?>
</body>

</html>