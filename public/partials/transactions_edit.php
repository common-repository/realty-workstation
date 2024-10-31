
<?php
function workstation_sanitize_array( $input ) {
    // Initialize the new array that will hold the sanitize values
    $new_input = array();
    // Loop through the input and sanitize each of the values
    foreach ( $input as $key => $val ) {
        $new_input[ $key ] = sanitize_text_field( $val );
    }
    return $new_input;
}
$cn_profiles = $wpdb->prefix . 'cn_profiles';
    $clients = $wpdb->prefix .'cn_clients';
    $cn_files = $wpdb->prefix .'cn_files';
    $properties = $wpdb->prefix .'cn_properties';
    $system_ci_sessions = $wpdb->prefix .'cn_system_ci_sessions';
    $cn_users = $wpdb->prefix .'cn_system_users';
    $system_users = $wpdb->prefix .'cn_system_users';
    $transactions = $wpdb->prefix .'cn_transactions';
$query = new Cn_Query();
if (isset($_POST['client'])) {
    $clientData = array();
    $clientData=workstation_sanitize_array($_POST['client']);
    $clientData['date_created'] = date("Y-m-d H:i:s");
    $client_cid=sanitize_text_field( $_POST['cid'] );
    $response=$query->iUpdateArray($clients,$clientData,array('`cid`'=>$client_cid)); 

    $propertyData = array();
    $propertyData=workstation_sanitize_array($_POST['propertyDetails']);
    $propertyData['property_no'] = '';//$this->input->post('property_no');
    $propertyData['date_created'] = date("Y-m-d H:i:s");
    $property_pid=sanitize_text_field( $_POST['pid'] );
    $response=$query->iUpdateArray($properties,$propertyData,array('`pid`'=>$property_pid));  

    $transactionData = array();
    $transactionData['uid'] = sanitize_text_field( $_POST['uid'] );
    $transactionData['status'] = 'open';
    $transactionData['sale_price'] = str_replace(',','',sanitize_text_field( $_POST['sale_price'] ));
    $transactionData['total_commision'] = str_replace(',','',sanitize_text_field( $_POST['total_commision'] ));
    $transactionData['agent_payout'] = sanitize_text_field( $_POST['agent_payout'] );
    $transactionData['transaction_commission'] = sanitize_text_field( $_POST['transaction_commission'] );
    $transactionData['rental_price'] = str_replace(',','',sanitize_text_field( $_POST['rental_price'] ));
    $transactionData['total_commision_rental'] = str_replace(',','',sanitize_text_field( $_POST['total_commision_rental'] ));
    $transactionData['broker_referral'] = sanitize_text_field( $_POST['broker_referral'] );
    $transactionData['date_edited'] = date("Y-m-d H:i:s");
    $transactionData['edited_by'] = $get_current_user_id;
    
    $transactions_id=sanitize_text_field( $_POST['tid'] );
    
    $response=$query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));   
    $response=json_decode($response);
    if ($response->success=='success') {
        saveFiles($_FILES, $get_current_user_id, $transactions_id);
        _e($query->showMessage($response->success,$response->msg));
    }else{
        _e($query->showMessage($response->success,$response->msg,$response->error,true,''));
    }
    ?>
    <script type="text/javascript">
                setTimeout(function(){ 
                    window.location.href='?transactions=' + '<?php echo $_GET['transactions']; ?>' ;
                 }, 2000);
                
            </script>
            <?php
}

