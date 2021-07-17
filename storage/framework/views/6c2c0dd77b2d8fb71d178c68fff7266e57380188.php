<?php $__env->startSection('title', 'Delivery Report | Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <delivery-report :camp_select="<?php echo e(json_encode($deliveries)); ?>" :company_id="<?php echo e(json_encode(Input::get('company_id'))); ?>" ></delivery-report>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sizcom\resources\views/reports/deliveries.blade.php ENDPATH**/ ?>