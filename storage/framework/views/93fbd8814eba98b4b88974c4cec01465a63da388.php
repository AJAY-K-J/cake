<?php $__env->startSection('title', 'Purchses Report | Admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <purchase-report :vendors="<?php echo e(json_encode($vendors)); ?>" :company_id="<?php echo e(json_encode(Input::get('company_id'))); ?>" ></purchase-report>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\cake\resources\views/reports/purchases.blade.php ENDPATH**/ ?>