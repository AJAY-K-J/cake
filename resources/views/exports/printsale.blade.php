<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=0.1">
    <meta name="description"
    content="SandOne">
    <meta name="keywords"
    content="SandOne">
    <meta name="BEEGAINS" content="SandOne">
    <title>Sale Invoice Print</title>

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


<div class="row">

  
 <div  style="text-align: center;">
   <span style="font-size: 16px;"><b>Bill of Supply</b></span>
   <br>
   Composition taxable person. Not eligible to collect tax on supplies
 </div>
</div>

  
  <table class="table table-bordered" style="margin: 0;padding:0;">
    <tbody>
        
        <tr >
            <td colspan="12" align="left">
                <b>Name & Address of the Supplier</b> 
                <br> sdfsddsfdsf <br> 
                 sdfsdfsdf   <br> 
                 sdfsdfsdfsdf, 
                 sdfsdfsdfsdf   <br> 
                 sdfsdfsdfsd    -
                 sdfsdfsdf   ,
                 sdfsdfsd    <br>

                 <br>
              sdfsdfsdfsd <br>   
               <b>GST No:</b>  sdfsdfsdfsd    
            </td>
           
           <td colspan="6">
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

           <td colspan="12" align="left" height="100px">
                <b>Buyer:</b> <br>
                <br> {{ $customer->name}}  <br> 
               
                 
                 {{ $customer->mobile }}<br>
                 <br>
                 <br>
                    
                
         </td>
         <td colspan="6">
             <b>Receipt No   :</b>  
                            {{$customer->receipt_no}}</b>
                              <br>
            <b>Receipt Date :</b>  
                             {{Carbon\Carbon::parse($customer->created_at)->format('d-M-Y')}}</b>
                             <br>
                             <br>
                             <br>
                             <br>   
                             <br>
         </td>
          
        
       </tr>

          

<tr>
            <td colspan=1 align="center"  style="padding: 5px">
             <b>SL no</b>
         </td>
             <td colspan=8 align="center"  style="padding: 5px">
              <b>Item Description</b>
          </td>
             <td colspan=3 align="center"  style="padding: 5px">
              <b>Part No</b>
          </td>
              <td colspan=2 align="center"  style="padding: 5px">
               <b>Quantity</b>
           </td>
               <td colspan=2 align="center"  style="padding: 5px">
                <b>Rate</b>
            </td>
                <td colspan=2 align="center"  style="padding: 5px">
                 <b>Total</b>

         </td>
    
          </tr>
          @foreach($customer->receipts as $receipt)
            <tr>
                <td colspan="1" align="center"  style="padding:10px;font-size: 12px;">
                    {{ $loop->index+1 }}
                </td>
             <td colspan=8 align="left" style="padding:10px;font-size: 12px;">
              <b>{{ $receipt->service_string }}</b>
          </td>
             <td colspan=3 align="center" style="padding:10px;font-size: 12px;">
              {{ $receipt->partno }}
          </td>
             <td colspan=2 align="center" style="padding:10px;font-size: 12px;">
              {{ $receipt->qty }}
          </td>

             <td colspan=2 align="center" style="padding:10px;font-size: 12px;">
              {{ $receipt->rate }}
          </td>
             <td colspan=2 align="center" style="padding:10px;font-size: 12px;">
                @php 
                $tot=$receipt->qty*$receipt->rate;
                @endphp
              {{ $tot  }}
          </td>
           </tr>
           @endforeach


           <tr>
               <td colspan="16" align="right">
                   <b> Discount</b>
               </td>
               <td colspan="2" align="right">
                   <b> {{ $customer->total_discount_amount }}</b>
               </td>
           </tr>
<tr>
    <td colspan="16" align="right">
        <b> Total Amount to be received  (Rs.)</b>
    </td>
    <td colspan="2" align="right">
        <b> {{ $customer->total_net_amount }}</b>
    </td>
</tr>
<tr>
    <td colspan="18" align="center">
        Total Amount in Words : {{decimal_to_words( $customer->total_net_amount )}}
    </td>
</tr>
    <tr>
        <td colspan="18" height="50" style="padding: 5px; text-align: justify-all; 
    vertical-align: middle; font-size: 11px;">
            I/We hereby certify that this invoice shows the actual price of the goods described and that all particulars are true and correct. 
        </td>
    </tr>
   
    <tr >
        <td colspan="18" style="padding: 10px" align="right" height="50">
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
<br>


</body>
</html>
