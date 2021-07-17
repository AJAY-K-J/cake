<!DOCTYPE html>
<html>
<head>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title>Login | Service Premium </title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />

        <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">

    </head>
</head>
<body class="bg-dark">
    <div class="container-fluid">
        <div class="vertical-align full-height">
            <div class="row justify-content-center">
                <div class="col-sm-8 col-md-6 col-lg-4">
                    <div class="card mx-auto" style="max-width: 350px;">
                        <div class="card-body">
                            <h2 class="card-title text-center" >LOGIN</h2>
                            <form id="login-form">
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Username</label>
                                    <input type="text" class="form-control" id="username" required>
                                </div>
                                <div class="form-group bmd-form-group">
                                    <label class="bmd-label-floating">Password</label>
                                    <input type="password" class="form-control" id="password" required>
                                </div>
                                
                                <div class="text-danger text-center mb-3 error-message">&nbsp</div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-primary btn-block" id="login-btn">Login</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>    
            </div>

        </div>

    </div>
    <script src="<?php echo e(asset('vendor/material-kit/js/core/jquery.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('vendor/material-kit/js/core/popper.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('vendor/material-kit/js/core/bootstrap-material-design.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('vendor/material-kit/js/material-kit.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>" type="text/javascript"></script>

    <script type="text/javascript">

    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\sizcom\resources\views/login.blade.php ENDPATH**/ ?>