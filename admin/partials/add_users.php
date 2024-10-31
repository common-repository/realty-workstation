<?php

/**
 * @Author: Sharma
 * @Date:   2021-02-02 00:46:24
 * @Last Modified by:   Sharma
 * @Last Modified time: 2021-02-02 01:16:35
 */
?>
<style>
  .alert {
    position: relative;
    padding: 1rem 1rem;
    margin-bottom: 1rem;
    border: 1px solid transparent;
    border-radius: .25rem;
}
.alert-danger {
    color: #842029;
    background-color: #f8d7da;
    border-color: #f5c2c7;
}
  </style>
<form id="add_Questions" action="#" class="form-horizontal" method="post">
  <div class="cn-cn-form-group">
    <?php if ($users_count >= 5) { ?>
      <div class="alert alert-danger">Please upgrade your plugin to PRO version to add more users. </div>
    <?php } else { ?>

      <div class="row">
        <div class="cn_col-md-12">
            <div class="cn-form-group">
                <label>First Name</label>
                <input type="text" name="first_name" value="" id="user_firstName" maxlength="255" class="cn-form-control" autocomplete="off">
            </div>

        </div>
        <div class="cn_col-md-12">
          <div class="cn-form-group">
                <label>Last Name</label>
                <input type="text" name="last_name" value="" id="user_lastName" maxlength="255" class="cn-form-control" autocomplete="off">
            </div>

        </div>
        <div class="cn_col-md-12">
          
        <div class="cn-form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="" id="user_emailAddress" maxlength="255" class="cn-form-control" autocomplete="off">
            </div>
        </div>
        <div class="cn_col-md-12">
          
            
        <div class="cn-form-group">
                <label>Password</label>
                <input type="password" name="password" value="" id="user_password" maxlength="255" class="cn-form-control" autocomplete="off">
            </div>
        </div>
        <div class="cn_col-md-12">
            <div class="cn-form-group">
                <label>Commission (As Decimal e.g. 50% = 0.50)</label>
                <input type="text" name="commission" id="user_commission" maxlength="255" class="cn-form-control" autocomplete="off" value="">
            </div>
        </div>
        <div class="cn_col-md-12">
              <div class="cn-form-group">
                  <label>Broker Referral Payout for Lease (As Decimal e.g. 50% = 0.50)</label>
                  <input type="text" name="lease" id="user_br_lease" maxlength="255" class="cn-form-control" autocomplete="off" value="">
              </div>
          </div>
          <div class="cn_col-md-12">
              <div class="cn-form-group">
                  <label>Broker Referral Payout for Sale and Purchase (As Decimal e.g. 50% = 0.50)</label>
                  <input type="text" name="sale" id="user_br_sale" maxlength="255" class="cn-form-control" autocomplete="off" value="">
              </div>
          </div>
    </div>
    <?php } ?>
  </div>
  <div class="cn-cn-form-group"> 
    <div class="">
      <?php if ($users_count <= 5) { ?>
        <button style="width: 100%;" type="submit" class="btn btn-success" name="btn_add_users"><i class="glyphicon glyphicon-floppy-save"></i>Save</button>
      <?php } else { ?>
        <a style="width: 100%;" class="btn btn-success" href="https://www.realtyworkstation.com/"><i class="glyphicon glyphicon-floppy-save"></i>Buy Pro Version</a>
      <?php } ?>
    </div>
  </div>
</form>
    