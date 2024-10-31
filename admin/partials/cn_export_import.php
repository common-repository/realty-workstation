<div class="wrap">
  <div class="row">
    <div class="cn_col-md-12">
        <div class="cn_card">
           <div class="cn_card-header" style="font-size: 15px;">
              <strong>Backup Workstation</strong>  
            </div>
          <div class="cn_card-body">
              
                <div class="form-group"> 
                  <div class="cn_col-sm-12 my-4" style="padding-left: 0rem !important; padding-right: 0rem !important;">
                  <!-- <button type="button" onclick="cn_export_db()" name="save_settings_info" class="button button-primary button-large">Export Database Backup</button> -->
                  <!-- <button type="button" onclick="cn_export_file()" name="save_settings_info" class="button button-primary button-large pull-right">Export File Backup</button> -->
                  <p><strong style="display: inline-block; max-width: 100%; margin-bottom: 5px !important; font-weight: 700;">This function will backup your entire workstation including all data and agents into a series of zip files.</strong></p>
                  <button type="button" onclick="cn_backup()" name="save_settings_info" class="button button-primary button-large">Backup</button>
                  </div>
                </div>
              
          </div>
        </div>
    </div>
    <div class="cn_col-md-12">
        <div class="cn_card">
           <div class="cn_card-header" style="font-size: 15px;">
              <strong>Restore Workstation</strong>  
            </div>
          <div class="cn_card-body">
              <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <div class="cn-form-group">
                  <div class="row">
                    <div class="cn_col-md-12">
                      <label class="control-label" for="">First select and then restore all the backup zip files:</label>
                       <input type="text" name="files" value=""class="cn-form-control">
                       <input type="text" name="files_urls" value=""class="cn-form-control" style="display: none;">
                       <input type="text" name="files_ids" value=""class="cn-form-control" style="display: none;">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <hr>
                </div>
                <div class="form-group"> 
                  <button type="button" class="button button-primary button-large btn-upload-files">Select Files</button>
                  <button type="submit" name="restore_files" class="button button-primary button-large">Restore</button>
                </div>
              </form>
          </div>
        </div>
    </div>
    
  </div>
      
</div>


<div class="mylod" style="">
      <img src="<?php _e(workstation_URI); ?>cn_package/img/loder.jpg" style="width: 200px;position: fixed;top: 40%;left: 0px;right: 0px;margin: 0px auto;z-index: 9999999999;border-radius: 3px;">  
</div>