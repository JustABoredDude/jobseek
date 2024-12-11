<?php  
if (!isset($_SESSION['ADMIN_USERID'])){
    redirect(web_root."admin/index.php");
}

// Fetch the user ID to edit (from GET or SESSION)
@$USERID = isset($_GET['id']) ? $_GET['id'] : $_SESSION['ADMIN_USERID'];

// Restrict staff from editing other user profiles
if ($_SESSION['ADMIN_ROLE'] == 'Staff' && $USERID != $_SESSION['ADMIN_USERID']) {
    redirect("index.php");
}

$user = New User();
$singleuser = $user->single_user($USERID);
?>

<div class="container">
    <div class="panel-body inf-content">
        <div class="row">
            <div class="col-md-4">
                <a data-target="#myModal" data-toggle="modal" href="" title="Click here to Change Image.">
                    <img alt="" style="width:500px; height:400px;" title="" class="img-circle img-thumbnail isTooltip" src="<?php echo web_root . 'admin/user/' . $singleuser->PICLOCATION; ?>" data-original-title="Usuario">
                </a>
            </div>
            <div class="col-md-6">
                <h1><strong>User Profile</strong></h1><br>
                <form class="form-horizontal span6" action="controller.php?action=edit" method="POST">
                    <input id="USERID" name="USERID" type="hidden" value="<?php echo $singleuser->USERID; ?>">

                    <div class="form-group">
                        <div class="col-md-8">
                            <label class="col-md-4 control-label" for="U_NAME">Name:</label>
                            <div class="col-md-8">
                                <input class="form-control input-sm" id="U_NAME" name="U_NAME" placeholder="Account Name" type="text" value="<?php echo $singleuser->FULLNAME; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8">
                            <label class="col-md-4 control-label" for="U_USERNAME">Username:</label>
                            <div class="col-md-8">
                                <input class="form-control input-sm" id="U_USERNAME" name="U_USERNAME" placeholder="Email Address" type="text" value="<?php echo $singleuser->USERNAME; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8">
                            <label class="col-md-4 control-label" for="U_PASS">Password:</label>
                            <div class="col-md-8">
                                <input class="form-control input-sm" id="U_PASS" name="U_PASS" placeholder="Account Password" type="password" value="" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8">
                            <label class="col-md-4 control-label" for="U_ROLE">Role:</label>
                            <div class="col-md-8">
                                <!-- Role field restricted for staff -->
                                <?php if ($_SESSION['ADMIN_ROLE'] == 'Administrator') { ?>
                                    <select class="form-control input-sm" name="U_ROLE" id="U_ROLE">
                                        <option value="Administrator" <?php echo ($singleuser->ROLE == 'Administrator') ? 'selected="true"' : ''; ?>>Administrator</option>
                                        <option value="Staff" <?php echo ($singleuser->ROLE == 'Staff') ? 'selected="true"' : ''; ?>>Staff</option>
                                    </select>
                                <?php } else { ?>
                                    <input class="form-control input-sm" id="U_ROLE" name="U_ROLE" type="text" value="<?php echo $singleuser->ROLE; ?>" readonly>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8">
                            <label class="col-md-4 control-label" for="idno"></label>
                            <div class="col-md-8">
                                <button class="btn btn-primary" name="save" type="submit"><span class="fa fa-save fw-fa"></span> Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel">Choose Image.</h4>
            </div>
            <form action="controller.php?action=photos" enctype="multipart/form-data" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="rows">
                            <div class="col-md-12">
                                <input name="MAX_FILE_SIZE" type="hidden" value="1000000">
                                <input id="photo" name="photo" type="file">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" name="savephoto" type="submit">Upload Photo</button>
                </div>
            </form>
        </div>
    </div>
</div>
