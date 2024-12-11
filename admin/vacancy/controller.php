<?php
require_once("../../include/initialize.php");

// Ensure the session is active and the user is logged in
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
    global $mydb;
    if (isset($_POST['save'])) {
        // Check for required fields
        if ($_POST['COMPANYID'] == "None") {
            message("All fields are required!", "error");
            redirect('index.php?view=add');
        } else {
            // Insert new job vacancy
            $job = new Jobs();
            $job->COMPANYID = $_POST['COMPANYID'];
            $job->CATEGORY = fetchCategoryName($_POST['CATEGORY']);
            $job->OCCUPATIONTITLE = $_POST['OCCUPATIONTITLE'];
            $job->REQ_NO_EMPLOYEES = $_POST['REQ_NO_EMPLOYEES'];
            $job->SALARIES = $_POST['SALARIES'];
            $job->DURATION_EMPLOYEMENT = $_POST['DURATION_EMPLOYEMENT'];
            $job->QUALIFICATION_WORKEXPERIENCE = $_POST['QUALIFICATION_WORKEXPERIENCE'];
            $job->JOBDESCRIPTION = $_POST['JOBDESCRIPTION'];
            $job->PREFEREDSEX = $_POST['PREFEREDSEX'];
            $job->SECTOR_VACANCY = $_POST['SECTOR_VACANCY'];
            $job->DATEPOSTED = date('Y-m-d H:i');
            $job->create();

            message("New Job Vacancy created successfully!", "success");
            redirect("index.php");
        }
    }
}

function doEdit()
{
    global $mydb;
    if (isset($_POST['save'])) {
        // Check for required fields
        if ($_POST['COMPANYID'] == "None") {
            message("All fields are required!", "error");
            redirect('index.php?view=edit&id=' . $_POST['JOBID']);
        } else {
            // Update job vacancy
            $job = new Jobs();
            $job->COMPANYID = $_POST['COMPANYID'];
            $job->CATEGORY = fetchCategoryName($_POST['CATEGORY']);
            $job->OCCUPATIONTITLE = $_POST['OCCUPATIONTITLE'];
            $job->REQ_NO_EMPLOYEES = $_POST['REQ_NO_EMPLOYEES'];
            $job->SALARIES = $_POST['SALARIES'];
            $job->DURATION_EMPLOYEMENT = $_POST['DURATION_EMPLOYEMENT'];
            $job->QUALIFICATION_WORKEXPERIENCE = $_POST['QUALIFICATION_WORKEXPERIENCE'];
            $job->JOBDESCRIPTION = $_POST['JOBDESCRIPTION'];
            $job->PREFEREDSEX = $_POST['PREFEREDSEX'];
            $job->SECTOR_VACANCY = $_POST['SECTOR_VACANCY'];
            $job->update($_POST['JOBID']);

            message("Job Vacancy has been updated!", "success");
            redirect("index.php");
        }
    }
}

function doDelete()
{
    if (isset($_GET['id'])) {
        // Delete the job vacancy
        $job = new Jobs();
        $job->delete($_GET['id']);
        message("Job Vacancy has been deleted!", "info");
        redirect("index.php");
    }
}

function fetchCategoryName($categoryId)
{
    global $mydb;
    $sql = "SELECT * FROM tblcategory WHERE CATEGORYID = {$categoryId}";
    $mydb->setQuery($sql);
    $category = $mydb->loadSingleResult();
    return $category->CATEGORY;
}
?>
