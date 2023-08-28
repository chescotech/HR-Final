<?php include '../../include/dbconnection.php'  ?>


<?php
$currentDate = date("Y-m-d");


$query3 = mysql_query("SELECT description,date, sum(amount) as total_exp FROM expenses_tb WHERE date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)  group by description ") or die(mysql_error());
$query4 = mysql_query("SELECT sum(amount) as total_exp FROM `expenses_tb` WHERE date >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)") or die(mysql_error());
$query5 = mysql_query("SELECT sales.date_added, sales_details.qty, sales_details.price FROM sales INNER JOIN sales_details ON sales_details.sales_id = sales.sales_id WHERE date_added >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)") or die(mysql_error());
$query6 = mysql_query("SELECT qty, price, date2collect FROM draft_temp_trans") or die(mysql_error());
$query7 = mysql_query("SELECT qty, price, date2collect FROM draft_temp_trans WHERE date2collect < '$currentDate'") or die(mysql_error());

$row4 = mysql_fetch_array($query4);
// $row5 = mysqli_fetch_array($query5);

$total = $row4['total_exp'];

if (mysql_num_rows($query3) > 0) {
    $expenses = array();
    
    while ($row3 = mysql_fetch_array($query3)) {
        $total_exp = $row3['total_exp'];
        $desc = $row3['description']; // Use the same $desc variable
                
        
        // Store the data in the array
        $expenses[] = array('description' => $desc, 'total_exp' => $total_exp);
    }
}

if (mysql_num_rows($query5) > 0) {
    $sales = array();

    
    while ($row5 = mysql_fetch_array($query5)) {
        $price = $row5['price'];
        $qty = $row5['qty'];
        $sales_total = $qty * $price;
        $sales_date = $row5['date_added'];          
        $totalAllSales = 0;
        
        // Store the data in the array
        $sales[] = array('qty' => $qty, 'price' => $price, 'total' => $sales_total, 'date_added' => $sales_date);
        $totalAllSales += $sales_total;
    }
}

function calculateProfitLoss($totalAllSales, $total) {
    $pl =  number_format(($totalAllSales - $total), 2, '.', ',');
    
    if ($totalAllSales > $total) {
        return '<span style="color: green;">You have a profit of k ' . $pl . '</span>';
    } else {
        return '<span style="color: red;">You have a loss of k ' . $pl . '</span>';
    }
}


$profitLossMessage = calculateProfitLoss($totalAllSales, $total);

if (mysql_num_rows($query6) > 0) {
    $invoice = array();

    $totalAllDraft =0;
    while ($row6 = mysql_fetch_array($query6)) {
        $draft_price = $row6['price'];
        $draft_qty = $row6['qty'];
        $draft_total = $draft_qty * $draft_price;
        $draft_date = $row6['date2collect'];          
        
        
        // Store the data in the array
        $invoice[] = array('qty' => $draft_qty, 'price' => $draft_price, 'total' => $draft_total, 'invoice_date' => $draft_date);
        $totalAllDraft += $draft_total;
    }
}



// Initialize the total outside the loop

if (mysql_num_rows($query7) > 0) {
    $invoice2 = array();
    $totalAllDraft2 = 0; 
    

    while ($row7 = mysql_fetch_array($query7)) {
        $draft_price2 = $row7['price'];
        $draft_qty2 = $row7['qty'];
        $draft_total2 = $draft_qty2 * $draft_price2;
        $draft_date2 = $row7['date2collect'];

        $invoice2[] = array('qty' => $draft_qty2, 'price' => $draft_price2, 'total' => $draft_total2, 'invoice_date' => $draft_date2);
        $totalAllDraft2 += $draft_total2;
    }
}

?>


