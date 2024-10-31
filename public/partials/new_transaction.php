<?php

/**
 * @Author: Sharma
 * @Date:   2021-03-12 03:45:44
 * @Last Modified by:   Sharma
 * @Last Modified time: 2021-03-12 04:27:24
 */
function workstation_sanitize_array( $input ) {
    // Initialize the new array that will hold the sanitize values
    $new_input = array();
    // Loop through the input and sanitize each of the values
    foreach ( $input as $key => $val ) {
        $new_input[ $key ] = sanitize_text_field( $val );
    }
    return $new_input;
}
			if ($_GET['trans_closed']=='closed') {
				$trans_id=sanitize_text_field( $_GET['trans_id'] );
				if ($trans_id) {
					$this->close($trans_id,$recode_for);	
				}
			}
			if ($_GET['trans_cancel']=='cancel') {
				$trans_id=sanitize_text_field( $_GET['trans_id'] );
				if ($trans_id) {
					$this->cancel($trans_id,$recode_for);	
				}
			}

			if (isset($_POST['btn_add_my_transactions'])) {
						
				$clientData = array();
				$clientData=workstation_sanitize_array($_POST['client']);
				$clientData['client_lastName'] = '';//$this->input->post('client_lastName');
				$clientData['date_created'] = date("Y-m-d H:i:s");
				$response=$query->iInsert($clients, $clientData);
				$response=json_decode($response);
				$clientId = $response->insert_id;

				$propertyData = array();
				$propertyData=workstation_sanitize_array($_POST['propertyDetails']);
		        $propertyData['property_no'] = '';//$this->input->post('property_no');
		        $propertyData['date_created'] = date("Y-m-d H:i:s");
				$response=$query->iInsert($properties, $propertyData);
				$response=json_decode($response);
				$propertyId = $response->insert_id;

		        $transactionData = array();
		        $transactionData['uid'] = $get_current_user_id;
		        $transactionData['status'] = 'open';
		        $transactionData['type'] = sanitize_text_field($_POST['transaction']['transactionType']);
		        $transactionData['property_id'] = $propertyId;
		        $transactionData['client_id'] = $clientId;
		        $transactionData['date_created'] = date("Y-m-d H:i:s");
				$response=$query->iInsert($transactions, $transactionData);
				$response=json_decode($response);
				if ($response->success=='success') {
					_e($query->showMessage($response->success,$response->msg));
				}else{
					_e($query->showMessage($response->success,$response->msg,$response->error,true,''));
				}
			}
			if (isset($_POST['btn_update_transactions'])) {
				// $transaction = $this->db->where('uid', $this->session->uid)
				//        ->where('transactions.id', $transactionId)
				//        ->join('clients', 'transactions.client_id = clients.cid')
				//        ->join('properties', 'transactions.property_id = properties.pid')
				//        ->get('transactions');
				$clientData = array();
				$clientData=workstation_sanitize_array($_POST['client']);
				$clientData['date_created'] = date("Y-m-d H:i:s");
				$client_cid=sanitize_text_field($_POST['cid']);
				$response=$query->iUpdateArray($clients,$clientData,array('`cid`'=>$client_cid));	

				$propertyData = array();
				$propertyData=workstation_sanitize_array($_POST['propertyDetails']);
		        $propertyData['property_no'] = '';//$this->input->post('property_no');
		        $propertyData['date_created'] = date("Y-m-d H:i:s");
		        $property_pid=sanitize_text_field($_POST['pid']);
				$response=$query->iUpdateArray($properties,$propertyData,array('`pid`'=>$property_pid));	

		        $transactionData = array();
		        $transactionData['uid'] = $get_current_user_id;
		        $transactionData['sale_price'] = str_replace(',','',sanitize_text_field($_POST['sale_price']));
	    		$transactionData['total_commision'] = str_replace(',','',sanitize_text_field($_POST['total_commision']));
	    		$transactionData['transaction_commission'] = sanitize_text_field($_POST['transaction_commission']);
	    		$transactionData['rental_price'] = str_replace(',','',sanitize_text_field($_POST['rental_price']));
	    		$transactionData['total_commision_rental'] = str_replace(',','',sanitize_text_field($_POST['total_commision_rental']));
	    		$transactionData['date_edited'] = date("Y-m-d H:i:s");
	    		$transactionData['edited_by'] = $get_current_user_id;
				
				$transactions_id=sanitize_text_field($_POST['tid']);
				
				$response=$query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));	
				$response=json_decode($response);
				if ($response->success=='success') {
					$this->saveFiles($_FILES, $get_current_user_id, $transactions_id);
					_e($query->showMessage($response->success,$response->msg));
				}else{
					_e($query->showMessage($response->success,$response->msg,$response->error,true,''));
				}
			}
			
			
			
			
?>
<style>
    .custom-label {
        font-weight: 500;
        margin-bottom: 5px;
    }
