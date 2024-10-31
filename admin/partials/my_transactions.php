<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.realtyworkstation.com/
 * @since      1.0.0
 *
 * @package    Workstation
 * @subpackage Workstation/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<style type="text/css">
	body {
    background: #f1f1f1 !important;
}

</style>
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<h1 class="wp-heading-inline">Broker <?php _e($cn_transactions_text); ?></h1>
	<button type="button" class="page-title-action" onclick="addmytransactionsRecord();" >Add New Transaction</button>
	<hr class="wp-header-end">
	<h2 class="screen-reader-text">Filter pages list</h2>
	<ul class="subsubsub">
		<li class="all"><a href="edit.php?post_type=page" class="current" aria-current="page">All <span class="count">(<?php _e($my_count); ?>)</span></a> |</li>
	</ul>
	<form id="posts-filter" method="get">
		<div class="tablenav top" style="float: left">
			<div class="alignleft actions bulkactions">
				<a href="?page=my-transactions&transactions=open" class="button action <?php if($actv=='open'){ _e('actv');} ?>"><i class="fa fa-folder-open-o"></i> Open</a>
				<a href="?page=my-transactions&transactions=closed" class="button action <?php if($actv=='closed'){ _e('actv');} ?>"><i class="fa fa-folder-o"></i> Closed & Cancelled</a>
			</div>
			<br>
		</div>
		<nav aria-label="Page navigation example" style="float: right">
		  	<ul class="pagination justify-content-end mb-2">
			  	<li class="page-item  <?php if($cn_pageno == 1){ esc_html_e('disabled', 'realty-workstation'); } ?>">
			  		<a class="page-link" href="?page=my-transactions<?php _e ( $cn_pagination_filter  ); ?>&cn_pageno=1">First</a>
			  	</li>
			    <li class="page-item <?php if($cn_pageno <= 1){ esc_html_e('disabled', 'realty-workstation'); } ?>">
			    	<a class="page-link" href="?page=my-transactions<?php _e ( $cn_pagination_filter ); ?><?php if($cn_pageno <= 1){ esc_html_e ('#', 'realty-workstation'); } else { _e ('&cn_pageno='.($cn_pageno - 1)); } ?>">Previous</a>
			    </li>
			    <li class="page-item">
			    	<div class="page-item">
			    		<a class="page-link"><?php esc_html_e ( $cn_pageno .' of '. $total_pages, 'realty-workstation'); ?></a>
			    	</div>
			    </li>
			    <li class="page-item <?php if($cn_pageno >= $total_pages){ esc_html_e('disabled', 'realty-workstation'); } ?>">
			    	<a class="page-link" href="?page=my-transactions<?php _e ( $cn_pagination_filter  ); ?><?php if($cn_pageno >= $total_pages){ esc_html_e ('#', 'realty-workstation'); } else { _e ('&cn_pageno='.($cn_pageno + 1)); } ?>">Next</a>
			    </li>
			    <li class="page-item <?php if($cn_pageno >= $total_pages){ esc_html_e('disabled', 'realty-workstation'); } ?>">
			    	<a class="page-link" href="?page=my-transactions<?php _e ( $cn_pagination_filter  ); ?>&cn_pageno=<?php _e($total_pages); ?>">Last</a>
			    </li>
		  	</ul>
		</nav>
		<br>
		<h2 class="screen-reader-text">Pages list</h2>
		<table class="wp-list-table widefat fixed striped pages">
			<thead>
				<tr>
				<th>Address</th>
					<th>Client</th>
					<th>Type</th>
					<?php if (1==1): ?>
						<th>Action</th>	
					<?php endif ?>
				</tr>
			</thead>
			<tbody id="the-list">
			<?php
				foreach ($my_details as $value) {
					$agent_id=$value['uid'];
					$transaction_id=$value['id'];
					 	$address  = '';
	                    $address .= ($value['property_street'] != "") ? $value['property_street']  : '';
	                    $address .= ($value['property_appt'] != "") ? ', '.$value['property_appt']: '';
	                    if($value['client_company']!='' && $value['client_company']!=null){
	                        // var_dump($value['client_lastName'].' ' .$value['client_firstName']);
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
                        <?php if (1==1): ?>
							<td class="text-center">
								<a href="?page=my-transactions&trans_edit=<?php _e($transaction_id); ?>" class="button action">Edit</a>
								<button onclick="deletemytransactionsRecord('<?php _e($transaction_id); ?>')" class="button action" type="button">DELETE</button>
							</td>
						<?php endif ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</form>

	<div id="ajax-response"></div>
	<br class="clear">
</div>

<div class="cn_model" id="cn_model">
	<div class="cn_model_body">
		<div class="cn_card mb-4">
			<div class="cn_card-header">New Transaction<i class="cn_close pull-right">X</i></div>
			<div id="cn_model_body" class="cn_card-body">
				
			</div>
		</div>
	</div>
</div>

<div class="mylod" style="">
      <img src="<?php _e(workstation_URI); ?>cn_package/img/loder.jpg" style="width: 200px;position: fixed;top: 40%;left: 0px;right: 0px;margin: 0px auto;z-index: 9999999999;border-radius: 3px;">  
</div>