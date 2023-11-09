<div class="content-wrapper">
    <style>
        .bg-light-green {
            background-color: #8CC63F;
        }
    </style>
    <section class="content-header">
        <h1>

            <?php

            use Dompdf\Css\Color;

            require_once('../PHPmailer/sendmail.php');
            $companyName = $_SESSION['company_name'];

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

                <a href="../employee/Attendance/log-attendance">
                    <div class="mh-100 col-lg-4 col-xs-6" style="color: white">
                        <div class="small-box bg-light-green">
                            <div class="inner">
                                <h4 style=" color: white">
                                    Attendance </h4>
                                <p style=" color: white">Login</p>
                            </div>
                            <div class="icon" style="margin-top:10px">
                                <i class="glyphicon glyphicon-paper"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="../employee/leave/apply">
                    <div class="mh-100 col-lg-4 col-xs-6" style="color: white">
                        <div class="small-box bg-light-green">
                            <div class="inner">
                                <h4 style=" color: white">
                                    Leave </h4>
                                <p style=" color: white">Apply</p>
                            </div>
                            <div class="icon" style="margin-top:10px">
                                <i class="glyphicon glyphicon-paper"></i>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="../employee/Payslips/my-payslips">
                    <div class="mh-100 col-lg-4 col-xs-6" style="color: white">
                        <div class="small-box bg-light-green">
                            <div class="inner">
                                <h4 style=" color: white">
                                    My Payslips </h4>
                                <p style=" color: white">View</p>
                            </div>
                            <div class="icon" style="margin-top:10px">
                                <i class="glyphicon glyphicon-paper"></i>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </section>


    <style>
        .publishes {
            border: 2px solid black;
            margin: 1em;
            padding: 1em;
            color: black;
            width: 60%;
        }

        .container-fluid {
            max-height: 500px;
            /* Adjust this value to control the height of the container */
            overflow-y: scroll;
        }

        textarea {
            width: 100%;
            height: 100%;

        }

        .text {
            height: 12rem;
            position: relative;
            overflow: none;
        }
    </style>

    <div class="container-fluid" style="margin-top: -4.5rem;">
        <?php
        $query = mysqli_query($link, "SELECT * FROM publications ORDER BY date DESC") or die(mysqli_error($link));
        $rowCount = 0; // To keep track of the displayed rows

        while ($row = mysqli_fetch_array($query)) {
            $id_ = $row['id'];
            $date = $row['date'];
            $files = $row['file'];
            $subject = $row['subject'];
            $message = $row['message'];
            $category = $row['category'];

            $color = '';
            if ($category == 'policy') {
                $color = 'brown';
            } else if ($category == 'memo') {
                $color = 'Green';
            } else {
                $color = 'Blue';
            }

        ?>


            <div class="col-md-4 col-sm-8">
                <div class="panel">
                    <div class="panel-heading panel-primary" style="background:<?php echo $color ?>; color:white;">
                        <strong Style="margin:4.8rem; line-height:4rem;;"><?php echo $category; ?> </strong>
                    </div>
                    <div class="panel-body" style="background-color: #f5f5f5; height:25rem;">
                        <p class="m0">
                            <strong>Date: <?php echo $date; ?></strong>
                        </p>
                        <p class="m0">
                            <strong>Subject: <?php echo $subject; ?></strong>
                        </p>
                        <p class="m0 text">
                            Message: <br>
                            <textarea readonly> <?php echo $message ?> </textarea>
                        </p>
                    </div>
                    <a href="../files/<?php echo $files; ?>" class="btn btn-primary" style="margin:1em;" download>
                        Download Attachment
                    </a>
                    <a href="moredetails.php?id=<?php echo $id_ ?>" class="btn btn-primary" style=" margin:1em;">
                        View Details
                    </a>
                </div>
            </div>


            <!-- <div class="publishes" style="border:<?php echo $color ?> solid 2px ;">
            <h3 style="color:<?php echo $color ?>;"> <b><?php echo $category ?></b></h3>
            <div class="date" style="font-size: 2rem;"><?php echo $date ?></div> 
            <div class="subject"><?php echo $subject ?></div><br>
            <div class="message"><?php echo $message ?></div>
        </div> -->
        <?php

            $rowCount++;
        }
        ?>
    </div>