<?php $__env->startSection('title', 'Incomes | Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
       
     
        <h3 class="title">Today Incomes <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addExpenseModal">Add Income</button></h3>
       
        <section>
            <incomes :incomecategories = "<?php echo e(json_encode($incomecategories)); ?>" :payment_types = "<?php echo e(json_encode($payment_types)); ?>">
            </incomes>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addExpenseModal" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD Income</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-income :incomecategories="<?php echo e(json_encode($incomecategories)); ?>" :payment_types = "<?php echo e(json_encode($payment_types)); ?>"></add-income>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\stockdemo\resources\views/admin/incomes.blade.php ENDPATH**/ ?>