<style>
    .btn-block {
        width: 100%;
    }
</style>
<?php if ($transactions_details['uid'] > 1) { ?>
    <?php
        $generalCommission = $transactions_details['commission'];
        $commission = 0;
        $saleCommission = $transactions_details['sale'];
        $leaseCommission = $transactions_details['lease'];
        if ($transactions_details['type'] == 'sale') {
            $transactions_details['type'] = 'Sale';
            $commission = $saleCommission;
        }
        if ($transactions_details['type'] == 'purchase') {
            $transactions_details['type'] = 'Purchase';
            $commission = $saleCommission;
        }
        if ($transactions_details['type'] == 'lease-tenant') {
            $transactions_details['type'] = 'Lease - Tenant';
            $commission = $leaseCommission;
        }
        if ($transactions_details['type'] == 'lease-landlord') {
            $transactions_details['type'] = 'Lease - Landlord';
            $commission = $leaseCommission;
        }
    ?>
    <h3>Edit Agent Transaction: <?php _e($transactions_details['first_name'] . ' ' . $transactions_details['last_name'] . ' - ' . $transactions_details['type']); ?></h3>	
<?php } ?>
<?php
    $upload = wp_upload_dir();
    $upload_dir = $upload['baseurl'];
    $upload_dir = $upload_dir . '/cn_workstation';
    $file_folder = $upload_dir;
?>
    <div class="wrap">
  <div class="cn_card cn_card-default">
    <div class="cn_card-body">
