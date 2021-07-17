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
    <title>Invoice Print</title>

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
      
        width: 150px;
        height: 50px;
        
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
<?php
 $gst = 0;
 ?>
<?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobcard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php
$gst = $gst+$jobcard->gst_percentage+$jobcard->sgst+$jobcard->igst+$jobcard->cess;
?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php if($gst!=0): ?> 
 <table width="100%">
  <tr style="border-bottom: 2px solid #000;" >
    <td colspan="6" align="left" style="padding:5px 2px;">
       <span>
        <img src="./images/poly_black.png" style="float: left; width: 168px; margin-bottom: 10px; margin-right: 10px; display: block;">
        </span>
        
      

        <h4 style="font-size: 15px; padding-top: 120px;   margin: 10px 0 0px 0; width: 100%; display: block;"> FUNCTIONAL INDUSTRIAL ESTATE </h4>
        
        
      <h2 style="color: #000; margin:0px 0 0px 0; border-radius: 5px; font-weight: normal; font-size: 14px; font-weight: 300; text-align: left;"><b>PAYYANAD P.O,MANJERI-676 122, MALAPPURAM,KERALA </b></h2>
        

      
    </td>
    <td colspan="6" align="right" valign="bottom" style="padding:15px 2px; width: 40%;border: 0;">

      
      <b style="margin:5px 0;">9847 640 137</b>
      
    </td>
  </tr>
  <br>
  <tr>
    <td colspan="6">
      <h3 style="background: #777; margin:0px 0 0 0; padding: 5px 10px; color: #fff; font-size:16px; text-align: left;border-radius: 4px; display: inline-block;">GSTIN NO:  32AAOFP2676H1Z0</h3>

    </td>
    <td colspan="6"></td>
  </tr>
</table>
<?php else: ?>
<table width="100%">
  <tr style="border-bottom: 2px solid #000;" height="300px;">
    <td colspan="6" align="left" style="padding:5px 2px;">
       <div style="width: 100%">
        <img src="./images/hi_tech.PNG" style="float: left; width: 68px; margin-bottom: 10px; margin-right: 10px;">
        <h1 style="   font-weight: 300; margin: 30px 0 60px 0;  font-size: 40px; margin-bottom: 7px;">Hi-Tech Tyres</h1>
        <h3 style="background: #777; margin:0px 0 0 0; padding: 5px 0px; color: #fff; font-size:12px; text-align: center;border-radius: 4px;">PRECURED AND CONVENTIONAL TYRE RETREADERS</h3>
        <!-- <p>Neetanimmal,KONDOTTY-673638<br>motorclaimcoordinater@gmail.com</p> -->
      </div>
    </td>
    <td colspan="6" align="right" valign="bottom" style="padding:15px 2px; width: 40%;border: 0;">

      <!-- <b style="margin:5px 0;">Sadim    TP&nbsp;&nbsp; 9846 715 911</b><br>
      <b style="margin:5px 0;">Nabeel   KP&nbsp;&nbsp;  9526 844 408</b><br>
      <b style="margin:5px 0;">Shamseer CK&nbsp;&nbsp; 8943 628 226</b><br> -->
      <b style="margin:5px 0;">0483-2714 349</b><br>
      <b style="margin:5px 0;">9847 640 137</b>
    </td>
  </tr>
  <tr>
    <td colspan="12"  style="border-bottom: 2px solid #000;">
      

      <h2 style="color: #000; margin:0px 0 8px 0; border-radius: 5px; font-weight: normal; font-size: 14px; font-weight: 300; text-align: left;"><b>Kodangad,KONDOTTY,MALAPPURAM </b></h2>
    </td>
  </tr>
</table>

