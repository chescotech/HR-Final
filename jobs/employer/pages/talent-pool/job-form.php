<?php
if (isset($_POST["create_posting"])) {
    // return var_dump($link);
    $title = $_POST["title"];
    $dep_id = $_POST["dep_id"];
    $description = $_POST["description"];
    // $regno = $_SESSION["reg_num"];
    $comp_id = $_SESSION["company_ID"];

    mysql_query("INSERT INTO talent_pool (title, department_id, description, emp_id)
                                            VALUES('$title', '$dep_id', '$description', '$comp_id')")
        or die("Err11 " . mysql_error());

    echo "<script>document.location='pool'</script>";
}

?>

<div class="content-wrapper" style="overflow:auto; height:80vh">
    <div>
        <ol class="breadcrumb">
            <li><a href="pool">Talent </a></li>
            <li class="active">Pool</li>
        </ol>
    </div>

    <div style="padding-right:20px; padding-left:20px">

        <form method="POST">

            <div class="panel panel-default">

                <div style="background-color:#fff; border-radius:5px; padding:10px; margin-bottom:20px;">
                    <label>
                        Fill out required information.
                    </label>

                    <div>
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="title">Talent Pool Title:</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>

                            <div class="col-md-6">
                                <label>Department:</label>
                                <select name="dep_id" class="form-control" required>
                                    <option>--Select Department--</option>
                                    <?php
                                    $departmentquery = mysql_query("SELECT * FROM department ");
                                    while ($row = mysql_fetch_array($departmentquery)) {
                                    ?>
                                        <option value="<?php echo $row['dep_id']; ?>"> <?php echo $row['department']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="pwd">Description:</label>
                                <textarea type="text" rows="5" cols="40" class="form-control" name="description" required> </textarea>
                            </div>



                        </div>
                    </div>
                </div>

            </div>


            <div class="panel panel-default">

                <div style="padding:10px; margin-top:20px;">
                    <div>
                        <div action="#save" class="row g-3">
                            <div class="col-md-6">
                                <button name="create_posting" onclick="error_message()" type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>