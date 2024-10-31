<?php

/**
 * @Author: Sharma
 * @Date:   2021-03-12 03:45:44
 * @Last Modified by:   Sharma
 * @Last Modified time: 2021-03-12 13:09:58
 */

if (isset($_POST['change_password'])) {			
    $cn_login_user_id=sanitize_text_field( $_SESSION['cn_login_user_id'] );
    if ($cn_login_user_id == 1) {
        update_option('workstation_masteruser_password', sanitize_text_field($_POST['user_password']));
        _e($query->showMessage('success','updated successfully'));
    } else {
        $password=sanitize_text_field($_POST['user_password']);
        $password = md5($password);
        $update_pass['password']=$password;
        $response=$query->iUpdateArray($cn_users,$update_pass,array('`uid`'=>$cn_login_user_id));   
        $response=json_decode($response);
        if ($response->success=='success') {
            _e($query->showMessage($response->success,$response->msg));
        }else{
            _e($query->showMessage($response->success,$response->msg,$response->error,true,''));
        }
    }
}
?>
<style>
    .custom-label {
        font-weight: 500;
        margin-bottom: 5px;
    }
    .btn-block {
        width: 100%;
    }
</style>
<form action="" role="form" id="change_password_form" autocomplete="off" enctype="multipart/form-data" method="post" accept-charset="utf-8" novalidate="novalidate" class="fv-form fv-form-bootstrap">
<input type="hidden" name="csrf_test_name" value="ee08ff90c11a964aca7fcecce4ef27dc">                                                                                        
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Change Password
            </div>
            <div class="card-body">

                <div class="row">

                    <div class="col-lg-6">
                        <div class="form-group has-feedback">
                            <label class="custom-label">Password</label>
                            <input type="password" name="user_password" value="" id="user_password" maxlength="255" class="form-control" autocomplete="off" data-fv-field="user_password"><i class="form-control-feedback" data-fv-icon-for="user_password" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="user_password" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="user_password" data-fv-result="NOT_VALIDATED" style="display: none;">Your password must be at least 6 characters</small></div>


                    </div>

                    <div class="col-lg-6">
                        <div class="form-group has-feedback">
                            <label class="custom-label">Confirm Password</label>
                            <input type="password" name="user_password2" value="" id="user_password2" maxlength="255" class="form-control" autocomplete="off" data-fv-field="user_password2"><i class="form-control-feedback" data-fv-icon-for="user_password2" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="user_password2" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="identical" data-fv-for="user_password2" data-fv-result="NOT_VALIDATED" style="display: none;">The password do not match</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="user_password2" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>

                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>


<!-- /.row -->

<div class="row mt-3">
    <div class="col-lg-12">
        <button type="submit" name="change_password" class="btn btn-success btn-block">SAVE</button>
    </div>
</div>

</form>