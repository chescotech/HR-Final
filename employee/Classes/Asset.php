<?php

class Asset
{

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function getMyAssets($emp_no_arg)
    {
        $query = "SELECT * FROM assets WHERE assigned_to = '$emp_no_arg'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $queryResult;
    }

    public function getAssetTypeById($id)
    {
        $query = "SELECT * FROM asset_type WHERE id = '$id'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return mysqli_fetch_assoc($queryResult);
    }
}
