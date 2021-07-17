<?php $__env->startSection('title', 'Companies | Superadmin'); ?>
<?php $__env->startSection('content'); ?>

<div class="container-fluid">
   <form class="card" id="filterForm">
       <div class="card-body">
           <div class="row">
               <div class="col-md-4">
                   <div class="form-group">
                       <label>From Date</label>
                       <input type="date" placeholder="From Date" autocomplete="off"  required="required" name="from" class="form-control" value="<?php echo e($_GET['from'] ?? DATE('Y-m-d')); ?>">
                   </div>
               </div>
               <div class="col-md-4">
                   <div class="form-group">
                       <label>To Date</label>
                       <input type="date" placeholder="To Date" autocomplete="off" required="required" name="to" class="form-control" value="<?php echo e($_GET['to'] ?? DATE('Y-m-d')); ?>">
                   </div>
               </div>
               <div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
                   <button class="btn btn-block btn-success btn-sm m-0 mr-md-2">Filter</button>
               </div>
               <div class="col-md-2 d-flex align-items-center mb-3 mb-md-0">
                   <a class="btn btn-block btn-danger btn-sm m-0 mr-md-2" href="/dashboard" role="button">Clear</a>
               </div>

           </div>
       </div>
   </form>
    <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <h3> <b><?php echo e($shop->name); ?></b>  </h3> 

    <?php
    // $today_date=date('Y-m-d');
    $expensetable="expenses_".$shop->id; 
    $expense=DB::table($expensetable)->where('status',0)->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get();
    $purchasecredit=DB::table('purchasecredits')->where('status',0)->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get();
    $customertable="customers_".$shop->id; 
  
    //$incometable="incomes_".$shop->id;
   // $today_incomes=DB::table($incometable)->where('status',0)->whereDate('created_at','=',$today_date)->get();
    $pendingcompletion = DB::table($customertable)->where([['status',0],['reg_status',0],['sale_status',0],['type','>=',3]])->get();

    $pendingdelivery = DB::table($customertable)->where([['status',0],['reg_status',1],['sale_status',0],['type','>=',3]])->get();
    $todaybooking = DB::table($customertable)->where([['status','>=',0],['sale_status',0],['type','>=',3]])
    ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get();
    $todaydelivered = DB::table($customertable)->where([['status','>=',0],['reg_status',2],['type','>=',3]]) 
    ->whereDate('delivered_date','>=',$from)->whereDate('delivered_date','<=',$to)->get();
    $credit=DB::table($customertable)->where([['status',0],['type',5]])
    ->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to)->get();
    ?>
    
    <div class="row">
      
      <div class="col-md-3">
        <h3><a href="/jobcards?company_id=<?php echo e($shop->id); ?>">  <b> Jobcards</b></a></h3>
          <table class="table table-bordered" style="margin: 0;padding:0;">
            <tbody>
               
               
                <tr>
                    <td colspan="1">  Pending Completion </td>
                    <td colspan="1">  <b style="color:red">  <?php echo e($pendingcompletion->count()); ?></b> </td>
                </tr>
               <tr>
                <td colspan="1">  Pending Delivery</td>
                <td colspan="1">  <b style="color:red">    <?php echo e($pendingdelivery->count()); ?></b> </td>
               </tr>
               <tr>
                <td colspan="1">   Today Created </td>
                <td colspan="1">  <b style="color:red">    <?php echo e($todaybooking->count()); ?></b> </td>
               </tr>
             <tr>
                 <td colspan="1"> Today Delivered</td>
                 <td colspan="1">     <b style="color:red"> <?php echo e($todaydelivered->where('sale_status',0)->count()); ?></b> </td>
             </tr>
            </tbody>
        </table>
       </div>
  
       <div class="col-md-3">

       <h3><a href="/sales?company_id=<?php echo e($shop->id); ?>"><b>Sales</b></a></h3>
         <table class="table table-bordered" style="margin: 0;padding:0;">
           <tbody>
               <tr>
                   <td colspan="1">Today Sales  </td>
                   <td colspan="1">  <b style="color:red"> <?php echo e($todaydelivered->where('sale_status',1)->count()); ?></b></td>
               </tr>
               <tr>
                   <td colspan="1">Sale Collection  </td>
                   <td colspan="1">  <b style="color:red"> <?php echo e($todaydelivered->where('sale_status',1)->sum('total_amount')); ?></b></td>
               </tr>
              
             
          <tr>
             <td colspan="2">
            
             <b>  <a href="/reports/deliveries?company_id=<?php echo e($shop->id); ?>">Delivery Report</b></a>
            </td>
          </tr>
           <tr>
             <td colspan="2">
            
             <b>  <a href="/reports/expenses?company_id=<?php echo e($shop->id); ?>">Expense Report</b></a>
            </td>
          </tr>
           
           </tbody>
       </table>
      
        
        
    </div>
    <div class="col-md-3">
     <h3><b>Total Collection</b></h3>
     <?php
     $coll=$todaydelivered->where('type',3)->where('renter_status',0)->sum('total_amount');
     $collcash=$todaydelivered->where('payment_type','Cash')->where('type',3)->where('renter_status',0)->sum('total_amount');
     $collbank=$todaydelivered->where('payment_type','HDFC-Bank')->where('type',3)->where('renter_status',0)->sum('total_amount');
     $collbank2=$todaydelivered->where('payment_type','AXIS-Bank')->where('type',3)->where('renter_status',0)->sum('total_amount');
     $collgooglepay=$todaydelivered->where('payment_type','GooglePay')->where('type',3)->where('renter_status',0)->sum('total_amount');
     $creditcoll=$credit->sum('total_amount');
     $creditcollcash=$credit->where('payment_type','Cash')->sum('total_amount');
     $creditcollbank=$credit->where('payment_type','HDFC-Bank')->sum('total_amount');
     $creditcollbank2=$credit->where('payment_type','AXIS-Bank')->sum('total_amount');
     $creditcollgooglepay=$credit->where('payment_type','GooglePay')->sum('total_amount');
     $total_collection= $coll+$creditcoll;
     $total_collection_bank= $collbank+$creditcollbank;
     $total_collection_bank2= $collbank2+$creditcollbank2;
     $total_collection_cash= $collcash+$creditcollcash;
     $total_collection_googlepay= $collgooglepay+$creditcollgooglepay;
     ?>
     
         
       <table class="table table-bordered" style="margin: 0;padding:0;">
         <tbody>
            
            
             <tr>
                 <td colspan="1">  HDFC-Bank </td>
                 <td colspan="1">  <b style="color:red">  <?php echo e($total_collection_bank); ?></b> </td>
             </tr>
             <tr>
                 <td colspan="1">  AXIS-Bank </td>
                 <td colspan="1">  <b style="color:red">  <?php echo e($total_collection_bank2); ?></b> </td>
             </tr>
            <tr>
             <td colspan="1">   Cash </td>
             <td colspan="1">  <b style="color:red">    <?php echo e($total_collection_cash); ?></b> </td>
            </tr>
            <tr>
             <td colspan="1">   GooglePay </td>
             <td colspan="1">  <b style="color:red">    <?php echo e($total_collection_googlepay); ?></b> </td>
            </tr>
          <tr>
              <td colspan="1">  Today total collection</td>
              <td colspan="1">     <b style="color:red"> <?php echo e($total_collection); ?></b> </td>
          </tr>
         </tbody>
     </table>
     </div>
    <div class="col-md-3">
     <h3><b>Total Expenses</b></h3>
     <?php
     $totalexpenses= $expense->sum('amount')+$purchasecredit->where('payment',1)->sum('amount');
     $expensecash=$expense->where('payment_type','Cash')->sum('amount')+$purchasecredit->where('payment_type','Cash')->where('payment',1)->sum('amount');
     $expensebank=$expense->where('payment_type','HDFC-Bank')->sum('amount')+$purchasecredit->where('payment_type','HDFC-Bank')->where('payment',1)->sum('amount');
     $expensebank2=$expense->where('payment_type','AXIS-Bank')->sum('amount')+$purchasecredit->where('payment_type','AXIS-Bank')->where('payment',1)->sum('amount');
     $expensegooglepay=$expense->where('payment_type','GooglePay')->sum('amount')+$purchasecredit->where('payment_type','GooglePay')->where('payment',1)->sum('amount');
     ?>
     
         
       <table class="table table-bordered" style="margin: 0;padding:0;">
         <tbody>
            
            
             <tr>
                 <td colspan="1">   HDFC-Bank </td>
                 <td colspan="1">  <b style="color:red">  <?php echo e($expensebank); ?></b> </td>
             </tr>
             <tr>
                 <td colspan="1">  AXIS-Bank </td>
                 <td colspan="1">  <b style="color:red">  <?php echo e($expensebank2); ?></b> </td>
             </tr>
            <tr>
             <td colspan="1">   Cash </td>
             <td colspan="1">  <b style="color:red">    <?php echo e($expensecash); ?></b> </td>
            </tr>
            <tr>
             <td colspan="1">   GooglePay </td>
             <td colspan="1">  <b style="color:red">    <?php echo e($expensegooglepay); ?></b> </td>
            </tr>
          <tr>
              <td colspan="1">  Today total expenses</td>
              <td colspan="1">     <b style="color:red"> <?php echo e($totalexpenses); ?></b> </td>
          </tr>
         </tbody>
     </table>
 </div>

    
      
     
