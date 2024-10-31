<?php

/**
 * @Author: Sharma
 * @Date:   2021-03-12 03:45:35
 * @Last Modified by:   Sharma
 * @Last Modified time: 2021-04-23 21:00:38
 */



	$cn_profiles = $wpdb->prefix . 'cn_profiles';
    $clients = $wpdb->prefix .'cn_clients';
    $cn_files = $wpdb->prefix .'cn_files';
    $properties = $wpdb->prefix .'cn_properties';
    $system_ci_sessions = $wpdb->prefix .'cn_system_ci_sessions';
    $cn_users = $wpdb->prefix .'cn_system_users';
    $system_users = $wpdb->prefix .'cn_system_users';
    $transactions = $wpdb->prefix .'cn_transactions';
	if ($_GET['trans_closed']=='closed') {
	                $trans_id=sanitize_text_field( $_GET['trans_id'] );
	    if ($trans_id) {
	        close($trans_id,$recode_for);    
	    }
	}
	if ($_GET['trans_cancel']=='cancel') {
	    $trans_id=sanitize_text_field( $_GET['trans_id'] );
	    if ($trans_id) {
	        cancel($trans_id,$recode_for);   
	    }
	}
if ($_GET['transactions']=='closed_transactions') {
				$actv='closed';
				$cn_transactions_text='Closed and Cancelled Transactions';
				if (isset($_GET['cn_pageno'])) {
					$cn_pageno = sanitize_text_field( $_GET['cn_pageno'] );
				} else {
					$cn_pageno = 1;
				}
				// $current_user_id=$current_user_id;
				$my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` WHERE `uid` = %d AND `status` != 'open' AND `status` != 'deleted' ORDER BY `date_completed` DESC, `date_cancelled` DESC, `".$wpdb->prefix."cn_transactions`.`date_created` DESC", $current_user_id);
				$transactions_details=$query->iWhileFetch($my);
}

function cancel($tid,$recode_for)
	{
            global $wpdb;
            $query = new Cn_Query();
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
			if (get_option('workstation_masteruser_email') && $current_user_id != 1) {
				global $wpdb;
				$query = new Cn_Query();
				$cn_profiles = $wpdb->prefix . 'cn_profiles';
				$clients = $wpdb->prefix .'cn_clients';
				$cn_files = $wpdb->prefix .'cn_files';
				$properties = $wpdb->prefix .'cn_properties';
				$system_ci_sessions = $wpdb->prefix .'cn_system_ci_sessions';
				$cn_users = $wpdb->prefix .'cn_system_users';
				$system_users = $wpdb->prefix .'cn_system_users';
				$transactions = $wpdb->prefix .'cn_transactions';
				$my="SELECT *
					FROM `$transactions`
					JOIN `$clients` ON `$transactions`.`client_id` = `$clients`.`cid`
					JOIN `$properties` ON `$transactions`.`property_id` = `$properties`.`pid`
					JOIN `$cn_users` ON `$cn_users`.`uid` = `$transactions`.`uid`
					WHERE `$transactions`.`id` = $tid
					ORDER BY `$transactions`.`date_created` DESC";
				$mail_transactions_details=$query->iWhileFetch($my)[0];
				$agent_name = $mail_transactions_details['first_name'] . ' ' . $mail_transactions_details['last_name'];
				$message = $agent_name . ' has closed a transaction and requested payment.';
				$message .= '<p>';
				$message .= 'Property information is below:';
				$message .= '</p>';
				$message .= '<p>';
				$message .= '<ul>';
				$message .= '<li>Property Street: ' . $mail_transactions_details['property_street'] . '</li>';
				$message .= '<li>Property Appt: ' . $mail_transactions_details['property_appt'] . '</li>';
				$message .= '<li>Property City: ' . $mail_transactions_details['property_city'] . '</li>';
				$message .= '<li>Property ZIP: ' . $mail_transactions_details['property_zip'] . '</li>';
				$message .= '</ul>';
				$message .= '</p>';
				$message .= '<p>';
				$message .= 'Price and Commission:';
				$message .= '</p>';
				$message .= '<p>';
				$message .= '<ul>';
				$message .= '<li>Sale Price: ' . number_format($mail_transactions_details['sale_price']) . '.00' . '</li>';
				$message .= '<li>Total Commission: ' . number_format($mail_transactions_details['total_commision']) . '.00' . '</li>';
				$message .= '<li>Agent Payout: ' . $mail_transactions_details['agent_payout'] . '</li>';
				$message .= '</ul>';
				$message .= '</p>';
				wp_mail( get_option('workstation_masteruser_email'), $agent_name . ' has closed a transaction and requested payment. ', $message );
			}
            global $wpdb;
            $query = new Cn_Query();
            $tdate=date('Y-m-d H:m:s');
            $transactions = $wpdb->prefix .'cn_transactions';
            $transactionData['status']='closed';
            $transactionData['date_completed']=$tdate;
            $transactions_id=$tid;

            $query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));   
            	_e($query->showMessage($response->success,'Transaction Closed Successfully'));
            ?>
            <script type="text/javascript">
                setTimeout(function(){ 
                    window.location.href='?transactions=closed_transactions';
                 }, 2000);
                
            </script>
            <?php
        }
?>
<table id="myTable" class="table table-striped table-bordered dataTable">
			<thead>
				<tr>
					<th>Address</th>
					<th>Client</th>
					<th>Type</th>
					<th>Date</th>
					<?php if ($actv=='open' || $current_user_id == 1): ?>
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
                        <?php if ($actv=='open' || $current_user_id == 1): ?>
							<td>
								<a class="btn btn-primary btn-sm" href="?transactions=closed_transactions&trans_edit=<?php _e($transaction_id); ?>" class="button action">Edit</a>
								<?php if ($current_user_id == 1) { ?>
									<button onclick="deletemytransactionsRecord('<?php _e($transaction_id); ?>')" class="button action btn btn-danger btn-sm" type="button">Delete</button>
								<?php } ?>
							</td>
						<?php endif ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>