<?php
error_reporting(0); 

?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="content-wrapper" style="background-color: white">

    <style>
        :root {
            --chart-label-color: #333;
            --chart-background-color: rgba(0, 0, 0, 0.5);
            --chart-data-colors: 'rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)', 'rgba(75, 192, 192, 0.7)';
        }


        .col-sm-3 {
            margin: .5rem;
            height: 15rem;
            /* border: 2px solid black; */
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .container-fluid {
            width: 100%;
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            height: 33rem;
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            position: relative;
        }

        .col-sm-5 {

            margin-right: auto;
            margin-left: auto;
        }

        .row {
            margin: 4rem;
        }

        .stats {
            max-height: 200px;
            /* Set a maximum height for the scrollable area */
            overflow-y: auto;
            /* Add vertical scroll if content overflows */
        }

        .th {
            line-height: 3em;
            display: flex;
            flex-direction: row;
            justify-content: space-between;

        }

        .tm {
            line-height: 1.4em;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .graph {

            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            position: relative;
            height: 100%;
            width: 60%;


        }

        .graph .diagram {
            flex-direction: column;
            background-color: transparent;
            justify-content: space-evenly;
        }

        .graph .diagram p {
            visibility: hidden;
        }


        .graph .stats {
            margin: 1rem 0 0 0.0rem;
            padding: 1rem 0 1rem 0;
        }

        .graph .stats p {

            padding: 0.2rem;
            position: relative;
        }


        .graph .stats .box {
            background: rgba(255, 99, 132, 0.7);
        }

        .box2 {
            background: rgba(54, 162, 235, 0.7);
        }

        .box3 {
            background: rgba(75, 192, 192, 0.7);
        }

        .graph .stats p b {
            width: 2rem;
            height: 4rem
        }


        .boxes {
            margin-top: 2.8em !important;
            height: fit-content;
        }

        .legend {
            margin-right: 0.5em;
            display: inline-flex;
            width: 10px;
            height: 10px;
            background: #9AD0F5;
            border: 1px solid black;
        }

        .legend2 {
            margin-right: 0.5em;
            display: inline-flex;
            width: 10px;
            height: 10px;
            background: #CC99BC;
            border: 1px solid black;
        }
        .th p {
            color: RED;
        }
    </style>
    <?php include './Classes/Loans.php';
    $LoanObject = new Loans();
    $companyId = $_SESSION['company_ID']; ?>
    <?php require './Reports.php' ?>
    <section class="content-header">
        <h1 style="color: black"><b>
                <?php
                $compName = $_SESSION['name'];
                $companyId = $_SESSION['company_ID'];
                echo ' Welcome to ' . $compName . ' Admin Panel ';
                ?>
            </b>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">

        <div class="wrapper" style="background: white;">

            <div class="container-fluid ">

                <div class="row">
                    <div class="">
                        <div class="col-sm-4 col-xs-4">
                            <div class="card">
                                <center>
                                    <div class="th">
                                    <?php                                         
                                        if(empty($gender)){
                                            echo ' <p style ="margin-right:auto; margin-left:auto; width:100%;"> No available data for chart</p>';                                             
                                        }
                                        ?>
                                    </div>
                                    <p> Total employees : <?php echo $totalGenderCount ?> </p>
                                    <p> Total percentages : male <?php echo number_format($totalMalePercentage, 2) . '%' ?> female: <?php echo number_format($totalFemalePercentage, 2) . '%' ?> </p>
                                    <div class="graph">
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </center>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-4">
                            <div class="card">
                                <center>
                                    <div class="th">
                                    <?php                                         
                                        if(empty($department)){
                                            echo ' <p style ="margin-right:auto; margin-left:auto; width:100%;"> No available data for chart </p>';                                             
                                        }
                                        ?>
                                    </div>
                                    <p> Total employees : <?php echo $totalGenderCount ?> </p>
                                    <div class="graph">
                                        <canvas id="myChart2"></canvas>
                                    </div>
                                </center>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-4">
                            <div class="card">
                                <center>
                                    <div class="th">  
                                    <?php                                         
                                        if(empty($totalEarlyArrivals & $totalLateArrivals)){
                                            echo ' <p style ="margin-right:auto; margin-left:auto; width:100%;"> No available data for chart </p>';                                             
                                        }
                                        ?>                                  
                                    </div>
                                    <div class="graph">
                                        <canvas id="myChart3"></canvas>
                                    </div>
                                </center>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container-fluid ">

                <div class="row">
                    <div class="">
                        <div class="col-sm-6 col-xs-6">
                            <div class="card">
                                <center>
                                    <div class="th">
                                    <?php                                         
                                        if(empty($ageGroups)){
                                            echo ' <p style ="margin-right:auto; margin-left:auto; width:100%;"> No available data for chart </p>';                                             
                                        }
                                        ?>

                                    </div>
                                    <div class="graph">
                                        <canvas id="myChart4"></canvas>
                                    </div>
                                </center>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-56">
                            <div class="card">
                                <center>
                                    <div class="th">
                                    <?php                                         
                                        if(empty($years)){
                                            echo ' <p style ="margin-right:auto; margin-left:auto; width:100%;"> No available data for chart </p>';                                             
                                        }
                                        ?>
                                    </div>
                                    <div class="graph">
                                        <canvas id="myChart5"></canvas>
                                    </div>
                                </center>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container-fluid ">

                <div class="row">
                    <div class="">


                        <div class="col-sm-6 col-xs-6">
                            <div class="card">
                                <center>
                                    <div class="th">
                                        <?php                                         
                                        if(empty($grossPayGroups)){
                                            echo ' <p style ="margin-right:auto; margin-left:auto; width:100%;"> No available data for chart </p>';                                             
                                        }
                                        ?>
                                    </div>
                                    <div class="graph">
                                        <canvas id="myChart7"></canvas>
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
    const gender = <?php echo json_encode($gender) ?>;
    const data = {
        labels: ['female', 'men'],
        datasets: [{
            data: gender.map(item => item.count),
            backgroundColor: ['magenta', '#236192'],
            borderWidth: 0,
        }],
    };


    const department = <?php echo json_encode($department) ?>;
    const data2 = {
        labels: department.map(item => item.departmentNames),
        datasets: [{
            data: department.map(item => item.count),
            data: department.map(item => item.count),
            backgroundColor: ['green', 'brown'],
            borderWidth: 0,
        }],
    };

    const totalEarlyArrivals = <?php echo json_encode($totalEarlyArrivals) ?>;
    const totalLateArrivals = <?php echo json_encode($totalLateArrivals) ?>;

    console.log(totalEarlyArrivals);
    console.log(totalLateArrivals);

    const data3 = {
        labels: ['Early Arrival', 'Late Arrival'],
        datasets: [{
            data: [totalEarlyArrivals, totalLateArrivals],
            backgroundColor: ['green', 'red'], // Color for early and late arrivals
            borderWidth: 0,
        }],
    };

    const ageGroupCounts = <?php echo json_encode($ageGroups) ?>;
    const data4 = {
        labels: ['18-25', '26-35', '36-45', '46+'],
        datasets: [{
            label: 'Age Group Distribution',
            data: Object.values(ageGroupCounts),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgb(54, 162, 235)',
            borderWidth: 1
        }]
    };

    const data5 = {
        labels: <?php echo json_encode($years); ?>,
        datasets: [{
            label: 'Exit with reason Distribution',
            data: <?php echo json_encode($counts); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgb(54, 162, 235)',
            borderWidth: 1
        }]
    };       


    const data6 = {
        labels: [
            'Eating',
            'Drinking',
            'Sleeping',
            'Designing',
            'Coding',
            'Cycling',
            'Running'
        ],
        datasets: [{
                label: 'My First Dataset',
                data: [65, 59, 90, 81, 56, 55, 40],
                fill: true,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgb(255, 99, 132)',
                pointBackgroundColor: 'rgb(255, 99, 132)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(255, 99, 132)'
            },
            {
                label: 'My Second Dataset',
                data: [28, 48, 40, 19, 96, 27, 100],
                fill: true,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgb(54, 162, 235)',
                pointBackgroundColor: 'rgb(54, 162, 235)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(54, 162, 235)'
            }
        ]
    };


    const grossPayGroups = <?php echo json_encode($grossPayGroups) ?>;
    const data7 = {
        labels: ['1 - 2000', '2001 - 4800', '4801 - 6000', '6001 - 9999', '10000 - 15000', '15001 - 20000', '20001 - 30000', '30001 - 60000', '60000+'],
        labels: ['1 - 2000', '2001 - 4800', '4801 - 6000', '6001 - 9999', '10000 - 15000', '15001 - 20000', '20001 - 30000', '30001 - 60000', '60000+'],
        datasets: [{
            label: 'Gross Pay Distribution',
            data: Object.values(grossPayGroups),
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgb(54, 162, 235)',
            borderWidth: 1
        }]
    };


    const config = {
        type: 'pie',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true, // Display the legend
                    position: 'bottom', // Position the legend at the bottom
                    labels: {
                        boxWidth: 10, // Set the width of the legend color boxes
                        usePointStyle: true // Use circle shape for legend color boxes
                    }
                },
                title: {
                    display: true,
                    text: 'gender stats'
                }
            }
        },
    };

    const config2 = {
        type: 'pie',
        data: data2,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true, // Display the legend
                    position: 'bottom', // Position the legend at the bottom
                    labels: {
                        boxWidth: 10, // Set the width of the legend color boxes
                        usePointStyle: true // Use circle shape for legend color boxes
                    }
                },
                title: {
                    display: true,
                    text: 'Employee stats by department'
                }
            }
        },
    };

    const config3 = {
        type: 'pie',
        data: data3,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    color: 'black'
                },
                labels: {
                    boxWidth: 10, // Set the width of the legend color boxes
                    usePointStyle: true // Use circle shape for legend color boxes
                },
                title: {
                    display: true,
                    text: 'Early and Late Login Counts'
                }
            }
        },
    };

    const config4 = {
        type: 'bar',
        data: data4,
        options: {
            responsive: true,
            scales: {
                x: { // x-axis becomes the horizontal axis
                    beginAtZero: true,
                    ticks: {
                        stepSize: 20 // Adjust this to control the step size of the x-axis ticks
                    }
                },
                y: { // y-axis becomes the vertical axis
                    beginAtZero: true
                }
            }
        },
    };

    const config5 = {
        type: 'bar',
        data: data5,
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        },
    };        



    const config6 = {
        type: 'radar',
        data: data6,
        options: {
            elements: {
                line: {
                    borderWidth: 3
                }
            }
        }
    };

    const config7 = {
        type: 'bar',
        data: data7,
        options: {
            responsive: true,
            scales: {
                x: { // x-axis becomes the horizontal axis
                    beginAtZero: true,
                    ticks: {
                        stepSize: 20 // Adjust this to control the step size of the x-axis ticks
                    }
                },
                y: { // y-axis becomes the vertical axis
                    beginAtZero: true
                }
            }
        },
    };



    const myChart = new Chart(document.getElementById('myChart').getContext('2d'), config);
    const myChart2 = new Chart(document.getElementById('myChart2').getContext('2d'), config2);
    const myChart3 = new Chart(document.getElementById('myChart3').getContext('2d'), config3);
    const myChart4 = new Chart(document.getElementById('myChart4').getContext('2d'), config4);
    const myChart5 = new Chart(document.getElementById('myChart5').getContext('2d'), config5);
    const myChart7 = new Chart(document.getElementById('myChart7').getContext('2d'), config7);
</script>

<?php
include_once '../Admin/Classes/Company.php';
$CompanyObject = new Company();
$compName = $_SESSION['name'];
$companyId = $_SESSION['company_ID'];
$_key = $_SESSION['_key'];

// echo '<img src="' . $CompanyObject->getCompanyLogo($companyId) . '" width="50%" >';
echo '<h4 style="color:red"><b>Software License valid till: ' . $CompanyObject->checkExpiryDate($_key) . '.<b></h4>';
echo '<h4 style="color:red"><b>Software Registered for : ' . number_format($CompanyObject->checkNousers($_key), 2) . ' users . <b></h4>';
?>
</section>
</div>