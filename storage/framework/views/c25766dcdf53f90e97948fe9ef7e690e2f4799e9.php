<?php $__env->startSection('title', 'Employees| Admin'); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <h3 class="title">Employees <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addMakeModal">Add Employee</button></h3>
        
        <section>
            <employees :designations="<?php echo e(json_encode($designations)); ?>" ></employees>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addMakeModal" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD EMPLOYEE</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-employee :designations="<?php echo e(json_encode($designations)); ?>"></add-employee>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\cake\resources\views/admin/employees.blade.php ENDPATH**/ ?>