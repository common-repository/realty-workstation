<!doctype html>
<html lang="en" data-workstation-url="<?php echo get_permalink((int) get_option('rw_workstation')); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Realty Workstation - Login</title>
        <link href="<?php echo REALTY_WORKSTATION_URL . 'public/css/bootstrap.min.css' ?>" rel="stylesheet"></link>
        <link href="<?php echo REALTY_WORKSTATION_URL . 'public/css/realty-workstation-public.css?version=' . REALTY_WORKSTATION_VERSION ?>" rel="stylesheet"></link>
        <style>
            html,
            body {
                height: 100%;
            }
            body {
                display: flex;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }
            .form-signin {
                max-width: 500px;
                padding: 15px;
            }
            .form-signin .form-floating:focus-within {
                z-index: 2;
            }
            .form-signin input[type="email"] {
                margin-bottom: -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }
            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        </style>
    </head>
    <body>
        <main class="form-signin w-100 m-auto">
            <div class="card shadow-lg p-3 mb-5 bg-body rounded">
                <div class="card-body">
                    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
                    <div class="alert alert-danger" style="display: none;"></div>
                    <div class="form-floating">
                        <input type="email" class="form-control" id="email" placeholder="name@example.com">
                        <label for="email">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" placeholder="Password">
                        <label for="password">Password</label>
                    </div>
                    <button class="w-100 btn btn-lg btn-success btn-sign-in" type="button">Sign in</button>
                </div>
            </div>
        </main>
        <script src="<?php echo REALTY_WORKSTATION_URL . 'public/js/jquery-3.6.3.min.js'; ?>"></script>
		<script>
			var rw_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
		</script>
        <script src="<?php echo REALTY_WORKSTATION_URL . 'public/js/realty-workstation-public.js?version=' . REALTY_WORKSTATION_VERSION ; ?>"></script>
    </body>
</html>