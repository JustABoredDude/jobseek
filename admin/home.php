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
</section>
