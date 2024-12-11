<?php
if (!isset($_SESSION['ADMIN_USERID'])) {
    redirect(web_root . "admin/index.php");
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">List of Applicants</h1>
    </div>
</div>

<!-- Display Error or Success Messages -->
<?php
if (isset($_SESSION['error_message'])) {
    echo '<div style="width: 100%; background-color: #e74c3c; color: white; text-align: center; padding: 10px; border-radius: 5px;">';
    echo $_SESSION['error_message'];
    echo '</div>';
    unset($_SESSION['error_message']); // Remove message after displaying
}

if (isset($_SESSION['success_message'])) {
    echo '<div style="width: 100%; background-color: #27ae60; color: white; text-align: center; padding: 10px; border-radius: 5px;">';
    echo $_SESSION['success_message'];
    echo '</div>';
    unset($_SESSION['success_message']); // Remove message after displaying
}
?>

<form class="wow fadeInDownaction" action="controller.php?action=delete" method="POST">
    <table id="dash-table" class="table table-striped table-hover table-responsive" style="font-size:12px" cellspacing="0">
        <thead>
            <tr>
                <th>Applicant</th>
                <th>Job Title</th>
                <th>Company</th>
                <th>Applied Date</th>
                <th>Remarks</th>
                <th width="14%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $mydb->setQuery("SELECT * FROM `tblcompany` c, `tbljobregistration` j, `tbljob` j2, `tblapplicants` a 
                             WHERE c.`COMPANYID`=j.`COMPANYID` AND j.`JOBID`=j2.`JOBID` AND j.`APPLICANTID`=a.`APPLICANTID`");
            $cur = $mydb->loadResultList();

            foreach ($cur as $result) {
                echo '<tr>';
                echo '<td>' . $result->APPLICANT . '</td>';
                echo '<td>' . $result->OCCUPATIONTITLE . '</td>';
                echo '<td>' . $result->COMPANYNAME . '</td>';
                echo '<td>' . $result->REGISTRATIONDATE . '</td>';
                echo '<td>' . $result->REMARKS . '</td>';
                echo '<td align="center">
                        <a title="View" href="index.php?view=view&id=' . $result->REGISTRATIONID . '" class="btn btn-info btn-xs">
                            <span class="fa fa-info fw-fa"></span> View
                        </a>';
                if ($_SESSION['ADMIN_ROLE'] === 'Administrator') {
                    echo '<a title="Remove" href="index.php?view=delete&id=' . $result->REGISTRATIONID . '" class="btn btn-danger btn-xs" onclick="return confirmDelete();">
                            <span class="fa fa-trash-o fw-fa"></span> Remove
                        </a>';
                }
                echo '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
</form>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to remove this applicant?");
    }
</script>
