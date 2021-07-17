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
    content="Sizcom">
    <meta name="XEECODE" content="Sizcom">
    <title>Daily Report Print</title>

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
     
      
     <div  style="text-align: center;">
       <span style="font-size: 16px;"><b>Daily Report</b></span>
       <br> {{ $company->name}}  <br> 
     </div>
    </div>
  
  <table class="table table-bordered" style="margin: 0;padding:0;">
    <thead>
          
        
           <tr>
               <th colspan="1">Sl No</th>
               <th colspan="1">Date</th>
               <th colspan="3">JCNo/Description</th>
               <th colspan="1">Credit</th>
               <th colspan="1">Debit</th>
               <th colspan="1">Payment Type</th>
              

           </tr>
       </thead>
       <tbody>
           @php
               $total_collection=0;
               $total_bankcollection=0;
               $total_bank2collection=0;
               $total_cashcollection=0;
               $total_googlepaycollection=0;
               $total_expenses=0;
               $total_bankexpenses=0;
               $total_bank2expenses=0;
               $total_cashexpenses=0;
               $total_googlepayexpenses=0;
           @endphp
           @foreach($amountfrombooking as $transaction)
               <tr>
                   <td colspan="1">{{ $loop->iteration }}</td>
                   @if($transaction->sale_status==0)

                   <td colspan="1">{{Carbon\Carbon::parse($transaction->delivered_date)->format('d-M-Y')}}</td>
                   @if($transaction->return_status==0)
                   <td colspan="3">{{ $transaction->jobcard_prefix }}{{ $transaction->jobcard_no }} </td>
                   @else
                    <td colspan="3">Item Returned - {{ $transaction->jobcard_prefix }}{{ $transaction->jobcard_no }} </td>
                   @endif
                   @elseif($transaction->sale_status==1)
                   <td colspan="1">{{Carbon\Carbon::parse($transaction->created_at)->format('d-M-Y')}}</td>
                   <td colspan="3">RPT{{ $transaction->receipt_no }}</td>
                   @endif
                   <td colspan="1">{{ $transaction->total_amount }}</td>
                   <td colspan="1"> </td>
               <td colspan="1">{{ $transaction->payment_type?$transaction->payment_type:'' }}</td>
                   @php
                   
                       $total_collection= $total_collection+$transaction->total_amount;
                       if($transaction->payment_type=='HDFC-Bank')
                       {
                       $total_bankcollection= $total_bankcollection+$transaction->total_amount;
                       }
                       else if($transaction->payment_type=='AXIS-Bank')
                       {
                       $total_bank2collection= $total_bank2collection+$transaction->total_amount;
                       }
                       else if($transaction->payment_type=='Cash')
                      {
                      $total_cashcollection= $total_cashcollection+$transaction->total_amount;
                      }
                      else{
                        $total_googlepaycollection= $total_googlepaycollection+$transaction->total_amount;
                      }
                     
                     

                  
                   @endphp
                  
               </tr>
           @endforeach
           @foreach($incomecollected as $transaction)
               <tr>
                   <td colspan="1">{{ $loop->iteration }}</td>
                   <td colspan="1">{{Carbon\Carbon::parse($transaction->created_at)->format('d-M-Y')}}</td>
                   <td colspan="3">INCOME - {{ $transaction->incomecategory }}-{{ $transaction->name  }}</td>
                   <td colspan="1">{{ $transaction->amount }}</td>
                   <td colspan="1"> </td>
               <td colspan="1">{{ $transaction->payment_type?$transaction->payment_type:'' }}</td>
                   @php
                   
                       $total_collection= $total_collection+$transaction->amount;
                       if($transaction->payment_type=='HDFC-Bank')
                       {
                       $total_bankcollection= $total_bankcollection+$transaction->amount;
                       }
                       else if($transaction->payment_type=='AXIS-Bank')
                       {
                       $total_bank2collection= $total_bank2collection+$transaction->amount;
                       }
                       else if($transaction->payment_type=='Cash')
                      {
                      $total_cashcollection= $total_cashcollection+$transaction->amount;
                      }
                      else{
                        $total_googlepaycollection= $total_googlepaycollection+$transaction->amount;
                      }
                     
                     

                  
                   @endphp
                  
               </tr>
           @endforeach
           @foreach($amountfromcredit as $transaction)
               <tr>
                   <td colspan="1">{{ $loop->iteration }}</td>
                   <td colspan="1">{{Carbon\Carbon::parse($transaction->created_at)->format('d-M-Y')}}</td>
                   <td colspan="3">PAY AGAINST CREDIT - {{ $transaction->name }}</td>
                   <td colspan="1">{{ $transaction->total_amount }}</td>
                   <td colspan="1"> </td>
               <td colspan="1">{{ $transaction->payment_type?$transaction->payment_type:'' }}</td>
                   @php
                   
                       $total_collection= $total_collection+$transaction->total_amount;
                       if($transaction->payment_type=='HDFC-Bank')
                       {
                       $total_bankcollection= $total_bankcollection+$transaction->total_amount;
                       }
                       else if($transaction->payment_type=='AXIS-Bank')
                       {
                       $total_bank2collection= $total_bank2collection+$transaction->total_amount;
                       }
                       else if($transaction->payment_type=='Cash')
                      {
                      $total_cashcollection= $total_cashcollection+$transaction->total_amount;
                      }
                      else{
                        $total_googlepaycollection= $total_googlepaycollection+$transaction->total_amount;
                      }
                     
                     

                  
                   @endphp
                  
               </tr>
           @endforeach
           @foreach($amountdebited as $transaction)
               <tr>
                   <td colspan="1">{{ $loop->iteration }}</td>
                   <td colspan="1">{{Carbon\Carbon::parse($transaction->created_at)->format('d-M-Y')}}</td>
                   <td colspan="3">EXPENSE : {{ $transaction->expensecategory }}-{{ $transaction->name  }}</td>
                   <td colspan="1"> </td>
                   <td colspan="1">{{ $transaction->amount }}</td>
                
               <td colspan="1">{{ $transaction->payment_type?$transaction->payment_type:'' }}</td>
                   @php
                   
                       $total_expenses= $total_expenses+$transaction->amount;
                       if($transaction->payment_type=='HDFC-Bank')
                       {
                       $total_bankexpenses= $total_bankexpenses+$transaction->amount;
                       }
                       else if($transaction->payment_type=='AXIS-Bank')
                       {
                       $total_bank2expenses= $total_bank2expenses+$transaction->amount;
                       }
                       else if($transaction->payment_type=='Cash')
                      {
                      $total_cashexpenses= $total_cashexpenses+$transaction->amount;
                      }
                      else{
                        $total_googlepayexpenses= $total_googlepayexpenses+$transaction->amount;
                      }
                     
                     

                  
                   @endphp
                  
               </tr>
           @endforeach

         @foreach($purchaseexpenses as $transaction)
             <tr>
                 <td colspan="1">{{ $loop->iteration }}</td>
                 <td colspan="1">{{Carbon\Carbon::parse($transaction->created_at)->format('d-M-Y')}}</td>
                 <td colspan="3">PURCHASE EXPENSE : {{ $transaction->vendor->name }}-{{ $transaction->remarks  }}</td>
                 <td colspan="1"> </td>
                 <td colspan="1">{{ $transaction->amount }}</td>
             <td colspan="1">{{ $transaction->payment_type?$transaction->payment_type:'' }}</td>
                 @php
                 
                     $total_expenses= $total_expenses+$transaction->amount;
                     if($transaction->payment_type=='HDFC-Bank')
                     {
                     $total_bankexpenses= $total_bankexpenses+$transaction->amount;
                     }
                     else if($transaction->payment_type=='AXIS-Bank')
                     {
                     $total_bank2expenses= $total_bank2expenses+$transaction->amount;
                     }
                     else if($transaction->payment_type=='Cash')
                    {
                    $total_cashexpenses= $total_cashexpenses+$transaction->amount;
                    }
                    else{
                      $total_googlepayexpenses= $total_googlepayexpenses+$transaction->amount;
                    }
                   
                   

                
                 @endphp
                
             </tr>
         @endforeach
