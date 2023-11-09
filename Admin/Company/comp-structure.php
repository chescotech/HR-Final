<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Company Record</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

    <script type='text/javascript' src='jquery.js'></script>
    <link rel="stylesheet" href="demo1.css" />
    <link rel="stylesheet" href="jquery.orgchart.css" />
    <script src="jquery.orgchart.js"></script>
    <script type='text/javascript'>
        $(function() {
            var members;
            $.ajax({
                url: 'load.php',
                async: false,
                success: function(data) {
                    members = $.parseJSON(data)
                }
            })

            //memberId,parentId,otherInfo
            for (var i = 0; i < members.length; i++) {

                var member = members[i];

                if (i == 0) {
                    $("#mainContainer").append("<li id=" + member.memberId + ">" + member.otherInfo + "</li>")
                } else {

                    if ($('#pr_' + member.parentId).length <= 0) {
                        $('#' + member.parentId).append("<ul id='pr_" + member.parentId + "'><li id=" + member.memberId + ">" + member.otherInfo + "</li></ul>")
                    } else {
                        $('#pr_' + member.parentId).append("<li id=" + member.memberId + ">" + member.otherInfo + "</li>")
                    }

                }
            }

            $("#mainContainer").orgChart({
                container: $("#main"),
                interactive: true,
                fade: true,
                speed: 'slow'
            });

        });
    </script>

</head>

<body class="hold-transition skin-green-light sidebar-mini" style=" background-color      : white;">

    <?php include '../navigation_panel/authenticated_user_header.php'; ?>

    <?php
    include '../navigation_panel/side_navigation_bar.php';
    $CompanyObject = new Company();
    // update the tree structures..

    $CompanyObject->trancateStructure();

    $result = mysqli_query($link, "SELECT hod_tb.id,parent_supervisor,emp_info.empno,CONCAT(emp_info.fname,'  ' ,lname ,' - ',emp_info.position) AS otherInfo from hod_tb LEFT JOIN emp_info on emp_info.empno=hod_tb.empno ") or die(mysqli_error($link));
    while ($row = mysqli_fetch_array($result)) {
        $id = $row['id'];
        $parent_supervisor = $row['parent_supervisor'];
        $empno = $row['empno'];
        $otherInfo = $row['otherInfo'];

        // insert the HOD's..

        $CompanyObject->createHodStrucures($empno, $otherInfo, $id);

        $parentId = $CompanyObject->getSupervisorParentId($parent_supervisor);

        if ($parent_supervisor == "FAB425") {
            mysqli_query($link, "UPDATE  comp_structure SET parent_id='1'  WHERE  empno='$empno' AND hod_id='$id' ") or die(mysqli_error($link));
        } else if ($empno == "FAB425") {
            mysqli_query($link, "UPDATE  comp_structure SET parent_id='0'  WHERE  empno='$empno' AND hod_id='$id' ") or die(mysqli_error($link));
        } else {
            mysqli_query($link, "UPDATE  comp_structure SET parent_id='$parentId'  WHERE  empno='$empno' AND hod_id='$id' ") or die(mysqli_error($link));
        }
    }


    $result_ = mysqli_query($link, "SELECT * FROM `emp_info` where empno not in ( SELECT hod_tb.empno from hod_tb)") or die(mysqli_error($link));
    while ($rows = mysqli_fetch_array($result_)) {
        $id = $rows['id'];
        $dept = $rows['dept'];
        $empno = $rows['empno'];
        $fname = $rows['fname'];
        $lname = $rows['lname'];
        $position = $rows['position'];
        $otherInfo = $fname . ' ' . $lname . ' ' . $position;

        $CompanyObject->createEmployeeStructure($empno, $otherInfo, $id);

        $parentId = $CompanyObject->getHodParentId($dept, $id);

        mysqli_query($link, "UPDATE  comp_structure SET parent_id='$parentId'  WHERE  empno='$empno' AND hod_id='0' ") or die(mysqli_error($link));
    }
    ?>
    <div style="overflow-y: scroll; height:600px;margin-left: 200px">
        <div style="display: none;text-align: center;">

            <ul id="mainContainer" class="clearfix"></ul>

        </div>
        <div id="main">

        </div>

    </div>


    <script src="../bootstrap/js/bootstrap.min.js"></script>

    <script src="../plugins/fastclick/fastclick.min.js"></script>

    <script src="../dist/js/app.min.js"></script>

    <script src="../dist/js/demo.js"></script>

</body>

</html>