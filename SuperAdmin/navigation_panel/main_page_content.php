<div class="content-wrapper">       
    <section class="content-header">
        <h1 style="color: black"><b>
                <?php
                $fname = $_SESSION['firstname'];
                $lname = $_SESSION['lastname'];
                echo 'Hi, '. $fname." ".$lname;
                ?>
            </b>       
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <?php
        echo '<img src="../src/images/logo.png" width="100%" height="110" class="img-thumbnail">';
        ?>
    </section>
</div>

