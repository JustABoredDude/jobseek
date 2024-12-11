<?php
require_once("../../include/initialize.php");
if (!isset($_SESSION['ADMIN_USERID'])) {
    redirect(web_root . "admin/index.php");
}

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
    case 'add':
        if (isAdmin()) {
            doInsert();
        } else {
            unauthorizedRedirect();
        }
        break;

    case 'edit':
        if (isAdmin()) {
            doEdit();
        } else {
            unauthorizedRedirect();
        }
        break;

    case 'delete':
        if (isAdmin()) {
            doDelete();
        } else {
            unauthorizedRedirect();
        }
        break;
}

function isAdmin()
{
    return isset($_SESSION['ADMIN_ROLE']) && $_SESSION['ADMIN_ROLE'] == 'Administrator';
}

function unauthorizedRedirect()
{
    message("You do not have permission to perform this action.", "error");
    redirect("index.php");
}

function doInsert()
{
    if (isset($_POST['save'])) {
        if ($_POST['COMPANYNAME'] == "" || $_POST['COMPANYADDRESS'] == "" || $_POST['COMPANYCONTACTNO'] == "") {
            message("All fields are required!", "error");
            redirect('index.php?view=add');
        } else {
            $company = new Company();
            $company->COMPANYNAME = $_POST['COMPANYNAME'];
            $company->COMPANYADDRESS = $_POST['COMPANYADDRESS'];
            $company->COMPANYCONTACTNO = $_POST['COMPANYCONTACTNO'];
            $company->create();

            message("New company created successfully!", "success");
            redirect("index.php");
        }
    }
}

function doEdit()
{
    if (isset($_POST['save'])) {
        $company = new Company();
        $company->COMPANYNAME = $_POST['COMPANYNAME'];
        $company->COMPANYADDRESS = $_POST['COMPANYADDRESS'];
        $company->COMPANYCONTACTNO = $_POST['COMPANYCONTACTNO'];
        $company->update($_POST['COMPANYID']);

        message("Company has been updated!", "success");
        redirect("index.php");
    }
}

function doDelete()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $company = new Company();
        $company->delete($id);

        message("Company has been deleted!", "info");
        redirect("index.php");
    }
}
?>
