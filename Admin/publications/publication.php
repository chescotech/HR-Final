<?php
session_start();
?>
<!DOCTYPE html>
<html>

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
    </style>
</head>

<body class="hold-transition skin-green-light sidebar-mini">
    <div class="wrapper">

        <?php
        include '../navigation_panel/authenticated_user_header.php';
        ?>

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
                    echo '<script>alert("Error inserting publication: ' . mysqli_error($link)($link) . '");</script>';
                    // Handle the error appropriately, e.g., output MySQL error
                }
            }
        }

        ?>

        <div class="content-wrapper">

            <section class="content-header">
                <h2>Publications</h2>
                <h1>
                    <?php
                    $compID = $_SESSION['company_ID'];
                    ?>
                </h1>
            </section>
            <section id="pub">
                <form action="" method="post" class="pub" enctype="multipart/form-data">
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" class="form-control" required><br><br>

                    <label for="category">Category:</label>
                    <select id="category" name="category" class="form-control">
                        <option value="memo">Memo</option>
                        <option value="policy">Policy</option>
                        <option value="news">News</option>
                    </select><br><br>

                    <label for="message">Message:</label><br>
                    <textarea class="form-control" id="message" name="message" rows="6" cols="50" required></textarea><br><br>

                    <div id="drop-area">
                        <input type="file" id="attachment" name="attachment" class="form-control">
                        <p>Drag and drop your file here or click to select</p>
                    </div>

                    <input type="submit" class="btn btn-success" value="Submit" name="submit_publication">
                </form>
            </section>
        </div>


        <script>
            const dropArea = document.getElementById('drop-area');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropArea.classList.add('highlight');
            }

            function unhighlight(e) {
                dropArea.classList.remove('highlight');
            }

            dropArea.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                handleFiles(files);
            }

            function handleFiles(files) {
                const attachmentInput = document.getElementById('attachment');
                attachmentInput.files = files;
            }
        </script>



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
            $('#employee_data').DataTable();
        });
    </script>
</body>

</html>