<tr>
    <td colspan="2" align="right">
        Total Expense
    </td>
        <td colspan="6">
            {{  $total_expenses}} (Cash: {{ $total_cashexpenses }}, HDFC-Bank:{{ $total_bankexpenses }},AXIS-Bank:{{ $total_bank2expenses }}, Google Pay:{{ $total_googlepayexpenses }})
        </td>
</tr>

<tr>
    <td colspan="2" align="right">
        Total  Collection
    </td>
        <td colspan="6">
            {{  $total_collection}} (Cash: {{ $total_cashcollection }}, HDFC-Bank:{{ $total_bankcollection }}, AXIS-Bank:{{ $total_bank2collection }},Google Pay:{{ $total_googlepaycollection }})
        </td>
</tr>
@php
$total_balance=$total_collection-$total_expenses;
$total_cashbalance=$total_cashcollection-$total_cashexpenses;

$total_googlepaybalance=$total_googlepaycollection-$total_googlepayexpenses;
$total_bankbalance=$total_bankcollection-$total_bankexpenses;
$total_bank2balance=$total_bank2collection-$total_bank2expenses;
@endphp
<tr>
    <td colspan="2" align="right">
        Total  Balance
    </td>
        <td colspan="6">
            {{  $total_balance}} (Cash: {{ $total_cashbalance }}, HDFC-Bank:{{ $total_bankbalance }},AXIS-Bank:{{ $total_bank2balance }},Google Pay:{{ $total_googlepaybalance }})
        </td>
</tr>
       </tbody>
   </table>

        



</body>
</html>



   