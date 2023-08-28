<div class="content-wrapper">
    <section class="content-header">
        <h1>

            <?php
            require_once('../PHPmailer/sendmail.php');
            require_once('classes.php');
            $Classes = new Classes();
            $user_id = $_SESSION['job_user_id'];

            // echo $companyName . ", employee self service portal";
            ?>

        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">


        <div class="box-body">
            <div class="row">

                <a href="../jobs/profile/profile">
                    <div class="mh-100 col-lg-4 col-xs-6" style="color: white">
                        <div class="small-box bg-blue-active">
                            <div class="inner">
                                <h4 style=" color: white">
                                    My Account </h4>
                                <p style=" color: white">View</p>
                            </div>
                            <div class="icon" style="margin-top:10px">
                                <i class="glyphicon glyphicon-paper"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="Recruitment/postings">
                    <div class="mh-100 col-lg-4 col-xs-6" style="color: white">
                        <div class="small-box bg-blue-active">
                            <div class="inner">
                                <h4 style=" color: white">
                                    Jobs </h4>
                                <p style=" color: white">Available</p>
                            </div>
                            <div class="icon" style="margin-top:10px">
                                <i class="glyphicon glyphicon-paper"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="Recruitment/my_applications">
                    <div class="mh-100 col-lg-4 col-xs-6" style="color: white">
                        <div class="small-box bg-blue-active">
                            <div class="inner">
                                <h4 style=" color: white">
                                    Applied Jobs </h4>
                                <p style=" color: white">View</p>
                            </div>
                            <div class="icon" style="margin-top:10px">
                                <i class="glyphicon glyphicon-paper"></i>
                            </div>
                        </div>
                    </div>
                </a>


            </div>
            <div style="padding: 2px" class="panel text-center">
                <h>
                    <?php
               
                    if ($Classes->profileStatus($user_id) < 90) {
                        echo "Your account is ".$Classes->profileStatus($user_id)."% done. Please complete 
                        your account to increase your chances of success.";
                    }
                    ?>
                </h>
            </div>
        </div>


        <?php
        /*
        include_once '../Admin/Classes/Company.php';
        $CompanyObject = new Company();
        $empno = $_SESSION['employee_id'];
        $companyId = $_SESSION['company_ID'];
        // echo '<img src="' . $CompanyObject->getCompanyLogo3($companyId) . '" height="70%" class="img-thumbnail">';
        if ($CompanyObject->checkLeaveStatus($empno) == "true") {
            // check if two days has elapsed since applied for leave..
            $today = date("Y-m-d");
            $today2 = date($CompanyObject->getLeaveApplicationDate($empno));
            $start = new DateTime($today2);
            $end = new DateTime($today);

            $interval = $end->diff($start);

            $days = $interval->days;

            if ($days > 2) {
                $supervisorsEmial = $CompanyObject->getHodSupervisor($empno);
                $em = new email();
                $image = '<img src="' . $CompanyObject->getCompanyLogo3($companyId) . '" width="100%" height="290" class="img-thumbnail" />';

                $message = "Greetings, ." . "<br>" . "<br>"
                    . "You have a leave application request"
                    . " ,  please login to your account to Approve or Decline this request ,"
                    . "<br>" . "<br>" . " Kind Regards ."
                    . "<br>" . "<br>" . "<br>" . "<br>"
                    . $image;

                $Subject = "Leave Aplication";

                $em->send_mail($supervisorsEmial, $message, $Subject);

                mysql_query("UPDATE leave_applications_tb SET parent_supervisor_notified = 'Yes' WHERE empno = '$empno'");
            }
        }
        */
        ?>

    </section>
</div>