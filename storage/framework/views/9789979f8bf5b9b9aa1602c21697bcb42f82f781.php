<?php $__env->startSection('title', 'Purchase Credit List | Admin'); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <h3 class="title">Purchase Credit List </h3>
        
        <section>
            <purchasecredits :payment_types = "<?php echo e(json_encode($payment_types)); ?>"></purchasecredits>
        </section>
    </div>
 
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\stockdemo\resources\views/reports/purchasecredits.blade.php ENDPATH**/ ?>