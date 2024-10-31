<?php

/**
 * @Author: Sharma
 * @Date:   2021-02-02 00:46:24
 * @Last Modified by:   Sharma
 * @Last Modified time: 2021-03-09 01:27:28
 */
?>
<?php
    global $wpdb;
    $query = new Cn_Query();
    $cn_users = $wpdb->prefix .'cn_system_users';
    $users= $wpdb->prepare("select * from `".$wpdb->prefix."cn_system_users` WHERE `status`='active' ORDER BY `uid` ASC");
    $users_details=$query->iWhileFetch($users);
?>

<form id="add_Questions" action="#" class="form-horizontal" method="post">

<!-- /.row -->
<div class="row">
    <div class="cn_col-lg-12">
        <div class="cn_card cn_card-default">
            <div class="cn_card-header">
                Agent
            </div>
            <div class="cn_card-body">
                <div class="row">
                    <div class="cn_col-lg-12">
                        <div class="cn-form-group has-feedback">
                            <label for="transaction[agent]" class="form-label custom-label">Select an Agent</label>
                            <select name="transaction[agent]" id="transaction[agent]" class="cn-form-control" style="max-width: 100%;" required>
                                <?php foreach ($users_details as $user) { ?>
                                    <option value="<?php _e($user['uid']); ?>"><?php _e($user['first_name'] . ' ' . $user['last_name']); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<!-- /.row -->
<div class="row">
    <div class="cn_col-lg-12">
        <div class="cn_card cn_card-default">
            <div class="cn_card-header">
                Transaction Type
            </div>
            <div class="cn_card-body">
                <div class="row">
                    <div class="cn_col-lg-12">
                        <div class="cn-form-group">
                            <label>Type</label>
                            <label class="radio-inline">
                                <input type="radio" name="transaction[transactionType]" id="transactionType1" value="purchase" checked="">Purchase
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="transaction[transactionType]" id="transactionType2" value="sale">Sale
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="transaction[transactionType]" id="transactionType3" value="lease-tenant">Lease - Tenant
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="transaction[transactionType]" id="transactionType4" value="lease-landlord">Lease - Landlord
                            </label>

                        </div>
                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.cn_card-body -->
        </div>
        <!-- /.cn_card -->
    </div>
    <!-- /.cn_col-lg-12 -->
</div>

<!-- /.row -->
<div class="row">
    <div class="cn_col-lg-12">
        <div class="cn_card cn_card-default">
            <div class="cn_card-header">
                Property
            </div>
            <div class="cn_card-body">
                <div class="row">
                <div class="cn_col-lg-6">
                        <div class="cn-form-group has-feedback">
                            <label>Address</label>
                            <input type="text" name="property[property_street]" value="" id="property_street" maxlength="200" class="cn-form-control" data-fv-field="property_street"><i class="cn-form-control-feedback" data-fv-icon-for="property_street" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="property_street" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="property_street" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                    </div>
                    <div class="cn_col-lg-6">
                        <div class="cn-form-group has-feedback">
                            <label>Apt / Suite</label>
                            <input type="text" name="property[property_appt]" value="" id="property_appt" maxlength="100" class="cn-form-control" data-fv-field="property_appt"><i class="cn-form-control-feedback" data-fv-icon-for="property_appt" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="stringLength" data-fv-for="property_appt" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                    </div>

                    <div class="cn_col-lg-6">

                        <div class="cn-form-group has-feedback">
                            <label>City</label>
                            <input type="text" name="property[property_city]" value="" id="property_city" maxlength="100" class="cn-form-control" data-fv-field="property_city"><i class="cn-form-control-feedback" data-fv-icon-for="property_city" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="property_city" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="property_city" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                    </div>
                    <div class="cn_col-lg-6">
                        <div class="cn-form-group has-feedback">
                            <label>Zip</label>
                            <input type="text" name="property[property_zip]" value="" id="property_zip" maxlength="100" class="cn-form-control" data-fv-field="property_zip"><i class="cn-form-control-feedback" data-fv-icon-for="property_zip" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="property_zip" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="property_zip" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="cn_col-lg-12">
        <div class="cn_card cn_card-default">
            <div class="cn_card-header">
                Client
            </div>
            <div class="cn_card-body">
                <div class="row">
                    <div class="cn_col-lg-6">

                        <div class="cn-form-group has-feedback">
                            <label>Full Name or Main Contact</label>
                            <input type="text" name="client[client_firstName]" value="" id="client_firstName" maxlength="100" class="cn-form-control" data-fv-field="client_firstName"><i class="cn-form-control-feedback" data-fv-icon-for="client_firstName" style="display: none;"></i>
                            <small class="help-block" data-fv-validator="notEmpty" data-fv-for="client_firstName" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="regexp" data-fv-for="client_firstName" data-fv-result="NOT_VALIDATED" style="display: none;">Can only consist of alphabetical and Space</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="client_firstName" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                        <div class="cn-form-group has-feedback">
                            <label>Phone Number</label>
                            <input type="phone" name="client[client_phoneNumber]" value="" id="client_phoneNumber" maxlength="255" class="cn-form-control" placeholder="+1 (123)456-7890" data-fv-field="client_phoneNumber"><i class="cn-form-control-feedback" data-fv-icon-for="client_phoneNumber" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="client_phoneNumber" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="phone" data-fv-for="client_phoneNumber" data-fv-result="NOT_VALIDATED" style="display: none;">The value is not valid %s phone number</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="client_phoneNumber" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>     
                        
                    </div>
                    <div class="cn_col-lg-6">
                        
                    <div class="cn-form-group has-feedback">
                            <label>Company Name</label>
                            <input type="text" name="client[client_company]" value="" id="client_company" maxlength="100" class="cn-form-control" data-fv-field="client_company"><i class="cn-form-control-feedback" data-fv-icon-for="client_company" style="display: none;"></i>
                            <small class="help-block" data-fv-validator="stringLength" data-fv-for="client_company" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                        <div class="cn-form-group has-feedback">
                            <label>Email Address</label>
                            <input type="email" name="client[client_emailAddress]" value="" id="client_emailAddress" maxlength="255" class="cn-form-control" data-fv-field="client_emailAddress"><i class="cn-form-control-feedback" data-fv-icon-for="client_emailAddress" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="client_emailAddress" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="regexp" data-fv-for="client_emailAddress" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a valid email address</small><small class="help-block" data-fv-validator="emailAddress" data-fv-for="client_emailAddress" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a valid email address</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="client_emailAddress" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>


                    </div>
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.cn_card-body -->
        </div>
        <!-- /.cn_card -->
    </div>
    <!-- /.cn_col-lg-12 -->
</div>


<!-- /.row -->
  <div class="cn-cn-cn-form-group"> 
    <div class="">
      <button style="width: 100%;" type="submit" class="btn btn-success" name="btn_add_agent_transactions"><i class="glyphicon glyphicon-floppy-save"></i> Save</button>
    </div>
  </div>
</form>
    