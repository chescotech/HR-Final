<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Publications</title>
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

<body>
    <div class="content-wrapper">
        <style>
            .bg-light-green {
                background-color: #8CC63F;
            }
        </style>
        <section class="content-header">
            <h1>
        </section>
        <section class="content">


            <div class="box-body">
                <?php include '../navigation_panel/authenticated_user_header.php'; ?>
            </div>
        </section>



        <style>
            #drop-area {
                border: 2px dashed black;
                border-radius: 20px;
                padding: 20px;
                text-align: center;
                font-size: 18px;
            }

            #pub {
                margin: 3em;
                border: 2px solid;
            }

            .pub {
                padding: 3rem;
                margin-left: auto;
                margin-right: auto;
                width: 50rem;
            }

            .pub textarea {
                width: 55rem;
                height: 38rem;
            }

            .pub label {
                width: 7rem;
                margin: 0.5em;

            }

            #drop-area {
                margin: 2rem 2rem 2rem 0;
                width: 100%;
            }

            .pub input {
                width: 70%;
            }

            .pub select {

                width: 50%;
                height: 2em;

            }

            .content {
                min-height: 20px;
            }

            .container-fluid,
            .content {
                background: white;
            }
        </style>


        <?php
        include '../navigation_panel/side_navigation_bar.php';

        if (isset($_POST['submit_publication'])) {
            $subject = $_POST['subject'];
            $category = $_POST['category'];
            $message = $_POST['message'];

            // Handle uploaded file
            $targetDirectory = "../../files/"; // Create this directory and set appropriate permissions
            $targetFile = '';

            if (isset($_POST['submit_publication'])) {
                $subject = $_POST['subject'];
                $category = $_POST['category'];
                $message = $_POST['message'];

                // Handle uploaded file
                $targetDirectory = "../../files/"; // Create this directory and set appropriate permissions
                $targetFile = '';

                if (!empty($_FILES["attachment"]["name"])) {
                    $filename = $_FILES["attachment"]["name"];
                    $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
                    $uniqueFilename = uniqid() . '.' . $fileExtension;
                    $targetFile = $targetDirectory . $uniqueFilename;

                    if (!move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFile)) {
                        echo '<script>alert("Error uploading file.");</script>';
                        // Handle the error appropriately
                    }
                }

                // Get current timestamp
                $timestamp = date('Y-m-d H:i:s');

                // Perform SQL insert operation into the publications table
                // Set the timestamp value directly in the SQL query
                if (!empty($targetFile)) {
                    // File was attached, use $targetFile in your SQL query
                    $sql = "INSERT INTO publications (category, subject, message, file, date) VALUES ('$category', '$subject', '$message', '$uniqueFilename', '$timestamp')";
                } else {
                    // No file attached, insert without the file column
                    $sql = "INSERT INTO publications (category, subject, message, date) VALUES ('$category', '$subject', '$message', '$timestamp')";
                }

                // Execute your SQL query here
                $result = mysqli_query($link, $sql); // Make sure you have $link defined

                if ($result) {
                    echo '<script>alert("Publication inserted successfully!");</script>';
                } else {
                    echo '<script>alert("Error inserting publication: ' . mysqli_error($link) . '");</script>';
                    // Handle the error appropriately, e.g., output MySQL error
                }
            }
        }

        if (isset($_POST['delete_publication']) && isset($_POST['id'])) {
            $id = $_POST['id'];

            // Delete the row from the database
            $sql = "DELETE FROM publications WHERE id = '$id'";
            $result = mysqli_query($link, $sql); // Make sure you have $link defined

            if ($result) {
                echo 'success';
            } else {
                echo 'error';
            }
            exit; // End the script
        }

        ?>
        <?php
        $query0 = mysqli_query($link, "SELECT * FROM publications ORDER BY date DESC") or die(mysqli_error($link));
        $rowCount = 0; // To keep track of the displayed rows
        ?>
        <div class="container-fluid">
            <table id="publication_table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>id</th>
                        <th> date</th>
                        <th>subject</th>
                        <th>message</th>
                        <th>Category</th>
                        <th>Attachment</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $query0 = mysqli_query($link, "SELECT * FROM publications ORDER BY date DESC") or die(mysqli_error($link));
                    $rowCount = 0;
                    while ($row0 = mysqli_fetch_array($query0)) {

                        $id = $row0['id'];
                        $files = $row0['file'];
                    ?>

                        <tr class="del<?php echo $id ?>">
                            <td><?php echo $row0['id']; ?></td>
                            <td><?php echo $row0['date']; ?></td>
                            <td><?php echo $row0['subject']; ?></td>
                            <td><?php echo $row0['message']; ?></td>
                            <td><?php echo $row0['category']; ?></td>
                            <td><a href="../../files/<?php echo $files ?>" class="btn">view</a></td>
                            <td><a href="./edit_form.php?id=<?php echo $id; ?>" class="btn">Edit</a> <a href="#" class="btn delete-btn">Delete</a></td>
                        </tr>
                    <?php } ?>

                </tbody>

            </table>

        </div>

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
            $('#publication_table').DataTable();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#publication_table').DataTable();

            // Capture click event on Delete buttons
            $('.delete-btn').on('click', function(e) {
                e.preventDefault(); // Prevent the link from navigating

                var row = $(this).closest('tr'); // Get the closest table row
                var id = row.find('td:first-child').text(); // Get the ID from the first column

                // Show a confirmation dialog
                var confirmDelete = confirm("Are you sure you want to delete this publication?");

                if (confirmDelete) {
                    // Send an AJAX request to delete the row
                    $.ajax({
                        url: '',
                        type: 'POST',
                        data: {
                            id: id,
                            delete_publication: true
                        }, // Send the ID and a flag to indicate deletion
                        success: function(response) {
                            if (response === 'success') {
                                row.remove(); // Remove the row from the table
                                location.reload(); // Reload the page
                            } else {
                                // alert('Error deleting publication.');
                                location.reload();
                            }
                        },
                        error: function() {
                            alert('An error occurred while processing the request.');
                        }
                    });
                }
            });
        });
    </script>


</body>