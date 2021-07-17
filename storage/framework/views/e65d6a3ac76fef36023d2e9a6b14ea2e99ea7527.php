<?php $__env->startSection('title', 'Counter Cash| Admin'); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
   <h2>Set Counter Cash <a class="float-right"><?php $date = date("d-m-Y")   ?> <?php echo e($date); ?></a></h2>
</div>
<div class="container-fluid">
   <section>
   		<accoption :payment_types = "<?php echo e(json_encode($payment_types)); ?>" :collections = "<?php echo e(json_encode($collections)); ?>" :expenses = "<?php echo e(json_encode($expenses)); ?>"></accoption>
   </section>
</div>
	
 
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\stockdemo\resources\views/admin/closing.blade.php ENDPATH**/ ?>