</style>
<form id="add_Questions" action="#" class="fv-form fv-form-bootstrap" method="post">
 
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card mb-3">
            <div class="card-header">
                Transaction Type
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="transaction[transactionType]" id="transactionType1" value="purchase">
                                <label class="form-check-label" for="transactionType1">Purchase</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="transaction[transactionType]" id="transactionType2" value="sale">
                                <label class="form-check-label" for="transactionType2">Sale</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="transaction[transactionType]" id="transactionType3" value="lease-tenant">
                                <label class="form-check-label" for="transactionType3">Lease - Tenant</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="transaction[transactionType]" id="transactionType4" value="lease-landlord">
                                <label class="form-check-label" for="transactionType4">Lease - Landlord</label>
                            </div>
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
                Property
            </div>
            <div class="card-body">
                <div class="row">
                <div class="col-lg-6">
                        <div class="form-group mb-2 has-feedback">
                            <label class="custom-label">Address</label>
                            <input type="text" name="propertyDetails[property_street]" value="" id="property_street" maxlength="200" class="form-control" data-fv-field="property_street"><i class="form-control-feedback" data-fv-icon-for="property_street" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="property_street" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="property_street" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-2 has-feedback">
                            <label class="custom-label">Apt / Suite</label>
                            <input type="text" name="propertyDetails[property_appt]" value="" id="property_appt" maxlength="100" class="form-control" data-fv-field="property_appt"><i class="form-control-feedback" data-fv-icon-for="property_appt" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="stringLength" data-fv-for="property_appt" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                    </div>

                    <div class="col-lg-6">

                        <div class="form-group mb-2 has-feedback">
                            <label class="custom-label">City</label>
                            <input type="text" name="propertyDetails[property_city]" value="" id="property_city" maxlength="100" class="form-control" data-fv-field="property_city"><i class="form-control-feedback" data-fv-icon-for="property_city" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="property_city" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="property_city" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group mb-2 has-feedback">
                            <label class="custom-label">Zip</label>
                            <input type="text" name="propertyDetails[property_zip]" value="" id="property_zip" maxlength="100" class="form-control" data-fv-field="property_zip"><i class="form-control-feedback" data-fv-icon-for="property_zip" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="property_zip" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="property_zip" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

                        <div class="form-group has-feedback">
                            <label class="custom-label">Full Name or Main Contact</label>
                            <input type="text" name="client[client_firstName]" value="" id="client_firstName" maxlength="100" class="form-control mb-2" data-fv-field="client_firstName"><i class="form-control-feedback" data-fv-icon-for="client_firstName" style="display: none;"></i>
                            <small class="help-block" data-fv-validator="notEmpty" data-fv-for="client_firstName" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="regexp" data-fv-for="client_firstName" data-fv-result="NOT_VALIDATED" style="display: none;">Can only consist of alphabetical and Space</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="client_firstName" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                        <div class="form-group has-feedback">
                            <label class="custom-label">Phone Number</label>
                            <input type="phone" name="client[client_phoneNumber]" value="" id="client_phoneNumber" maxlength="255" class="form-control mb-2" placeholder="+1 (123)456-7890" data-fv-field="client_phoneNumber"><i class="form-control-feedback" data-fv-icon-for="client_phoneNumber" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="client_phoneNumber" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="phone" data-fv-for="client_phoneNumber" data-fv-result="NOT_VALIDATED" style="display: none;">The value is not valid %s phone number</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="client_phoneNumber" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>     
                        
                    </div>
                    <div class="col-lg-6">
                        
                    <div class="form-group has-feedback">
                            <label class="custom-label">Company Name</label>
                            <input type="text" name="client[client_company]" value="" id="client_company" maxlength="100" class="form-control mb-2" data-fv-field="client_company"><i class="form-control-feedback" data-fv-icon-for="client_company" style="display: none;"></i>
                            <small class="help-block" data-fv-validator="stringLength" data-fv-for="client_company" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>
                        <div class="form-group has-feedback">
                            <label class="custom-label">Email Address</label>
                            <input type="email" name="client[client_emailAddress]" value="" id="client_emailAddress" maxlength="255" class="form-control mb-2" data-fv-field="client_emailAddress"><i class="form-control-feedback" data-fv-icon-for="client_emailAddress" style="display: none;"></i>
                        <small class="help-block" data-fv-validator="notEmpty" data-fv-for="client_emailAddress" data-fv-result="NOT_VALIDATED" style="display: none;">Required</small><small class="help-block" data-fv-validator="regexp" data-fv-for="client_emailAddress" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a valid email address</small><small class="help-block" data-fv-validator="emailAddress" data-fv-for="client_emailAddress" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a valid email address</small><small class="help-block" data-fv-validator="stringLength" data-fv-for="client_emailAddress" data-fv-result="NOT_VALIDATED" style="display: none;">Please enter a value with valid length</small></div>


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
        <div class="col-lg-12 text-center">
      <button type="submit" class="btn btn-success w-25" name="btn_add_my_transactions"><i class="glyphicon glyphicon-floppy-save"></i> Save</button>
    </div>
  </div>
</form>
    <br>
    <br>
    <br>