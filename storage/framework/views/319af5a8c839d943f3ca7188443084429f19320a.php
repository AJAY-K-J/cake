    
    <?php $__env->startSection('title', 'Credit Report | Admin'); ?>
    <?php $__env->startSection('content'); ?>

        <div class="container-fluid">
            <h3 class="title">Credit Customer List </h3>
            
            <section>
                <credits></credits>
            </section>
        </div>
     
    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('scripts'); ?>
    <?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sizcom\resources\views/reports/credits.blade.php ENDPATH**/ ?>