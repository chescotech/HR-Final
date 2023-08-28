<?php include('../includes/dbconnection.php'); ?>

<header class="main-header" style="background: linear-gradient(to right, #02B9FD, #2ECC71) !important;">
    <div class="container-fluid">
        <center>
            <section class="">
                <h3 style="text-align: center;">
                    <?php
                    echo ' Job Details';
                    ?>
                </h3>

            </section>
        </center>
        <div class="navbar-header" style="height:9rem">
            <a class="navbar-brand" href="#" style="border-radius:100px;">
                <?php
                // echo '<img style="margin-top:-10px;border-radius:100px" src="../../Admin/' . $CompanyObject->getCompanyLogo($companyId) . '" height="58" >';
                echo '<img style="margin-top:-3em;border-radius:100px" src="/jobs/assets/images/logo45.jpeg" height="58" width="59rem" >';

                ?>
            </a>
            <?php include '../navigation_panel/backArrow.php' ?>


        </div>


    </div>
</header>