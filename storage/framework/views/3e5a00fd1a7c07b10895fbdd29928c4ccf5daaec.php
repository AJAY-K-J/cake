<?php $__env->startSection('title', 'Item Report | Admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <item-report :products="<?php echo e(json_encode($products)); ?>"></item-report>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\cake\resources\views/reports/item_report.blade.php ENDPATH**/ ?>