<?php endif; ?>
  
   <table class="table table-bordered" style="margin: 0;padding:0;">
    <tbody>
        
        <tr>
          <td colspan="18">
            <p style="margin:0;">  Invoice No   &nbsp;&nbsp;:<?php echo e($invoice->invoice_no); ?> </p>
          <p style="margin:0;"> Date         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?php echo e(Carbon\Carbon::parse($invoice->invoice_date)->format('d-M-Y')); ?> </p>
          </td>
        </tr>
        <tr>

           <td colspan="5" align="left" style="padding: 5px">
                <b>Customer Name</b> 
           </td>
           <td colspan="5" align="left" style="padding: 5px"> 
                : <?php echo e($invoice->name); ?>  
            </td>
            <td colspan="4"  align="left" style="padding: 5px">
                <b>Vehicle No</b>
            </td>
            <td colspan="4"  align="left" style="padding: 5px">
               : <?php echo e($invoice->reg_no); ?>

            </td>
        </tr>
           <?php if($gst!=0): ?> 
        <tr >

           <td colspan="5" align="left" style="padding: 5px">
                <b>Contact No:</b>
           </td>
           <td colspan="5" align="left" style="padding: 5px"> 
                :<?php echo e($invoice->mobile); ?>  
            </td>

            <td colspan="4"  align="left" style="padding: 5px">
                <b>GST No</b>
            </td>
            <td colspan="4"  align="left" style="padding: 5px">
               :<?php echo e($invoice->gst_no? $invoice->gst_no:''); ?> 
            </td>
        </tr>
        <?php else: ?>
        <tr >

           <td colspan="9" align="left" style="padding: 5px">
                <b>Contact No:</b>
           </td>
           <td colspan="9" align="left" style="padding: 5px"> 
                :<?php echo e($invoice->mobile); ?>  
            </td>

           
        </tr>
        <?php endif; ?>

         
          <?php 
          $netservicerate =  0;
          $sgstservicerate= 0;
          $cgstservicerate=0;
          $igstservicerate= 0;
          $cessservicerate= 0;
          $totaltaxservicerate=0;
          $totalnetserviceamount=0;


          $netrate =  0;
          $sgstrate= 0;
          $cgstrate= 0;
          $igstrate= 0;
          $cessrate= 0;
          $totaltaxrate=0;
          $totalnetamount=0;
          $i=0;
          ?>

          
        <tr>
         <td colspan=18 align="left"  style="padding: 5px">
          <b>Details of Products</b>
      </td>

       </tr>

         <tr>
          <td colspan=1 align="left" style="font-size: 10px">
           <b>SL No.</b>
        </td>
          <td colspan=2 align="left"   style="font-size: 10px">
           <b>Product</b>
      
        </td>
          <td colspan=1 align="left"  style="font-size: 10px" >
           <b>Qty</b>
        </td>
        </td>
          <td colspan=1 align="left"   style="font-size: 10px">
           <b>Rate</b>
        </td>
        </td>
          <td colspan=1 align="left" style="font-size: 10px" >
           <b>Value</b>
        </td>
        </td>
          <td colspan=1 align="left"   style="font-size: 10px">
           <b>Discount</b>
        </td>
        </td>
          <td colspan=1 align="left"  style="font-size: 10px">
           <b>Taxable Value </b>
        </td>
        </td>
          <td colspan=1 align="left"  style="font-size: 10px">
           <b>SGST (%)</b>
        </td>
        </td>
          <td colspan=1 align="left"   style="font-size: 10px">
           <b>SGST Amount</b>
        </td>
        </td>
          <td colspan=1 align="left"  style="font-size: 10px">
           <b>CGST (%)</b>
        </td>
        </td>
          <td colspan=1 align="left"   style="font-size: 10px">
           <b>CGST Amount</b>
        </td>
        </td>
          <td colspan=1 align="left"   style="font-size: 10px">
           <b>IGST (%)</b>
        </td>
        </td>
          <td colspan=1 align="left"  style="font-size: 10px">
           <b>IGST Amount</b>
        </td>
        </td>
          <td colspan=1 align="left"   style="font-size: 10px">
           <b>Cess (%)</b>
        </td>
        </td>
          <td colspan=1 align="left"   style="font-size: 10px">
           <b>Cess Amount</b>
        </td>
       </td>
         <td colspan=1 align="left"   style="font-size: 10px">
          <b>Total Tax Amount </b>
       </td>
       </td>
         <td colspan=1 align="left"   style="font-size: 10px">
          <b>Total Amount </b>
       </td>
        </tr>
       <?php $__currentLoopData = $invoice->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobcard): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      
         <tr  style="padding:5px;font-size: 10px;">

          <td colspan=1 align="center">
           <b><?php echo e($loop->iteration); ?></b>
       </td>
          <td colspan=2 align="center">
          <b><?php echo e($jobcard->product); ?></b>
      </td>
          <td colspan=1 align="center">
          <b><?php echo e($jobcard->qty); ?></b>
      </td>
          <td colspan=1 align="center">
          <b><?php echo e($jobcard->rate); ?></b>
      </td>
          <td colspan=1 align="center">
            
          <b><?php echo e($jobcard->qty*$jobcard->rate); ?></b>
      </td>
          <td colspan=1 align="center">
          <b><?php echo e($jobcard->discount); ?></b>
      </td>
          <td colspan=1 align="center">
           <?php 
           $netrate =  $netrate+$jobcard->amount;
           $cgstrate= $cgstrate+$jobcard->cgst;
           $sgstrate= $sgstrate+$jobcard->sgst;
           $igstrate= $igstrate+$jobcard->igst;
           $cessrate= $cessrate+$jobcard->cess;
           $tax=$jobcard->sgst+$jobcard->cgst+$jobcard->igst+$jobcard->cess ;
           $totaltaxrate=$totaltaxrate+ $tax;
           $totalnetamount= $totalnetamount+$jobcard->net_amount;
           ?>
          <b><?php echo e($jobcard->amount); ?></b>
      </td>
          <td colspan=1 align="center">
             <?php if($jobcard->tax_type == 1 || $jobcard->tax_type == 3): ?>
          <b><?php echo e($jobcard->gst_percentage/2); ?></b>
          <?php else: ?>
          <b>0</b>
          <?php endif; ?>

      </td>
          <td colspan=1 align="center">
          <?php if($jobcard->tax_type == 1 || $jobcard->tax_type == 3): ?>
                      <b><?php echo e($jobcard->sgst); ?></b>
                      <?php else: ?>
                      <b>0</b>
                      <?php endif; ?>
      </td>
          <td colspan=1 align="center">
         <?php if($jobcard->tax_type == 1 || $jobcard->tax_type == 3): ?>
                     <b><?php echo e($jobcard->gst_percentage/2); ?></b>
                     <?php else: ?>
                     <b>0</b>
                     <?php endif; ?>
      </td>
          <td colspan=1 align="center">
        <?php if($jobcard->tax_type == 1 || $jobcard->tax_type == 3): ?>
                                <b><?php echo e($jobcard->sgst); ?></b>
                                <?php else: ?>
                                <b>0</b>
                                <?php endif; ?>
      </td>
          <td colspan=1 align="center">
       <?php if($jobcard->tax_type == 2|| $jobcard->tax_type == 4): ?>
                               <b><?php echo e($jobcard->gst_percentage); ?></b>
                               <?php else: ?>
                               <b>0</b>
                               <?php endif; ?>
      </td>
      </td>
          <td colspan=1 align="center">
        <?php if($jobcard->tax_type == 1|| $jobcard->tax_type == 3): ?>
                                         <b><?php echo e($jobcard->igst); ?></b>
                                         <?php else: ?>
                                         <b>0</b>
                                         <?php endif; ?>
      </td>
      </td>
          <td colspan=1 align="center">
             <?php if($jobcard->tax_type == 3 || $jobcard->tax_type == 4): ?>
                                     <b>1</b>
                                     <?php else: ?>
                                     <b>0</b>
                                     <?php endif; ?>
         
      </td>
      </td>
          <td colspan=1 align="center">
         <?php if($jobcard->tax_type == 3 || $jobcard->tax_type == 4): ?>
                                               <b><?php echo e($jobcard->cess); ?></b>
                                               <?php else: ?>
                                               <b>0</b>
                                               <?php endif; ?>
      </td>
      </td>
          <td colspan=1 align="center">
             
          <b><?php echo e($tax); ?></b>
      </td>
      </td>
          <td colspan=1 align="center">
        
          <b><?php echo e($jobcard->net_amount); ?></b>
      </td>
        </tr>
    
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   

