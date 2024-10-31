<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://www.realtyworkstation.com/
 * @since      1.0.0
 *
 * @package    Workstation
 * @subpackage Workstation/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
 <div id="wrapper">
		<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
			    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			        <span class="sr-only">Toggle navigation</span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			        <span class="icon-bar"></span>
			    </button>
			    <a style="color: #00457B;" class="navbar-brand" href="http://wppluginhub.com/workstation/portal"> Miller Eaton Agent Workstation</a>
			</div>
		    <ul class="nav navbar-top-links navbar-right">
		        <li class="dropdown">
				    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
				        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
				    </a>
				    <ul class="dropdown-menu dropdown-user">
				        <li>
				            <a href="?transactions=change_password"><i class="fa fa-lock fa-fw"></i> Change Password</a>
				        </li>
				        <li class="divider"></li>

				        <li>
				            <a href="?transactions=logout"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
				        </li>
				    </ul>
				</li>
		    </ul>
		    <div class="navbar-default sidebar" role="navigation">
		        <div class="sidebar-nav navbar-collapse">
		            <ul class="nav" id="side-menu">
		                <li>
		                    <a href="#"><i class="fa fa-table fa-fw"></i> My Transactions<span class="fa arrow"></span></a>
		                    <ul class="nav nav-second-level">
		                        <li>
		                            <a class="fa fa-plus" href="?transactions=new_transaction"> New</a>
		                        </li>
		                        <li>
		                            <a class="fa fa-folder-open-o" href="?transactions=open_transactions"> Open</a>
		                        </li>
		                        <li>
		                            <a class="fa fa-folder-o" href="?transactions=closed_transactions"> Closed & Cancelled</a>
		                        </li>
		                    </ul>
		                </li>
		            </ul>
		        </div>
		        <!-- /.sidebar-collapse -->
		    </div>
    
		</nav>
        <!-- Page Content -->
        <div id="page-wrapper">
			<div class="container-fluid">
			    <div class="row">
			        <div class="col-lg-12">
			        	<?php if ($_GET['transactions']=='open_transactions'): ?>
			        		<h1 class="page-header">Open Transactions</h1>	
			        	<?php endif ?>
			        	<?php if ($_GET['transactions']=='closed_transactions'): ?>
			        		<h1 class="page-header">Closed and Cancelled Transactions</h1>	
			        	<?php endif ?>
			        	<?php if ($_GET['transactions']=='new_transaction'): ?>
			        		<h1 class="page-header">New Transaction</h1>	
			        	<?php endif ?>
			        	<?php if ($_GET['transactions']=='change_password'): ?>
			        		<h1 class="page-header">Change Password</h1>	
			        	<?php endif ?>
			            
			        </div>
			    </div>
			    <div class="row">
			    	<?php 
			    	if ($_GET['transactions']=='open_transactions'){
			    		$recode_for='transactions=closed_transactions';
			    		if ($_GET['trans_edit']) {
							require_once workstation_DIR . 'public/partials/transactions_edit.php';	
						}else{
							require_once workstation_DIR . 'public/partials/open_transactions.php';
						}
						
		        	 }
		        	 if ($_GET['transactions']=='closed_transactions'){
		        	 	$recode_for='transactions=closed_transactions';
						require_once workstation_DIR . 'public/partials/closed_transactions.php';
		        	 }
		        	 if ($_GET['transactions']=='new_transaction'){
						require_once workstation_DIR . 'public/partials/new_transaction.php';
		        	 }
		        	 ?>
			    </div>
			</div>
		</div>
    </div>