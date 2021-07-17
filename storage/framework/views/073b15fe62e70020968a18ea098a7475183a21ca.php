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
    <title>Bill Print</title>

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
      <!-- <div class="column"> <img src="<?php echo e(asset('storage/'.$logo)); ?>" class="logo"/></div> -->
      
     <div  style="text-align: center;">
       <span style="font-size: 16px;"><b>Bill of Supply</b></span>
       <br>
       Composition taxable person. Not eligible to collect tax on supplies
     </div>
    </div>
  
  <table class="table table-bordered" style="margin: 0;padding:0;">
    <tbody>
         <tr >
             <td colspan="5" align="left">
                 <b>Name & Address of the Supplier</b> 
                 <br> <?php echo e($company->name); ?>  <br> 
                  <?php echo e($company->address_1); ?>    <br> 
                  <?php echo e($company->address_2); ?>, 
                  <?php echo e($company->address_3); ?>    <br> 
                  <?php echo e($company->district); ?>    -
                  <?php echo e($company->pincode); ?>   ,
                  <?php echo e($company->state); ?>    <br>

                  <br>
               <?php echo e($company->other); ?> <br>   
                <b>GST No:</b>  <?php echo e($company->gst_no); ?>    
             </td>
            
            <td colspan="3">
                <b>Nature of Transaction   :</b>  <br>
                                 Supply of Goods and Services
                                 <br>
                                 <br>
                                 <br>
               <b>State Code and Name  :</b>  <br>
                               32-Kerala
            </td>
            

            
         </tr>
         <tr>

            <td colspan="5" align="left" height="100px">
                 <b>Buyer:</b> <br>
                 <br> <?php echo e($customer->name); ?>  <br> 
                
                  
                  <?php echo e($customer->mobile); ?><br>
                  <br>
                  <br>
                     
                 
          </td>
          <td colspan="3">
              <b>Jobcard No   :</b>  
                             <?php echo e($customer->jobcard_prefix); ?><?php echo e($customer->jobcard_no); ?></b>
                               <br>
             <b>Date :</b>  
                              <?php echo e(Carbon\Carbon::parse($customer->delivered_date)->format('d-M-Y')); ?></b>
                              <br>
                              <br>
                              <br>
                              <br>   
                              <br>
          </td>
           
         
        </tr>

       
        <tr>
            <?php if($customer->recovery==0): ?>
           <td colspan="6" style="padding:5px;">
            Model:<b> <?php echo e($customer->make); ?> - <?php echo e($customer->model); ?> </b> 
            <br> Serial No/IMEI No: <b><?php echo e($customer->serial_no); ?></b>
            </td>
            <?php else: ?>
            <td colspan="6" style="padding:5px;">
             Model:<b> <?php echo e($customer->make); ?> </b> 
             <br> Data Recovery:   <b><?php echo e($customer->item_type); ?> - <?php echo e($customer->item_size); ?></b>
             </td>

            <?php endif; ?>
            <td colspan="2" style="padding:5px;">
               JOB ADVISOR : 
            
               <br>
                   <?php
                       $empl=DB::table('employees')->where('id',$customer->jobadvisor_id)->first();
                   ?>
                   
                     <b><?php echo e($empl->name?$empl->name:''); ?> </b>
            </td>
           
           </b>
       </tr>
 
                <tr style="padding:5px;">
                    <td colspan="1" style="padding:5px;" >No.</td>
                    <td colspan="4" style="padding:5px;">Service</td>
                    
                    <td colspan="1" style="padding:5px;">Rate</td>
                   
                    <td colspan="2" style="padding:5px;">Technician</td>
                    
                </tr>
                <?php  
                $grandtotal=0; 
                ?> 
                <?php $__currentLoopData = $customer->jobcards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobcard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $loop->index =$loop->index +1;
               $rate=(int)$jobcard->rate;
               $labour=(int)$jobcard->labour;
                $total = $jobcard->rate;
               $grandtotal=$grandtotal+$total;
               ?>
               
                <tr>
                    <td colspan="1" style="padding:5px;border-top: none; border-bottom: none;"><?php echo e($loop->index); ?></td>
                    <?php
                        $service=DB::table('services')->where('id',$jobcard->service_id)->first();

                    ?>
                    <td colspan="4" style="padding:5px;border-top: none; border-bottom: none; font-size:12px;"><b> <?php echo e($service?$service->name:$jobcard->service_string); ?></b></td>
                   
                    <td colspan="1" style="padding:5px;border-top: none; border-bottom: none;font-size:12px;" class="text-center"><?php echo e($rate); ?></td>
                   
                    <?php
                        $empl=DB::table('employees')->where('id',$jobcard->technician_id)->first();

                    ?>
                    <td colspan="2" style="padding:5px;border-top: none; border-bottom: none;font-size:12px;" class="text-center"><?php echo e($empl?$empl->name:''); ?></td>


                    
                   
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td colspan="1" style="border-top: none; border-bottom: none;"></td>
                  <td   colspan="4" style="border-top: none; border-bottom: none;"></td>
                    <td  colspan="1" style="border-top: none; border-bottom: none;"></td>
                    <td  colspan="2" style="border-top: none; border-bottom: none;"></td>
                   
                </tr>

               
               
                   
                </tr>
                <tr>
                  <td colspan="1" style="border-top: none; border-bottom: none;"></td>
                                   <td   colspan="4" style="border-top: none; border-bottom: none;"></td>
                                     <td  colspan="1" style="border-top: none; border-bottom: none;"></td>
                                     <td  colspan="2" style="border-top: none; border-bottom: none;"></td>
                                    
                </tr>
                <tr>
                  

                    <td  colspan=6 class="text-right" style="font-size: 15px;">Discount</td>
                    
                
                  
                    <td  colspan=2 class="text-center" style="font-size: 15px;"><b><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo e($customer->discount?$customer->discount:'0'); ?> </b> </td>
                    </tr>
                    <tr>
                      
                    <td colspan=6 class="text-right" style="font-size: 15px;">Total</td>
                    
                    
                    
                    <td colspan=2 class="text-center" style="font-size: 15px;"><b><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span><?php echo e($customer->total_amount); ?> </b> </td>

                  
                    
                 
                    
                </tr>
               
                  
               <tr>
                   <td colspan="8" align="center">
                       Total Amount in Words : <?php echo e(decimal_to_words( $customer->total_amount )); ?>

                   </td>
               </tr>
              <tr>
                  <td colspan="8" height="50" style="padding: 5px; text-align: justify-all; 
              vertical-align: middle; font-size: 11px;">
                      I/We hereby certify that this invoice shows the actual price of the goods described and that all particulars are true and correct. 
                  </td>
              </tr>
              
              <tr >
                  <td colspan="8" style="padding: 10px" align="right" height="50">
                    For Sizcom <br>
                    <br>
                    <br>
                    Authorized Signatory
                    <br>
                    (Sign and Stamp)
                  </td>
                 
                 
              </tr>
              
             
           
          
            </tbody>
        </table>

        



</body>
</html>
<?php /**PATH C:\laragon\www\sizcom\resources\views/exports/printbill.blade.php ENDPATH**/ ?>