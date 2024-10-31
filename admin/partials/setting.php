<form class="form-horizontal" action="" method="post">

<div class="row">
      <div class="cn_col-md-12">
        <div class="cn_card">
        	 <div class="cn_card-header" style="font-size: 15px;">
              <strong>Web Version Settings</strong>  
            </div>
          <div class="cn_card-body">
              <!-- <form class="form-horizontal" action="" method="post"> -->
                <div class="cn-form-group">
                  <div class="row">
                    <div class="cn_col-md-6">
                      <label class="control-label" for="">Select Web Version Page:</label>
                       <select name="agent_page" class="cn-form-control">
                        <option value="">--Select--</option>
                        <?php

                          $pages_list= get_pages();
                          foreach ($pages_list as $page) {?>
                            <option <?php if ($agent_page==$page->ID){ _e('selected');} ?> value="<?php _e($page->ID);?>"><?php _e($page->post_title); ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="cn_col-md-6">
                      <label class="control-label" for="">Workstation Name:</label>
                      <input type="text" name="workstation_name" value="<?php _e($workstation_name); ?>" class="cn-form-control">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <hr>
                </div>
                <!-- <div class="form-group"> 
                  <div class="cn_col-sm-8">
                  <button type="submit" name="save_settings_info" class="button button-primary button-large">Submit</button>
                  </div>
                </div> -->
              <!-- </form> -->
          </div>
        </div>
      </div>
</div>
<div class="row">
      <div class="cn_col-md-12">
        <div class="cn_card">
        	 <div class="cn_card-header" style="font-size: 15px;">
              <strong>Broker Username Settings</strong>  
            </div>
          <div class="cn_card-body">
              <!-- <form class="form-horizontal" action="" method="post"> -->
                <div class="cn-form-group">
                  <div class="row">
                    <div class="cn_col-md-6">
                      <label class="control-label" for="">Email Address:</label>
                      <input type="email" name="masteruser_email" value="<?php _e($masteruser_email); ?>" class="cn-form-control">
                    </div>
                    <div class="cn_col-md-6">
                      <label class="control-label" for="">Password:</label>
                      <input type="text" name="masteruser_password" value="<?php _e($masteruser_password); ?>" class="cn-form-control">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <hr>
                </div>
                <!-- <div class="form-group"> 
                  <div class="cn_col-sm-8">
                  <button type="submit" name="save_master_user_settings_info" class="button button-primary button-large">Submit</button>
                  </div>
                </div> -->
              <!-- </form> -->
          </div>
        </div>
      </div>
</div>
<div class="row">
      <div class="cn_col-md-12">
        <div class="cn_card">
        	 <div class="cn_card-header" style="font-size: 15px;">
              <strong>Commission Deposits Bank Information</strong>  
            </div>
          <div class="cn_card-body">
              <!-- <form class="form-horizontal" action="" method="post"> -->
                <div class="cn-form-group">
                  <div class="row">
                    <div class="cn_col-md-6">
                      <label class="control-label" for="">Bank Name:</label>
                      <input type="text" name="cdbi_bank_name" value="<?php _e($cdbi_bank_name); ?>" class="cn-form-control">
                    </div>
                    <div class="cn_col-md-6">
                      <label class="control-label" for="">Account Name:</label>
                      <input type="text" name="cdbi_account_name" value="<?php _e($cdbi_account_name); ?>" class="cn-form-control">
                    </div>
                  </div>
                  <div class="row" style="margin-top: 0.5rem;">
                    <div class="cn_col-md-6">
                      <label class="control-label" for="">Account Number:</label>
                      <input type="text" name="cdbi_account_number" value="<?php _e($cdbi_account_number); ?>" class="cn-form-control">
                    </div>
                    <div class="cn_col-md-6">
                      <label class="control-label" for="">Account Address:</label>
                      <input type="text" name="cdbi_account_address" value="<?php _e($cdbi_account_address); ?>" class="cn-form-control">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <hr>
                </div>
                <!-- <div class="form-group"> 
                  <div class="cn_col-sm-8">
                  <button type="submit" name="save_cdbi_settings_info" class="button button-primary button-large">Submit</button>
                  </div>
                </div> -->
              <!-- </form> -->
          </div>
        </div>
      </div>
      <div class="form-group" style="margin-top: 1rem;"> 
                  <div class="cn_col-sm-8">
                  <button type="submit" name="save_general_settings_info" class="button button-primary button-large">Submit</button>
                  </div>
                </div>
</div>
</form>


