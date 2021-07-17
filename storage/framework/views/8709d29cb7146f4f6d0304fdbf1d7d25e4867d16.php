<?php $__env->startSection('title', 'Invoice Report | Admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <invoice-report :companies="<?php echo e(json_encode($companies)); ?>" ></invoice-report>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\cake\resources\views/reports/invoices.blade.php ENDPATH**/ ?>