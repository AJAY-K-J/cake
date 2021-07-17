<?php $__env->startSection('title', 'Pay Balance| Admin'); ?>
<?php $__env->startSection('content'); ?>

    <div class="container-fluid">
        <h3 class="title">BALANCE PAYMENT INVOICE REPORT </h3>
        
        <section>
            <pay-balance-invoice :total_balance="<?php echo e(json_encode($total_balance)); ?>"></pay-balance-invoice>
        </section>
    
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(window).bind("pageshow", onload=function(){
  var e=document.getElementById("refreshed");
   if(e.value=="no")e.value="yes";
      else{e.value="no";location.reload();}

});
    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\cake\resources\views/admin/pay_balance_invoices.blade.php ENDPATH**/ ?>