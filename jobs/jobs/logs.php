<?php

class Logs
{

    public function createLog($trans_name, $trans_by, $trans_on)
    {
        mysqli_query($link, "INSERT INTO `jobs_logs`(`trans_name`, `trans_by`, `trans_on`)
                            VALUES ('$trans_name', '$trans_by', '$trans_on')
            ") or die(mysqli_error($link));
    }
}
