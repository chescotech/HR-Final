<head>
    <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">

</head>

<div class="content-wrapper">
    <div>
        <ol class="breadcrumb">
            <li><a href="#">Jobs</a></li>
            <li class="active">List</li>
        </ol>
    </div>
    <div class="panel panel-default">
        <div class="panel-body" style="font-size:14px;">

            <div style="padding-bottom:10px">
                <a class="btn btn-primary" href="create-job">Create New Job</a>
            </div>

            <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Job title</th>
                        <th>Department</th>
                        <th>Salary Min</th>
                        <th>Salary Max</th>
                        <th>Expires</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $user_q = mysql_query("SELECT * FROM jobs_postings INNER JOIN department ON jobs_postings.dep_id = department.dep_id ") or die(mysql_error());
                    while ($row = mysql_fetch_array($user_q)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $department = $row['department'];
                        // $vacancies = $row['vacancies'];
                        // $experience = $row['experience'];
                        $salary_min = $row['salary_min'];
                        $salary_max = $row['salary_max'];
                        // $date = $row['date'];
                        $expires = $row['expires'];

                        echo '
                            <tr>
                                <td>' . $title . '</td>
                                <td>' . $department . '</td>
                                <td>' . $salary_min . '</td>
                                <td>' . $salary_max . '</td>
                                <td>' . $expires . '</td>
                                <td>
                                    <a class="btn btn-primary" style="padding:2px; padding-left: 10px; padding-right:10px;" href="job_details.php?job=' . $id . '">View</a>
                                    <a class="btn btn-primary" style="padding:2px; padding-left: 10px; padding-right:10px;" href="job_details.php?job=' . $id . '">Candidates</a>
                                    <a class="btn btn-info" style="padding:2px; padding-left: 10px; padding-right:10px;" href="job-editor.php?id=' . $id . '">Edit</a>
                                    <a class="btn btn-danger" style="padding:2px; padding-left: 10px; padding-right:10px;" href="delete-job.php?id=' . $id . '">Delete</a>
                                </td>
                            </tr>';
                    }
                    ?>

                </tbody>
                <tfoot style="background-color: #c0c0c0; color: #ffffff; font-size: 0.9em; ">
                    <tr>
                        <th>Job title</th>
                        <th>Department</th>
                        <th>Salary Min</th>
                        <th>Salary Max</th>
                        <th>Expires</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" src="../../js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../../js/jszip.min.js"></script>
<script type="text/javascript" src="../../js/pdfmake.min.js"></script>
<script type="text/javascript" src="../../js/vfs_fonts.js"></script>
<script type="text/javascript" src="../../js/buttons.html5.min.js"></script>
<script type="text/javascript" src="../../js/buttons.print.min.js"></script>
<script type="text/javascript" src="../../js/app.js"></script>
<script type="text/javascript" src="../../js/jquery.mark.min.js"></script>
<script type="text/javascript" src="../../js/datatables.mark.js"></script>
<script type="text/javascript" src="../../js/buttons.colVis.min.js"></script>

<script>
   $(document).ready(function() {
    var table = $('#maintable').DataTable();
 
    $('#maintable tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    } );
 
    $('#button').click( function () {
        alert( table.rows('.selected').data().length +' row(s) selected' );
    } );
} );
</script>