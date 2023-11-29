<?php
session_start();
?>
<!DOCTYPE html>


<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>My Timesheets</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />

</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
        include_once '../Classes/Leave.php';
        $leaveObject = new Leave();

        $empno = $_SESSION['employee_id'];
        ?>

        <?php include '../navigation_panel/side_navigation_bar.php'; ?>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    My Timesheets
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#"> My Timesheets</a></li>
                </ol>
            </section>

            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div style="display: flex; align-items: center; justify-content: space-between;">

                            <div class="" style="margin-bottom: 8px;">
                                <button href="" onclick="history.back()" class="btn btn-primary">Back</button>
                            </div>
                            <div>
                                <?php
                                // Parse the date string into a DateTime object
                                $date = new DateTime($_GET['current-date']);

                                // Add 1 day to the date
                                $date->add(new DateInterval('P1D')); // P1D represents one day

                                // Format the date back to the desired format (e.g., YYYY-MM-DD)
                                $newDate = $date->format('Y-m-d');

                                // URL-encode the new date
                                $encodedNewDate = urlencode($newDate);
                                ?>
                                <a href="create-timesheet.php?page= <?= $_GET['page'] + 1 ?>&current-date=<?= $newDate ?>" class="btn btn-success">Next Day</a>
                            </div>
                        </div>
                        <div class="box">

                            <div class="box-body">
                                <div class="">
                                    <i class="fa fa-calendar" aria-hidden="true" style="font-size: x-large;"></i>
                                    <span class="" style="font-size: large;">Timesheet Entry for <span style="color: #f44;"><?= $_GET['current-date'] ?></span></span>
                                </div>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Hours</th>
                                            <th>
                                                Notes
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <form method="post" id="timesheet-form">
                                            <tr>
                                                <td>
                                                    <input type="time" name="start_time1" id="start_time1" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="time" name="end_time1" id="end_time1" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="hours1" id="hours1" class="form-control" readonly="true">
                                                </td>
                                                <td>
                                                    <input type="text" name="note1" id="note1" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="time" name="start_time2" id="start_time2" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="time" name="end_time2" id="end_time2" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="hours2" id="hours2" class="form-control" readonly="true">
                                                </td>
                                                <td>
                                                    <input type="text" name="note2" id="note2" class="form-control">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input type="time" name="start_time3" id="start_time3" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="time" name="end_time3" id="end_time3" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="text" name="hours3" id="hours3" class="form-control" readonly="true">
                                                </td>
                                                <td>
                                                    <input type="text" name="note3" id="note3" class="form-control">
                                                </td>
                                            </tr>
                                            <div class="form-group">
                                                <input type="hidden" class="form-control" name="date" id="date" placeholder="" value="<?= $_GET['current-date'] ?>" readonly="true">
                                            </div>
                                            <tr>
                                                <td class="" style="float: right;">
                                                    <div>
                                                        <button type="submit" class="btn btn-primary" id="save-button">Save</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </form>
                                    </tbody>
                                </table>

                            </div><!-- /.box-body -->
                        </div><!-- /.box -->

                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->

        <?php include '../footer/footer.php'; ?>
        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="../plugins/datatables/jquery.dataTables.min.js"></script>

    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <!-- page script -->
    <script>
        $(document).ready(function() {
            // Iterate through the three input sections
            for (var i = 1; i <= 3; i++) {
                // Event listener for changes in start time and end time fields for each section
                $("#start_time" + i + ", #end_time" + i).on("change", function() {
                    var sectionIndex = $(this).attr('id').charAt($(this).attr('id').length - 1); // Get the section index

                    // Get the values of start time and end time for the current section
                    var startTime = $("#start_time" + sectionIndex).val();
                    var endTime = $("#end_time" + sectionIndex).val();

                    // Check if both start time and end time are filled for the current section
                    if (startTime !== "" && endTime !== "") {
                        // Convert start time and end time to Date objects
                        var startDate = new Date("1970-01-01T" + startTime + "Z");
                        var endDate = new Date("1970-01-01T" + endTime + "Z");

                        // Calculate the time difference in milliseconds
                        var timeDiff = endDate - startDate;

                        // Calculate hours and minutes from milliseconds
                        var hours = Math.floor(timeDiff / (1000 * 60 * 60));
                        var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));

                        // Update the hours input field for the current section
                        $("#hours" + sectionIndex).val(hours + (minutes / 60));
                    } else {
                        // If either start time or end time is not filled, clear the hours input field for the current section
                        $("#hours" + sectionIndex).val("");
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const numDays = <?= $_SESSION['num_days']; ?>;
            const form = document.getElementById("timesheet-form");
            const saveButton = document.getElementById("save-button");

            let currentPage = <?= $_GET['page'] ?>;

            saveButton.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent the default form submission

                const entries = [];

                // Calculate the current date for the current page
                const currentDate = document.getElementById("date").value;

                // Parse the date string into a Date object
                const nextDate = new Date(currentDate);

                // Add one day to the date
                nextDate.setDate(nextDate.getDate() + 1);

                // Convert the updated date back to a string in the same format
                const updatedDateString = nextDate.toISOString().split('T')[0];

                // Iterate through the fields for the current page
                for (let i = 1; i <= 3; i++) {
                    const startTime = document.getElementById('start_time' + i).value;
                    const endTime = document.getElementById('end_time' + i).value;
                    const hours = document.getElementById('hours' + i).value;
                    const note = document.getElementById('note' + i).value;

                    // Construct an object for each entry
                    const entry = {
                        start_time: startTime,
                        end_time: endTime,
                        hours: hours,
                        note: note,
                    };

                    // Push the entry to the entries array
                    entries.push(entry);
                }

                // Send data (entries array) to the server via fetch
                const nextPage = currentPage + 1;

                fetch("save-day.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({
                            date: currentDate,
                            page: currentPage,
                            entries: entries,
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }

                        // Check if the response indicates that there are more pages
                        if (currentPage <= numDays) {
                            // Update the page number for the next page
                            // form.value = nextPage;

                            // Reload the page (or use AJAX to load the next page)
                            window.location.assign("create-timesheet?page=" + nextPage + "&current-date=" + updatedDateString);
                        } else {
                            // All data has been saved, you can redirect to a success page or perform other actions
                            alert("All data has been saved.");
                            window.location.assign("my-timesheets");
                        }
                    })
                    // .then(data => {
                    // })
                    .catch(error => {
                        console.error("Error:", error);
                    });
            });
        });
    </script>
</body>

</html>