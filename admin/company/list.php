<?php
if (!isset($_SESSION['ADMIN_USERID'])) {
    redirect(web_root . "admin/index.php");
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">List of Companies
            <?php if ($_SESSION['ADMIN_ROLE'] == 'Administrator') { ?>
                <a href="index.php?view=add" class="btn btn-primary btn-xs"> <i class="fa fa-plus-circle fw-fa"></i> Add Company</a>
            <?php } ?>
        </h1>
    </div>
</div>

<form action="controller.php?action=delete" method="POST">
    <div class="table-responsive">
        <table id="dash-table" class="table table-striped table-bordered table-hover" style="font-size:12px" cellspacing="0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Contact No.</th>
                    <th width="10%" align="center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $mydb->setQuery("SELECT * FROM `tblcompany`");
                $cur = $mydb->loadResultList();
                foreach ($cur as $result) {
                    echo '<tr>';
                    echo '<td>' . $result->COMPANYNAME . '</td>';
                    echo '<td>' . $result->COMPANYADDRESS . '</td>';
                    echo '<td>' . $result->COMPANYCONTACTNO . '</td>';
                    echo '<td align="center">';
                    if ($_SESSION['ADMIN_ROLE'] == 'Administrator') {
                        echo '<a title="Edit" href="index.php?view=edit&id=' . $result->COMPANYID . '" class="btn btn-primary btn-xs"> <span class="fa fa-edit fw-fa"></span></a>';
                        echo '<a title="Delete" href="controller.php?action=delete&id=' . $result->COMPANYID . '" class="btn btn-danger btn-xs" onclick="return confirmDelete();"> <span class="fa fa-trash-o fw-fa"></span></a>';
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
        return confirm("Are you sure you want to remove this company?");
    }
</script>