</div>



<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">

</script>
<?php $__env->stopPush(); ?>

<style>
/*header { position: fixed; top: -30px; left: 0px; right: 0px; height: 20px; }*/

html body {
    font-family: arial, sans-serif ;
    font-size: 12px;
    color: #000000;
    margin: 0px;
    /* background: #fff; */
}
table {
    background-color: transparent;
}
table {
    border-spacing: 0;
    border-collapse: collapse;
}
.table {
    width: 100%;
    max-width: 100%;
    padding-top: 0;
    padding-bottom: 0;
  
}
.table-bordered {
    border: 1px solid #000;
}
.border {
    border: 1px solid #000;
 
}
.m-8{
    margin-left: 8px;
    margin-right: 8px;
}
.table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
    border: 1px solid #000;
}
td,th {
    padding-left:3px;
    padding-right:3px;
    padding-top: 1px;
    padding-bottom: 1px;
}
.text-center{
    text-align: center;
}
.text-right{
    text-align: right;
}
.row:after {
    content: "";
    display: table;
    clear: both;
}
.col-2{
    float: left;
    width:16.66666667%;
}
.col-3{
    float: left;
    width:25%;
}
.col-4{
    float: left;
    width:33.33333333%;
}
.col-6{
    float: left;
    width:50%;
}
.col-8{
    float: left;
    width:66.66666667%;
}
.col-10{
    float: left;
    width:83.33333333%;
}
.mb-10{
    margin-bottom: 10px;
}
.mb-6{
    margin-bottom: 6px;
}
.mt-10{
    margin-top: 10px;
}
.dotted {
    border: none;
    border-bottom: 1px dotted #040404;
    color: #fff;
    background-color: #fff;
    margin: 0 13px 0 11px;
}
.clearfix{

    clear: both;
}
.ptb-0{
    padding-top: 0;
    padding-bottom: 0;
}
.text-right{
    text-align: right;
}
.logo {
  
    max-width: 150px;
    max-height: 30px;
    
       top: 0px;
       right: 0px;
    object-position: top right;
    
}
.column {
  float: left;
  width: 33.33%;
}


.column {
  float: left;
  width: 13%;

  border: 1px solid green;
  padding: 10px;
  margin: 10px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;

}

.box {
  width: 300px;
  border: 1px solid green;
  padding: 20px;
  margin: 20px;
}
</style>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\sizcom\resources\views/shopadmin/dashboard.blade.php ENDPATH**/ ?>