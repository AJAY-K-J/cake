<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=0.1">
    <meta name="description"
    content="SandOne">
    <meta name="keywords"
    content="SandOne">
    <meta name="BEEGAINS" content="SandOne">
    <title>Job Card Print</title>

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
      width: 50%;
    }

    /* Clear floats after the columns */
    .row:after {
      content: "";
      display: table;
      clear: both;
    }
    

</style>
</head>
<body style="margin: 0;padding:0;" >


<div class="row">
  <div class="column"> <img src="<?php echo e(asset('storage/'.$logo)); ?>" class="logo"/> 
    <span style="text-align: left;float:left; font-size: 10px;margin-top:15px;"><br><?php echo e($company->other); ?><br> E-mail: <?php echo e($company->email); ?></span>

  </div>
 
 
  <div style="text-align: right;width:75%;float:right; font-size: 10px;"> <?php echo e($company->address_1); ?><br><?php echo e($company->address_2); ?>, <?php echo e($company->district); ?>-<?php echo e($company->pincode); ?> <br> GSTIN/UIN:<?php echo e($company->gst_no); ?> <br>State Name: Kerala, Code:32</div>
</div>
<div style="text-align: center;">
  <b>Job Authorization Form</b>
</div>
  
  <table class="table table-bordered" style="margin: 0;padding:0;">
    <tbody>
        
        <tr >
            <td colspan="2" align="left">
                 Customer name: <br> <b><?php echo e($customer->name?$customer->name:''); ?>  <br> 
                 <?php echo e($customer->service_string); ?>    <br> 

                <?php echo e($customer->mobile); ?></b>    

            </td>
            <td colspan="2">
                Jobcard No. <br>
                <b><?php echo e($customer->service_string); ?> <br>
                  <?php echo e($customer->service_string); ?> <br> 
                       <?php echo e($customer->jobcard_prefix); ?><?php echo e($customer->jobcard_no); ?>             

                                </b>    
            </td>
            <td colspan="2">
                Dated <br>
                <b><?php echo e($customer->service_string); ?> <br>
                                <?php echo e($customer->service_string); ?> <br> 
                                <?php echo e(Carbon\Carbon::parse($customer->created_at)->format('d-M-Y')); ?></b>
            </td>
            <td colspan="2">
               Type <br>
                <b><?php echo e($customer->service_string); ?> <br>
                                <?php echo e($customer->service_string); ?> <br> 
                                <?php echo e($customer->dealer); ?></b>
            </td>
        </tr>
        <tr>

            <?php if($customer->recovery==0): ?>
           <td colspan=6>
            Model:<b> <?php echo e($customer->make); ?> - <?php echo e($customer->model); ?> </b> 
            <br> Serial No/IMEI No: <b><?php echo e($customer->serial_no); ?></b>
            </td>
            <?php else: ?>
            <td colspan=6>
             Model:<b> <?php echo e($customer->make); ?> </b> 
             <br>Data Recovery:  <b><?php echo e($customer->item_type); ?> - <?php echo e($customer->item_size); ?></b>
             </td>
            <?php endif; ?>
            <td colspan=2>
               JOB ADVISOR : 
            
               <br>
                   <?php
                       $empl=DB::table('employees')->where('id',$customer->jobadvisor_id)->first();
                   ?>
                   
                     <b><?php echo e($empl->name?$empl->name:''); ?> </b>
            </td>
           
           </b>
       </tr>

           <tr>
            <td colspan=8 align="center"  style="padding: 5px">
             <b>Preliminary Inspection Report</b>
         </td>
          </tr>
          <?php $__currentLoopData = $customer->customercategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customercategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr  style="padding:5px;font-size: 10px;">
             <td colspan=2 align="center">
              <b><?php echo e($customercategory->category->name); ?></b>
          </td>
             <td colspan=6 align="center">
              <?php echo e($customercategory->catremark->name); ?>

          </td>
           </tr>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       
      
      
    <tr>
        <td colspan="2" align="center"  style="padding: 5px;font-size: 12px;">
          <b>Customer Voice</b>
        </td>
        <td colspan="6" style="padding: 5px">
            
            <?php echo e($customer->customer_voice?$customer->customer_voice: "NA"); ?>

        </td>
    </tr>
    <tr>
       
        <td colspan="2" style="padding: 0px" align="center" style="font-size: 10px;" >
           Warranty: <b><?php echo e($customer->with_warranty?'Yes':'No'); ?></b>
        </td>
       
        <td colspan="3" style="padding: 0px" align="center" style="font-size: 10px;">
       Out-of-Warranty: <b><?php echo e($customer->without_warranty?'Yes':'No'); ?></b>
        </td>
      
       
       

        <td colspan="3" style="padding: 0px" align="center" style="font-size: 10px;">
         Customer Dead Risk: <b><?php echo e($customer->customer_dead_risk?'Yes':'No'); ?></b>
        </td>
      
        
       
    </tr>
         
    <?php if($customer->estimate_amount>0): ?>
    <tr>
        
        <td colspan="4" style="align:center;padding: 5px;">
            
          <b>Estimate:</b> 
        </td>
        <td colspan="4" style="padding: 5px">
            
            <?php echo e($customer->estimate_amount?$customer->estimate_amount:"NA"); ?>

        </td>
    </tr>
    <?php endif; ?>
    <tr>
        <td colspan="8" style="padding: 5px; text-align: justify-all; 
    vertical-align: middle; font-size: 11px;">
            I hereby authorize Sizcom computers to perform the necessary repair / replacement if the charges are in the limit mentioned above. I know the Sizcom computers will intimate me if there is any difference in repair charges or if the item is not repairable and I agree to the terms and conditions given below.
        </td>
    </tr>
    <tr >
      
       
        <td colspan="4" style="padding: 5px" align="center">
           <b>Customer signature</b>
        </td>
        <td colspan="4" style="padding: 5px" align="center">
           <b>Date</b> 
        </td>
       
    </tr>
    <tr >
        <td colspan="4" style="padding: 0px" align="center">
           <?php if($customer->signature_path): ?>
           <img src="<?php echo e(asset('storage/'.$customer->signature_path)); ?>" class="logo"/>
           <?php endif; ?>
        </td>
       
        <td colspan="4" style="padding: 0px" align="center">
          <b> <?php echo e(Carbon\Carbon::parse($customer->created_at)->format('d-M-Y')); ?></b>
        </td>
       
    </tr>
    <?php if($customer->recovery==0): ?>
    <tr >
        <td colspan="8" style="padding: 0px" align="center">
          Accessories
        </td>
       
    </tr>
    <tr >
        <td colspan="2" style="padding: 0px" align="center" >
           Battery: <b><?php echo e($customer->battery?'Yes':'No'); ?></b>
        </td>
       
        <td colspan="2" style="padding: 0px" align="center">
        Charger: <b><?php echo e($customer->charger?'Yes':'No'); ?></b>
        </td>
        <td colspan="2" style="padding: 0px" align="center">
         Bag/pouch: <b><?php echo e($customer->bag?'Yes':'No'); ?></b>
        </td>
        <?php if($customer->dvd_drive): ?>
        <td colspan="2" style="padding: 0px" align="center" >
          Cd/DVD: <b><?php echo e($customer->dvd_drive?'Yes':'No'); ?></b>
        </td>
        <?php else: ?>
        <td colspan="2" style="padding: 0px" align="center" >
          SIM: <b><?php echo e($customer->sim?'Yes':'No'); ?></b>
        </td>

        <?php endif; ?>
        
       
    </tr>
         
    <?php endif; ?>
        
       
       <tr>
           <td colspan="2" align="center"  style="padding: 5px;font-size: 12px;">
             <b>Remarks</b>
           </td>
           <td colspan="6" style="padding: 5px">
               
               <?php echo e($customer->remarks?$customer->remarks: "No Remarks"); ?>

           </td>
       </tr>
    </tbody>
