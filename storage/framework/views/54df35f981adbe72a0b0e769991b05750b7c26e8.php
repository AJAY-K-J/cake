

<!DOCTYPE html>
<html>
<head>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content=<?php echo e(csrf_token()); ?>>
        <title><?php echo $__env->yieldContent('title', 'SME'); ?></title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('vendor/fontawesome/css/all.min.css')); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo e(asset('fontaw/font-awesome.min.css')); ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/app.css')); ?>">
        <link href="<?php echo e(asset('vendor/floating-scroll/jquery.floatingscroll.css')); ?>" rel="stylesheet">
 <!-- datatable -->
		<!-- Styles -->
		<?php echo $__env->yieldPushContent('styles'); ?>
    </head>
</head>
<body>
<?php echo $__env->make('layouts.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<section id="app">
	<?php echo $__env->yieldContent('content'); ?>
	<change-password></change-password>
</section>
    <script src="<?php echo e(asset('js/app.js')); ?>" type="text/javascript"></script>
   
    <!-- Material Design -->
    <script src="<?php echo e(asset('vendor/material-kit/js/core/bootstrap-material-design.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('vendor/material-kit/js/plugins/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendor/material-kit/js/material-kit.min.js')); ?>" type="text/javascript"></script>

    <script src="<?php echo e(asset('js/main.js')); ?>" type="text/javascript"></script>

    <!-- Scripts -->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\laragon\www\cake\resources\views/layouts/app.blade.php ENDPATH**/ ?>