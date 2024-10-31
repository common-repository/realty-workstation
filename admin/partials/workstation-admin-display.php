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
	<h1 class="wp-heading-inline">Agents</h1>
	<button type="button" class="page-title-action" onclick="addusersRecord('type');" >Add New Agent</button>
	<hr class="wp-header-end">
	<h2 class="screen-reader-text">Filter pages list</h2>
	<ul class="subsubsub">
		<li class="all"><a href="edit.php?post_type=page" class="current" aria-current="page">All <span class="count">(<?php _e($users_count); ?>)</span></a> |</li>
	</ul>
	<form id="posts-filter" method="get">
		<div class="tablenav top" style="float: left">
			<div class="alignleft actions bulkactions">
				<button type="button" onclick="editAllusersRecord();" class="button action">Edit Selected</button>
				<button type="button" onclick="deleteAllusersRecord();" class="button action">Delete Selected</button>
			</div>
			<br>
		</div>
		<nav aria-label="Page navigation example" style="float: right">
		  	<ul class="pagination justify-content-end mb-2">
			  	<li class="page-item  <?php if($cn_pageno == 1){ esc_html_e('disabled', 'realty-workstation'); } ?>">
			  		<a class="page-link" href="?page=workstation<?php _e( $cn_pagination_filter); ?>&cn_pageno=1">First</a>
			  	</li>
			    <li class="page-item <?php if($cn_pageno <= 1){ esc_html_e('disabled', 'realty-workstation'); } ?>">
			    	<a class="page-link" href="?page=workstation<?php _e( $cn_pagination_filter); ?><?php if($cn_pageno <= 1){ esc_html_e ('#', 'realty-workstation'); } else { _e ('&cn_pageno='.($cn_pageno - 1)); } ?>">Previous</a>
			    </li>
			    <li class="page-item">
			    	<div class="page-item">
			    		<a class="page-link"><?php _e ( $cn_pageno .' of '. $total_pages); ?></a>
			    	</div>
			    </li>
			    <li class="page-item <?php if($cn_pageno >= $total_pages){ esc_html_e('disabled', 'realty-workstation'); } ?>">
			    	<a class="page-link" href="?page=workstation<?php _e( $cn_pagination_filter); ?><?php if($cn_pageno >= $total_pages){ esc_html_e ('#', 'realty-workstation'); } else { _e ('&cn_pageno='.($cn_pageno + 1)); } ?>">Next</a>
			    </li>
			    <li class="page-item <?php if($cn_pageno >= $total_pages){ esc_html_e('disabled', 'realty-workstation'); } ?>">
			    	<a class="page-link" href="?page=workstation<?php _e( $cn_pagination_filter); ?>&cn_pageno=<?php _e($total_pages); ?>">Last</a>
			    </li>
		  	</ul>
		</nav>
		<br>
		<h2 class="screen-reader-text">Pages list</h2>
		<table class="wp-list-table widefat fixed striped pages">
			<thead>
				<tr>
					<td id="cb" class="manage-column column-cb check-column">
						<label class="screen-reader-text" for="cb-select-all-1">Select All</label>
						<input id="cb-select-all-1" type="checkbox">
					</td>
					<th>Name</th>
					<th>Email</th>
					<th>Last Accessed</th>
					<th style="width: 270px">Actions</th>
				</tr>
			</thead>
			<tbody id="the-list">
				<?php
				foreach ($users_details as $value) {
					$users_id=$value['uid'];
					?>
					<tr id="Cn_users<?php _e($users_id); ?>" class="">
						<th scope="row" class="check-column">			
							<input id="cn<?php _e($users_id); ?>" class="cn_checkbox" type="checkbox" name="post" value="<?php _e($users_id); ?>">
						</th>
						<td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
							<div class="locked-info">
								<span class="locked-avatar"></span> 
								<span class="locked-text"></span>
							</div>
							<strong>
								<a class="row-title" href="javascript:void(0);" onclick="editusersRecord('<?php _e($users_id); ?>');">
									<?php _e($value['last_name']); ?>
									<?php esc_html_e( ', ', 'realty-workstation' ); ?>
									<?php _e($value['first_name']); ?>
								</a>
							</strong>
						</td>
						<td><?php _e($value['email']); ?></td>
						<td><?php _e($value['date_loggedIn']); ?></td>
						<td>
							<button onclick="editusersRecord('<?php _e($users_id); ?>');" class="button action" type="button"><?php esc_html_e( 'EDIT', 'realty-workstation'); ?></button>
							<button onclick="deleteusersRecord('<?php _e($users_id); ?>')" class="button action" type="button"><?php esc_html_e( 'DELETE', 'realty-workstation'); ?></button>
							<!-- <button onclick="ResetPasswordusersRecord('<?php _e($users_id); ?>')" class="button action" type="button"><?php esc_html_e( 'RESET PASSWORD', 'realty-workstation'); ?></button> -->
						</td>
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
			<div class="cn_card-header">Agent<i class="cn_close pull-right">X</i></div>
			<div id="cn_model_body" class="cn_card-body">
				
			</div>
		</div>
	</div>
</div>

<div class="mylod" style="">
      <img src="<?php _e(workstation_URI); ?>cn_package/img/loder.jpg" style="width: 200px;position: fixed;top: 40%;left: 0px;right: 0px;margin: 0px auto;z-index: 9999999999;border-radius: 3px;">  
</div>