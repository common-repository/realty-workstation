<?php

/**
 * @Author: Sharma
 * @Date:   2021-03-12 03:45:20
 * @Last Modified by:   Sharma
 * @Last Modified time: 2021-03-12 04:52:15
 */
if ($_GET['transactions']=='open_transactions') {

	$cn_transactions_text='Open Transactions';
	$actv='open';
	if (isset($_GET['cn_pageno'])) {
		$cn_pageno = sanitize_text_field( $_GET['cn_pageno'] );
	} else {
		$cn_pageno = 1;
	}
	global $wpdb;
	$my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` WHERE `uid` = %d AND `status` = 'open' AND `status` != 'deleted' ORDER BY `".$wpdb->prefix."cn_transactions`.`date_created` DESC", $current_user_id);
	$transactions_details=$query->iWhileFetch($my);
}
?>
<table id="myTable" class="table table-striped table-bordered dataTable">
			<thead>
				<tr>
					<th>Address</th>
					<th>Client</th>
					<th>Type</th>
					<th>Date</th>
					<?php if ($actv=='open'): ?>
						<th>Action</th>	
					<?php endif ?>
				</tr>
			</thead>
			<tbody id="the-list">
				<?php
				foreach ($transactions_details as $value) {
					$agent_id=$value['uid'];
					$transaction_id=$value['id'];
					 	$address  = '';
	                    $address .= ($value['property_street'] != "") ? $value['property_street']  : '';
	                    $address .= ($value['property_appt'] != "") ? ', '.$value['property_appt']: '';
	                    if($value['client_company']!='' && $value['client_company']!=null){
	                        $temp=array($value['client_lastName'].' ' .$value['client_firstName'],$value['client_company']);
	                        $fullname= implode(', ',$temp);
	                    }else{
	                        $fullname=$value['client_lastName'] . ' ' . $value['client_firstName'];
	                    }
					?>
					<tr id="Cn_mytransactions<?php _e( $transaction_id ); ?>" class="">
						<td><?php _e( $address ); ?></td>
                        <td><?php _e( $fullname ); ?></td>
						<td>
							<?php 
								if ($value['type'] == 'sale') {
									esc_html_e( 'Sale', 'realty-workstation' );
								}
								if ($value['type'] == 'purchase') {
									esc_html_e( 'Purchase', 'realty-workstation' );
								}
								if ($value['type'] == 'lease-tenant') {
									esc_html_e( 'Lease - Tenant', 'realty-workstation' );
								}
								if ($value['type'] == 'lease-landlord') {
									esc_html_e( 'Lease - Landlord', 'realty-workstation' );
								}
							?>
						</td>
						<?php
							$my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` WHERE id = " . $transaction_id);
							$result=$query->iWhileFetch($my);
						?>
						<td><?php _e( date('m-d-Y', strtotime($result[0]['date_created'])) ); ?></td>
                        <?php if ($actv=='open'): ?>
							<td >
								<a class="btn btn-primary btn-sm" href="?transactions=open_transactions&trans_edit=<?php _e($transaction_id); ?>" class="button action">Edit</a>
								<?php if ($current_user_id == 1) { ?>
									<button onclick="deletemytransactionsRecord('<?php _e($transaction_id); ?>')" class="button action btn btn-danger btn-sm" type="button">Delete</button>
								<?php } ?>
							</td>
						<?php endif ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>