<style type="text/css">
#receipt_table td, #receipt_table th {
    border: 1px solid #ddd;
    padding-top: 8px;
    padding-left: 8px;
    padding-bottom: 8px;
    word-break:break-all;
    text-align: left;
    word-wrap: break-word;
    font-size: 11px;
    font-family: Arial, Helvetica, sans-serif;
  }
  #receipt_table thead {
    background-color : #B1C3DE;
    font-family: Arial, Helvetica, sans-serif;
  }
</style>
<h4>DATE: <?php echo e($details['date']); ?> </h4>
<table  id="receipt_table" class="table" style="width:100%" cellspacing="0" cellpadding="1" border="0">
    <thead>
        <tr>
            <th colspan="3">SUMMERY</th>
        </tr>
    </thead>
    <tbody>
        <?php if($details['opening_balance']=='0.00'): ?>
          <tr>
            <td width="100%"><span>Opening Blanace Not Found!!!</span></td>
            <td></td>
            <td></td>
         </tr>
        <?php else: ?>   
          <tr>
           <td width="40%">Opening</td>
           <td width="30%">
           <?php $__currentLoopData = $details['openings']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
           <?php echo e($type['type']); ?> : <?php echo e($type['amount']); ?> &nbsp;
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </td>
           <td width="30%"><b><?php echo e($details['opening_balance']); ?></b></td>
         </tr>
         <tr>
           <td>Collection</td>
           <td>
           <?php $__currentLoopData = $details['collections']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
           <?php echo e($type['type']); ?> : <?php echo e($type['amount']); ?> &nbsp;
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
           </td>
           <td><b><?php echo e($details['total_coll']); ?></b></td>
         </tr>
         <tr>
           <td>Expense</td>
           <td>
           <?php $__currentLoopData = $details['expense']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
           <?php echo e($type['type']); ?> : <?php echo e($type['amount']); ?> &nbsp;
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
           </td>
           <td><b><?php echo e($details['total_exp']); ?></b></td>
         </tr>
         
         <tr>
           <td>Balance Amount</td>
           <td>
           <?php $__currentLoopData = $details['balances']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
           <?php echo e($type['type']); ?> : <?php echo e($type['amount']); ?> &nbsp;
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>   
           </td>
           <td><b><?php echo e($details['balance_amount']); ?></b></td>
         </tr>
         
        <?php endif; ?> 
    </tbody>

</table>

<table  id="receipt_table" class="table" style="width:100%" cellspacing="0" cellpadding="1" border="0">
    <thead>
        <tr>
            <th colspan="2">INVOICE</th>
        </tr>
    </thead>
    <tbody>
           <tr>
                 <td width="70%">Created</td>
                 <td width="30%"><b><?php echo e($details['sales']); ?></b></td>
               </tr>
                
              
               
               <tr>
                 <td>Invoice Total Discount</td>
                 <td><b><?php echo e($details['sale_total_discount']); ?></b></td>
               </tr>
               <tr>
                 <td>Invoice Total Amount</td>
                 <td><b><?php echo e($details['sale_total_amount']); ?></b></td>
               </tr>
    </tbody>

</table>
<table  id="receipt_table" class="table" style="width:100%" cellspacing="0" cellpadding="1" border="0">
    <thead>
        <tr>
            <th colspan="2">EXPENSE</th>
        </tr>
    </thead>
    <tbody>
           <tr>
                 <td width="70%">Created</td>
                 <td width="30%"><b><?php echo e($details['expenses']); ?></b></td>
               </tr>
             <?php if($details['cats']!=''): ?>
              <?php $__currentLoopData = $details['cats']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
               <tr>
                 <td><?php echo e($detail['name']); ?></td>
                 <td><b><?php echo e($detail['amount']); ?></b></td>
               </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
             <?php endif; ?> 
               <tr>
                 <td>Sale Total Amount</td>
                 <td><b><?php echo e($details['exp_total_amount']); ?></b></td>
               </tr>
    </tbody>

</table>
<table  id="receipt_table" class="table" style="width:100%" cellspacing="0" cellpadding="1" border="0">
    <thead>
        <tr>
            <th colspan="3">ITEMS</th>
        </tr>
    </thead>
    <tbody>
           <tr>
                 <td><b>PART NO</b></td>
                 <td><b>QTY</b></td>
                 <td><b>AMOUNT</b></td>
               </tr>
             <?php if($details['parts']): ?>  
              <?php $__currentLoopData = $details['parts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
               <tr>
                 <td><?php echo e($part['name']); ?></td>
                 <td><?php echo e($part['qty']); ?></td>
                 <td><?php echo e($part['amount']); ?></td>
               </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            <?php endif; ?>  
              
    </tbody>
     <tfoot>
                <tr>
                 <td>Total</td>
                 <td><b><?php echo e($details['item_total_qty']); ?></b></td>
                 <td><b><?php echo e($details['item_total_amount']); ?></b></td>
                </tr> 
               </tfoot>

</table><?php /**PATH C:\laragon\www\cake\resources\views/exports/day_report.blade.php ENDPATH**/ ?>