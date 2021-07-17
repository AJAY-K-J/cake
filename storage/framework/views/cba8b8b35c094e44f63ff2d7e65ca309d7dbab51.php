<?php $__env->startSection('title', 'Pay Balance Details | Admin'); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <h3 class="title">BALANCE PAYMENT PURCHASE DETAILS </h3>
        
        <section>
            <pay-balance-purchase :purchases="<?php echo e(json_encode($purchases)); ?>"></pay-balance-purchase>
        </section>
   
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\cake\resources\views/admin/paybalancepurchase.blade.php ENDPATH**/ ?>