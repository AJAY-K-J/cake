<?php $__env->startSection('title', 'Return    Report | Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <return-report :deliveries="<?php echo e(json_encode($deliveries)); ?>"></return-report>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\stockdemo\resources\views/reports/return_list.blade.php ENDPATH**/ ?>