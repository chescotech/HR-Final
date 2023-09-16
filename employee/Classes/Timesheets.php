<?php

include_once 'DBClass.php';

class Timesheets
{
    function __construct()
    {
        $conn = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die('db connection problem' . mysql_error());
        mysql_select_db(DB_NAME, $conn);
    }

    function createTimesheet($emp_no_arg, $company_id_arg, $start_day_arg, $end_day_arg)
    {
        $query = mysql_query("INSERT INTO timesheet(employee_no, company_id, start_date, end_date) VALUES('$emp_no_arg', '$company_id_arg','$start_day_arg','$end_day_arg')") or die(mysql_error());

        return $query;
    }

    function deleteTimesheet($timesheet_id_arg)
    {
        // Select all timesheet_day rows with the specified timesheet_id
        $querySelectDays = "SELECT id FROM timesheet_day WHERE timesheet_id = $timesheet_id_arg";
        $resultSelectDays = mysql_query($querySelectDays);
        if (!$resultSelectDays) {
            die("Query failed: " . mysql_error());
        }

        $dayIdsToDelete = array();
        while ($row = mysql_fetch_assoc($resultSelectDays)) {
            $dayIdsToDelete[] = $row['id'];
        }

        if (!empty($dayIdsToDelete)) {
            // Delete all associated timesheet_entry rows
            $dayIdsToDeleteStr = implode(', ', $dayIdsToDelete);
            $queryDeleteEntries = "DELETE FROM timesheet_entry WHERE day_id IN ($dayIdsToDeleteStr)";
            $resultDeleteEntries = mysql_query($queryDeleteEntries);
            if (!$resultDeleteEntries) {
                die("Query failed: " . mysql_error());
            }

            // Delete the timesheet_day rows
            $queryDeleteDays = "DELETE FROM timesheet_day WHERE timesheet_id = $timesheet_id_arg";
            $resultDeleteDays = mysql_query($queryDeleteDays);
            if (!$resultDeleteDays) {
                die("Query failed: " . mysql_error());
            }

            // Delete the timesheet itself
            $queryDeleteTimesheet = "DELETE FROM timesheet WHERE id = $timesheet_id_arg";
            $resultDeleteTimesheet = mysql_query($queryDeleteTimesheet);
            if (!$resultDeleteTimesheet) {
                die("Query failed: " . mysql_error());
            }

            return $resultDeleteTimesheet;
        }
    }

    function getTimesheets($emp_no_arg)
    {
        $query = mysql_query("SELECT * FROM timesheet WHERE employee_no='$emp_no_arg'");

        return $query;
    }

    function getTimesheetById($timesheet_id_arg)
    {
        $query = mysql_query("SELECT * FROM timesheet WHERE id='$timesheet_id_arg'");

        return $query;
    }

    function getTimeSheetsByDepartment($dept_id_arg)
    {
        $result = mysql_query("SELECT * FROM emp_info em WHERE dept=''$dept_id_arg");

        return $result;
    }

    function saveDay($day_arg, $timesheet_id_arg)
    {
        $query = mysql_query("INSERT INTO timesheet_day(day_date, timesheet_id) VALUES('$day_arg','$timesheet_id_arg')") or die(mysql_error());

        return $query;
    }

    function saveDayEntries($day_id_arg, $start_time_arg, $end_time_arg, $hours_arg, $note_arg, $timesheet_id_arg)
    {
        $query = mysql_query("INSERT INTO timesheet_entry(day_id, start_time, end_time, hours, note) VALUES('$day_id_arg', '$start_time_arg', '$end_time_arg', '$hours_arg', '$note_arg')") or die(mysql_error());

        if ($query) {
            $timesheet = $this->getTimesheetById($timesheet_id_arg);

            $tsRow = mysql_fetch_assoc($timesheet);

            $currentHours = $tsRow['hours'];

            $updateTimesheet = mysql_query("UPDATE timesheet SET hours = ($currentHours + $hours_arg) WHERE id='$timesheet_id_arg'");
        }

        return $query;
    }

    // Check if there are more days to enter
    function hasMoreDays($timesheet_id_arg, $current_date_arg)
    {
        $tsQuery = mysql_query("SELECT end_date FROM timesheet WHERE id='$timesheet_id_arg'");

        $tsRow = mysql_fetch_assoc($tsQuery);

        $timesheet_end_date = new DateTime($tsRow);

        if ($current_date_arg < $timesheet_end_date) {
            return true;
        } else {
            return false;
        }
    }
}
