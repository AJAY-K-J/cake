<?php $__env->startSection('title', 'Stock Report| Admin'); ?>
<?php $__env->startSection('content'); ?> 
<div class="container-fluid">
    <h3 class="title">STOCKS</h3> 
         <br>
   <section>
            <stock-report  :vendors = "<?php echo e(json_encode($vendors)); ?>"></stock-report>
        </section>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sizcom\resources\views/reports/stockreport.blade.php ENDPATH**/ ?>