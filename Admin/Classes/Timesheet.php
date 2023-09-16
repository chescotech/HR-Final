<?php

class Timesheet
{

    public function getAllTimesheets()
    {
        $query = "SELECT * FROM timesheet";
        $result = mysql_query($query);
        if (!$result) {
            die("Query failed: " . mysql_error());
        }

        $timesheets = array();
        while ($row = mysql_fetch_assoc($result)) {
            $timesheets[] = $row;
        }

        return $timesheets;
    }
    public function getAllTimesheetsByCompany($company_id_arg)
    {
        $query = "SELECT * FROM timesheet WHERE company_id='$company_id_arg'";
        $result = mysql_query($query);
        if (!$result) {
            die("Query failed: " . mysql_error());
        }

        return $result;
    }

    public function getEmployeeTimesheets($emp_id_arg)
    {
        $query = "SELECT * FROM timesheet WHERE employee_no = '$emp_id_arg'";
        $result = mysql_query($query);
        if (!$result) {
            die("Query failed: " . mysql_error());
        }


        return $result;
    }

    public function getTimesheetDetails($timesheet_id_arg)
    {
        $query = "SELECT * FROM timesheet ts
        INNER JOIN timesheet_day td on td.timesheet_id=ts.id
        INNER JOIN timesheet_entry te on td.id=te.day_id
        WHERE ts.id='$timesheet_id_arg'";

        $result = mysql_query($query);

        if (!$result) {
            die("Query failed: " . mysql_error());
        }

        return $result;
    }

    public function setEmployeeTimesheets($emp_id_arg, $status_arg)
    {
        $query = "UPDATE emp_info SET has_timesheets='$status_arg' WHERE empno='$emp_id_arg'";

        $result = mysql_query($query) or die(mysql_error());

        return $result;
    }

    public function updateTimesheetStatus($status_arg, $timesheet_id_arg)
    {
        $query = "UPDATE timesheet SET status='$status_arg' WHERE id='$timesheet_id_arg'";

        $result = mysql_query($query) or die(mysql_error());

        return $result;
    }

    public function viewTimesheet($timesheet_id_arg)
    {
        $timesheet_id = intval($timesheet_id_arg);
        $query = "SELECT * FROM timesheet WHERE id = $timesheet_id";
        $result = mysql_query($query);
        if (!$result) {
            die("Query failed: " . mysql_error());
        }

        $timesheet = mysql_fetch_assoc($result);

        return $timesheet;
    }
}
