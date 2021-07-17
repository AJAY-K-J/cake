<?php $__env->startSection('title', 'Pay Credit Report | Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <paycredit-report :camp_select="<?php echo e(json_encode($deliveries)); ?>"></paycredit-report>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sizcom\resources\views/reports/paycredits.blade.php ENDPATH**/ ?>