<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.realtyworkstation.com/
 * @since      1.0.0
 *
 * @package    Workstation
 * @subpackage Workstation/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Workstation
 * @subpackage Workstation/public
 * @author     Realty Workstation <info@realtyworkstation.com>
 */
class Workstation_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$query = new Cn_Query();
		$this->query=$query;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name.'-bootstrap-css', plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-fontawesome-css', plugin_dir_url( __FILE__ ) . 'portalresources/bower_components/font-awesome/css/font-awesome.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-formvalidation-css', plugin_dir_url( __FILE__ ) . 'portalresources/css/formvalidation/formValidation.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-dataTables.bootstrap5-css', plugin_dir_url( __FILE__ ) . 'css/dataTables.bootstrap5.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-sweet-alert-css', plugin_dir_url( __FILE__ ) . '../cn_package/node_modules/sweetalert/sweetalert/lib/sweet-alert.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-custom-css', plugin_dir_url( __FILE__ ) . '../cn_package/css/cn-custom.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name.'-uploader-css', plugin_dir_url( __FILE__ ) . 'css/uploader.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/workstation-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script('sweet-alert-js', plugin_dir_url( __FILE__ ) . '../cn_package/node_modules/sweetalert/sweetalert/lib/sweet-alert.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('jquery-maskMoney-js', plugin_dir_url( __FILE__ ) . 'portalresources/js/jquery.maskMoney.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('jquery-inputmask-js', plugin_dir_url( __FILE__ ) . 'portalresources/js/input-mask/jquery.inputmask.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('jquery-inputmask-extensions-js', plugin_dir_url( __FILE__ ) . 'portalresources/js/input-mask/jquery.inputmask.extensions.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('jquery-inputmask-date-extensions-js', plugin_dir_url( __FILE__ ) . 'portalresources/js/input-mask/jquery.inputmask.date.extensions.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('jquery-knob-js', plugin_dir_url( __FILE__ ) . 'portalresources/js/upload/jquery.knob.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('jquery-iframe-transport-js', plugin_dir_url( __FILE__ ) . 'portalresources/js/upload/jquery.iframe-transport.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('bootstrap-bundle-js', plugin_dir_url( __FILE__ ) . 'js/bootstrap.bundle.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('formValidation-js', plugin_dir_url( __FILE__ ) . 'portalresources/js/formvalidation/formValidation.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('richscott-js', plugin_dir_url( __FILE__ ) . 'portalresources/js/richscott.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('jquery-dataTables-js', plugin_dir_url( __FILE__ ) . 'js/jquery.dataTables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('dataTables-bootstrap5-js', plugin_dir_url( __FILE__ ) . 'js/dataTables.bootstrap5.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script('cn-custom-js', plugin_dir_url( __FILE__ ) . 'js/workstation-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'cn-custom.js','cn_plugin_vars', array('ajaxurl' => admin_url('admin-ajax.php'),'plugin_url'=>workstation_URI));
	}

	public function agent_workstation($atts){
		ob_start();
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

		require_once workstation_DIR . 'public/partials/workstation-public-display.php';
		$ReturnString = ob_get_contents(); ob_end_clean(); 
 		return $ReturnString;
	}

	public function register_session(){
	    if( !session_id() )
	        session_start();
	}

	public function workstation_ajax_handaler(){
		global $wpdb;
		$cn_files = $wpdb->prefix .'cn_files';
		$transactions = $wpdb->prefix .'cn_transactions';
		$tdate = date('Y-m-d H:m:s');
		$param = sanitize_text_field($_REQUEST['param']) ? sanitize_text_field($_REQUEST['param']) : "";
		if ($param == 'cn_donload') {
			
		}elseif ($param=='delete_file') {
			if ($_POST['file_ids']) {
	    		$file_ids=sanitize_text_field($_POST['file_ids']);
	    		if ($ss=$wpdb->query($wpdb->prepare("UPDATE `".$cn_files."` SET `status`= 'user_deleted' WHERE id=%d", $file_ids))) 
				{
					$msg="Update successfully";	
					_e(json_encode(array('msg'=>$msg))) ;
				}else{
					$msg='something was wrong';
					_e(json_encode(array('msg'=>$msg,'users_ids'=>$users_ids))) ;
				}
			}
		}
		elseif ($param=='update_price_and_commission') {
			$transactionData = array();
			$transactionData['sale_price'] = sanitize_text_field($_POST['sale_price']);
			$transactionData['total_commision'] = sanitize_text_field($_POST['total_commision']);
			$transactionData['broker_referral'] = sanitize_text_field($_POST['broker_referral']);
			$transactionData['date_created'] = $tdate;
			$transactions_id=sanitize_text_field($_POST['id']);
			$response=$this->query->iUpdateArray($transactions,$transactionData,array('`id`'=>$transactions_id));   
		}
		else {
			$msg = 'Something was wrong';
			_e(json_encode(array('msg' => $msg)));
		}
		wp_die();
	
	}

	public function wpse27856_set_content_type() {
		return "text/html";
	}

	public function wpb_sender_name( $original_email_from ) {
		$workstation_name = get_option('workstation_name');
		if (isset($workstation_name) && !empty($workstation_name)) {
			return $workstation_name;
		} else {
			return $original_email_from;
		}
	}

	public function my_prefix_remove_all_styles() {
		if(  get_page_template_slug() === 'agent_page.php' ) {
			global $wp_styles;
			foreach ($wp_styles->queue as $key => $value) {
				if (!str_contains($value, 'workstation')) {
					unset($wp_styles->queue[$key]);
				}
			}
			show_admin_bar(false);
		}
	}

}
