<?php
// Ensure the session is active and user is logged in as admin
if (!isset($_SESSION['ADMIN_USERID'])) {
    redirect(web_root . "admin/index.php");
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            List of Vacancies
            <?php if ($_SESSION['ADMIN_ROLE'] == 'Administrator') { ?>
                <a href="index.php?view=add" class="btn btn-primary btn-xs">
                    <i class="fa fa-plus-circle fw-fa"></i> Add Job Vacancy
                </a>
            <?php } ?>
        </h1>
    </div>
</div>

<form action="controller.php?action=delete" method="POST">
    <div class="table-responsive">
        <table id="dash-table" class="table table-striped table-bordered table-hover" style="font-size:12px" cellspacing="0">
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Occupation Title</th>
                    <th>Require no. of Employees</th>
                    <th>Salaries</th>
                    <th>Duration of Employment</th>
                    <th>Qualification/Work Experience</th>
                    <th>Job Description</th>
                    <th>Preferred Sex</th>
                    <th>Sector of Vacancy</th>
                    <th>Job Status</th>
                    <th width="10%" align="center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch vacancy data
                $mydb->setQuery("SELECT * FROM `tbljob` j, `tblcompany` c WHERE j.COMPANYID=c.COMPANYID");
                $cur = $mydb->loadResultList();

                foreach ($cur as $result) {
                    echo '<tr>';
                    echo '<td>' . $result->COMPANYNAME . '</td>';
                    echo '<td>' . $result->OCCUPATIONTITLE . '</td>';
                    echo '<td>' . $result->REQ_NO_EMPLOYEES . '</td>';
                    echo '<td>' . $result->SALARIES . '</td>';
                    echo '<td>' . $result->DURATION_EMPLOYEMENT . '</td>';
                    echo '<td>' . $result->QUALIFICATION_WORKEXPERIENCE . '</td>';
                    echo '<td>' . $result->JOBDESCRIPTION . '</td>';
                    echo '<td>' . $result->PREFEREDSEX . '</td>';
                    echo '<td>' . $result->SECTOR_VACANCY . '</td>';
                    echo '<td>' . $result->JOBSTATUS . '</td>';
                    echo '<td align="center">';

                    // Only show Edit/Delete buttons if the user is an administrator
                    if ($_SESSION['ADMIN_ROLE'] == 'Administrator') {
                        echo '<a title="Edit" href="index.php?view=edit&id=' . $result->JOBID . '" class="btn btn-info btn-xs">
                                <span class="fa fa-edit fw-fa"></span>
                              </a>';
                        echo '<a title="Delete" href="controller.php?action=delete&id=' . $result->JOBID . '" class="btn btn-danger btn-xs" onclick="return confirmDelete();">
                                <span class="fa fa-trash-o fw-fa"></span>
                              </a>';
                    } else {
                        echo '<span class="text-muted">No Actions Available</span>';
                    }
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</form>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to remove this vacancy?");
    }
</script>
