<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.realtyworkstation.com/
 * @since      1.0.0
 *
 * @package    Workstation
 * @subpackage Workstation/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Workstation
 * @subpackage Workstation/admin
 * @author     Realty Workstation <info@realtyworkstation.com>
 */
class Workstation_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
			$query = new Cn_Query();
		$this->query=$query;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'uploader.css', plugin_dir_url( __FILE__ ) . 'css/uploader.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/workstation-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'dataTables.css', plugin_dir_url( __FILE__ ) . 'css/jquery.dataTables.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'cn-custom.css', plugin_dir_url( __FILE__ ) . '../cn_package/css/cn-custom.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'cn-grid', plugin_dir_url( __FILE__ ) . '../cn_package/css/cn-grid.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'sweet-alert.css', plugin_dir_url( __FILE__ ) . '../cn_package/node_modules/sweetalert/sweetalert/lib/sweet-alert.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'awesome', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', array(), $this->version, 'all' );
		

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if ( ! did_action( 'wp_enqueue_media' ) ) {
			wp_enqueue_media();
		}
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/workstation-admin.js', array( 'jquery' ), '05042022', false );
		wp_enqueue_script('cn-dataTables.js', plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('cn-maskmoney.js', plugin_dir_url( __FILE__ ) . 'js/jquery.maskMoney.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('cn-custom.js', plugin_dir_url( __FILE__ ) . '../cn_package/js/cn-custom.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'sweetalert2.all.min.js', plugin_dir_url( __FILE__ ) . '../cn_package/node_modules/sweetalert/sweetalert/lib/sweet-alert.min.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( 'cn-custom.js','cn_plugin_vars', array('ajaxurl' => admin_url('admin-ajax.php'),'plugin_url'=>workstation_URI));
	}
	public function workstation_plugin_menu(){

		add_menu_page('Realty Workstation', 'Realty Workstation', 'manage_options', 'workstation',  array($this, 'workstation'), workstation_URI .'admin/icons/icon.png',5);
		add_submenu_page('workstation', 'Agents', 'Agents', 'manage_options', 'workstation',  array($this, 'workstation'));
		add_submenu_page('workstation', 'Agent Transactions ', ' Agent Transactions', 'manage_options', 'agent-transactions',  array($this, 'agent_transactions'));
		add_submenu_page('workstation', 'Broker Transactions ', 'Broker Transactions', 'manage_options', 'my-transactions',  array($this, 'my_transactions'));
		add_submenu_page('workstation', 'Leads ', 'Leads', 'manage_options', 'upgrade-to-pro-leads',  array($this, 'upgrade_to_pro_leads'));
		add_submenu_page('workstation', 'Contracts ', 'Contracts', 'manage_options', 'upgrade-to-pro-contracts',  array($this, 'upgrade_to_pro_contracts'));
		add_submenu_page('workstation', 'Backup and Restore ', 'Backup and Restore', 'manage_options', 'upgrade-to-pro',  array($this, 'upgrade_to_pro'));
		add_submenu_page('workstation', 'Settings', 'Settings', 'manage_options', 'workstation-settings',  array($this, 'cn_settings'));
	}
	
	public function workstation_sanitize_array( $input ) {
		// Initialize the new array that will hold the sanitize values
		$new_input = array();
		// Loop through the input and sanitize each of the values
		foreach ( $input as $key => $val ) {
			$new_input[ $key ] = sanitize_text_field( $val );
		}
		return $new_input;
	}

	public function deleteAll($dir, $remove = false) {
		$structure = glob(rtrim($dir, "/").'/*');
		if (is_array($structure)) {
			foreach($structure as $file) {
				if (is_dir($file))
					$this->deleteAll($file,true);
				else if(is_file($file))
					unlink($file);
			}
		}
		if($remove)
			rmdir($dir);
	}
	public function cn_settings(){
		global $wpdb;
		$tdate=date('Y-m-d H:m:s');
		if (isset($_POST['save_general_settings_info'])) {
			update_option('cn_workstation', sanitize_text_field($_POST['cn_workstation']));
			if ($_POST['agent_page']) {
				$page_id= sanitize_text_field($_POST['agent_page']);
				$agent_page=get_option('agent_page');
				if ($agent_page) {
					update_post_meta($agent_page, '_wp_page_template', '');	
				}
				update_post_meta($page_id, '_wp_page_template', 'agent_page.php');
				update_option('agent_page', $page_id);
			}
			update_option('workstation_name', sanitize_text_field($_POST['workstation_name']));
			update_option('workstation_masteruser_email', sanitize_email($_POST['masteruser_email']));
			update_option('workstation_masteruser_password', sanitize_text_field($_POST['masteruser_password']));
			update_option('cdbi_bank_name', sanitize_text_field($_POST['cdbi_bank_name']));
			update_option('cdbi_account_name', sanitize_text_field($_POST['cdbi_account_name']));
			update_option('cdbi_account_number', sanitize_text_field($_POST['cdbi_account_number']));
			update_option('cdbi_account_address', sanitize_text_field($_POST['cdbi_account_address']));
			?>
					<script type="text/javascript">
						jQuery(document).ready(function(){
							swal({
								type: 'success',
								title: 'updated successfully',
								text: '',
								showConfirmButton: false,
								timer: 1600
							});
						});
					</script>
			<?php
		}
		if (isset($_POST['save_settings_info'])) {
				update_option('cn_workstation', sanitize_text_field($_POST['cn_workstation']));
				if ($_POST['agent_page']) {
					$page_id= sanitize_text_field($_POST['agent_page']);
					$agent_page=get_option('agent_page');
					if ($agent_page) {
						update_post_meta($agent_page, '_wp_page_template', '');	
					}
					update_post_meta($page_id, '_wp_page_template', 'agent_page.php');
					update_option('agent_page', $page_id);
				}
				update_option('workstation_name', sanitize_text_field($_POST['workstation_name']));
				

				?>
					<script type="text/javascript">
						jQuery(document).ready(function(){
							swal({
								type: 'success',
								title: 'updated successfully',
								text: '',
								showConfirmButton: false,
								timer: 1600
							});
						});
					</script>
			<?php
		}
		if (isset($_POST['save_master_user_settings_info'])) {
			update_option('workstation_masteruser_email', sanitize_email($_POST['masteruser_email']));
			update_option('workstation_masteruser_password', sanitize_text_field($_POST['masteruser_password']));
			?>
					<script type="text/javascript">
						jQuery(document).ready(function(){
							swal({
								type: 'success',
								title: 'updated successfully',
								text: '',
								showConfirmButton: false,
								timer: 1600
							});
						});
					</script>
			<?php
		}
		if (isset($_POST['save_cdbi_settings_info'])) {
			update_option('cdbi_bank_name', sanitize_text_field($_POST['cdbi_bank_name']));
			update_option('cdbi_account_name', sanitize_text_field($_POST['cdbi_account_name']));
			update_option('cdbi_account_number', sanitize_text_field($_POST['cdbi_account_number']));
			update_option('cdbi_account_address', sanitize_text_field($_POST['cdbi_account_address']));
			?>
					<script type="text/javascript">
						jQuery(document).ready(function(){
							swal({
								type: 'success',
								title: 'updated successfully',
								text: '',
								showConfirmButton: false,
								timer: 1600
							});
						});
					</script>
			<?php
		}
		$agent_page=get_option('agent_page');
		$workstation_name=get_option('workstation_name');
		$masteruser_email=get_option('workstation_masteruser_email');
		$masteruser_password=get_option('workstation_masteruser_password');
		$cdbi_bank_name=get_option('cdbi_bank_name');
		$cdbi_account_name=get_option('cdbi_account_name');
		$cdbi_account_number=get_option('cdbi_account_number');
		$cdbi_account_address=get_option('cdbi_account_address');
		require_once workstation_DIR . 'admin/partials/setting.php';		
	}

	public function workstation(){
		global $wpdb;
		$tdate=date('Y-m-d H:m:s');
		$cn_profiles = $wpdb->prefix . 'cn_profiles';
		$clients = $wpdb->prefix .'cn_clients';
		$files = $wpdb->prefix .'cn_files';
		$properties = $wpdb->prefix .'cn_properties';
		$system_ci_sessions = $wpdb->prefix .'cn_system_ci_sessions';
		$cn_users = $wpdb->prefix .'cn_system_users';
		$transactions = $wpdb->prefix .'cn_transactions';

		if (isset($_POST['btn_add_users'])) {
			$password=sanitize_text_field($_POST['password']);
			// $salt = '$2a$15$' . md5(openssl_random_pseudo_bytes(16)) . '$';
	        // $_POST['password'] = crypt($password, $salt);
	        $_POST['password']=md5($password);
			$result_data=array('first_name'=>sanitize_text_field($_POST['first_name']),'last_name'=>sanitize_text_field($_POST['last_name']),'email'=>sanitize_email($_POST['email']),'password'=>sanitize_text_field($_POST['password']),'date_created'=>$tdate,'status'=>'active','admin'=>0,'commission'=>$_POST['commission'],'lease'=>$_POST['lease'],'sale'=>$_POST['sale']);
			$response=$this->query->iInsert($cn_users,$result_data);
			$response=json_decode($response);
			if ($response->success=='success') {
				_e($this->query->showMessage($response->success,$response->msg));
			}else{
				_e($this->query->showMessage($response->success,$response->msg,$response->error,true,''));
			}
		}
		if (isset($_POST['btn_update_users'])) {
			foreach ($_POST as $value) {
				$value=json_decode(json_encode($value));
				if ($value->first_name) {
					$result_data = '';
					if (isset($_POST['password']) && !empty($_POST['password'])) {
						$_POST['password']=md5($_POST['password']);
						$result_data=array('first_name'=>$value->first_name,'last_name'=>$value->last_name, 'email'=>$value->email, 'password'=>$_POST['password'],'commission'=>$value->commission,'lease'=>$value->lease,'sale'=>$value->sale);
					} else {
						$result_data=array('first_name'=>$value->first_name,'last_name'=>$value->last_name, 'email'=>$value->email,'commission'=>$value->commission,'lease'=>$value->lease,'sale'=>$value->sale);
					}
					$users_id=$value->uid;
					$response=$this->query->iUpdateArray($cn_users,$result_data,array('`uid`'=>$users_id));	
					$response=json_decode($response);
					if ($response->success=='success') {
						_e($this->query->showMessage($response->success,$response->msg));
					}else{
						_e($this->query->showMessage($response->success,$response->msg,$response->error,true,''));
					}
				}
			}
		}
		if (isset($_GET['cn_pageno'])) {
			$cn_pageno = sanitize_text_field( $_GET['cn_pageno'] );
		} else {
			$cn_pageno = 1;
		}

		$no_of_records_per_page = 10;
		$offset = ($cn_pageno-1) * $no_of_records_per_page;
		global $wpdb;
		$users=$wpdb->prepare("select * from `".$wpdb->prefix."cn_system_users` WHERE `status`='active' ORDER BY `uid` ASC");
		$users_details=$this->query->iWhileFetch($users);
		$users_count=count($users_details);
		$total_pages = ceil($users_count / $no_of_records_per_page);
		global $wpdb;
		$users=$wpdb->prepare("select * from `".$wpdb->prefix."cn_system_users` WHERE `status`='active' ORDER BY `uid` ASC LIMIT %d, %d ", $offset, $no_of_records_per_page);
		$users_details=$this->query->iWhileFetch($users);
		$users_count=count($users_details);
		require_once workstation_DIR . 'admin/partials/workstation-admin-display.php';	
	}

	public function workstation_users(){
		global $wpdb;
		$tdate=date('Y-m-d H:m:s');
		$cn_profiles = $wpdb->prefix . 'cn_profiles';
		$clients = $wpdb->prefix .'cn_clients';
		$files = $wpdb->prefix .'cn_files';
		$properties = $wpdb->prefix .'cn_properties';
		$system_ci_sessions = $wpdb->prefix .'cn_system_ci_sessions';
		$cn_users = $wpdb->prefix .'cn_system_users';
		$transactions = $wpdb->prefix .'cn_transactions';
		require_once workstation_DIR . 'admin/partials/workstation_users.php';	
	}

	// my_transactions//
		public function my_transactions(){
			global $wpdb;
			$tdate=date('Y-m-d H:m:s');
			$cn_profiles = $wpdb->prefix . 'cn_profiles';
			$clients = $wpdb->prefix .'cn_clients';
			$cn_files = $wpdb->prefix .'cn_files';
			$properties = $wpdb->prefix .'cn_properties';
			$system_ci_sessions = $wpdb->prefix .'cn_system_ci_sessions';
			//$cn_users = $wpdb->prefix .'cn_system_users';
			$cn_users = $wpdb->prefix .'users';
			$transactions = $wpdb->prefix .'cn_transactions';
			$recode_for='my-transactions';
			$get_current_user_id=get_current_user_id();
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
				$clientData=$this->workstation_sanitize_array($_POST['client']);
				$clientData['client_lastName'] = '';//$this->input->post('client_lastName');
				$clientData['date_created'] = date("Y-m-d H:i:s");
				$response=$this->query->iInsert($clients, $clientData);
				$response=json_decode($response);
				$clientId = $response->insert_id;

				$propertyData = array();
				$propertyData=$this->workstation_sanitize_array($_POST['property']);
		        $propertyData['property_no'] = '';//$this->input->post('property_no');
		        $propertyData['date_created'] = date("Y-m-d H:i:s");
				$response=$this->query->iInsert($properties, $propertyData);
				$response=json_decode($response);
				$propertyId = $response->insert_id;

		        $transactionData = array();
		        $transactionData['uid'] = $get_current_user_id;
		        $transactionData['status'] = 'open';
		        $transactionData['type'] = sanitize_text_field($_POST['transaction']['transactionType']);
		        $transactionData['property_id'] = $propertyId;
		        $transactionData['client_id'] = $clientId;
		        $transactionData['date_created'] = date("Y-m-d H:i:s");

				$response=$this->query->iInsert($transactions, $transactionData);
				$response=json_decode($response);
				if ($response->success=='success') {
					_e($this->query->showMessage($response->success,$response->msg));
				}else{
					_e($this->query->showMessage($response->success,$response->msg,$response->error,true,''));
				}
			}
			if (isset($_POST['btn_update_transactions'])) {
				$clientData = array();
				$clientData=$this->workstation_sanitize_array($_POST['client']);
				$clientData['date_created'] = date("Y-m-d H:i:s");
				$client_cid=sanitize_text_field($_POST['cid']);
				$response=$this->query->iUpdateArray($clients,$clientData,array('`cid`'=>$client_cid));	

				$propertyData = array();
				$propertyData=$this->workstation_sanitize_array($_POST['property']);
		        $propertyData['property_no'] = '';//$this->input->post('property_no');
		        $propertyData['date_created'] = date("Y-m-d H:i:s");
		        $property_pid=sanitize_text_field($_POST['pid']);
				$response=$this->query->iUpdateArray($properties,$propertyData,array('`pid`'=>$property_pid));	

		        $transactionData = array();
		        $transactionData['uid'] = $get_current_user_id;
		        $transactionData['sale_price'] = str_replace(',','',sanitize_text_field($_POST['sale_price']));
	    		$transactionData['total_commision'] = str_replace(',','',sanitize_text_field($_POST['total_commision']));
	    		$transactionData['transaction_commission'] = sanitize_text_field($_POST['transaction_commission']);
	    		$transactionData['rental_price'] = str_replace(',','', sanitize_text_field(sanitize_text_field($_POST['rental_price'])));
	    		$transactionData['total_commision_rental'] = str_replace(',','', sanitize_text_field(sanitize_text_field($_POST['total_commision_rental'])));
	    		$transactionData['broker_referral'] = sanitize_text_field(sanitize_text_field($_POST['broker_referral']));
	    		$transactionData['date_edited'] = date("Y-m-d H:i:s");
	    		$transactionData['edited_by'] = $get_current_user_id;
				
				$transactions_id=sanitize_text_field($_POST['tid']);
				
				$response=$this->query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));	
				$response=json_decode($response);
				if ($response->success=='success') {
					$this->saveFiles($_FILES, $get_current_user_id, $transactions_id);
					_e($this->query->showMessage($response->success,$response->msg));
				}else{
					_e($this->query->showMessage($response->success,$response->msg,$response->error,true,''));
				}
			}
			if ($_GET['transactions']=='closed') {
				$actv='closed';
				$cn_transactions_text='Closed Transactions';

				if (isset($_GET['cn_pageno'])) {
					$cn_pageno = sanitize_text_field( $_GET['cn_pageno'] );
				} else {
					$cn_pageno = 1;
				}
		
				$no_of_records_per_page = 10;
				$offset = ($cn_pageno-1) * $no_of_records_per_page; 
				global $wpdb;
				$my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` WHERE `uid` = %d AND `status` != 'open' AND `status` != 'deleted' ORDER BY `date_completed` DESC, `date_cancelled` DESC, `".$wpdb->prefix."cn_transactions`.`date_created` DESC", $get_current_user_id);
				$my_details=$this->query->iWhileFetch($my);
				$my_count=count($my_details);
				$total_pages = ceil($my_count / $no_of_records_per_page);
				global $wpdb;
				$my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` WHERE `uid` = %d AND `status` != 'open' AND `status` != 'deleted' ORDER BY `date_completed` DESC, `date_cancelled` DESC, `".$wpdb->prefix."cn_transactions`.`date_created` DESC LIMIT %d, %d", $get_current_user_id, $offset, $no_of_records_per_page);
				$my_details=$this->query->iWhileFetch($my);
				$my_count=count($my_details);

			}else{
				$cn_transactions_text='Open Transactions';
				$actv='open';

				if (isset($_GET['cn_pageno'])) {
					$cn_pageno = sanitize_text_field( $_GET['cn_pageno'] );
				} else {
					$cn_pageno = 1;
				}
		
				$no_of_records_per_page = 10;
				$offset = ($cn_pageno-1) * $no_of_records_per_page; 
				global $wpdb;
				$my=$wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` WHERE `uid` = %d AND `status` = 'open' AND `status` != 'deleted' ORDER BY `".$wpdb->prefix."cn_transactions`.`date_created` DESC", $get_current_user_id);
				$my_details=$this->query->iWhileFetch($my);
				$my_count=count($my_details);
				$total_pages = ceil($my_count / $no_of_records_per_page);
				global $wpdb;
				$my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` WHERE `uid` = %d AND `status` = 'open' AND `status` != 'deleted' ORDER BY `".$wpdb->prefix."cn_transactions`.`date_created` DESC LIMIT %d, %d", $get_current_user_id, $offset, $no_of_records_per_page);
				$my_details=$this->query->iWhileFetch($my);
				$my_count=count($my_details);
			}

			
			
			if ($_GET['trans_edit']) {
				$trans_edit=sanitize_text_field( $_GET['trans_edit'] );
				global $wpdb;
				$my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` JOIN `".$wpdb->prefix."users` ON `".$wpdb->prefix."users`.`ID` = `".$wpdb->prefix."cn_transactions`.`uid` WHERE `".$wpdb->prefix."cn_transactions`.`uid` = %d AND `".$wpdb->prefix."cn_transactions`.`id` = %d", $get_current_user_id, $trans_edit);
				$transactions_details=$this->query->iFetch($my);

				$tr_files=$wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_files` WHERE `associated_record` = %d AND status='active'", $trans_edit);
				$cn_files_details=$this->query->iWhileFetch($tr_files);
				require_once workstation_DIR . 'admin/partials/my_transactions_edit.php';	
			}else{
				require_once workstation_DIR . 'admin/partials/my_transactions.php';	
			}
		}

		public function upgrade_to_pro() {
			require_once workstation_DIR . 'admin/partials/upgrade-to-pro.php';	
		}

		public function upgrade_to_pro_leads() {
			require_once workstation_DIR . 'admin/partials/upgrade-to-pro-leads.php';	
		}

		public function upgrade_to_pro_contracts() {
			require_once workstation_DIR . 'admin/partials/upgrade-to-pro-contracts.php';	
		}

		public function getFileList($associated_recordId)
	    {
	    	global $wpdb;
			$tdate=date('Y-m-d H:m:s');
			$cn_profiles = $wpdb->prefix . 'cn_profiles';
			$clients = $wpdb->prefix .'cn_clients';
			$cn_files = $wpdb->prefix .'cn_files';
			$properties = $wpdb->prefix .'cn_properties';
			$system_ci_sessions = $wpdb->prefix .'cn_system_ci_sessions';
			$cn_users = $wpdb->prefix .'cn_system_users';
			$transactions = $wpdb->prefix .'cn_transactions';

	        $files = $this->db->where('associated_record', $associated_recordId)->where('status', 'active')->get('files');
	        return $files->result();
	    }

		public function saveFiles($file_array, $uid, $associated_record)
	    {
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
	               $sortedArray = $this->rearrangeFileArray($file_array[$document_type]);

	                foreach ($sortedArray as $sortedFile) {
	                    if ($sortedFile['error'] == 0) {
	                        $fileId = $this->saveFile($sortedFile, $uid, 'document', $associated_record, $document_type);
	                    }
	                }
	            }
	        }
	    }
	    public function saveFile($uploadedFile, $uid, $content_type, $associated_record = null, $document_type = null)
	    {
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

	        if(!$this->_acceptedFileType($extension, $content_type)){
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

	            $response=$this->query->iInsert($cn_files, $fileInsertData);
	            $response=json_decode($response);
				return  $response->insert_id;
	        }

	        return false;
	    }
	    private function _acceptedFileType($extention, $content_type)
	    {
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
	    public function rearrangeFileArray( $arr ){
	        foreach( $arr as $key => $all ){
	            foreach( $all as $i => $val ){
	                $new[$i][$key] = $val;
	            }
	        }
	        return $new;
	    }
	    public function cancel($tid,$recode_for)
	    {
	        global $wpdb;
			$tdate=date('Y-m-d H:m:s');
			$transactions = $wpdb->prefix .'cn_transactions';

            $transactionData['status']='cancelled';
            $transactionData['date_cancelled']=$tdate;
	        $transactions_id=$tid;
				
			$response=$this->query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));	
			_e($this->query->showMessage($response->success,'Transaction Cancelled Successfully'));
	        ?>
	        <script type="text/javascript">
	        	setTimeout(function(){ 
	        		window.location.href='?page=<?php _e($recode_for); ?>&transactions=closed';
	        	 }, 2000);
	        	
	        </script>
	        <?php
	    }

	    public function close($tid,$recode_for)
	    {
	    	global $wpdb;
			$tdate=date('Y-m-d H:m:s');
			$transactions = $wpdb->prefix .'cn_transactions';
			$transactionData['status']='closed';
			$transactionData['date_completed']=$tdate;
			$transactions_id=$tid;
			$response=$this->query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));	
			_e($this->query->showMessage($response->success,'Transaction Closed Successfully'));
	        ?>
	        <script type="text/javascript">
	        	setTimeout(function(){ 
	        		window.location.href='?page=<?php _e($recode_for); ?>&transactions=closed';
	        	 }, 2000);
	        	
	        </script>
	        <?php
	    }

    // my_transactions //

	// agent_transactions //	    
		public function agent_transactions(){
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

			$get_current_user_id=0;get_current_user_id();
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

			
			if (isset($_POST['btn_add_agent_transactions'])) {
						
				$clientData = array();
				$clientData=$this->workstation_sanitize_array($_POST['client']);
				$clientData['client_lastName'] = '';//$this->input->post('client_lastName');
				$clientData['date_created'] = date("Y-m-d H:i:s");
				$response=$this->query->iInsert($clients, $clientData);
				$response=json_decode($response);
				$clientId = $response->insert_id;

				$propertyData = array();
				$propertyData=$this->workstation_sanitize_array($_POST['property']);
		        $propertyData['property_no'] = '';//$this->input->post('property_no');
		        $propertyData['date_created'] = date("Y-m-d H:i:s");
				$response=$this->query->iInsert($properties, $propertyData);
				$response=json_decode($response);
				$propertyId = $response->insert_id;

		        $transactionData = array();
		        $transactionData['uid'] = sanitize_text_field($_POST['transaction']['agent']);
		        $transactionData['status'] = 'open';
		        $transactionData['type'] = sanitize_text_field($_POST['transaction']['transactionType']);
		        $transactionData['property_id'] = $propertyId;
		        $transactionData['client_id'] = $clientId;
		        $transactionData['date_created'] = date("Y-m-d H:i:s");

				$response=$this->query->iInsert($transactions, $transactionData);
				$response=json_decode($response);
				if ($response->success=='success') {
					_e($this->query->showMessage($response->success,$response->msg));
				}else{
					_e($this->query->showMessage($response->success,$response->msg,$response->error,true,''));
				}
			}

			if (isset($_POST['btn_update_transactions'])) {
				$clientData = array();
				$clientData=$this->workstation_sanitize_array($_POST['client']);
				$clientData['date_created'] = date("Y-m-d H:i:s");
				$client_cid=sanitize_text_field($_POST['cid']);
				$response=$this->query->iUpdateArray($clients,$clientData,array('`cid`'=>$client_cid));	

				$propertyData = array();
				$propertyData=$this->workstation_sanitize_array($_POST['property']);
		        $propertyData['property_no'] = '';//$this->input->post('property_no');
		        $propertyData['date_created'] = date("Y-m-d H:i:s");
		        $property_pid=sanitize_text_field($_POST['pid']);
				$response=$this->query->iUpdateArray($properties,$propertyData,array('`pid`'=>$property_pid));	

		        $transactionData = array();
		        // $transactionData['uid'] = $get_current_user_id;
		        $transactionData['sale_price'] = str_replace(',','',sanitize_text_field(['sale_price']));
	    		$transactionData['total_commision'] = str_replace(',','',sanitize_text_field(['total_commision']));
	    		$transactionData['transaction_commission'] = sanitize_text_field(['transaction_commission']);
	    		$transactionData['rental_price'] = str_replace(',','',sanitize_text_field(['rental_price']));
	    		$transactionData['total_commision_rental'] = str_replace(',','',sanitize_text_field(['total_commision_rental']));
	    		$transactionData['broker_referral'] = sanitize_text_field(['broker_referral']);
	    		$transactionData['date_edited'] = date("Y-m-d H:i:s");
	    		$transactionData['edited_by'] = $get_current_user_id;
				
				$transactions_id=sanitize_text_field(['tid']);
				
				$response=$this->query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));	
				$response=json_decode($response);
				if ($response->success=='success') {

					$this->saveFiles($_FILES, $get_current_user_id, $transactions_id);
					_e($this->query->showMessage($response->success,$response->msg));
				}else{
					_e($this->query->showMessage($response->success,$response->msg,$response->error,true,''));
				}
			}

			if ($_GET['transactions']=='closed') {
				$actv='closed';
				$cn_transactions_text='Closed Transactions';

				if (isset($_GET['cn_pageno'])) {
					$cn_pageno = sanitize_text_field( $_GET['cn_pageno'] );
				} else {
					$cn_pageno = 1;
				}
		
				$no_of_records_per_page = 10;
				$offset = ($cn_pageno-1) * $no_of_records_per_page; 
				global $wpdb;
				$agent_transaction = $wpdb->prepare("SELECT `".$wpdb->prefix."cn_transactions`.*, `".$wpdb->prefix."cn_clients`.*, `".$wpdb->prefix."cn_properties`.*, `".$wpdb->prefix."cn_system_users`.`first_name`, `".$wpdb->prefix."cn_system_users`.`last_name` FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` JOIN `".$wpdb->prefix."cn_system_users` ON `".$wpdb->prefix."cn_system_users`.`uid` = `".$wpdb->prefix."cn_transactions`.`uid` WHERE `".$wpdb->prefix."cn_transactions`.`status` != 'open' AND `".$wpdb->prefix."cn_transactions`.`status` != 'deleted' ORDER BY `date_completed` DESC, `date_cancelled` DESC, `".$wpdb->prefix."cn_transactions`.`date_created` DESC");
				$agent_transaction_details=$this->query->iWhileFetch($agent_transaction);
				$agent_transaction_count=count($agent_transaction_details);
				$total_pages = ceil($agent_transaction_count / $no_of_records_per_page);
				$agent_transaction = $wpdb->prepare("SELECT `".$wpdb->prefix."cn_transactions`.*, `".$wpdb->prefix."cn_clients`.*, `".$wpdb->prefix."cn_properties`.*, `".$wpdb->prefix."cn_system_users`.`first_name`, `".$wpdb->prefix."cn_system_users`.`last_name` FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` JOIN `".$wpdb->prefix."cn_system_users` ON `".$wpdb->prefix."cn_system_users`.`uid` = `".$wpdb->prefix."cn_transactions`.`uid` WHERE `".$wpdb->prefix."cn_transactions`.`status` != 'open' AND `".$wpdb->prefix."cn_transactions`.`status` != 'deleted' ORDER BY `date_completed` DESC, `date_cancelled` DESC, `".$wpdb->prefix."cn_transactions`.`date_created` DESC LIMIT %d, %d", $offset, $no_of_records_per_page);
				$agent_transaction_details=$this->query->iWhileFetch($agent_transaction);
				$agent_transaction_count=count($agent_transaction_details);
			}else{
				$cn_transactions_text='Open Transactions';
				$actv='open';

				if (isset($_GET['cn_pageno'])) {
					$cn_pageno = sanitize_text_field( $_GET['cn_pageno'] );
				} else {
					$cn_pageno = 1;
				}
		
				$no_of_records_per_page = 10;
				$offset = ($cn_pageno-1) * $no_of_records_per_page; 
				global $wpdb;
				$agent_transaction = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` JOIN `".$wpdb->prefix."cn_system_users` ON `".$wpdb->prefix."cn_system_users`.`uid` = `".$wpdb->prefix."cn_transactions`.`uid` WHERE `".$wpdb->prefix."cn_transactions`.`status` = 'open' AND `".$wpdb->prefix."cn_transactions`.`status` != 'deleted' ORDER BY `".$wpdb->prefix."cn_transactions`.`date_created` DESC");
				$agent_transaction_details=$this->query->iWhileFetch($agent_transaction);
				$agent_transaction_count=count($agent_transaction_details);
				$total_pages = ceil($agent_transaction_count / $no_of_records_per_page);
				$agent_transaction = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` JOIN `".$wpdb->prefix."cn_system_users` ON `".$wpdb->prefix."cn_system_users`.`uid` = `".$wpdb->prefix."cn_transactions`.`uid` WHERE `".$wpdb->prefix."cn_transactions`.`status` = 'open' AND `".$wpdb->prefix."cn_transactions`.`status` != 'deleted' ORDER BY `".$wpdb->prefix."cn_transactions`.`date_created` DESC LIMIT %d, %d", $offset, $no_of_records_per_page);
				$agent_transaction_details=$this->query->iWhileFetch($agent_transaction);
				$agent_transaction_count=count($agent_transaction_details);

			}
			
			if ($_GET['trans_edit']) {
				$trans_edit=sanitize_text_field( $_GET['trans_edit'] );
				global $wpdb;
				$my = $wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_transactions` JOIN `".$wpdb->prefix."cn_clients` ON `".$wpdb->prefix."cn_transactions`.`client_id` = `".$wpdb->prefix."cn_clients`.`cid` JOIN `".$wpdb->prefix."cn_properties` ON `".$wpdb->prefix."cn_transactions`.`property_id` = `".$wpdb->prefix."cn_properties`.`pid` JOIN `".$wpdb->prefix."cn_system_users` ON `".$wpdb->prefix."cn_system_users`.`uid` = `".$wpdb->prefix."cn_transactions`.`uid` WHERE `".$wpdb->prefix."cn_transactions`.`id` = %d", $trans_edit);
				$transactions_details=$this->query->iFetch($my);
				$tr_files=$wpdb->prepare("SELECT * FROM `".$wpdb->prefix."cn_files` WHERE `associated_record` = %d AND status='active'", $trans_edit);
				$cn_files_details=$this->query->iWhileFetch($tr_files);
				require_once workstation_DIR . 'admin/partials/my_transactions_edit.php';	
			}else{
				require_once workstation_DIR . 'admin/partials/agent_transactions.php';	
			}
		}
	// agent_transactions //

	public function return_bytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) 
		{
			case 'g':
			$val *= 1024;
			case 'm':
			$val *= 1024;
			case 'k':
			$val *= 1024;
		}
		return $val;
	}

	public function workstation_plugin_ajax_handaler(){
		global $wpdb;
		$cn_profiles = $wpdb->prefix . 'cn_profiles';
		$clients = $wpdb->prefix .'cn_clients';
		$cn_files = $wpdb->prefix .'cn_files';
		$properties = $wpdb->prefix .'cn_properties';
		$system_ci_sessions = $wpdb->prefix .'cn_system_ci_sessions';
		$cn_users = $wpdb->prefix .'cn_system_users';
		$transactions = $wpdb->prefix .'cn_transactions';
		
		
    	$tdate=date('Y-m-d H:m:s');
    	$param= sanitize_text_field($_REQUEST['param'])?sanitize_text_field($_REQUEST['param']):"";

    	if ($param=='add_users') {
			$users=$wpdb->prepare("select * from `".$wpdb->prefix."cn_system_users` WHERE `status`='active' ORDER BY `uid`");
			$users_details=$this->query->iWhileFetch($users);
			$users_count=count($users_details);
    		require_once workstation_DIR . 'admin/partials/add_users.php';
    	}elseif ($param=='edit_all_users') {
			if (($_POST['users_ids'])) {
	    		$users_ids=sanitize_text_field($_POST['users_ids']);
				$users_ids = explode(",",$users_ids);
	    		$users="select * from `".$wpdb->prefix."cn_system_users` WHERE `uid` IN (".implode(',', array_fill(0, count($users_ids), '%s')).")";
				$users = call_user_func_array(array($wpdb, 'prepare'), array_merge(array($users), $users_ids));
				$users_details= $this->query->iWhileFetch($users);
				$type=sanitize_text_field($_POST['type']);
				require_once workstation_DIR . 'admin/partials/edit_users.php';
				
			}
		}elseif ($param=='delete_all_users') {
			if (($_POST['users_ids'])) {
	    		$users_ids=sanitize_text_field($_POST['users_ids']);
	    		if ($wpdb->delete( $wpdb->prefix.'cn_system_users', array( 'uid' => $users_ids ) )) 
				{
					$msg="Remove successfully";	
					_e(json_encode(array('msg'=>$msg))) ;
				}else{
					$msg='something was wrong';
					_e(json_encode(array('msg'=>$msg,'users_ids'=>$users_ids))) ;
				}
			}
		}elseif ($param=='edit_all_reset_password_users') {
			if (($_POST['users_ids'])) {
	    		$users_ids=sanitize_text_field($_POST['users_ids']);
	    		// $salt = '$2a$15$' . md5(openssl_random_pseudo_bytes(16)) . '$';
	    		// $de_password='123456';
	        	//$password = crypt($de_password, $salt);
	        	$password = md5(123456);
				
	    		if ($wpdb->update( $wpdb->prefix.'cn_system_users', array( 'password' => $password ), array( 'uid' => $users_ids ) )) 
				{
					$msg="Update successfully";	
					_e(json_encode(array('msg'=>$msg,'pws'=>$password))) ;
				}else{
					$msg='something was wrong';
					_e(json_encode(array('msg'=>$msg,'users_ids'=>$users_ids))) ;
				}
			}
		}elseif ($param=='edit_all_agent_transactions') {
			if (($_POST['transaction_ids'])) {
	    		$transaction_ids=sanitize_text_field($_POST['transaction_ids']);
	    		if ($wpdb->update( $wpdb->prefix.'cn_transactions', array( 'status' => 'deleted' ), array( 'id' => $transaction_ids ) )) 
				{
					$msg="Deleted successfully";	
					_e(json_encode(array('msg'=>$msg))) ;
				}else{
					$msg='something was wrong';
					_e(json_encode(array('msg'=>$msg,'users_ids'=>$users_ids))) ;
				}
			}
		}elseif ($param=='add_mytransactions') {
    		require_once workstation_DIR . 'admin/partials/my_transactions_add.php';
    	}elseif ($param=='add_agenttransactions') {
    		require_once workstation_DIR . 'admin/partials/agent_transactions_add.php';
    	}elseif ($param=='delete_all_mytransactions') {
			if (($_POST['mytransactions_ids'])) {
	    		$mytransactions_ids=sanitize_text_field($_POST['mytransactions_ids']);
				$mytransactions_ids = explode(",",$mytransactions_ids);
				$mytransactions="UPDATE `".$wpdb->prefix."cn_transactions` SET `status`= 'deleted' WHERE id IN (".implode(',', array_fill(0, count($mytransactions_ids), '%s')).")";
				$mytransactions = call_user_func_array(array($wpdb, 'prepare'), array_merge(array($mytransactions), $mytransactions_ids));
	    		if ($this->query->iQuery($mytransactions)) 
				{
					$msg="Remove successfully";	
					_e(json_encode(array('msg'=>$msg))) ;
				}else{
					$msg='something was wrong';
					_e(json_encode(array('msg'=>$msg,'users_ids'=>$users_ids))) ;
				}
			}
		}elseif ($param=='delete_file') {
			if (($_POST['file_ids'])) {
				$file_ids=sanitize_text_field($_POST['file_ids']);
	    		if ($ss=$this->query->iQuery($wpdb->prepare("UPDATE `".$wpdb->prefix."cn_files` SET `status`= 'user_deleted' WHERE id=%d"), $file_ids)) 
				{
					$msg="Update successfully";	
					_e(json_encode(array('msg'=>$msg))) ;
				}else{
					$msg='something was wrong';
					_e(json_encode(array('msg'=>$msg,'users_ids'=>$users_ids))) ;
				}
			}
		}elseif ($param=='update_price_and_commission') {
			$transactionData = array();
			$transactionData['sale_price'] = sanitize_text_field($_POST['sale_price']);
			$transactionData['total_commision'] = sanitize_text_field($_POST['total_commision']);
			$transactionData['broker_referral'] = sanitize_text_field($_POST['broker_referral']);
			$transactions_id=sanitize_text_field($_POST['id']);
			$response=$this->query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));   
		}elseif ($param=='export_data') {
			$tabel_array = array('cn_properties','cn_transactions','cn_clients','cn_system_users','cn_files','cn_system_ci_sessions','cn_profiles');
			
			foreach ($tabel_array as $tabel_name) {
				$sql=$wpdb->prepare("select * from `".$wpdb->prefix.$tabel_name."`");
				$tblData=$this->query->iWhileFetch($sql);
				if ($tblData) {
					foreach ($tblData[0] as $key => $value) {
						$fields[]=$key;
					}
					$cn_filename=$tabel_name.'.csv';
					$cn_all_filename[]=$cn_filename;
					$filepathe=workstation_DIR.'backup/'.$cn_filename;
					$delimiter = ",";
					$f = fopen($filepathe, 'w');
					fputcsv($f, $fields, $delimiter);
					foreach ($tblData as $Data_val) {
						foreach ($fields as $field_key => $field_value) {
							$lineData[]=$Data_val[$field_value];
						}
						fputcsv($f, $lineData, $delimiter);   
						unset($lineData);
					}
					unset($fields);
					fseek($f, 0);
					fpassthru($f);
				}
			}
			
			$zip = new ZipArchive;
			if ($zip->open(workstation_DIR.'backup/db_backup.zip', ZIPARCHIVE::CREATE) === TRUE) {
				foreach ($cn_all_filename as $cn_backup_filename) {
					$zip->deleteName(workstation_DIR.'backup/'.$cn_backup_filename);
					$zip->addFile(workstation_DIR.'backup/'.$cn_backup_filename, $cn_backup_filename);	
					//unlink(workstation_DIR.'backup/'.$cn_backup_filename);
				}
			    $zip->close();
			} else {
			}
			$download_path =workstation_URI.'backup/db_backup.zip';
			_e($download_path);
		}elseif ($param=='export_file') {
			$zip = new ZipArchive;
			if ($zip->open(workstation_DIR.'backup/files_backup.zip') === TRUE) {
				$upload = wp_upload_dir();
				$upload_dir = $upload['basedir'];
				$upload_dir = $upload_dir . '/cn_workstation';
				$file_folder = $upload_dir;
				if ($handle = opendir($file_folder))
			    {
			        // Add all files inside the directory
			        while (false !== ($entry = readdir($handle)))
			        {
			        	if ($entry != "." && $entry != ".." && !is_dir($file_folder . '/' . $entry))
			            {
			                $zip->addFile($file_folder . '/' . $entry, $entry);
			            }
			        }
			        closedir($handle);
			    }
			} else {
			}
			$download_path =workstation_URI.'/backup/files_backup.zip';
			_e($download_path);
		}elseif ($param=='backup_data') {
			$tabel_array = array('cn_properties','cn_transactions','cn_clients','cn_system_users','cn_files','cn_system_ci_sessions','cn_profiles');
			
			foreach ($tabel_array as $tabel_name) {
				$sql=$wpdb->prepare("select * from `".$wpdb->prefix.$tabel_name."`");
				$tblData=$this->query->iWhileFetch($sql);
				if ($tblData) {
					foreach ($tblData[0] as $key => $value) {
						$fields[]=$key;
					}
					$cn_filename=$tabel_name.'.csv';
					$cn_all_filename[]=$cn_filename;
					$filepathe=workstation_DIR.'backup/'.$cn_filename;
					$delimiter = ",";
					$f = fopen($filepathe, 'w');
					fputcsv($f, $fields, $delimiter);
					foreach ($tblData as $Data_val) {
						foreach ($fields as $field_key => $field_value) {
							$lineData[]=$Data_val[$field_value];
						}
						fputcsv($f, $lineData, $delimiter);   
						unset($lineData);
					}
					unset($fields);
					fseek($f, 0);
					fpassthru($f);
				}
			}
			
			$zip = new ZipArchive;
			if ($zip->open(workstation_DIR.'backup/file1.zip', ZIPARCHIVE::CREATE) === TRUE) {
				foreach ($cn_all_filename as $cn_backup_filename) {
					$zip->deleteName(workstation_DIR.'backup/'.$cn_backup_filename);
					$zip->addFile(workstation_DIR.'backup/'.$cn_backup_filename, $cn_backup_filename);	
					//unlink(workstation_DIR.'backup/'.$cn_backup_filename);
				}
			    $zip->close();
			} else {
			}
			$downloadURLs = [];
			array_push($downloadURLs, workstation_URI.'backup/file1.zip');
			// Files Backup
			$zipFileNames = [];
			for ($i = 2; $i <= 100; $i++) {
				array_push($zipFileNames, 'file' . $i . '.zip');
				unlink(workstation_DIR.'backup/file' . $i . '.zip');
			}
			$upload = wp_upload_dir();
			$upload_dir = $upload['basedir'];
			$upload_dir = $upload_dir . '/cn_workstation';
			$file_folder = $upload_dir;
			if ($handle = opendir($file_folder))
			{
			    // Add all files inside the directory
				$zipCounter = 0;
				array_push($downloadURLs, workstation_URI.'backup/'.$zipFileNames[$zipCounter]);
			    while (false !== ($entry = readdir($handle)))
			    {
					$zip = new ZipArchive;
					if ($zip->open(workstation_DIR.'backup/'.$zipFileNames[$zipCounter], ZIPARCHIVE::CREATE) === TRUE) {
						if (filesize(workstation_DIR.'backup/'.$zipFileNames[$zipCounter]) < $this->return_bytes((ini_get('upload_max_filesize') - '10').'M')) {
							if ($entry != "." && $entry != ".." && !is_dir($file_folder . '/' . $entry))
							{
								$zip->addFile($file_folder . '/' . $entry, $entry);
							}
						} else {
							$zipCounter++;
							array_push($downloadURLs, workstation_URI.'backup/'.$zipFileNames[$zipCounter]);
							if ($zip->open(workstation_DIR.'backup/'.$zipFileNames[$zipCounter], ZIPARCHIVE::CREATE) === TRUE) {
								if ($entry != "." && $entry != ".." && !is_dir($file_folder . '/' . $entry))
								{
									$zip->addFile($file_folder . '/' . $entry, $entry);
								}
							}
						}
					}
			    }
			    closedir($handle);
			}
			_e(json_encode($downloadURLs));
		}
		else{
    		$msg='Something was wrong';
    		_e(json_encode(array('msg'=>$msg)));
    	}
    	wp_die();
	}


	public function workstation_add_template_to_select( $post_templates) {
		$post_templates['agent_page.php'] = __('Agent Workstation');
	    return $post_templates;
	}

	public function workstation_load_plugin_template( $template ) {
		if(  get_page_template_slug() === 'agent_page.php' ) {
	        if ( $theme_file = locate_template( array( 'start_quiz.php') ) ) {
	            $template = $theme_file;
	        } else {
	           $template = workstation_DIR . 'public/template/agent_page.php';
	        }
	   	}
	   	if($template == '') {
	        throw new \Exception('No template found');
	    }
	    return $template;
	}

	public function wp_upe_upgrade_completed( $upgrader_object, $options ) {
		// The path to our plugin's main file
		// If an update has taken place and the updated type is plugins and the plugins element exists
		if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
		 	// Iterate through the plugins being updated and check if ours is there
		 	foreach( $options['plugins'] as $plugin ) {
		  		if( str_contains($plugin, 'workstation') ) {
		   			// 
					global $wpdb;
					$cn_system_users = $wpdb->prefix . 'cn_system_users';
					maybe_add_column($cn_system_users, 'commission', "ALTER TABLE {$cn_system_users} ADD commission decimal(3, 2) DEFAULT '0.90'");
					maybe_add_column($cn_system_users, 'lease', "ALTER TABLE {$cn_system_users} ADD lease decimal(3, 2) DEFAULT NULL");
					maybe_add_column($cn_system_users, 'sale', "ALTER TABLE {$cn_system_users} ADD sale decimal(3, 2) DEFAULT NULL");
					// 
				}
		 	}
		}
	}


}
