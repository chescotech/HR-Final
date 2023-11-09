<?php

include_once 'DBClass.php';

class Timesheets
{
    private $link;

    function __construct($link)
    {
        $this->link = $link ? $link : mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    function createTimesheet($emp_no_arg, $company_id_arg, $start_day_arg, $end_day_arg)
    {
        $query = mysqli_query($this->link, "INSERT INTO timesheet(employee_no, company_id, start_date, end_date) VALUES('$emp_no_arg', '$company_id_arg','$start_day_arg','$end_day_arg')") or die(mysqli_error($this->link));

        return $query;
    }

    function deleteTimesheet($timesheet_id_arg)
    {
        // Select all timesheet_day rows with the specified timesheet_id
        $querySelectDays = "SELECT id FROM timesheet_day WHERE timesheet_id = $timesheet_id_arg";
        $resultSelectDays = mysqli_query($this->link, $querySelectDays);
        if (!$resultSelectDays) {
            die("Query failed: " . mysqli_error($this->link));
        }

        $dayIdsToDelete = array();
        while ($row = mysqli_fetch_assoc($resultSelectDays)) {
            $dayIdsToDelete[] = $row['id'];
        }

        if (!empty($dayIdsToDelete)) {
            // Delete all associated timesheet_entry rows
            $dayIdsToDeleteStr = implode(', ', $dayIdsToDelete);
            $queryDeleteEntries = "DELETE FROM timesheet_entry WHERE day_id IN ($dayIdsToDeleteStr)";
            $resultDeleteEntries = mysqli_query($this->link, $queryDeleteEntries);
            if (!$resultDeleteEntries) {
                die("Query failed: " . mysqli_error($this->link));
            }

            // Delete the timesheet_day rows
            $queryDeleteDays = "DELETE FROM timesheet_day WHERE timesheet_id = $timesheet_id_arg";
            $resultDeleteDays = mysqli_query($this->link, $queryDeleteDays);
            if (!$resultDeleteDays) {
                die("Query failed: " . mysqli_error($this->link));
            }

            // Delete the timesheet itself
            $queryDeleteTimesheet = "DELETE FROM timesheet WHERE id = $timesheet_id_arg";
            $resultDeleteTimesheet = mysqli_query($this->link, $queryDeleteTimesheet);
            if (!$resultDeleteTimesheet) {
                die("Query failed: " . mysqli_error($this->link));
            }

            return $resultDeleteTimesheet;
        }
    }

    function getTimesheets($emp_no_arg)
    {
        $query = mysqli_query($this->link, "SELECT * FROM timesheet WHERE employee_no='$emp_no_arg'");

        return $query;
    }

    public function getTimesheetDetails($timesheet_id_arg)
    {
        $query = "SELECT * FROM timesheet ts
        INNER JOIN timesheet_day td on td.timesheet_id=ts.id
        INNER JOIN timesheet_entry te on td.id=te.day_id
        WHERE ts.id='$timesheet_id_arg'";

        $result = mysqli_query($this->link, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($this->link));
        }

        return $result;
    }

    function getTimesheetById($timesheet_id_arg)
    {
        $query = mysqli_query($this->link, "SELECT * FROM timesheet WHERE id='$timesheet_id_arg'");

        return $query;
    }

    function getTimeSheetsByDepartment($dept_id_arg)
    {
        $result = mysqli_query($this->link, "SELECT * FROM emp_info em 
        INNER JOIN timesheet on timesheet.employee_no=em.empno
        WHERE em.dept='$dept_id_arg'");

        return $result;
    }

    function saveDay($day_arg, $timesheet_id_arg)
    {
        $query = "INSERT INTO timesheet_day(day_date, timesheet_id) 
              VALUES('$day_arg','$timesheet_id_arg')";
        mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return mysqli_insert_id($this->link);
    }

    function saveDayEntries($day_id_arg, $start_time_arg, $end_time_arg, $hours_arg, $note_arg, $timesheet_id_arg)
    {
        $query = mysqli_query($this->link, "INSERT INTO timesheet_entry(day_id, start_time, end_time, hours, note) VALUES('$day_id_arg', '$start_time_arg', '$end_time_arg', '$hours_arg', '$note_arg')") or die(mysqli_error($this->link));

        if ($query) {
            $timesheet = $this->getTimesheetById($timesheet_id_arg);

            $tsRow = mysqli_fetch_assoc($timesheet);

            $currentHours = $tsRow['hours'];

            $updateTimesheet = mysqli_query($this->link, "UPDATE timesheet SET hours = ($currentHours + $hours_arg) WHERE id='$timesheet_id_arg'");
        }

        return $query;
    }

    // Check if there are more days to enter
    function hasMoreDays($timesheet_id_arg, $current_date_arg)
    {
        $tsQuery = mysqli_query($this->link, "SELECT end_date FROM timesheet WHERE id='$timesheet_id_arg'");

        $tsRow = mysqli_fetch_assoc($tsQuery);

        $timesheet_end_date = new DateTime($tsRow);

        if ($current_date_arg < $timesheet_end_date) {
            return true;
        } else {
            return false;
        }
    }


    public function updateTimesheetStatus($status_arg, $timesheet_id_arg)
    {
        $query = "UPDATE timesheet SET status='$status_arg' WHERE id='$timesheet_id_arg'";

        $result = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $result;
    }
}
