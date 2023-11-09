<?php
if (isset($_POST["field"])) {
  $key = strtoupper($_POST["key"]);
  $field = $_POST["field"];
  if (!empty($_POST["key"]))
    if ($field == "empno")
      if (is_numeric($key))
        $query = "SELECT * FROM profile_image WHERE empno = $key limit 1";
      else
        exit('<h6><br/></h6>');
    else
      $query = "SELECT * FROM profile_image WHERE UPPER($field) like '$key%'";
  else
    $query = "SELECT * FROM profile_image";
  include 'employee/include/dbconnection.php';
  $result = mysqli_query($link, $query) or die(mysqli_error($link));
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
?>
    <?php
    @$image = $row['photo'];
    ?><img src="/employee/image/<?php echo $image; ?>" class="img" width=120" height="120">
<?php
  }
}
?>