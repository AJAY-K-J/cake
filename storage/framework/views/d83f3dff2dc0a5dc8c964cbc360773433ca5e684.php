<?php $__env->startSection('title', 'Expense Report | Admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <expense-report :expensecategories="<?php echo e(json_encode($expensecategories)); ?>" :company_id="<?php echo e(json_encode(Input::get('company_id'))); ?>" ></expense-report>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\stockdemo\resources\views/reports/expenses.blade.php ENDPATH**/ ?>