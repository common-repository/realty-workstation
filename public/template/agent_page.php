<?php

/**
 * @Author: Sharma
 * @Date:   2021-03-12 03:10:24
 * @Last Modified by:   Sharma
 * @Last Modified time: 2021-04-23 20:59:45
 */
 /*

 Template Name: Start-Quiz

 */
	session_start();
	if ($_GET['transactions']=='logout'){
	 	session_destroy();
	 	?>
	 	<script type="text/javascript">
	 		window.location.href='?logout=success';
	 	</script>
	 	<?php
	 	exit();
	}
	global $wpdb;
	$tdate=date('Y-m-d H:m:s');
	$cn_profiles = $wpdb->prefix . 'cn_profiles';
	$clients = $wpdb->prefix .'cn_clients';
	$cn_files = $wpdb->prefix .'cn_files';
	$properties = $wpdb->prefix .'cn_properties';
	$system_ci_sessions = $wpdb->prefix .'cn_system_ci_sessions';
	$cn_users = $wpdb->prefix .'cn_system_users';
	$system_users = $wpdb->prefix .'cn_system_users';
	$transactions = $wpdb->prefix .'cn_transactions';
	$recode_for='agent-transactions';
	$query = new Cn_Query();
	$current_user_id=sanitize_text_field( $_SESSION['cn_login_user_id'] );
	$get_current_user_id=sanitize_text_field( $_SESSION['cn_login_user_id'] );
	$users_log = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_system_users` WHERE `uid` = %d", $current_user_id);
	$users_details=$query->iFetch($users_log);
	$workstation_name=get_option('workstation_name');
	if ($workstation_name) {
		$workstation_name;
	}else{
		$workstation_name=get_option('blogname');
	}

?>

<!DOCTYPE html>
<html lang="en" style="margin-top: 0px !important;">

<head>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title> Realty Workstation</title>

<!-- Bootstrap Core CSS -->

<!-- Custom Fonts -->

<!-- FormValidation CSS file -->

<script type="text/javascript">
	<?php $cn_plugin_vars=json_encode(array('ajaxurl' => admin_url('admin-ajax.php'),'plugin_url'=>workstation_URI));
		_e('cn_plugin_vars='.$cn_plugin_vars);
	 ?>
	
</script>
<!-- jQuery -->
<?php wp_head(); ?>
</head>

<body>
	<?php
	
	if ($_SESSION['cn_login_user_id']) {
		?>
		<header class="navbar sticky-top flex-md-nowrap p-0 shadow">
			<a class="navbar-brand col-md-2 me-0 fs-3 px-3" href="<?php _e(site_url('workstation')); ?>"> <?php _e($workstation_name); ?></a>
			<div class="my-class">
				<a class="nav-link" style="display: inline;" aria-current="page" href="?transactions=change_password">
					<i class="fa fa-lock"></i> &nbsp;Change Password
				</a>
				<a class="nav-link" style="display: inline;" aria-current="page" href="?transactions=logout">
					<i class="fa fa-sign-out"></i> Logout
				</a>
			</div>
			<button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		</header>
		<div class="container-fluid">
  			<div class="row">
				<nav id="sidebarMenu" class="col-md-2 d-md-block bg-light sidebar collapse">
					<div class="position-sticky p-3 pt-5">
						<ul class="nav nav-pills flex-column mb-auto">
							<?php if ($current_user_id == 1) { ?>
								<li class="nav-item">
									<a class="nav-link first-level-anchor <?php _e(($_GET['agents'] && ($_GET['agents'] == 'new_agent' || $_GET['agents'] == 'all_agents')) ? 'active' : ''); ?>" aria-current="page" href="javascript:void(0);">
										<i class="fa fa-table fa-fw"></i> Agents
									</a>
									<ul class="ps-3">
										<li class="nav-item second-level">
											<a class="nav-link <?php _e(($_GET['agents'] && $_GET['agents'] == 'new_agent') ? 'active' : ''); ?>" aria-current="page" href="?agents=new_agent">
												<i class="fa fa-plus"></i> New Agent
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php _e(($_GET['agents'] && $_GET['agents'] == 'all_agents') ? 'active' : ''); ?>" aria-current="page" href="?agents=all_agents">
												<i class="fa fa-folder-open-o"></i> All Agents
											</a>
										</li>
									</ul>
								</li>
								<li class="nav-item">
									<a class="nav-link first-level-anchor <?php _e(($_GET['transactions'] && ($_GET['transactions'] == 'new_agent_transaction' || $_GET['transactions'] == 'open_agent_transactions' || $_GET['transactions'] == 'closed_agent_transactions')) ? 'active' : ''); ?>" aria-current="page" href="javascript:void(0);">
										<i class="fa fa-table fa-fw"></i> Agent Transactions
									</a>
									<ul class="ps-3">
										<li class="nav-item second-level">
											<a class="nav-link <?php _e(($_GET['transactions'] && $_GET['transactions'] == 'new_agent_transaction') ? 'active' : ''); ?>" aria-current="page" href="?transactions=new_agent_transaction">
												<i class="fa fa-plus"></i> New Transaction
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php _e(($_GET['transactions'] && $_GET['transactions'] == 'open_agent_transactions') ? 'active' : ''); ?>" aria-current="page" href="?transactions=open_agent_transactions">
												<i class="fa fa-folder-open-o"></i> Open Transactions
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php _e(($_GET['transactions'] && $_GET['transactions'] == 'closed_agent_transactions') ? 'active' : ''); ?>" aria-current="page" href="?transactions=closed_agent_transactions">
												<i class="fa fa-folder-o"></i> Closed Transactions
											</a>
										</li>
									</ul>
								</li>
								<li class="nav-item">
									<a class="nav-link first-level-anchor <?php _e(($_GET['transactions'] && ($_GET['transactions'] == 'new_transaction' || $_GET['transactions'] == 'open_transactions' || $_GET['transactions'] == 'closed_transactions')) ? 'active' : ''); ?>" aria-current="page" href="javascript:void(0);">
										<i class="fa fa-table fa-fw"></i> Broker Transactions
									</a>
									<ul class="ps-3">
										<li class="nav-item second-level">
											<a class="nav-link <?php _e(($_GET['transactions'] && ($_GET['transactions'] == 'new_transaction')) ? 'active' : ''); ?>" aria-current="page" href="?transactions=new_transaction">
												<i class="fa fa-plus"></i> New Transaction
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php _e(($_GET['transactions'] && $_GET['transactions'] == 'open_transactions') ? 'active' : ''); ?>" aria-current="page" href="?transactions=open_transactions">
												<i class="fa fa-folder-open-o"></i> Open Transactions
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php _e(($_GET['transactions'] && $_GET['transactions'] == 'closed_transactions') ? 'active' : ''); ?>" aria-current="page" href="?transactions=closed_transactions">
												<i class="fa fa-folder-o"></i> Closed Transactions
											</a>
										</li>
									</ul>
								</li>
							<?php } else { ?>
								<li class="nav-item">
									<a class="nav-link first-level-anchor <?php _e(($_GET['transactions'] && ($_GET['transactions'] == 'new_transaction' || $_GET['transactions'] == 'open_transactions' || $_GET['transactions'] == 'closed_transactions')) ? 'active' : ''); ?>" aria-current="page" href="javascript:void(0);">
										<i class="fa fa-table fa-fw"></i> My Transactions
									</a>
									<ul class="ps-3">
										<li class="nav-item second-level">
											<a class="nav-link <?php _e(($_GET['transactions'] && ($_GET['transactions'] == 'new_transaction')) ? 'active' : ''); ?>" aria-current="page" href="?transactions=new_transaction">
												<i class="fa fa-plus"></i> New Transaction
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php _e(($_GET['transactions'] && ($_GET['transactions'] == 'open_transactions')) ? 'active' : ''); ?>" aria-current="page" href="?transactions=open_transactions">
												<i class="fa fa-folder-open-o"></i> Open Transactions
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php _e(($_GET['transactions'] && ($_GET['transactions'] == 'closed_transactions')) ? 'active' : ''); ?>" aria-current="page" href="?transactions=closed_transactions">
												<i class="fa fa-folder-o"></i> Closed Transactions
											</a>
										</li>
									</ul>
								</li>
							<?php } ?>
						</ul>
						<!-- <ul class="nav bottom-navbar">
							<li class="nav-item">
								<a class="nav-link" aria-current="page" href="?transactions=change_password">
									<i class="fa fa-lock"></i> &nbsp;Change Password
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" aria-current="page" href="?transactions=logout">
									<i class="fa fa-sign-out"></i> Logout
								</a>
							</li>
						</ul> -->
					</div>
				</nav>
				<main class="col-md-10 ms-sm-auto px-md-4">
					<div class="pt-3 pb-2 mb-3 border-bottom">
						<div class="row mb-3">
							<div class="col-12">
								<?php if (!$_GET['transactions']): ?>
									<!-- <h3>Dashboard</h3>	 -->
								<?php endif ?>
								<?php if ($_GET['agents']=='all_agents'){ ?>
									<?php if (isset($_GET['user_id'])){ ?>
										<h3>Edit Agent</h3>	
									<?php } else { ?>
										<h3>All Agents</h3>	
									<?php } ?>
								<?php } ?>
								<?php if ($_GET['agents']=='new_agent'): ?>
									<h3>New Agent</h3>	
								<?php endif ?>
								<?php if ($_GET['transactions']=='open_transactions'): ?>
									<h3>Open Transactions</h3>	
								<?php endif ?>
								<?php if ($_GET['transactions']=='open_agent_transactions' && isset($_GET['trans_edit']) && !empty($_GET['trans_edit'])) { ?>
									<?php
										$trans_edit=sanitize_text_field( $_GET['trans_edit']);
										global $wpdb;
										$my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` JOIN `".$wpdb->prefix."cn_system_users` ON `".$wpdb->prefix."cn_system_users`.`uid` = `".$wpdb->prefix."cn_transactions`.`uid` WHERE `".$wpdb->prefix."cn_transactions`.`id` = %d", $trans_edit);
										$transactions_details=$query->iFetch($my);
										if ($transactions_details['type'] == 'sale') {
											$transactions_details['type'] = 'Sale';
										}
										if ($transactions_details['type'] == 'purchase') {
											$transactions_details['type'] = 'Purchase';
										}
										if ($transactions_details['type'] == 'lease-tenant') {
											$transactions_details['type'] = 'Lease - Tenant';
										}
										if ($transactions_details['type'] == 'lease-landlord') {
											$transactions_details['type'] = 'Lease - Landlord';
										}
									?>
									<h3>Open Transactions: <?php _e($transactions_details['type'] . ' - ' . $transactions_details['first_name'] . ' ' . $transactions_details['last_name']); ?></h3>	
								<?php } else if ($_GET['transactions']=='open_agent_transactions') { ?>
									<h3>Open Transactions</h3>	
								<?php } ?>
								<?php if ($_GET['transactions']=='closed_transactions'): ?>
									<h3>Closed Transactions</h3>	
								<?php endif ?>
								<?php if ($_GET['transactions']=='closed_agent_transactions'): ?>
									<?php if ($_GET['trans_edit']) { ?>
										<?php
										$trans_edit=sanitize_text_field( $_GET['trans_edit']);
										global $wpdb;
										$my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` JOIN `".$wpdb->prefix."cn_system_users` ON `".$wpdb->prefix."cn_system_users`.`uid` = `".$wpdb->prefix."cn_transactions`.`uid` WHERE `".$wpdb->prefix."cn_transactions`.`id` = %d", $trans_edit);
										$transactions_details=$query->iFetch($my);
										if ($transactions_details['type'] == 'sale') {
											$transactions_details['type'] = 'Sale';
										}
										if ($transactions_details['type'] == 'purchase') {
											$transactions_details['type'] = 'Purchase';
										}
										if ($transactions_details['type'] == 'lease-tenant') {
											$transactions_details['type'] = 'Lease - Tenant';
										}
										if ($transactions_details['type'] == 'lease-landlord') {
											$transactions_details['type'] = 'Lease - Landlord';
										}
									?>
									<h3>Closed Transactions: <?php _e($transactions_details['type'] . ' - ' . $transactions_details['first_name'] . ' ' . $transactions_details['last_name']); ?></h3>
									<?php } else { ?>
										<h3>Closed Transactions</h3>
									<?php } ?>
								<?php endif ?>
								<?php if ($_GET['transactions']=='new_transaction'): ?>
									<h3>New Transaction</h3>	
								<?php endif ?>
								<?php if ($_GET['transactions']=='new_agent_transaction'): ?>
									<h3>New Transaction</h3>	
								<?php endif ?>
								<?php if ($_GET['transactions']=='change_password'): ?>
									<h3>Change Password</h3>	
								<?php endif ?>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
							<?php 
							$dashboard = true;
							if (array_key_exists('agents', $_GET) || array_key_exists('transactions', $_GET)) {
								$dashboard = false;
							}
						
						if ( $dashboard ) {
							require_once workstation_DIR . 'public/partials/dashboard.php';
						}
						if ($_GET['agents']=='all_agents'){
							if (isset($_GET['user_id'])) {
								require_once workstation_DIR . 'public/partials/edit_agent.php';
							} else {
								require_once workstation_DIR . 'public/partials/all_agents.php';
							}
			        	}
						if ($_GET['agents']=='new_agent'){
							require_once workstation_DIR . 'public/partials/new_agent.php';
			        	}
				    	if ($_GET['transactions']=='new_transaction'){
							require_once workstation_DIR . 'public/partials/new_transaction.php';
			        	}
						if ($_GET['transactions']=='new_agent_transaction'){
							require_once workstation_DIR . 'public/partials/new_agent_transaction.php';
			        	}
				    	if ($_GET['transactions']=='open_transactions'){
				    		$recode_for='transactions=closed_transactions';
							$trans_edit=sanitize_text_field( $_GET['trans_edit']);
				    		if ($trans_edit) {
								require_once workstation_DIR . 'public/partials/transactions_edit.php';	
							}else{
								require_once workstation_DIR . 'public/partials/open_transactions.php';
							}
			        	}
						if ($_GET['transactions']=='open_agent_transactions'){
				    		$recode_for='transactions=closed_transactions';
				    		$trans_edit=sanitize_text_field( $_GET['trans_edit']);
				    		if ($trans_edit) {
								require_once workstation_DIR . 'public/partials/transactions_edit.php';	
							}else{
								require_once workstation_DIR . 'public/partials/open_agent_transactions.php';
							}
			        	}
			        	if ($_GET['transactions']=='closed_transactions'){
			        	 	$recode_for='transactions=closed_transactions';
							 $trans_edit=sanitize_text_field( $_GET['trans_edit']);
							 if ($trans_edit) {
								require_once workstation_DIR . 'public/partials/transactions_edit.php';	
							}else{
								require_once workstation_DIR . 'public/partials/closed_transactions.php';
							}
			        	 }
						 if ($_GET['transactions']=='closed_agent_transactions'){
							$recode_for='transactions=closed_agent_transactions';
				    		$trans_edit=sanitize_text_field( $_GET['trans_edit']);
				    		if ($trans_edit) {
								require_once workstation_DIR . 'public/partials/transactions_edit.php';	
							}else{
								require_once workstation_DIR . 'public/partials/closed_agent_transactions.php';
							}
						}
			        	 if ($_GET['transactions']=='change_password'){
							require_once workstation_DIR . 'public/partials/change_password.php';
			        	 }
			        	 ?>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>
		<?php
 	
 	}else{
 		require_once workstation_DIR . 'public/partials/login.php';
	 
 	}?>




<script>
    // $(document).ready(function() {
       
    //     $(".rpwd_bt").click(function(){            
        
    //         var result=confirm('Are you sure you want to change the password to \'123456\' ?');
    //         console.log("===> result: %o",result);
    //         if(result){               
            
    //             var user_id=$(this).data('id');
    //             console.log("===> user_id: %o",user_id); 
    //             $.ajax({
    //                 url:"http://wppluginhub.com/workstation/admin/rest_pwd/",
    //                 method:'POST',
    //                 data: {
    //                     csrf_test_name : 'ffecad256fe411d2066caf7e4eeac55d',
    //                     user_id:user_id,
    //                 },
    //                 success:function(){
    //                     console.log("The password was changed successfully");
    //                 }
    //             });

    //         }
    //     });

    // });
</script>
<?php wp_footer(); ?>
</body>

</html>