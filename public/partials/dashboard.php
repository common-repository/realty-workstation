<?php
	session_start();
	$rw_workstation = get_permalink( (int) get_option('rw_workstation') );
?>
<!doctype html>
<html lang="en" data-workstation-url="<?php echo $rw_workstation; ?>" data-admin-ajax="<?php echo admin_url('admin-ajax.php'); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Realty Workstation</title>
        <link href="<?php echo REALTY_WORKSTATION_URL . 'public/css/bootstrap.min.css' ?>" rel="stylesheet"></link>
        <link href="<?php echo REALTY_WORKSTATION_URL . 'public/css/font-awesome/css/font-awesome.min.css'; ?>" rel="stylesheet"></link>
        <link href="<?php echo REALTY_WORKSTATION_URL . 'public/css/dataTables.bootstrap5.min.css'; ?>" rel="stylesheet"></link>
        <link href="<?php echo REALTY_WORKSTATION_URL . 'public/css/uploader.css'; ?>" rel="stylesheet"></link>
        <link href="<?php echo REALTY_WORKSTATION_URL . 'public/css/realty-workstation-public.css?version=' . REALTY_WORKSTATION_VERSION ?>" rel="stylesheet"></link>
    </head>
    <body>
        <header class="navbar sticky-top flex-md-nowrap p-2 shadow">
			<a class="navbar-brand col-md-2 me-0 fs-3 px-3" href="<?php echo get_permalink((int) get_option('rw_webpage')) . '?dashboard=true'; ?>"><?php echo get_option('rw_name'); ?></a>
			<div class="pe-3">
				<?php if (isset($_SESSION['rwUser']) && !empty($_SESSION['rwUser']) && $_SESSION['rwUser'] == 'agent') { ?>
					<a class="nav-link me-3" style="display: inline;" aria-current="page" href="?change-password=true">
						<i class="fa fa-lock"></i> &nbsp;Change Password
					</a>
				<?php } ?>
				<a class="nav-link logout-link" style="display: inline;" aria-current="page" href="javascript:void(0);">
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
					<div class="position-sticky p-1 pt-3">
						<ul class="nav nav-pills flex-column mb-auto">
							<?php if (isset($_SESSION['rwUser']) && !empty($_SESSION['rwUser']) && $_SESSION['rwUser'] == 'broker'): ?>
								<li class="nav-item">
									<a class="nav-link <?php echo (isset($_GET['agents']) && !empty($_GET['agents'])) ? 'active' : ''; ?> first-level-anchor " aria-current="page" href="javascript:void(0);">
										<i class="fa fa-table fa-fw"></i> Agents
									</a>
									<ul class="ps-3">
										<li class="nav-item second-level">
											<a class="nav-link <?php echo (isset($_GET['agents']) && !empty($_GET['agents']) && $_GET['agents'] == 'new') ? 'active' : ''; ?>" aria-current="page" href="?agents=new">
												<i class="fa fa-plus"></i> New Agent
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php echo (isset($_GET['agents']) && !empty($_GET['agents']) && $_GET['agents'] == 'true') ? 'active' : ''; ?>" aria-current="page" href="?agents=true">
												<i class="fa fa-folder-open-o"></i> All Agents
											</a>
										</li>
									</ul>
								</li>
								<li class="nav-item">
									<a class="nav-link first-level-anchor <?php echo (isset($_GET['agent-transactions']) && !empty($_GET['agent-transactions'])) ? 'active' : ''; ?>" aria-current="page" href="javascript:void(0);">
										<i class="fa fa-table fa-fw"></i> Agent Transactions
									</a>
									<ul class="ps-3">
										<li class="nav-item second-level">
											<a class="nav-link <?php echo (isset($_GET['agent-transactions']) && !empty($_GET['agent-transactions']) && $_GET['agent-transactions'] == 'new') ? 'active' : ''; ?>" aria-current="page" href="?agent-transactions=new">
												<i class="fa fa-plus"></i> New Transaction
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php echo (isset($_GET['agent-transactions']) && !empty($_GET['agent-transactions']) && $_GET['agent-transactions'] == 'open') ? 'active' : ''; ?>" aria-current="page" href="?agent-transactions=open">
												<i class="fa fa-folder-open-o"></i> Open Transactions
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php echo (isset($_GET['agent-transactions']) && !empty($_GET['agent-transactions']) && $_GET['agent-transactions'] == 'closed') ? 'active' : ''; ?>" aria-current="page" href="?agent-transactions=closed">
												<i class="fa fa-folder-o"></i> Closed Transactions
											</a>
										</li>
									</ul>
								</li>
								<li class="nav-item">
									<a class="nav-link first-level-anchor <?php echo (isset($_GET['broker-transactions']) && !empty($_GET['broker-transactions'])) ? 'active' : ''; ?>" aria-current="page" href="javascript:void(0);">
										<i class="fa fa-table fa-fw"></i> Broker Transactions
									</a>
									<ul class="ps-3">
										<li class="nav-item second-level">
											<a class="nav-link <?php echo (isset($_GET['broker-transactions']) && !empty($_GET['broker-transactions']) && $_GET['broker-transactions'] == 'new') ? 'active' : ''; ?>" aria-current="page" href="?broker-transactions=new">
												<i class="fa fa-plus"></i> New Transaction
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php echo (isset($_GET['broker-transactions']) && !empty($_GET['broker-transactions']) && $_GET['broker-transactions'] == 'open') ? 'active' : ''; ?>" aria-current="page" href="?broker-transactions=open">
												<i class="fa fa-folder-open-o"></i> Open Transactions
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php echo (isset($_GET['broker-transactions']) && !empty($_GET['broker-transactions']) && $_GET['broker-transactions'] == 'closed') ? 'active' : ''; ?>" aria-current="page" href="?broker-transactions=closed">
												<i class="fa fa-folder-o"></i> Closed Transactions
											</a>
										</li>
									</ul>
								</li>
							<?php endif; ?>
							<?php if (isset($_SESSION['rwUser']) && !empty($_SESSION['rwUser']) && $_SESSION['rwUser'] == 'agent'): ?>
								<li class="nav-item">
									<a class="nav-link first-level-anchor <?php echo (isset($_GET['agent-transactions']) && !empty($_GET['agent-transactions'])) ? 'active' : ''; ?>" aria-current="page" href="javascript:void(0);">
										<i class="fa fa-table fa-fw"></i> My Transactions
									</a>
									<ul class="ps-3">
										<li class="nav-item second-level">
											<a class="nav-link <?php echo (isset($_GET['agent-transactions']) && !empty($_GET['agent-transactions']) && $_GET['agent-transactions'] == 'new') ? 'active' : ''; ?>" aria-current="page" href="?agent-transactions=new">
												<i class="fa fa-plus"></i> New Transaction
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php echo (isset($_GET['agent-transactions']) && !empty($_GET['agent-transactions']) && $_GET['agent-transactions'] == 'open') ? 'active' : ''; ?>" aria-current="page" href="?agent-transactions=open">
												<i class="fa fa-folder-open-o"></i> Open Transactions
											</a>
										</li>
										<li class="nav-item second-level">
											<a class="nav-link <?php echo (isset($_GET['agent-transactions']) && !empty($_GET['agent-transactions']) && $_GET['agent-transactions'] == 'closed') ? 'active' : ''; ?>" aria-current="page" href="?agent-transactions=closed">
												<i class="fa fa-folder-o"></i> Closed Transactions
											</a>
										</li>
									</ul>
								</li>
							<?php endif; ?>
						</ul>
					</div>
				</nav>
				<main class="col-md-10 ms-sm-auto px-md-4">
					<div class="pt-3 pb-2 mb-3 border-bottom">
						<div class="realty-workstation-container row">
							<div class="col-12">
								<?php if (isset($_GET['dashboard']) && !empty($_GET['dashboard']) && $_GET['dashboard'] == 'true') { ?>
									<?php require_once( REALTY_WORKSTATION_PATH . 'public/partials/welcome.php' ); ?>
								<?php } ?>
								<?php if (isset($_GET['agents']) && !empty($_GET['agents']) && $_GET['agents'] == 'true') { ?>
									<?php require_once( REALTY_WORKSTATION_PATH . 'public/partials/agents-all.php' ); ?>
								<?php } ?>
								<?php if (isset($_GET['agents']) && !empty($_GET['agents']) && $_GET['agents'] == 'new') { ?>
									<?php require_once( REALTY_WORKSTATION_PATH . 'public/partials/agents-new.php' ); ?>
								<?php } ?>
								<?php if (isset($_GET['agents']) && !empty($_GET['agents']) && $_GET['agents'] == 'edit') { ?>
									<?php require_once( REALTY_WORKSTATION_PATH . 'public/partials/agents-edit.php' ); ?>
								<?php } ?>
								<?php if (isset($_GET['agent-transactions']) && !empty($_GET['agent-transactions']) && ($_GET['agent-transactions'] == 'open' || $_GET['agent-transactions'] == 'closed')) { ?>
									<?php require_once( REALTY_WORKSTATION_PATH . 'public/partials/agent-transactions-all.php' ); ?>
								<?php } ?>
								<?php if (isset($_GET['agent-transactions']) && !empty($_GET['agent-transactions']) && $_GET['agent-transactions'] == 'new') { ?>
									<?php require_once( REALTY_WORKSTATION_PATH . 'public/partials/agent-transactions-new.php' ); ?>
								<?php } ?>
								<?php if (isset($_GET['agent-transactions']) && !empty($_GET['agent-transactions']) && $_GET['agent-transactions'] == 'edit') { ?>
									<?php require_once( REALTY_WORKSTATION_PATH . 'public/partials/agent-transactions-edit.php' ); ?>
								<?php } ?>
								<?php if (isset($_GET['broker-transactions']) && !empty($_GET['broker-transactions']) && ($_GET['broker-transactions'] == 'open' || $_GET['broker-transactions'] == 'closed')) { ?>
									<?php require_once( REALTY_WORKSTATION_PATH . 'public/partials/broker-transactions-all.php' ); ?>
								<?php } ?>
								<?php if (isset($_GET['broker-transactions']) && !empty($_GET['broker-transactions']) && $_GET['broker-transactions'] == 'new') { ?>
									<?php require_once( REALTY_WORKSTATION_PATH . 'public/partials/broker-transactions-new.php' ); ?>
								<?php } ?>
								<?php if (isset($_GET['broker-transactions']) && !empty($_GET['broker-transactions']) && $_GET['broker-transactions'] == 'edit') { ?>
									<?php require_once( REALTY_WORKSTATION_PATH . 'public/partials/broker-transactions-edit.php' ); ?>
								<?php } ?>
								<?php if (isset($_GET['change-password']) && !empty($_GET['change-password']) && $_GET['change-password'] == 'true') { ?>
									<?php require_once( REALTY_WORKSTATION_PATH . 'public/partials/change-password.php' ); ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</main>
			</div>
		</div>
        <script src="<?php echo REALTY_WORKSTATION_URL . 'public/js/jquery-3.6.3.min.js'; ?>"></script>
        <script src="<?php echo REALTY_WORKSTATION_URL . 'public/js/jquery.dataTables.min.js'; ?>"></script>
        <script src="<?php echo REALTY_WORKSTATION_URL . 'public/js/dataTables.bootstrap5.min.js'; ?>"></script>
        <script src="<?php echo REALTY_WORKSTATION_URL . 'public/js/jquery.maskMoney.min.js'; ?>"></script>
        <script src="<?php echo REALTY_WORKSTATION_URL . 'public/js/sweetalert2.min.js'; ?>"></script>
		<script>
			var rw_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
		</script>
        <script src="<?php echo REALTY_WORKSTATION_URL . 'public/js/realty-workstation-public.js?version=' . REALTY_WORKSTATION_VERSION ; ?>"></script>
    </body>
</html>