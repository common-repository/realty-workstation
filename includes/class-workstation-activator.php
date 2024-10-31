<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.realtyworkstation.com/
 * @since      1.0.0
 *
 * @package    Workstation
 * @subpackage Workstation/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Workstation
 * @subpackage Workstation/includes
 * @author     Realty Workstation <info@realtyworkstation.com>
 */
class Workstation_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public  function activate() {
		global $Workstation;
		global $wpdb;
		$Workstation = '1.0';
		$charset_collate = $wpdb->get_charset_collate();
		

		$cn_clients = $wpdb->prefix . 'cn_clients';
		$sql ="CREATE TABLE `$cn_clients` (
		  `cid` int(11) NOT NULL,
		  `client_firstName` varchar(50) DEFAULT NULL,
		  `client_lastName` varchar(50) DEFAULT NULL,
		  `client_company` varchar(200) DEFAULT NULL,
		  `client_phoneNumber` varchar(255) DEFAULT NULL,
		  `client_emailAddress` varchar(255) DEFAULT NULL,
		  `date_created` datetime DEFAULT NULL
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);

		// --
		// -- Table structure for table `files`
		// --
		$cn_files = $wpdb->prefix . 'cn_files';
		$sql ="CREATE TABLE `$cn_files` (
		  `id` int(11) NOT NULL,
		  `uid` varchar(255) DEFAULT NULL,
		  `status` varchar(255) DEFAULT NULL,
		  `original_name` varchar(255) DEFAULT NULL,
		  `file_type` varchar(255) DEFAULT NULL,
		  `saved_name` varchar(255) DEFAULT NULL,
		  `date_uploaded` datetime DEFAULT NULL,
		  `date_deleted` datetime DEFAULT NULL,
		  `content_type` varchar(255) DEFAULT NULL,
		  `associated_record` int(11) DEFAULT NULL,
		  `document_type` varchar(255) DEFAULT NULL
		)  $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);


		// --
		// -- Table structure for table `profiles`
		// --
		$cn_profiles = $wpdb->prefix . 'cn_profiles';
		$sql ="CREATE TABLE `$cn_profiles` (
		  `uid` int(11) DEFAULT NULL,
		  `image_file` int(11) DEFAULT NULL,
		  `first_name` varchar(100) DEFAULT NULL,
		  `last_name` varchar(100) DEFAULT NULL,
		  `phone_number` varchar(255) DEFAULT NULL,
		  `email_address` varchar(50) DEFAULT NULL,
		  `about_me` text,
		  `date_created` datetime DEFAULT NULL,
		  `date_edited` datetime DEFAULT NULL,
		  `url` varchar(255) DEFAULT NULL,
		  `approved` tinyint(1) DEFAULT NULL,
		  `display_order` int(11) DEFAULT NULL
		)  $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);


		// --
		// -- Table structure for table `properties`
		// --
		$cn_properties = $wpdb->prefix . 'cn_properties';
		$sql ="CREATE TABLE `$cn_properties` (
		  `pid` int(11) NOT NULL,
		  `property_no` varchar(255) DEFAULT NULL,
		  `property_street` varchar(255) DEFAULT NULL,
		  `property_appt` varchar(255) DEFAULT NULL,
		  `property_city` varchar(255) DEFAULT NULL,
		  `property_zip` varchar(30) DEFAULT NULL,
		  `date_created` datetime DEFAULT NULL
		)  $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);

		// --
		// -- Table structure for table `system_ci_sessions`
		// --
		$cn_system_ci_sessions = $wpdb->prefix . 'cn_system_ci_sessions';
		$sql ="CREATE TABLE `$cn_system_ci_sessions` (
		  `id` varchar(40) NOT NULL,
		  `ip_address` varchar(45) NOT NULL,
		  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
		  `data` blob NOT NULL
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);

		// --
		// -- Table structure for table `system_users`
		// --
		$cn_system_users = $wpdb->prefix . 'cn_system_users';
		$sql ="CREATE TABLE `$cn_system_users` (
		  `uid` int(11) NOT NULL,
		  `first_name` varchar(50) DEFAULT NULL,
		  `last_name` varchar(50) DEFAULT NULL,
		  `email` varchar(100) DEFAULT NULL,
		  `password` varchar(255) DEFAULT NULL,
		  `date_created` datetime DEFAULT NULL,
		  `date_loggedIn` datetime DEFAULT NULL,
		  `date_lastActivity` datetime DEFAULT NULL,
		  `status` varchar(255) DEFAULT NULL,
		  `admin` tinyint(1) DEFAULT NULL,
		  `commission` decimal(3,2) DEFAULT '0.90',
		  `lease` decimal(3,2) DEFAULT NULL,
		  `sale` decimal(3,2) DEFAULT NULL,
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);

		// --
		// -- Table structure for table `transactions`
		// --
		$cn_transactions = $wpdb->prefix . 'cn_transactions';
		$sql ="CREATE TABLE `$cn_transactions` (
		  `id` int(11) NOT NULL,
		  `uid` int(11) DEFAULT NULL,
		  `status` varchar(255) DEFAULT NULL,
		  `type` varchar(255) DEFAULT NULL,
		  `property_id` int(11) DEFAULT NULL,
		  `client_id` int(11) DEFAULT NULL,
		  `date_created` datetime DEFAULT NULL,
		  `date_completed` datetime DEFAULT NULL,
		  `date_cancelled` datetime DEFAULT NULL,
		  `sale_price` decimal(19,2) DEFAULT NULL,
		  `transaction_commission` decimal(19,2) DEFAULT NULL,
		  `total_commision` decimal(9,2) DEFAULT NULL,
		  `broker_referral` varchar(255) DEFAULT NULL,
		  `total_commision_rental` decimal(9,2) DEFAULT NULL,
		  `rental_price` decimal(19,2) DEFAULT NULL,
		  `rental_term` int(11) DEFAULT NULL,
		  `rental_term_period` varchar(255) DEFAULT NULL,
		  `commission_structure` varchar(255) DEFAULT NULL,
		  `transaction_commission_rental` varchar(255) DEFAULT NULL,
		  `date_edited` datetime DEFAULT NULL,
		  `edited_by` int(11) DEFAULT NULL
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta($sql);


		// --
		// -- Indexes for table `clients`
		// --
		$sql ="ALTER TABLE `".$cn_clients."` ADD PRIMARY KEY (`cid`)";
		$wpdb->query($sql);

		// --
		// -- Indexes for table `files`
		// --
		$sql ="ALTER TABLE `".$cn_files."` ADD PRIMARY KEY (`id`)";
		$wpdb->query($sql);

		// --
		// -- Indexes for table `profiles`
		// --
		$sql ="ALTER TABLE `".$cn_profiles."` ADD UNIQUE KEY `uid` (`uid`)";
		$wpdb->query($sql);

		// --
		// -- Indexes for table `properties`
		// --
		$sql ="ALTER TABLE `".$cn_properties."` ADD PRIMARY KEY (`pid`)";
		$wpdb->query($sql);

		$sql ="ALTER TABLE `".$cn_transactions."` ADD PRIMARY KEY (`id`)";
		$wpdb->query($sql);

		// --
		// -- Indexes for table `system_ci_sessions`
		// --
		$sql ="ALTER TABLE `".$cn_system_ci_sessions."` ADD KEY `ci_sessions_timestamp` (`timestamp`)";
		$wpdb->query($sql);

		// --
		// -- Indexes for table `system_users`
		// --
		$sql ="ALTER TABLE `".$cn_system_users."` ADD PRIMARY KEY (`uid`), ADD UNIQUE KEY `email` (`email`)";
		$wpdb->query($sql);

		// --
		// -- Indexes for table `transactions`
		// --
		$sql ="ALTER TABLE `".$transactions."` ADD PRIMARY KEY (`id`)";
		$wpdb->query($sql);
		// --
		// -- AUTO_INCREMENT for dumped tables
		// --

		// --
		// -- AUTO_INCREMENT for table `clients`
		// --
		$sql ="ALTER TABLE `".$cn_clients."` MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT";
		$wpdb->query($sql);

		// --
		// -- AUTO_INCREMENT for table `files`
		// --
		$sql ="ALTER TABLE `".$cn_files."` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT";
		$wpdb->query($sql);

		// --
		// -- AUTO_INCREMENT for table `properties`
		// --
		$sql ="ALTER TABLE `".$cn_properties."` MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT";
		$wpdb->query($sql);

		// --
		// -- AUTO_INCREMENT for table `system_users`
		// --
		$sql ="ALTER TABLE `".$cn_system_users."` MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10";
		$wpdb->query($sql);

		// --
		// -- AUTO_INCREMENT for table `transactions`
		// --
		 $sql ="ALTER TABLE `".$cn_transactions."` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT";
		 $wpdb->query($sql);

		add_option( 'Workstation', $Workstation);

		$this->cn_setup_pages();
		$this->Workstation_carete_dir();

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		global $wpdb;
		$transactions = $wpdb->prefix .'cn_transactions';
		maybe_add_column( $transactions, 'agent_payout', "ALTER TABLE {$transactions} ADD agent_payout varchar(255)" );

	}
	private function cn_setup_pages() {
	 	$pages = array(
            array(
                'post_title' => __( 'Workstation', 'workstation' ),
                'slug'       => 'workstation',
                'page_id'    => 'workstation',
                'content'    => '',
            )
        );
	 	if ( $pages ) {
            foreach ( $pages as $page ) {
                $page_id = $this->cn_create_page( $page );
            } 
        } 
        
	}
	private function cn_create_page( $page ) {
    	$page_obj = get_page_by_path( $page['post_title'] );
	    if ( ! $page_obj ) {
	        $page_id = wp_insert_post( array(
	            'post_title'     => $page['post_title'],
	            'post_name'      => $page['slug'],
	            'post_content'   => $page['content'],
	            'post_status'    => 'publish',
	            'post_type'      => 'page',
	            'comment_status' => 'closed',
	        ) );
	        update_option('agent_page', $page_id);
	        update_post_meta($page_id, '_wp_page_template', 'agent_page.php');
	    }

	    return false;
	}

	private function Workstation_carete_dir() {
		$plugin = new Workstation();
		$upload = wp_upload_dir();
	    $upload_dir = $upload['basedir'];
	    $upload_dir = $upload_dir . '/cn_'.$plugin->get_plugin_name();
	    if (! is_dir($upload_dir)) {
	       mkdir( $upload_dir, 0755 );
	    }
	    
	}

}