if ($_GET['trans_closed']=='closed') {
                $trans_id=sanitize_text_field( $_GET['trans_id'] );
    if ($trans_id) {
        //close($trans_id,$recode_for);    
        global $wpdb;
            $tdate=date('Y-m-d H:m:s');
            $transactions = $wpdb->prefix .'cn_transactions';
            $transactionData['status']='closed';
            $transactionData['date_completed']=$tdate;
            $transactions_id=$tid;
            $response=$query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));   
            _e($query->showMessage($response->success,'Transaction Closed Successfully'));
            ?>
            <script type="text/javascript">
                setTimeout(function(){ 
                    window.location.href='?transactions=closed_transactions';
                 }, 2000);
                
            </script>
            <?php
    }
}


        function saveFiles($file_array, $uid, $associated_record)
        {
            $query = new Cn_Query();
            global $wpdb;
            $tdate=date('Y-m-d H:m:s');
            $cn_profiles = $wpdb->prefix . 'cn_profiles';
            $clients = $wpdb->prefix .'cn_clients';
            $cn_files = $wpdb->prefix .'cn_files';
            $properties = $wpdb->prefix .'cn_properties';
            $system_ci_sessions = $wpdb->prefix .'cn_system_ci_sessions';
            $cn_users = $wpdb->prefix .'cn_system_users';
            $transactions = $wpdb->prefix .'cn_transactions';

            $document_types = array('hud', 'contract', 'lrol', 'sros', 'other_files', 'condor', 'selldis', 'commission', 'eros', 'closing_statement', 'additional_documents', 'erol');
            foreach($document_types as $document_type)
            {
                if(isset($file_array[$document_type])) {
                   $sortedArray = rearrangeFileArray($file_array[$document_type]);

                    foreach ($sortedArray as $sortedFile) {
                        if ($sortedFile['error'] == 0) {
                            $fileId = saveFile($sortedFile, $uid, 'document', $associated_record, $document_type);
                        }
                    }
                }
            }
        }
         function saveFile($uploadedFile, $uid, $content_type, $associated_record = null, $document_type = null)
        {
            $query = new Cn_Query();
            global $wpdb;
            $tdate=date('Y-m-d H:m:s');
            $cn_profiles = $wpdb->prefix . 'cn_profiles';
            $clients = $wpdb->prefix .'cn_clients';
            $cn_files = $wpdb->prefix .'cn_files';
            $properties = $wpdb->prefix .'cn_properties';
            $system_ci_sessions = $wpdb->prefix .'cn_system_ci_sessions';
            $cn_users = $wpdb->prefix .'cn_system_users';
            $transactions = $wpdb->prefix .'cn_transactions';

            $upload = wp_upload_dir();
			$upload_dir = $upload['basedir'];
			$upload_dir = $upload_dir . '/cn_workstation';
			$file_folder = $upload_dir;
            $extension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);

            if(!acceptedFileType($extension, $content_type)){
                return false;
            }

            $savedName = str_replace(' ', '_', $uid . '-' . date('dmYHis') . '_' . $uploadedFile['name']);
	        $savedName = str_replace('#', '', $savedName);
	        $savedName = str_replace('@', '', $savedName);
            if(move_uploaded_file($uploadedFile['tmp_name'], $file_folder.'/'. $savedName)){

                $fileInsertData = array();
                $fileInsertData['uid'] = $uid;
                $fileInsertData['status'] = 'active';
                $fileInsertData['original_name'] = $uploadedFile['name'];
                $fileInsertData['file_type'] = $uploadedFile['type'];
                $fileInsertData['saved_name'] = $savedName;
                $fileInsertData['date_uploaded'] = date("Y-m-d H:i:s");
                $fileInsertData['content_type'] = $content_type;
                $fileInsertData['associated_record'] = $associated_record;
                $fileInsertData['document_type'] = $document_type;

                $response=$query->iInsert($cn_files, $fileInsertData);
                $response=json_decode($response);
                return  $response->insert_id;
            }

            return false;
        }
        function acceptedFileType($extention, $content_type)
        {
            $query = new Cn_Query();
            $acceptedExtensions = array(
                'profile_image' => array('png', 'jpg', 'jpeg'),
                'document'      => array('png','jpg', 'jpeg', 'pdf')
            );

            if(in_array($extention, $acceptedExtensions[$content_type]))
            {
                return true;
            }

            return false;
        }
         function rearrangeFileArray( $arr ){
            foreach( $arr as $key => $all ){
                foreach( $all as $i => $val ){
                    $new[$i][$key] = $val;
                }
            }
            return $new;
        }
         function cancel($tid,$recode_for)
        {
            $query = new Cn_Query();
            global $wpdb;
            $tdate=date('Y-m-d H:m:s');
            $transactions = $wpdb->prefix .'cn_transactions';

            $transactionData['status']='cancelled';
            $transactionData['date_cancelled']=$tdate;
            $transactions_id=$tid;
                
            $response=$query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));   
            _e($query->showMessage($response->success,'Transaction Cancelled Successfully'));
            ?>
            <script type="text/javascript">
                setTimeout(function(){ 
                    window.location.href='?transactions=closed_transactions';
                 }, 2000);
                
            </script>
            <?php
        }

         function close($tid,$recode_for)
        {
            $query = new Cn_Query();
            global $wpdb;
            $tdate=date('Y-m-d H:m:s');
            $transactions = $wpdb->prefix .'cn_transactions';
            $transactionData['status']='closed';
            $transactionData['date_completed']=$tdate;
            $transactions_id=$tid;
            $response=$query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));   
            _e($query->showMessage($response->success,'Transaction Closed Successfully'));
            ?>
            <script type="text/javascript">
                setTimeout(function(){ 
                    window.location.href='?transactions=closed_transactions';
                 }, 2000);
                
            </script>
            <?php
        }

        if ($get_current_user_id == 1) {
            if ($_GET['transactions'] == 'open_agent_transactions') {
                $trans_edit=sanitize_text_field( $_GET['trans_edit'] );
                global $wpdb;
                $my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` JOIN `".$wpdb->prefix."cn_system_users` ON `".$wpdb->prefix."cn_system_users`.`uid` = `".$wpdb->prefix."cn_transactions`.`uid` WHERE `".$wpdb->prefix."cn_transactions`.`id` = %d", $trans_edit);
                $transactions_details=$query->iFetch($my);
                $tr_files = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_files` WHERE `associated_record` = %d AND status='active'", $trans_edit);
                $cn_files_details=$query->iWhileFetch($tr_files);
            } else if ($_GET['transactions'] == 'closed_agent_transactions') {
                $trans_edit=sanitize_text_field( $_GET['trans_edit'] );
                global $wpdb;
                $my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` JOIN `".$wpdb->prefix."cn_system_users` ON `".$wpdb->prefix."cn_system_users`.`uid` = `".$wpdb->prefix."cn_transactions`.`uid` WHERE `".$wpdb->prefix."cn_transactions`.`id` = %d", $trans_edit);
                $transactions_details=$query->iFetch($my);
                $tr_files = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_files` WHERE `associated_record` = %d AND status='active'", $trans_edit);
                $cn_files_details=$query->iWhileFetch($tr_files);
            } else {
                $trans_edit=sanitize_text_field( $_GET['trans_edit'] );
                global $wpdb;
                $my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` WHERE `".$wpdb->prefix."cn_transactions`.`id` = %d", $trans_edit);
                $transactions_details=$query->iFetch($my);
                $tr_files = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_files` WHERE `associated_record` = %d AND status='active'", $trans_edit);
                $cn_files_details=$query->iWhileFetch($tr_files);
            }
        } else {

            $trans_edit=sanitize_text_field( $_GET['trans_edit'] );
            global $wpdb;
            $my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` JOIN `".$wpdb->prefix."cn_system_users` ON `".$wpdb->prefix."cn_system_users`.`uid` = `".$wpdb->prefix."cn_transactions`.`uid` WHERE `".$wpdb->prefix."cn_transactions`.`id` = %d", $trans_edit);
            $transactions_details=$query->iFetch($my);
            $tr_files = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_files` WHERE `associated_record` = %d AND status='active'", $trans_edit);
            $cn_files_details=$query->iWhileFetch($tr_files);
        }
        $upload = wp_upload_dir();
			$upload_dir = $upload['baseurl'];
			$upload_dir = $upload_dir . '/cn_workstation';
			$file_folder = $upload_dir;
