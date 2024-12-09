<?php
require_once('../include/initialize.php'); // Adjust with your DB connection script

$action = $_POST['action'] ?? '';
switch ($action) {
  case 'add':
    $task_text = $_POST['task_text'];
    $mydb->setQuery("INSERT INTO tbltasks (task_text) VALUES ('$task_text')");
    $mydb->executeQuery();
    break;
  
  case 'delete':
    $id = $_POST['id'];
    $mydb->setQuery("DELETE FROM tbltasks WHERE id = $id");
    $mydb->executeQuery();
    break;

  case 'edit':
    $id = $_POST['id'];
    $task_text = $_POST['task_text'];
    $mydb->setQuery("UPDATE tbltasks SET task_text = '$task_text' WHERE id = $id");
    $mydb->executeQuery();
    break;

  case 'update':
    $id = $_POST['id'];
    $completed = $_POST['completed'];
    $mydb->setQuery("UPDATE tbltasks SET completed = $completed WHERE id = $id");
    $mydb->executeQuery();
    break;

  case 'deleteMultiple':
    $ids = implode(',', $_POST['ids']);
    $mydb->setQuery("DELETE FROM tbltasks WHERE id IN ($ids)");
    $mydb->executeQuery();
    break;
}
?>
