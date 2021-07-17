<?php $__env->startSection('title', 'Closing Report | Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <closing-report :payment_types="<?php echo e($payment_types); ?>"></closing-report>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\cake\resources\views/reports/closing.blade.php ENDPATH**/ ?>