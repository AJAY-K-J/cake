<?php $__env->startSection('title', 'Jobcards | Admin'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
               <?php 
               use App\Http\Controllers\SMS;
               use Illuminate\Support\Facades\Input;
               $api= Auth::user()->company->sms->api;
               $balance = SMS::getBalance($api) + Auth::user()->company->sms->buffer;

              $company_id=Input::has('company_id');
              $company=DB::table('companies')->where('id','=',$comp_id)->first();
              $company_name=$company?$company->name:'';
                       ?>
            <?php if(!$company_id): ?>
            <?php if(Auth::user()->company->type ==2): ?>
               <h4 class="title" > <font color="red"> Balance SMS: <?php echo e($balance); ?></font></h4>
        <h3 class="title">JOBCARDS<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addRecoveryModal">Add Recovery</button><button class="btn btn-primary float-right" data-toggle="modal" data-target="#addBookingModal">Add Jobcard</button></h3>
        <?php else: ?>
               <h4 class="title" > <font color="red"> Balance SMS: <?php echo e($balance); ?></font></h4>
        <h3 class="title">JOBCARDS<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addBookingModal">Add Jobcard</button></h3>
        <?php endif; ?>
            <?php elseif($company_id): ?>
               <h3 class="title"> <font color="red"> <?php echo e($company_name); ?></font></h3>
        
        <?php endif; ?>
      
       
        <section>
            <jobcards 
                :services = "<?php echo e(json_encode($services)); ?>" :vehiclemakes="<?php echo e(json_encode($vehiclemakes)); ?>" :technicians="<?php echo e(json_encode($technicians)); ?>" :jobadvisors="<?php echo e(json_encode($jobadvisors)); ?>" :company_id="<?php echo e(json_encode(Input::get('company_id'))); ?>" :categories="<?php echo e(json_encode($categories)); ?>" :products="<?php echo e(json_encode($products)); ?>">
            </jobcards>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addBookingModal" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD JOBCARD</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-jobcard :services="<?php echo e(json_encode($services)); ?>" :technicians="<?php echo e(json_encode($technicians)); ?>" :jobadvisors="<?php echo e(json_encode($jobadvisors)); ?>" :vehiclemakes="<?php echo e(json_encode($vehiclemakes)); ?>" :categories="<?php echo e(json_encode($categories)); ?>" :company_id="<?php echo e(json_encode(Input::get('company_id'))); ?>" :products="<?php echo e(json_encode($products)); ?>"></add-jobcard>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="addRecoveryModal" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD JOBCARD</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-recovery :services="<?php echo e(json_encode($services)); ?>" :technicians="<?php echo e(json_encode($technicians)); ?>" :jobadvisors="<?php echo e(json_encode($jobadvisors)); ?>" :vehiclemakes="<?php echo e(json_encode($vehiclemakes)); ?>" :categories="<?php echo e(json_encode($categories)); ?>" :company_id="<?php echo e(json_encode(Input::get('company_id'))); ?>" :products="<?php echo e(json_encode($products)); ?>"></add-recovery>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    
</script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sizcom\resources\views/admin/jobcards.blade.php ENDPATH**/ ?>