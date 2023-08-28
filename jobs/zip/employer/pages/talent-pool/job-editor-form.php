<?php
if (isset($_GET['id'])) {
    $from_jobs_id = $_GET['id'];

    $user_q = mysql_query("SELECT * FROM talent_pool   WHERE id=$from_jobs_id ") or die(mysql_error());
    while ($row = mysql_fetch_array($user_q)) {
        $edit_title = $row["title"];
        $edit_dep_id = $row["department_id"];
        $description = $row["description"];
        
    }
}

if (isset($_POST["updated_posting"])) {
    // return var_dump($link);
    $title = $_POST["title"];
    $dep_id = $_POST["dep_id"];
    
    $description = $_POST["description"];
    

    mysql_query("UPDATE talent_pool SET title='$title', department_id='$dep_id',description='$description'
     WHERE id='$from_jobs_id'")
        or die("Err11 " . mysql_error());

    echo "<script>document.location='pool'</script>";
}

?>

<div class="content-wrapper" style="overflow:auto; height:80vh">
    <div>
        <ol class="breadcrumb">
            <li><a href="pool">Talent</a></li>
            <li class="active"> Pool</li>
        </ol>
    </div>

    <div style="padding-right:20px; padding-left:20px">

        <form method="POST">

            <div class="panel panel-default">

                <div style="background-color:#fff; border-radius:5px; padding:10px; margin-bottom:20px;">
                    <label>
                        Edit out required information.
                    </label>

                    <div>
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="title">Job Title:</label>
                                <input value="<?php echo $edit_title; ?>" type="text" class="form-control" name="title" required>
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
                                <label for="pwd">Talent Description:</label>
                                <textarea  type="text" class="form-control" name="description" rows="5" cols="40" required>
                                <?php echo $description; ?>
                                </textarea>
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
                                <button name="updated_posting" onclick="error_message()" type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>