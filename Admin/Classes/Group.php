<?php

class Group
{
    private $link;

    function __construct()
    {
        $this->link = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die('db connection problem' . mysqli_connect_error());
    }

    // check user permission
    public function checkUserPermission(
        $group_id,
        $route_name
    ) {
        // get the permissions id for the group
        $perm_s = mysqli_fetch_assoc(Group::getGroupPermissions($group_id));
        // slice the route name to get only the parent directory
        $route = explode("/", $route_name);
        // e.g. for Groups/groups, only get Groups
        // compare the route name with the entries in the permissions table
        if (array_key_exists(strtolower($route[3]), $perm_s)) {
            $status = $perm_s[strtolower($route[3])] === 'true' ? 'true' : 'false';
        } else {
            $status = 'true';
        }
        // return true or false
        return $status;
    }
    public function createGroup(
        // group name argument
        $name,
        $company_id,
        // permissions arguments
        $comp_setup_arg,
        $employee_arg,
        $hr_reports_arg,
        $payroll_arg,
        $payroll_reports_arg,
        $settings_arg,
        $recruitment_arg,
        $users_arg,
        $groups_arg
    ) {
        // insert a row into permissions_tb
        $newPermissions = mysqli_query($this->link, "INSERT INTO permissions_tb(company_setup, employee, hr_reports, payroll, reports, settings, recruitment, users, groups) VALUES(
        '$comp_setup_arg', 
        '$employee_arg', 
        '$hr_reports_arg', 
        '$payroll_arg', 
        '$payroll_reports_arg', 
        '$settings_arg', 
        '$recruitment_arg', 
        '$users_arg',
        '$groups_arg'
        )");
        // return var_dump($newPermissions);
        $perm_id = mysql_insert_id($link);
        $newGroup = mysqli_query($this->link, "INSERT INTO group_tb(name, permissions_id, company_id) VALUES('$name','$perm_id', '$company_id')");

        return $newGroup;
    }

    public function getGroups($comp)
    {
        $groups = mysqli_query($this->link, "SELECT * FROM group_tb WHERE company_id = '$comp'");
        return $groups;
    }

    public function getGroupById($id)
    {
        $groupResult = mysqli_query($this->link, "SELECT * FROM group_tb WHERE id = '$id'");

        // $group = mysqli_fetch_array($groupResult);

        return $groupResult;
    }

    public function getGroupMemberCount($id, $comp)
    {
        $members = mysqli_query($this->link, "SELECT COUNT(*) as members FROM users_tb WHERE group_id='$id' and company_id = '$comp'") or die(mysqli_error($this->link));
        $row = mysqli_fetch_array($members);
        $nomembers = $row['members'];
        return $nomembers;
    }
    // get group members
    public function getGroupMembers($id, $comp)
    {
        $members = mysqli_query($this->link, "SELECT * FROM users_tb WHERE group_id = '$id' AND company_id = '$comp'") or die(mysqli_error($this->link));
        // $row = mysqli_fetch_array($members);
        return $members;
    }
    public function getGroupPermissions($id)
    {
        $perm = mysqli_query($this->link, "SELECT * FROM group_tb
        LEFT JOIN permissions_tb ON permissions_tb.id = group_tb.permissions_id
        WHERE group_tb.id='$id'");

        return ($perm);
    }
    public function updateGroup(
        // group id
        $group_id_arg,
        // group name argument
        // $name,
        // permissions arguments
        $comp_setup_arg,
        $employee_arg,
        $hr_reports_arg,
        $payroll_arg,
        $payroll_reports_arg,
        $settings_arg,
        $recruitment_arg,
        $users_arg
    ) {
        // find the group
        $group = mysqli_query($this->link, "SELECT * FROM group_tb WHERE id = $group_id_arg");

        // update the row in permissions_tb
        $row = mysqli_fetch_array($group);

        // return var_dump($row['permissions_id']);
        $group_perm = $row['permissions_id'];


        $updatedPermissions = mysqli_query($this->link, "UPDATE permissions_tb SET company_setup = '$comp_setup_arg', employee = '$employee_arg', hr_reports = '$hr_reports_arg', payroll = '$payroll_arg', reports = '$payroll_reports_arg', settings = '$settings_arg', recruitment = '$recruitment_arg', users = '$users_arg' WHERE permissions_tb.id = '$group_perm' ");

        return $updatedPermissions;
    }

    public function updateUserGroup($group_id, $user_id)
    {
        $updateUserQuery = mysqli_query($this->link, "UPDATE users_tb SET group_id = '$group_id' WHERE users_tb.id = '$user_id'");

        if (!$updateUserQuery) {
            die("Query failed: " . mysqli_error($this->link));
        } else {
            // Query successfully executed
            // Handle the result here if needed
            return $updateUserQuery;
        }
    }
    public function deleteGroup($group_id)
    {
        // delete group
        $perms_query = mysqli_query($this->link, "SELECT * from group_tb WHERE id='$group_id'");

        $perms = mysqli_fetch_array($perms_query);

        $perm_id = $perms['permissions_id'];
        // return var_dump($perms);

        $group_del_query = mysqli_query($this->link, "DELETE FROM group_tb WHERE id = '$group_id'");

        // if group deleted, delete permissions
        if ($group_del_query) {
            $del_perms = mysqli_query($this->link, "DELETE FROM permissions_tb WHERE id='$perm_id'");

            // also set user group to 0
            $update_users = mysqli_query($this->link, "UPDATE users_tb SET group_id = '0' WHERE users_tb.group_id = '$group_id'");
        }

        return $group_del_query;
    }
}
