<?php $__env->startSection('title', 'Invoices | Admin'); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <h3 class="title"> Today Invoices<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addMakeModal">Add Invoice </button></h3>
        
    <section>
            <today-invoices :company_id="<?php echo e(json_encode(Input::get('company_id'))); ?>" :products = "<?php echo e(json_encode($products)); ?>" 
            :companies = "<?php echo e(json_encode($companies)); ?>" :rubbers = "<?php echo e(json_encode($rubbers)); ?>"  :payment_types = "<?php echo e(json_encode($payment_types)); ?>"></today-invoices>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addMakeModal" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0" >ADD INVOICE</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-invoice :company_id="<?php echo e(json_encode(Input::get('company_id'))); ?>" :products = "<?php echo e(json_encode($products)); ?>"
                      :companies = "<?php echo e(json_encode($companies)); ?>"   :rubbers = "<?php echo e(json_encode($rubbers)); ?>" :payment_types = "<?php echo e(json_encode($payment_types)); ?>"></add-invoice>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\stockdemo\resources\views/admin/invoices.blade.php ENDPATH**/ ?>