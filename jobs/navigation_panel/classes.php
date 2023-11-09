<?php

class Classes
{
    public function profileStatus($user_id)
    {
        $total_points = 0;
        // Other Info Score
        $sql = mysqli_query($link, "SELECT * FROM jobs_user_info WHERE user_id = '$user_id' ") or die(mysqli_error($link));
        $point = 0;
        if (mysqli_num_rows($sql) > 0) {
            $total_points = $total_points + mysqli_num_rows($sql);
            while ($row = mysqli_fetch_array($sql)) {

                if ($row['location'] != '') {
                    $point = $point + 1;
                } elseif ($row['location'] == '') {
                    $point = $point + 0;
                }
                if ($row['lang1'] != '') {
                    $point = $point + 1;
                } elseif ($row['lang1'] == '') {
                    $point = $point + 0;
                }
                if ($row['lang2'] != '') {
                    $point = $point + 1;
                } elseif ($row['lang2'] == '') {
                    $point = $point + 0;
                }
                if ($row['lang3'] != '') {
                    $point = $point + 1;
                } elseif ($row['lang3'] == '') {
                    $point = $point + 0;
                }
                if ($row['marital_status'] != '') {
                    $point = $point + 1;
                } elseif ($row['marital_status'] == '') {
                    $point = $point + 0;
                }
                if ($row['disabilities'] != '') {
                    $point = $point + 1;
                } elseif ($row['disabilities'] == '') {
                    $point = $point + 0;
                }
                if ($row['memberships'] != '') {
                    $point = $point + 1;
                } elseif ($row['memberships'] == '') {
                    $point = $point + 0;
                }
                if ($row['awards'] != '') {
                    $point = $point + 1;
                } elseif ($row['awards'] == '') {
                    $point = $point + 0;
                }
                if ($row['links'] != '') {
                    $point = $point + 1;
                } elseif ($row['links'] == '') {
                    $point = $point + 0;
                }
                if ($row['salary'] != '') {
                    $point = $point + 1;
                } elseif ($row['salary'] == '') {
                    $point = $point + 0;
                }
                if ($row['currency'] != '') {
                    $point = $point + 1;
                } elseif ($row['currency'] == '') {
                    $point = $point + 0;
                }
                if ($row['expected_benefits'] != '') {
                    $point = $point + 1;
                } elseif ($row['expected_benefits'] == '') {
                    $point = $point + 0;
                }
                if ($row['notice_period'] != '') {
                    $point = $point + 1;
                } elseif ($row['notice_period'] == '') {
                    $point = $point + 0;
                }
                if ($row['can_relocate'] != '') {
                    $point = $point + 1;
                } elseif ($row['can_relocate'] == '') {
                    $point = $point + 0;
                }
                if ($row['can_relocate'] != '') {
                    $point = $point + 1;
                } elseif ($row['can_relocate'] == '') {
                    $point = $point + 0;
                }
                if ($row['can_travel'] != '') {
                    $point = $point + 1;
                } elseif ($row['can_travel'] == '') {
                    $point = $point + 0;
                }
            }
        }

        // Skills Score
        $sk_sql = mysqli_query($link, "SELECT * FROM jobs_user_skills WHERE user_id = '$user_id' ") or die(mysqli_error($link));
        $sk_point = 0;
        $total_points = $total_points + 5;
        if (mysqli_num_rows($sk_sql) > 0) {
            $sk_point = 5;
            while ($sk_row = mysqli_fetch_array($sk_sql)) {
            }
        }

        // Qualification Score
        $qal_sql = mysqli_query($link, "SELECT * FROM jobs_user_qualifications WHERE user_id = '$user_id' ") or die(mysqli_error($link));
        $qal_point = 0;
        $total_points = $total_points + 5;
        if (mysqli_num_rows($qal_sql) > 0) {
            $qal_point = 5;
            while ($qal_row = mysqli_fetch_array($qal_sql)) {
            }
        }

        // Experience Score
        $exp_sql = mysqli_query($link, "SELECT * FROM jobs_user_experience WHERE user_id = '$user_id' ") or die(mysqli_error($link));
        $exp_point = 0;
        $total_points = $total_points + 5;
        if (mysqli_num_rows($exp_sql) > 0) {
            $exp_point = 5;
            while ($exp_row = mysqli_fetch_array($exp_sql)) {
            }
        }

        // Attachments Score
        $att_sql = mysqli_query($link, "SELECT * FROM jobs_user_attachments WHERE user_id = '$user_id' ") or die(mysqli_error($link));
        $att_point = 0;
        $total_points = $total_points + 5;
        if (mysqli_num_rows($att_sql) > 0) {
            $att_point = 5;
            while ($att_row = mysqli_fetch_array($att_sql)) {
            }
        }

        // Reference Score
        $ref_sql = mysqli_query($link, "SELECT * FROM jobs_user_refs WHERE user_id = '$user_id' ") or die(mysqli_error($link));
        $ref_point = 0;
        $total_points = $total_points + 5;
        if (mysqli_num_rows($ref_sql) > 0) {
            $ref_point = 5;
            while ($ref_row = mysqli_fetch_array($ref_sql)) {
            }
        }

        // Total score
        $total_score = $point + $sk_point + $qal_point + $exp_point + $att_point + $ref_point;

        $profile_status = ($total_score / $total_points) * 100;

        return number_format($profile_status, 2);
        // return $total_score . $total_points." - ".number_format($profile_status, 2)."%";
    } // func..


} // class
