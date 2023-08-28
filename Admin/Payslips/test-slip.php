<?php

 include_once '../Classes/Department.php';
        include_once '../Classes/Payslips.php';
        include_once '../Classes/Loans.php';
        include_once '../Classes/Tax.php';

  $PaySlipsObject = new Payslips();

echo $PaySlipsObject->pensionCalculations('FAB290');