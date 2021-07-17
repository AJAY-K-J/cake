<?php $__env->startSection('title', 'Payments | Admin'); ?>
<?php $__env->startSection('content'); ?>

	<div class="container-fluid">
		<h3 class="title">Payments <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addPaymentModal">Add Payment</button><a href="<?php echo e(URL::previous()); ?>" class="btn btn-primary float-right">
          Back   
        </a>
        </h3>
		
		<section>
			<payments :invoice="<?php echo e($invoice); ?>" :payment_types="<?php echo e($payment_types); ?>"></payments>
		</section>
	</div>
	<div class="container">
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" id="addPaymentModal" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title title my-0">Add Payment</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<add-payment :invoice="<?php echo e($invoice); ?>" :payment_types="<?php echo e($payment_types); ?>"></add-payment>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
	
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\cake\resources\views/admin/payments.blade.php ENDPATH**/ ?>