?>
<?php if ($transactions_details['uid'] > 1) { ?>
    <?php
        $generalCommission = $transactions_details['commission'];
        $commission = 0;
        $saleCommission = $transactions_details['sale'];
        $leaseCommission = $transactions_details['lease'];
        if ($transactions_details['type'] == 'sale') {
            $commission = $saleCommission;
        }
        if ($transactions_details['type'] == 'purchase') {
            $commission = $saleCommission;
        }
        if ($transactions_details['type'] == 'lease-tenant') {
            $commission = $leaseCommission;
        }
        if ($transactions_details['type'] == 'lease-landlord') {
            $commission = $leaseCommission;
        }
    ?>
<?php } ?>
<style>
    .custom-label {
        font-weight: 500;
        margin-bottom: 5px;
    }
    .btn-block {
        width: 100%;
    }
    .badge.bg-success {
        font-size: .875rem;
        border-radius: 0.2 rem;
        padding: 0.5rem 0.5rem !important;
        border-radius: 0.2rem;
    }
</style>
<div class="wrap">
  <div class="panel panel-default">
    <div class="panel-body">
<form id="edit_transaction_form" class="fv-form fv-form-bootstrap" method="post" enctype="multipart/form-data">
    <!-- <input type="hidden" name="csrf_test_name" value="ffecad256fe411d2066caf7e4eeac55d"> -->
    <input type="hidden" name="tid" value="<?php _e($trans_edit); ?>">
    <input type="hidden" name="cid" value="<?php _e($transactions_details['cid']); ?>">
    <input type="hidden" name="pid" value="<?php _e($transactions_details['pid']); ?>">
    <input type="hidden" name="uid" value="<?php _e($transactions_details['uid']); ?>">
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    Property
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- <div class="col-lg-4">

                            <div class="form-group">
                                <label>No.</label>
                                <input type="text" name="property_no" value="" id="property_no" maxlength="100" class="form-control"  />
                            </div>
                        </div> -->
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="custom-label">Address</label>
                                <input type="text" name="propertyDetails[property_street]" value="<?php _e($transactions_details['property_street']); ?>" id="property_street" maxlength="100" class="form-control mb-2">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="custom-label">Apt / Suite</label>
                                <input type="text" name="propertyDetails[property_appt]" value="<?php _e($transactions_details['property_appt']); ?>" id="property_appt" maxlength="100" class="form-control mb-2">
                            </div>
                        </div>

                        <div class="col-lg-6">

                            <div class="form-group">
                                <label class="custom-label">City</label>
                                <input type="text" name="propertyDetails[property_city]" value="<?php _e($transactions_details['property_city']); ?>" id="property_city" maxlength="100" class="form-control mb-2">
                            </div>
                        </div>
                        <div class="col-lg-6">

                            <div class="form-group">
                                <label class="custom-label">Zip</label>
                                <input type="text" name="propertyDetails[property_zip]" value="<?php _e($transactions_details['property_zip']); ?>" id="property_zip" maxlength="100" class="form-control mb-2">
                            </div>
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    Client
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">

                            <div class="form-group">
                                <label class="custom-label">Full Name or Main Contact</label>
                                <input type="text" name="client[client_firstName]" value="<?php _e( $transactions_details['client_firstName'] ); ?>" id="client_firstName" maxlength="100" class="form-control mb-2">
                            </div>
                                <div class="form-group">
                                <label class="custom-label">Phone Number</label>
                                <input type="phone" name="client[client_phoneNumber]" value="<?php _e( $transactions_details['client_phoneNumber'] ); ?>" id="client_phoneNumber" maxlength="255" class="form-control mb-2" placeholder="+1 (123)456-7890">
                            </div>
                            
                        </div>
                        <div class="col-lg-6">
                            
                        <div class="form-group">
                                <label class="custom-label">Company Name</label>
                                <input type="text" name="client[client_company]" value="<?php _e( $transactions_details['client_company'] ); ?>" id="client_company" maxlength="100" class="form-control mb-2">
                            </div>
                            <div class="form-group">
                                <label class="custom-label">Email Address</label>
                                <input type="email" name="client[client_emailAddress]" value="<?php _e( $transactions_details['client_emailAddress'] ); ?>" id="client_emailAddress" maxlength="255" class="form-control mb-2">
                            </div>


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
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    Documents
                </div>
                <?php if ($transactions_details['type'] == 'sale') { ?>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Exclusive Right of Sale</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="eros" type="file" name="eros[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="eros" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='eros') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Contract</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="contract" type="file" name="contract[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="contract" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='contract') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Closing Statement</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="closing_statement" type="file" name="closing_statement[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="closing_statement" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='closing_statement') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Additional Documents</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="additional_documents" type="file" name="additional_documents[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="additional_documents" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='additional_documents') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($transactions_details['type'] == 'purchase') { ?>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Contract</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="contract" type="file" name="contract[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="contract" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='contract') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Closing Statement</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="closing_statement" type="file" name="closing_statement[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="closing_statement" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='closing_statement') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Additional Documents</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="additional_documents" type="file" name="additional_documents[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="additional_documents" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='additional_documents') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($transactions_details['type'] == 'lease-tenant') { ?>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Contract</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="contract" type="file" name="contract[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="contract" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='contract') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Additional Documents</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="additional_documents" type="file" name="additional_documents[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="additional_documents" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='additional_documents') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($transactions_details['type'] == 'lease-landlord') { ?>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Exclusive Right of Lease</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="erol" type="file" name="erol[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="erol" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='erol') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Contract</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="contract" type="file" name="contract[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="contract" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='contract') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="hud" class=" form-group">
                                    <label>Additional Documents</label>
                                    <div id="file-upload-form" class="uploader">
                                        <input id="additional_documents" type="file" name="additional_documents[]" accept="image/jpeg, image/png, application/pdf" multiple="multiple" />
                                        <label for="additional_documents" id="file-drag-0">
                                            <img id="file-image" src="#" alt="Preview" class="hidden">
                                            <div id="start">
                                            <i class="fa fa-download" aria-hidden="true"></i>
                                            <div><p class="help-block">.jpg / .png / .pdf (If you are uploading multiple pages in seperate files. Please number the files e.g. 'title of document 1of4.jpg'</p></div>
                                            <div id="notimage" class="hidden">Please select an image</div>
                                            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
                                            </div>
                                            <div id="response" class="hidden">
                                            <div id="messages"></div>
                                            <progress class="progress" id="file-progress" value="0">
                                                <span>0</span>%
                                            </progress>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>File Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach ($cn_files_details as $tr_files) {
                                                if ($tr_files['document_type']=='additional_documents') {
                                                    $html  = '<tr data-id="'.$tr_files['id'].'" class="tr_files_'.$tr_files['id'].'">';
                                                    $html .= '<td><a target="_blank" href="' . $file_folder . '/'.$tr_files['saved_name'].'"> '. $tr_files['original_name'] . ' </a></td>';
                                                    $html .= '<td><div class="badge bg-success">Uploaded</div></td>';
                                                    $html .= '<td><button type="button" class="btn btn-sm btn-danger btn-delete" data-file_type="document" onclick="file_delete('.$tr_files['id'].')">Remove</button></td>';
                                                    $html .= '</tr>';
                                                    _e($html);
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>



    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-3">
                <div class="card-header">
                    Price and Commission
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
<!--sale-->
                            <div class="form-group mb-2">
                                <?php if (str_contains($transactions_details['type'], 'lease')) { ?>
                                    <label class="custom-label">Lease Price</label>
                                <?php } else { ?>
                                    <label class="custom-label">Sales Price</label>
                                <?php } ?>
                                <input type="text" name="sale_price" value="<?php if($transactions_details['sale_price']){ _e($transactions_details['sale_price']);}else{ _e('0.00');} ?>" id="sale_price" maxlength="255" class="form-control">
                            </div>
<!--
                            <div class="form-group mb-2">
                                <label class="custom-label">Transaction Commission Percentage (%)</label>
                                <input type="number" name="transaction_commission" value="" id="transaction_commission" maxlength="255" class="form-control" max="100.0" min="0.0" step="0.0001"  />
                            </div>
                            -->
                            <div class="form-group mb-2">
                                <label class="custom-label">Total Commission </label>
                                <input type="text" name="total_commision" value="<?php if($transactions_details['total_commision']){ _e($transactions_details['total_commision']);}else{ _e('0.00');} ?>" id="total_commision" maxlength="255" class="form-control">
                            </div>

                            <div class="form-group mb-2" style="display: none;">
                                <div class="checkbox">
                                    <label style="padding-left: 0rem;">
                                        <strong>Broker Referral</strong> <input style="margin-left: 1rem;" type="checkbox" name="broker_referral" value="true" <?php if($transactions_details['broker_referral'] && $transactions_details['broker_referral'] == 'true'){ _e('checked');} ?>>
                                    </label>
                                </div>
                            </div>

                            <?php if ($transactions_details['uid'] == 1) { ?>
                                <div class="form-group mb-2">
                                    <label class="custom-label">Agent Payout (<span class="agent-payout" data-commission="1" data-admin="true">100</span>% of Commission)</label>
                                    <input type="text" name="agent_payout" value="<?php if($transactions_details['agent_payout']){ _e($transactions_details['agent_payout']);} ?>" id="agent_payout" maxlength="255" class="form-control">
                                </div>
                            <?php } else { ?>
                                <div class="form-group mb-2">
                                    <label class="custom-label">Agent Payout (<span class="agent-payout" data-commission="<?php _e((float) $transactions_details['commission']); ?>"><?php _e ((float) $transactions_details['commission'] * 100); ?></span>% of Commission)</label>
                                    <input type="text" name="agent_payout" value="<?php if($transactions_details['agent_payout']){ _e($transactions_details['agent_payout']);} ?>" data-commission-referral="<?php echo $commission; ?>" id="agent_payout" maxlength="255" class="form-control">
                                </div>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="card-footer">
                        <p class="help-block" style="color: #111;font-weight: bold; line-height: 25px;">Deposit commission check at <?php _e(get_option('cdbi_bank_name')); ?>.  <br> Account name: <?php _e(get_option('cdbi_account_name')); ?>. Account Number: <?php _e(get_option('cdbi_account_number')); ?> Account Address: <?php _e(get_option('cdbi_account_address')); ?></p>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->


    

            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12 text-center">
            <button type="submit" id="saveTransaction" name="btn_update_transactions" class="btn btn-primary w-25">Save and exit</button>
            <button onclick="transactionClose(<?php _e($transactions_details['id']); ?>,'<?php _e($recode_for); ?>');" id="saveandclose" type="button" class="btn btn-success w-25" data-toggle="modal" data-target="#modalClose">Close and request payment</button>
        </div>
    </div>
  
</form>
</div>
</div>
</div>
<div class="mylod" style="">
      <img src="<?php _e(workstation_URI); ?>cn_package/img/loder.jpg" style="width: 200px;position: fixed;top: 40%;left: 0px;right: 0px;margin: 0px auto;z-index: 9999999999;border-radius: 3px;">  
</div>