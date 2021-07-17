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
    <title>Sale Order Print</title>

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
        padding-left:4px;
        padding-right:4px;
        padding-top: 3px;
        padding-bottom: 3px;
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



  
   <table class="table table-bordered" style="margin: 0;padding:0;">
    <tbody>
        
        <tr>
          <td colspan="7">
            <p style="margin:0;">  Sale Order No   &nbsp;&nbsp;:{{ $sale_order->id }} </p>
          <p style="margin:0;"> Date         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:{{ Carbon\Carbon::parse($sale_order->created_at)->format('d-M-Y') }} </p>
          </td>
        </tr>
        <tr>

           <td colspan="2" align="left" style="padding: 5px">
                <b>Customer Name</b> 
           </td>
           <td colspan="2" align="left" style="padding: 5px"> 
                : {{ $sale_order->name}}  
            </td>
            <td colspan="2"  align="left" style="padding: 5px">
                <b>Vehicle No</b>
            </td>
            <td colspan="1"  align="left" style="padding: 5px">
               : {{ $sale_order->reg_no}}
            </td>
        </tr>
        <tr >

           <td colspan="2" align="left" style="padding: 5px">
                <b>Contact No:</b>
           </td>
           <td colspan="2" align="left" style="padding: 5px"> 
                :{{ $sale_order->mobile }}  
            </td>
            <td colspan="2"  align="left" style="padding: 5px">
               
            </td>
            <td colspan="1"  align="left" style="padding: 5px">
               :
            </td>
        </tr>

        <tr>
         <td colspan=7 align="left"  style="padding: 5px">
          <b>Details of Products</b>
      </td>

       </tr>

         <tr>
          <td colspan=1 align="left" style="font-size: 10px">
           <b>SL No.</b>
        </td>
          <td colspan=1 align="left"   style="font-size: 10px">
           <b>Product</b>
      
        </td>
          <td colspan=1 align="left"  style="font-size: 10px" >
           <b>Qty</b>
        </td>
        
          <td colspan=1 align="left"   style="font-size: 10px">
           <b>Rate</b>
        </td>
        
          <td colspan=1 align="left" style="font-size: 10px" >
           <b>Serial No</b>
        </td>
        
          <td colspan=1 align="left"   style="font-size: 10px">
           <b>Size</b>
        </td>
        
          <td colspan=1 align="left"  style="font-size: 10px">
           <b>Company</b>
        </td>
        </tr>
       @foreach($sale_order->items as $jobcard)
      
         <tr  style="padding:5px;font-size: 10px;">

          <td colspan=1 align="left">
           <b>{{ $loop->iteration }}</b>
       </td>
          <td colspan=1 align="left">
          <b>{{ $jobcard->product }}</b>
      </td>
          <td colspan=1 align="left">
          <b>{{ $jobcard->qty }}</b>
      </td>
          <td colspan=1 align="left">
          <b>{{ $jobcard->rate }}</b>
      </td>
          <td colspan=1 align="left">
            
          <b>{{ $jobcard->serial_no }}</b>
      </td>
          <td colspan=1 align="left">
          <b>{{ $jobcard->size }}</b>
      </td>
      <td colspan=1 align="left">
         
          <b>{{ $jobcard->company }}</b>
      </td>
        </tr>
       
        @endforeach
   


<tr>
    <td colspan="6" align="right">
        <b> Total Estimate Amount(Rs.)</b>
    </td>
    <td colspan="1" align="right">
        <b> {{ $sale_order->total_estimate }}</b>
    </td>
</tr>
<tr>
    <td colspan="7" align="center">
        Total Amount in Words : {{decimal_to_words( $sale_order->total_estimate )}}
    </td>
</tr>
   
    <tr >
        <td colspan="7" style="padding: 10px" align="right" height="80">
          For Stock Demo<br>
          <br>
          <br>
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
