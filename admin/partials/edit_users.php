<form id="add_demos" class="form-horizontal" method="post">
  <?php 
  $sn=0;
  foreach ($users_details as $key => $value) {
    $sn++;
    $users_id=$value['uid'];
    ?>
    <!-- <strong>Form <?php _e($sn); ?></strong> -->
    <!-- <hr> -->
    <input type="hidden" name="<?php _e ( $key ); ?>[uid]" value="<?php _e ( $users_id ); ?>">
    <div class="cn-form-group">
       <div class="row">
        <div class="cn_col-md-12">
            <div class="cn-form-group">
                <label>First Name</label>
                <input type="text" name="<?php _e ( $key ); ?>[first_name]"  id="user_firstName" maxlength="255" class="cn-form-control" autocomplete="off" value="<?php _e ( $value['first_name'] ); ?>">
            </div>
            

        </div>
        <div class="cn_col-md-12">
            
        <div class="cn-form-group">
                <label>Email Address</label>
                <input type="email" name="<?php _e ( $key ); ?>[email]" id="user_emailAddress" maxlength="255" class="cn-form-control" autocomplete="off" value="<?php _e ( $value['email'] ); ?>">
            </div>
        </div>
        <div class="cn_col-md-12">
            <div class="cn-form-group">
                <label>Last Name</label>
                <input type="text" name="<?php _e ( $key ); ?>[last_name]"  id="user_lastName" maxlength="255" class="cn-form-control" autocomplete="off" value="<?php _e ( $value['last_name'] ); ?>">
            </div>
        </div>
        <div class="cn_col-md-12">
            
        <div class="cn-form-group">
                <label>Password</label>
                <input type="password" name="<?php _e ( $key ); ?>[password]" id="user_password" maxlength="255" class="cn-form-control" autocomplete="off" value="">
            </div>
        </div>
        <div class="cn_col-md-12">
              <div class="cn-form-group">
                  <label>Commission (As Decimal e.g. 50% = 0.50)</label>
                  <input type="text" name="<?php _e ( $key ); ?>[commission]" id="user_commission" maxlength="255" class="cn-form-control" autocomplete="off" value="<?php _e ( $value['commission'] ); ?>">
              </div>
        </div>
        <div class="cn_col-md-12">
              <div class="cn-form-group">
                  <label>Broker Referral Payout for Lease (As Decimal e.g. 50% = 0.50)</label>
                  <input type="text" name="<?php _e ( $key ); ?>[lease]" id="user_br_lease" maxlength="255" class="cn-form-control" autocomplete="off" value="<?php _e ( $value['lease'] ); ?>">
              </div>
          </div>
          <div class="cn_col-md-12">
              <div class="cn-form-group">
                  <label>Broker Referral Payout for Sale and Purchase (As Decimal e.g. 50% = 0.50)</label>
                  <input type="text" name="<?php _e ( $key ); ?>[sale]" id="user_br_sale" maxlength="255" class="cn-form-control" autocomplete="off" value="<?php _e ( $value['sale'] ); ?>">
              </div>
          </div>
    </div>
    </div>
  <?php } ?>
    
  <div class="cn-form-group"> 
    <div class="">
      <button type="submit" class="btn btn-success" name="btn_update_users"><i class="glyphicon glyphicon-floppy-save"></i> <?php esc_html_e( 'Update', 'realty-workstation'); ?></button>
    </div>
  </div>
</form>
