<?php
// Ensure the session is active and user is logged in as admin
if (!isset($_SESSION['ADMIN_USERID'])) {
    redirect(web_root . "admin/index.php");
}
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            List of Employees
            <?php if ($_SESSION['ADMIN_ROLE'] == 'Administrator') { ?>
                <a href="index.php?view=add" class="btn btn-primary btn-xs">
                    <i class="fa fa-plus-circle fw-fa"></i> Add New Employee
                </a>
            <?php } ?>
        </h1>
    </div>
</div>

<form action="controller.php?action=delete" method="POST">
    <div class="table-responsive">
        <table id="dash-table" class="table table-striped table-hover table-responsive" style="font-size:12px" cellspacing="0">
            <thead>
                <tr>
                    <th width="5%">EmployeeNo</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Sex</th>
                    <th>Age</th>
                    <th>ContactNo</th>
                    <th>Position</th>
                    <th width="14%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch employee data
                $mydb->setQuery("SELECT * FROM `tblemployees`");
                $cur = $mydb->loadResultList();

                foreach ($cur as $result) {
                    echo '<tr>';
                    echo '<td>' . $result->EMPLOYEEID . '</td>';
                    echo '<td>' . $result->LNAME . ', ' . $result->FNAME . '</td>';
                    echo '<td>' . $result->ADDRESS . '</td>';
                    echo '<td>' . $result->SEX . '</td>';
                    echo '<td>' . $result->AGE . '</td>';
                    echo '<td>' . $result->TELNO . '</td>';
                    echo '<td>' . $result->POSITION . '</td>';
                    echo '<td align="center">';

                    // Only show Edit/Delete buttons if the user is an administrator
                    if ($_SESSION['ADMIN_ROLE'] == 'Administrator') {
                        echo '<a title="Edit" href="index.php?view=edit&id=' . $result->EMPLOYEEID . '" class="btn btn-info btn-xs">
                                <span class="fa fa-edit fw-fa"></span>Edit
                              </a>';
                        echo '<a title="Delete" href="controller.php?action=delete&id=' . $result->EMPLOYEEID . '" class="btn btn-danger btn-xs" onclick="return confirmDelete();">
                                <span class="fa fa-trash-o fw-fa"></span>Delete
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
        return confirm("Are you sure you want to remove this employee?");
    }
</script>
