<?php

include_once 'DBClass.php';

class Reminders
{
    private $link;

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function checkForReminders($companyId)
    {
        $count = 0;
        $result = mysqli_query($this->link, "SELECT * FROM emp_info where company_id = '$companyId'");
        while ($rows = mysqli_fetch_array($result)) {

            $fname = $rows['fname'];
            $lname = $rows['lname'];
            $id = $rows['id'];

            $datePrinted = strtoTime($rows['date_left']);
            $expiryDate = date('F d, Y', $datePrinted);
            $dateEnd = $rows['date_left'];
            $probationDate = $rows['probation_deadline'];
            $probationExpireDate = date('F d, Y', strtoTime($rows['probation_deadline']));

            $todaysDate = date("Y-m-d");
            // check for probation deadline .. 
            $d1 = new DateTime($todaysDate);
            $d2 = new DateTime($probationDate);
            $probationDuration = $d1->diff($d2)->days;

            // check for contract deadline .. 

            $d11 = new DateTime($todaysDate);
            $d22 = new DateTime($dateEnd);
            $contractDuration = $d11->diff($d22)->days;

            if ($dateEnd != "" || $probationDate != "") {
                if ($dateEnd <= $todaysDate && $dateEnd != "") {
                    $count++;
                } else if ($contractDuration <= 30 && $dateEnd != "") {
                    $count++;
                } else if ($probationDate <= $todaysDate && $probationDate != "") {
                    $count++;
                }
                if ($probationDate > $todaysDate && $probationDuration <= 30 && $probationDate != "") {
                    $count++;
                }
            }
        }
        return $count;
    }

    public function getReminders($companyId)
    {

        $months = 0;
        $result = mysqli_query($this->link, "SELECT * FROM emp_info where company_id = '$companyId'");
        while ($rows = mysqli_fetch_array($result)) {

            $fname = $rows['fname'];
            $lname = $rows['lname'];
            $id = $rows['id'];

            $datePrinted = strtoTime($rows['date_left']);
            $expiryDate = date('F d, Y', $datePrinted);
            $dateEnd = $rows['date_left'];
            $probationDate = $rows['probation_deadline'];
            $probationExpireDate = date('F d, Y', strtoTime($rows['probation_deadline']));

            $todaysDate = date("Y-m-d");
            // check for probation deadline .. 
            $d1 = new DateTime($todaysDate);
            $d2 = new DateTime($probationDate);
            $probationDuration = $d1->diff($d2)->days;

            // check for contract deadline .. 

            $d11 = new DateTime($todaysDate);
            $d22 = new DateTime($dateEnd);
            $contractDuration = $d11->diff($d22)->days;

            if ($dateEnd != "" || $probationDate != "") {
                if ($dateEnd <= $todaysDate && $dateEnd != "") {
                    $reminderType = "Contract Reminder";
                    $reminderMessage = "Contract for " . $fname . " " . $lname . " expired on " . $expiryDate;
                    echo '<tr style="color:red;">               
                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-red"></i></a></td>
                <td class="mailbox-name"><a href="reminder-details?id=' . $id . '&reminderType=' . $reminderType . '&message=' . $reminderMessage . '">' . $fname . " " . $lname . '</a></td>
                <td class="mailbox-subject"><b>' . $reminderMessage . ' </b></td>
                </tr>';
                } else if ($contractDuration <= 30 && $dateEnd != "") {
                    $reminderType = "Contract Reminder";
                    $reminderMessage = "Contract for " . $fname . " " . $lname . " expires on " . $expiryDate;
                    echo '<tr style="color:orange;">              
                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                <td class="mailbox-name"><a href="reminder-details?id=' . $id . '&reminderType=' . $reminderType . '&message=' . $reminderMessage . '">' . $fname . " " . $lname . '</a></td>
               <td class="mailbox-subject"><b>' . $reminderMessage . '</b></td>
                </tr>';
                } else if ($probationDate <= $todaysDate && $probationDate != "") {
                    $reminderType = "Probation Reminder";
                    $reminderMessage = "Probation for " . $fname . " " . $lname . " expired on " . $probationExpireDate;
                    echo '<tr style="color:red;">               
                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
               <td class="mailbox-name"><a href="reminder-details?id=' . $id . '&reminderType=' . $reminderType . '&message=' . $reminderMessage . '">' . $fname . " " . $lname . '</a></td>
                <td class="mailbox-subject"><b>' . $reminderMessage . '</b></td>
                </tr>';
                }
                if ($probationDate > $todaysDate && $probationDuration <= 30 && $probationDate != "") {
                    $reminderType = "Probation Reminder";
                    $reminderMessage = "Probation for " . $fname . " " . $lname . " expires on " . $probationExpireDate;
                    echo '<tr style="color:orange;">               
                <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                <td class="mailbox-name"><a href="reminder-details?id=' . $id . '&reminderType=' . $reminderType . '&message=' . $reminderMessage . '">' . $fname . " " . $lname . '</a></td>
                <td class="mailbox-subject"><b>' . $reminderMessage . '</b></td>
                </tr>';
                }
            }
        }
    }

    public function getDepartmentById($depId)
    {
        $query =  mysqli_query($this->link, "SELECT * FROM department WHERE dep_id = '$depId' ");
        $rows = mysqli_fetch_array($query);
        $deptName = $rows['department'];
        return $deptName;
    }
}
