<?php
require_once ("../../include/initialize.php");

if (!isset($_SESSION['ADMIN_USERID'])) {
    redirect(web_root . "admin/index.php");
}

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : '';

switch ($action) {
    case 'add':
        doInsert();
        break;

    case 'edit':
        doEdit();
        break;

    case 'delete':
        doDelete();
        break;
}

function doInsert() {
    if (isset($_POST['save'])) {
        if ($_SESSION['ADMIN_ROLE'] != 'Administrator') {
            message("Access denied!", "error");
            redirect('index.php');
            return;
        }

        if ($_POST['CATEGORY'] == "") {
            message("All fields are required!", "error");
            redirect('index.php?view=add');
        } else {
            $category = New Category();
            $category->CATEGORY = $_POST['CATEGORY'];
            $category->create();

            message("New category created!", "success");
            redirect("index.php");
        }
    }
}

function doEdit() {
    if (isset($_POST['save'])) {
        if ($_SESSION['ADMIN_ROLE'] != 'Administrator') {
            message("Access denied!", "error");
            redirect('index.php');
            return;
        }

        $category = New Category();
        $category->CATEGORY = $_POST['CATEGORY'];
        $category->update($_POST['CATEGORYID']);

        message("[" . $_POST['CATEGORY'] . "] has been updated!", "success");
        redirect("index.php");
    }
}

function doDelete() {
    if ($_SESSION['ADMIN_ROLE'] != 'Administrator') {
        message("Access denied!", "error");
        redirect('index.php');
        return;
    }

    $id = $_GET['id'];
    $category = New Category();
    $category->delete($id);

    message("Category has been deleted!", "info");
    redirect('index.php');
}
?>
