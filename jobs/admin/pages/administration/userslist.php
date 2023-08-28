<head>
    <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">

</head>

<div class="content-wrapper">
    <div>
        <ol class="breadcrumb">
            <li><a href="#">Administration</a></li>
            <li class="active">Users</li>
        </ol>
    </div>
    <div class="panel panel-default">
        <div class="panel-body" style="font-size:14px;">

            <div style="padding-bottom:10px">
                <a class="btn btn-primary" href="new-user">Create New User</a>
            </div>

            <table id="maintable" class="display compact cell-border" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>email</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>User type</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $user_q = mysql_query("SELECT * FROM jobs_users WHERE user_type='admin' ") or die(mysql_error());
                    while ($row = mysql_fetch_array($user_q)) {
                        $fname = $row['fname'];
                        $lname = $row['lname'];
                        $email = $row['email'];
                        $gender = $row['gender'];
                        $user_id = $row['id'];
                        $phone = $row['phone'];
                        $user_type = $row['user_type'];

                        $fullname = $fname . ' ' .  $lname;

                        echo '
                            <tr>
                                <td>' . $fullname . '</td>
                                <td>' . $email . '</td>
                                <td>' . $gender . '</td>
                                <td>' . $phone . '</td>
                                <td>' . $user_type . '</td>
                                <td>
                                    <a class="btn btn-primary" style="padding:2px; padding-left: 10px; padding-right:10px;" href="user-editor.php?id=' . $user_id . '">Edit</a>
                                    <a class="btn btn-danger" style="padding:2px; padding-left: 10px; padding-right:10px;" href="deleteuser.php?id=' . $user_id . '">Delete</a>
                                </td>
                            </tr>';
                    }
                    ?>

                </tbody>
                <tfoot style="background-color: #c0c0c0; color: #ffffff; font-size: 0.9em; ">
                    <tr>
                        <th>Name</th>
                        <th>email</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>User type</th>
                        <th>actions</th>
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