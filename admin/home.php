<?php
require '../plugins/phpmailer/PHPMailer.php';
require '../plugins/phpmailer/SMTP.php';
require '../plugins/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jovincepro9@gmail.com'; // Your email address
        $mail->Password = 'ghco xeqy svvz kfzb'; // Replace with your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($email, $name); // User's email as sender
        $mail->addAddress('jovincepro9@gmail.com'); // Your email as recipient
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "<h4>Contact Form Message</h4>
                       <p><strong>Email to:</strong>$email</p>
                       <p><strong>Subject:</strong></p>
                       <p><strong>Message:</strong></p>
                       <p>$message</p>";

        $mail->send();
        $success = "Your message has been sent successfully!";
    } catch (Exception $e) {
        $error = "There was an error sending your message. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>


<section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <?php 
  if (!isset($_SESSION['ADMIN_USERID'])) {
    redirect(web_root . "admin/index.php");
  }

  $mydb->setQuery("SELECT COUNT(*) as company_count FROM `tblcompany`");
  $company_count_result = $mydb->loadSingleResult();
  $company_count = $company_count_result->company_count;
?>

  <div class="small-box bg-aqua">
    <div class="inner">
        <h3><?php echo $company_count; ?></h3>
        <p>Companies</p>
    </div>
    <div class="icon">
        <i class="ion ion-bag"></i>
    </div>
    <a href="http://localhost/jobseek/admin/company/" class="small-box-footer">
        More info <i class="fa fa-arrow-circle-right"></i>
    </a>
      </div>
        </div>
        <!-- EMPLOYEE -->
        <?php 
  if (!isset($_SESSION['ADMIN_USERID'])) {
    redirect(web_root . "admin/index.php");
  }
  $mydb->setQuery("SELECT COUNT(*) as employee_count FROM `tblemployees`");
  $employee_count_result = $mydb->loadSingleResult();
  $employee_count = $employee_count_result->employee_count;
  ?>

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-green">
        <div class="inner">
            <h3><?php echo $employee_count; ?></h3>
            <p>Employee</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="http://localhost/jobseek/admin/employee/" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
  </div>


  <?php 
  if (!isset($_SESSION['ADMIN_USERID'])) {
    redirect(web_root . "admin/index.php");
  }

  // Fetch the total number of applicants
  $mydb->setQuery("SELECT COUNT(*) as applicant_count FROM `tblapplicants`");
  $applicant_count_result = $mydb->loadSingleResult();
  $applicant_count = $applicant_count_result->applicant_count;
?>

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-yellow">
        <div class="inner">
            <h3><?php echo $applicant_count; ?></h3>
            <p>Applicants</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="http://localhost/jobseek/admin/applicants/" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
  </div>

        <!-- DASHBOARD USERS -->
        <?php 
  if (!isset($_SESSION['ADMIN_USERID'])) {
    redirect(web_root . "admin/index.php");
  }

  // Fetch the total number of users
  $mydb->setQuery("SELECT COUNT(*) as user_count FROM `tblusers`");
  $user_count_result = $mydb->loadSingleResult();
  $user_count = $user_count_result->user_count;
  ?>

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-red">
        <div class="inner">
            <h3><?php echo $user_count; ?></h3> 
            <p>Dashboard Users</p>
        </div>
        <div class="icon">
            <i class="ion ion-pie-graph"></i>
        </div>
        <a href="http://localhost/jobseek/admin/user/" class="small-box-footer">
            More info <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
  </div>

      </div>
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
          <!-- /.nav-tabs-custom -->

          <!-- TO DO List -->
<!-- TO DO List -->
<div class="box box-primary">
  <div class="box-header">
    <i class="ion ion-clipboard"></i>
    <h3 class="box-title">To-Do List</h3>
    <div class="box-tools pull-right">
      <ul class="pagination pagination-sm inline">
        <li><a href="#">&laquo;</a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">&raquo;</a></li>
      </ul>
    </div>
  </div>
  <div class="box-body">
    <ul class="todo-list" id="todoList">
      <?php
      // Fetch tasks from the database
      $tasks_query = $mydb->setQuery("SELECT * FROM tbltodo ORDER BY id DESC");
      $tasks = $mydb->loadResultList();
      foreach ($tasks as $task) : ?>
        <li data-id="<?php echo $task->id; ?>">
          <span class="handle">
            <i class="fa fa-ellipsis-v"></i>
            <i class="fa fa-ellipsis-v"></i>
          </span>
          <input type="checkbox" class="toggle-completed" <?php echo $task->completed ? 'checked' : ''; ?>>
          <span class="text"><?php echo htmlspecialchars($task->task_text); ?></span>
          <small class="label label-<?php echo $task->priority; ?>">
            <i class="fa fa-clock-o"></i> <?php echo $task->deadline; ?>
          </small>
          <div class="tools">
            <i class="fa fa-edit edit-task"></i>
            <i class="fa fa-trash-o delete-task"></i>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="box-footer clearfix no-border">
    <button type="button" class="btn btn-danger pull-right" id="deleteSelected"><i class="fa fa-trash"></i></button>
    <button type="button" class="btn btn-default" id="addItem"><i class="fa fa-plus"></i> Add Item</button>
  </div>
</div>

<script>
  $(document).ready(function () {
    const todoList = $('#todoList');

    // Add a new task
    $('#addItem').on('click', function () {
      const taskText = prompt('Enter a new task:');
      if (taskText) {
        $.post('todo_actions.php', { action: 'add', task_text: taskText }, function (response) {
          location.reload(); // Reload to reflect changes
        });
      }
    });

    // Delete a single task
    todoList.on('click', '.delete-task', function () {
      const id = $(this).closest('li').data('id');
      $.post('todo_actions.php', { action: 'delete', id: id }, function (response) {
        location.reload(); // Reload to reflect changes
      });
    });

    // Mark task as completed
    todoList.on('change', '.toggle-completed', function () {
      const id = $(this).closest('li').data('id');
      const completed = $(this).is(':checked') ? 1 : 0;
      $.post('todo_actions.php', { action: 'update', id: id, completed: completed }, function (response) {
        location.reload(); // Reload to reflect changes
      });
    });

    // Edit a task
    todoList.on('click', '.edit-task', function () {
      const id = $(this).closest('li').data('id');
      const currentText = $(this).closest('li').find('.text').text();
      const updatedText = prompt('Edit task:', currentText);
      if (updatedText) {
        $.post('todo_actions.php', { action: 'edit', id: id, task_text: updatedText }, function (response) {
          location.reload(); // Reload to reflect changes
        });
      }
    });

    // Delete multiple selected tasks
    $('#deleteSelected').on('click', function () {
      const selectedTasks = [];
      $('.todo-list input[type="checkbox"]:checked').each(function () {
        selectedTasks.push($(this).closest('li').data('id'));
      });
      if (selectedTasks.length > 0) {
        $.post('todo_actions.php', { action: 'deleteMultiple', ids: selectedTasks }, function (response) {
          location.reload(); // Reload to reflect changes
        });
      } else {
        alert('No tasks selected!');
      }
    });
  });
</script>
<!-- END OF TO-DO LIST -->

          <!-- quick email widget -->
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>

              <h3 class="box-title">Email</h3>
            </div>
            <div class="box-body">
              <form action="#" method="post">
                <div class="form-group">
                  <input type="email" class="form-control" name="emailto" placeholder="Email to:">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" name="subject" placeholder="Subject">
                </div>
                <div>
                  <textarea class="textarea" placeholder="Message" style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              </form>
            </div>
            <div class="box-footer clearfix">
              <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>

        </section>
        <!-- /.Left col -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  