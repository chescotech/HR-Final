<div class="content-wrapper">

    <section class="content-header">
        <h3><b>

                <?php
                $companyName = $_SESSION['company_name'];

                echo $companyName . " Company Structure";
                ?>
            </b>
        </h3>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-lg-3">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h5>Chief Operating Officer (CEO)</h5>
                        <p></p>
                    </div>
                    <a class="small-box-footer">
                        <h4>Mr Lombe Paul Okpara</h4>
                    </a>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h5>General Manager</h5>
                        <p></p>
                    </div>
                    <a class="small-box-footer">
                        <h4>Mr Nicholas Mungo</h4>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            $Company = $_SESSION['company_name'];
            $company_ID = $_SESSION['company_ID'];
            $Departments = mysqli_query($link, "SELECT * FROM hod_tb");
            if (mysqli_num_rows($Departments) != 0) {
                while ($row = mysqli_fetch_array($Departments)) {
                    $departmentId = $row['departmentId'];
                    $empno = $row['empno'];
                    $DepartmentSupervisors = mysqli_query($link, "SELECT * FROM emp_info WHERE empno='$empno' AND company_id='$company_ID'  ");
                    $supervisorRows = mysqli_fetch_array($DepartmentSupervisors);
                    if (mysqli_num_rows($DepartmentSupervisors) == 0) {
                        $supervisorsInfo = "Supervisor Not Yet assigned";
                    } else {
                        $supervisorsInfo = " Supervised by  " . $supervisorRows['fname'] . " " . $supervisorRows['lname'];
                    }

                    $departments = mysqli_query($link, "SELECT * FROM department WHERE dep_id ='$departmentId' AND company_ID= '$company_ID'  ");
                    $departmentNamerow = mysqli_fetch_array($departments);

                    $deptname = $departmentNamerow['department'];
                    if ($deptname != "") {
                        echo '<div class="col-lg-3 col-xs-6">              
                <div class="small-box bg-aqua">                  
                    <div class="inner">
                        <h5>' . "$deptname" . ' Department</h5>                       
                        <p></p>
                    </div>          
                    <a class="small-box-footer">
                        <h5>' . "$supervisorsInfo" . '</h5>                         
                    </a>
                </div>              
            </div> ';
                    }
                }
            } else {
                $Company = $_SESSION['company_name'];
                $Departments = mysqli_query($link, "SELECT * FROM department WHERE company_ID = '$Company'");
                if (mysqli_num_rows($Departments) != 0) {
                    while ($row = mysqli_fetch_array($Departments)) {
                        $deptname = $row['department'];
                        if ($deptname != "") {
                            echo '<div class="col-lg-3 col-xs-6">              
                        <div class="small-box bg-aqua">                  
                            <div class="inner">
                                <h5>' . "$deptname" . ' Department</h5>                       
                                <p></p>
                            </div>          
                            <a class="small-box-footer">
                                <h5>Supervisor Not Yet assigned </h5>                         
                            </a>
                        </div>              
                    </div> ';
                        }
                    }
                }
            }
            ?>
        </div>
    </section>
</div>