<form id="add_demos" class="form-horizontal" method="post" enctype="multipart/form-data">
    <input type="hidden" name="tid" value="<?php _e( $trans_edit ); ?>">
    <input type="hidden" name="cid" value="<?php _e( $transactions_details['cid'] ); ?>">
    <input type="hidden" name="pid" value="<?php _e( $transactions_details['pid'] ); ?>">
    
    <div class="row">
        <div class="cn_col-lg-12">
            <div class="cn_card cn_card-default">
                <div class="cn_card-header">
                    <?php esc_html_e( 'Property', 'realty-workstation' ); ?>
                </div>
                <div class="cn_card-body">
                    <div class="row">
                        <!-- <div class="cn_col-lg-4">

                            <div class="cn-form-group">
                                <label>No.</label>
                                <input type="text" name="property_no" value="" id="property_no" maxlength="100" class="cn-form-control"  />
                            </div>
                        </div> -->
                        <div class="cn_col-lg-6">
                            <div class="cn-form-group">
                                <label>Address</label>
                                <input type="text" name="property[property_street]" value="<?php _e( $transactions_details['property_street'] ); ?>" id="property_street" maxlength="100" class="cn-form-control">
                            </div>
                        </div>
                        <div class="cn_col-lg-6">
                            <div class="cn-form-group">
                                <label>Apt / Suite</label>
                                <input type="text" name="property[property_appt]" value="<?php _e( $transactions_details['property_appt'] ); ?>" id="property_appt" maxlength="100" class="cn-form-control">
                            </div>
                        </div>

                        <div class="cn_col-lg-6">

                            <div class="cn-form-group">
                                <label>City</label>
                                <input type="text" name="property[property_city]" value="<?php _e( $transactions_details['property_city'] ); ?>" id="property_city" maxlength="100" class="cn-form-control">
                            </div>
                        </div>
                        <div class="cn_col-lg-6">

                            <div class="cn-form-group">
                                <label>Zip</label>
                                <input type="text" name="property[property_zip]" value="<?php _e( $transactions_details['property_zip'] ); ?>" id="property_zip" maxlength="100" class="cn-form-control">
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
                    Client
                </div>
                <div class="cn_card-body">
                    <div class="row">
                        <div class="cn_col-lg-6">

                            <div class="cn-form-group">
                                <label>Full Name or Main Contact</label>
                                <input type="text" name="client[client_firstName]" value="<?php _e( $transactions_details['client_firstName'] ); ?>" id="client_firstName" maxlength="100" class="cn-form-control">
                            </div>
                                <div class="cn-form-group">
                                <label>Phone Number</label>
                                <input type="phone" name="client[client_phoneNumber]" value="<?php _e( $transactions_details['client_phoneNumber'] ); ?>" id="client_phoneNumber" maxlength="255" class="cn-form-control" placeholder="+1 (123)456-7890">
                            </div>
                            
                        </div>
                        <div class="cn_col-lg-6">
                            
                        <div class="cn-form-group">
                                <label>Company Name</label>
                                <input type="text" name="client[client_company]" value="<?php _e( $transactions_details['client_company'] ); ?>" id="client_company" maxlength="100" class="cn-form-control">
                            </div>
                            <div class="cn-form-group">
                                <label>Email Address</label>
                                <input type="email" name="client[client_emailAddress]" value="<?php _e( $transactions_details['client_emailAddress'] ); ?>" id="client_emailAddress" maxlength="255" class="cn-form-control">
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
                    Documents
                </div>
                        <?php if ($transactions_details['type'] == 'sale') { ?>
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
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
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
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
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
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
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="cn_card-body">
                                <hr>
                                <div class="row">
                                    <div class="cn_col-lg-12">
                                        <div id="hud" class="cn-form-group">
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
                                    <div class="cn_col-lg-12">
                                        <table class="widefat fixed" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th id="file-name" class="manage-column column-file-name" scope="col">File Name</th>
                                                    <th id="status" class="manage-column column-status" scope="col">Status</th>
                                                    <th id="remove-btn" class="manage-column column-remove-btn" scope="col">Actions</th>
                                                </tr>
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
                                                            _e($html, 'realty-workstation');
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
        <div class="cn_col-lg-12">
            <div class="cn_card cn_card-default">
                <div class="cn_card-header">
                    Price and Commission
                </div>

                <div class="cn_card-body">
                    <div class="row">
                        <div class="cn_col-lg-12">
<!--sale-->
                            <div class="cn-form-group">
                                <?php if (str_contains($transactions_details['type'], 'lease')) { ?>
                                    <label>Lease Price</label>
                                <?php } else { ?>
                                    <label>Sales Price</label>
                                <?php } ?>
                                <input type="text" name="sale_price" value="<?php if($transactions_details['sale_price']){ _e($transactions_details['sale_price']);}else{ _e('0.00');} ?>" id="sale_price" maxlength="255" class="cn-form-control">
                            </div>
<!--
                            <div class="cn-form-group">
                                <label>Transaction Commission Percentage (%)</label>
                                <input type="number" name="transaction_commission" value="" id="transaction_commission" maxlength="255" class="cn-form-control" max="100.0" min="0.0" step="0.0001"  />
                            </div>
                            -->
                            <div class="cn-form-group">
                                <label>Total Commission </label>
                                <input type="text" name="total_commision" value="<?php if($transactions_details['total_commision']){ _e($transactions_details['total_commision']);}else{ _e('0.00');} ?>" id="total_commision" maxlength="255" class="cn-form-control">
                            </div>

                            <div class="cn-form-group" style="display: none;">
                                <div class="checkbox">
                                    <label>
                                        Broker Referral <input type="checkbox" name="broker_referral" value="true" <?php if($transactions_details['broker_referral'] && $transactions_details['broker_referral'] == 'true'){ _e('checked');} ?>>
                                    </label>
                                </div>
                            </div>

                            <?php if ($transactions_details['uid'] == 1) { ?>
                                <div class="cn-form-group">
                                    <label>Agent Payout (<span class="agent-payout" data-commission="1" data-admin="true">100</span>% of Commission)</label>
                                    <input type="text" name="agent_payout" value="<?php if($transactions_details['agent_payout']){ _e($transactions_details['agent_payout']);} ?>" id="agent_payout" maxlength="255" class="cn-form-control">
                                </div>
                            <?php } else { ?>
                                <div class="cn-form-group">
                                    <label>Agent Payout (<span class="agent-payout" data-commission="<?php _e((float) $transactions_details['commission']); ?>"><?php _e ((float) $transactions_details['commission'] * 100); ?></span>% of Commission)</label>
                                    <input type="text" name="agent_payout" value="<?php if($transactions_details['agent_payout']){ _e($transactions_details['agent_payout']);} ?>" data-commission-referral="<?php echo (float) $commission; ?>" id="agent_payout" maxlength="255" class="cn-form-control">
                                </div>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="cn_card-footer">
                        <p class="help-block" style="cn_color: #111;font-weight: bold; line-height: 25px;">Deposit commission check at <?php _e(get_option('cdbi_bank_name')); ?>.  <br> Account name: <?php _e(get_option('cdbi_account_name')); ?>. Account Number: <?php _e(get_option('cdbi_account_number')); ?> Account Address: <?php _e(get_option('cdbi_account_address')); ?></p>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.cn_card-body -->


    

            </div>
            <!-- /.cn_card -->
        </div>
        <!-- /.cn_col-lg-12 -->
    </div>

    <div class="row">
      <div class="cn_col-lg-12"><br></div>
        <div class="cn_col-lg-4">
            <button type="submit" id="saveTransaction" name="btn_update_transactions" class="btn btn-primary btn-lg btn-block">Save and keep open</button>
        </div>
        <div class="cn_col-lg-4">
            <button onclick="transactionClose(<?php _e($transactions_details['id']); ?>,'<?php _e($recode_for); ?>');" id="saveandclose" type="button" class="btn btn-success btn-lg btn-block" data-toggle="modal" data-target="#modalClose">Close and request payment</button>
        </div>
        <!-- <div class="cn_col-lg-4">
            <button onclick="transactionCancel(<?php _e($transactions_details['id']); ?>,'<?php _e($recode_for); ?>');" type="button" class="btn btn-danger btn-lg btn-block" data-toggle="modal" data-target="#modalCancel">Cancel and archive</button>
        </div> -->
    </div>
  
</form>
</div>
</div>
</div>
<div class="mylod" style="">
      <img src="<?php _e(workstation_URI); ?>cn_package/img/loder.jpg" style="width: 200px;position: fixed;top: 40%;left: 0px;right: 0px;margin: 0px auto;z-index: 9999999999;border-radius: 3px;">  
</div>