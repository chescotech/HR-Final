<?php

class Asset
{
    private $link;

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    public function assignAsset($emp_id_arg, $asset_id_arg, $admin_id_arg, $company_id_arg)
    {
        $query = "UPDATE assets SET assigned_to = '$emp_id_arg' WHERE id = '$asset_id_arg'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        if ($queryResult) {
            $assigned_to = NULL;
            $comments = 'asset assigned to employee: ' . $emp_id_arg;
            $admin_id = $admin_id_arg;

            $this->logAssetAssignment($asset_id_arg, $emp_id_arg, $comments, $admin_id, $company_id_arg);
        }

        return $queryResult;
    }

    public function deleteAssetType($asset_type_id_arg)
    {
        $query = "DELETE FROM assets WHERE type_id = '$asset_type_id_arg'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));


        if ($queryResult) {
            $deleteTypeQuery = "DELETE FROM asset_type WHERE id = '$asset_type_id_arg'";

            $deleteTypeResult = mysqli_query($this->link, $deleteTypeQuery) or die(mysqli_error($this->link));

            return $deleteTypeResult;
        } else {
            return false;
        }
    }

    public function deleteAsset($admin_id_arg, $company_id_arg, $asset_id_arg)
    {
        $query = "DELETE FROM assets WHERE id = '$asset_id_arg'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        if ($queryResult) {
            $assigned_to = NULL;
            $comments = 'asset deleted by admin with id: ' . $admin_id_arg;
            $admin_id = $admin_id_arg;

            $this->logAssetDeletion($asset_id_arg, $assigned_to, $comments, $admin_id, $company_id_arg);
        }

        return $queryResult;
    }

    public function getAssets($company_id_arg)
    {
        $query = "SELECT * FROM assets WHERE company_id = '$company_id_arg'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $queryResult;
    }

    public function getAssetTypes($company_id_arg)
    {
        $query = "SELECT * FROM asset_type WHERE company_id = '$company_id_arg'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $queryResult;
    }

    public function getAssetTypeById($type_id)
    {
        $query = "SELECT * FROM asset_type WHERE id = '$type_id'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        $type = mysqli_fetch_assoc($queryResult);

        return $type;
    }

    public function getAssetsInTypeCount($asset_type_id_arg)
    {
        $query = "SELECT COUNT(*) as noassets from assets WHERE type_id = '$asset_type_id_arg'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        $row = mysqli_fetch_assoc($queryResult);

        return $row['noassets'];
    }

    public function returnAsset($admin_id_arg, $asset_id_arg, $comments_arg, $company_id_arg)
    {
        $query = "UPDATE assets SET assigned_to = NULL WHERE id = '$asset_id_arg'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        if ($queryResult) {
            // log asset return;
            $assigned_to = NULL;
            $admin_id = $admin_id_arg;

            $this->logAssetReturn($asset_id_arg, $assigned_to, $comments_arg, $admin_id, $company_id_arg);
        }

        return $queryResult;
    }

    public function saveAsset($admin_id_arg, $name_arg, $description_arg, $identifier_arg, $type_id_arg, $company_id_arg)
    {
        $query = "INSERT INTO assets (name, admin_id, description, identifier, type_id, company_id) VALUES ('$name_arg', '$admin_id_arg','$description_arg','$identifier_arg','$type_id_arg', '$company_id_arg')";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        if ($queryResult) {
            // log asset creation
            $asset_id = mysqli_insert_id($this->link);
            $assigned_to = NULL;
            $comments = 'New asset created by admin with id: ' . $admin_id_arg;
            $admin_id = $admin_id_arg;

            $this->logAssetCreation($asset_id, $assigned_to, $comments, $admin_id, $company_id_arg);
        }

        return $queryResult;
    }

    public function saveNewAssetType($name_arg, $company_id_arg)
    {
        $query = "INSERT INTO asset_type (name, company_id) VALUES ('$name_arg','$company_id_arg')";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $queryResult;
    }

    public function updateAssetType($name_arg, $id_arg)
    {
        $query = "UPDATE asset_type SET name = '$name_arg' WHERE id = '$id_arg'";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $queryResult;
    }

    // logs
    public function logAssetCreation($asset_id_arg, $assigned_to_arg, $comments_arg, $admin_id, $company_id)
    {
        $query = "INSERT INTO asset_logs (asset_id, assigned_to, comments, action, admin_id, company_id) VALUES ('$asset_id_arg', '$assigned_to_arg', '$comments_arg', 'create', '$admin_id', '$company_id')";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $queryResult;
    }

    public function logAssetDeletion($asset_id_arg, $assigned_to_arg, $comments_arg, $admin_id, $company_id_arg)
    {
        $query = "INSERT INTO asset_logs (asset_id, assigned_to, comments, action, admin_id, company_id) VALUES ('$asset_id_arg', '$assigned_to_arg', '$comments_arg', 'delete', '$admin_id', '$company_id_arg')";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $queryResult;
    }

    public function logAssetAssignment($asset_id_arg, $assigned_to_arg, $comments_arg, $admin_id, $company_id_arg)
    {
        $query = "INSERT INTO asset_logs (asset_id, assigned_to, comments, action, admin_id, company_id) VALUES ('$asset_id_arg', '$assigned_to_arg', '$comments_arg', 'assign', '$admin_id', '$company_id_arg')";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $queryResult;
    }

    public function logAssetReturn($asset_id_arg, $assigned_to_arg, $comments_arg, $admin_id, $company_id_arg)
    {
        $query = "INSERT INTO asset_logs (asset_id, assigned_to, comments, action, admin_id, company_id) VALUES ('$asset_id_arg', '$assigned_to_arg', '$comments_arg', 'return', '$admin_id', '$company_id_arg')";

        $queryResult = mysqli_query($this->link, $query) or die(mysqli_error($this->link));

        return $queryResult;
    }
}