</table>
<br>
<b>Terms and Conditions</b> <br>
<ol>
    <li style=" font-size: 10px;">I hereby confirm that the above mentioned item belongs to me or the firm I represent and I take full responsibility of the same if any dispute or legal action / enquiries arises.</li>

   <li style=" font-size: 10px;">I hereby agree to collect the above item back within 30 days from today. I also agree the Sizcom computers cannot be held responsible for any loss or damage afterwards. If I fail to do so.</li>

    <li style=" font-size:10px;">I further acknowledgeand agree that I have backed up the data on my harddrive, and I understand that sizcom computers cannot be held responsible for any loss of data or programs from my hard drive.</li>

   <li style=" font-size: 10px;">Sizcom Computers is not responsible for keeping or returning defective parts that are replaced as part of the repair unless specifically requested by the customers prior to acceptance of our repair estimate.</li>

   <li style=" font-size: 10px;">Sizcom Computers undertake hardware level repair only and any Operating system level problems need to be addressed separately by the user.</li>

   <li style=" font-size: 10px;">I understand that sizcom will take due care of the equipment. However I agree that the items are left at Sizcom at my sole risk.</li>

</ol>

</body>
</html>
<?php /**PATH C:\laragon\www\sizcom\resources\views/exports/printjobcard.blade.php ENDPATH**/ ?>