<tr>
    <td colspan="7" align="right">
        <b>Total Amount (Rs.)</b>
    </td>
    <td colspan="1" align="right">
        <b><?php echo e($netrate); ?></b>
    </td>
    <td colspan="2" align="center">
        <b><?php echo e($cgstrate); ?></b>
    </td>
    <td colspan="2" align="center">
        <b><?php echo e($sgstrate); ?></b>
    </td>
    <td colspan="2" align="center">
        <b><?php echo e($igstrate); ?></b>
    </td>
    <td colspan="2" align="center">
        <b><?php echo e($cessrate); ?></b>
    </td>
    <td colspan="1" align="right">
        <b><?php echo e($totaltaxrate); ?></b>
    </td>
    <td colspan="1" align="right">
        <b><?php echo e($totalnetamount); ?></b>
    </td>


</tr>
<tr>
    <td colspan="16" align="right">
        <b> Additional Discount</b>
    </td>
    <td colspan="2" align="right">
        <b> <?php echo e($invoice->total_discount); ?></b>
    </td>
</tr>
<tr>
    <td colspan="16" align="right">
        <b> Total Amount to be received  (Rs.)</b>
    </td>
    <td colspan="2" align="right">
        <b> <?php echo e($invoice->total_net_amount); ?></b>
    </td>
</tr>
<tr>
    <td colspan="18" align="center">
        Total Amount in Words : <?php echo e(decimal_to_words( $invoice->total_net_amount )); ?>

    </td>
</tr>
    <tr>
        <td colspan="18" height="50" style="padding: 5px; text-align: justify-all; 
    vertical-align: middle; font-size: 11px;">
            I/We hereby certify that my/our registration certificate under the SGST/CGST/IGST Act is in force on data on which the supply of goods/services specified in this tax invoice is made by me/us and that the transaction of supply covered by this TAX INVOICE has been affected by me/us and it shall be accountedfor in the turnover of sale while filing of return and the due tax, if any, payable on the supply has been paid or shall paid. 
        </td>
    </tr>
   
    <tr >
      <?php if($gst!=0): ?> 
        <td colspan="18" style="padding: 10px" align="right" height="80">
          For Poly Black<br>
          <br>
          <br>
          <br>
          <br>
          Authorized Signatory
          <br>
          (Sign and Stamp)
        </td>
       
       <?php else: ?>
        <td colspan="18" style="padding: 10px" align="right" height="80">
          For Hitech<br>
          <br>
          <br>
          <br>
          <br>
          Authorized Signatory
          <br>
          (Sign and Stamp)
        </td>
       <?php endif; ?>
    </tr>
   
  
        
       
      
    </tbody>
</table>
<br>


</body>
</html>
<?php /**PATH C:\laragon\www\stockdemo\resources\views/exports/print_invoice.blade.php ENDPATH**/ ?>