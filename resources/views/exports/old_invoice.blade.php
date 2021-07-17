<!DOCTYPE html>
<html>
<head>
<title>Receipt Print</title>   
<style type="text/css">
  @page {
  margin: 10px 20px 15px 25px;
}
   td{
      border:1px solid #000;
      font-size: 13px;
   }
   th{
      border:1px solid #000;
      font-size: 13px;
   }
   .logo {
    width: 40%;
    
  }
</style>
</head>
<body>

<!-- <div style="text-align: center;
    vertical-align: middle;font-size: 20px;">
   <b >RECEIPT </b> 
</div> -->
<div style="text-align: left;">
<h3 style="background: #fff; margin:0px 0 0 0; padding: 5px 0px; color: #000; font-size:12px; text-align: center;border-radius: 4px;"> <span style="   font-weight: 300;  font-size: 30px;"> CAKE BOX INN  </span><br> AYDEED COMPLEX, YMCA CROSS ROAD <br> CALICUT, KERALA - 673011 <br>8891 87 84 24 , 9847 86 82 82 <br> GST No: 32ATMPM6185B2ZO </h3>
</div>
<span style="margin-left: 215px ">Time :{{Carbon\Carbon::parse($receipt->created_at)->format('h:i:s')}} </span>

<table class="table table-bordered"  width="80mm;" border="1" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;text-align: left;">
   <tbody>
   <thead>
      <tr>
         <td colspan="8" style="text-align: center;"><b>INVOICE VOUCHER</b></td>
      </tr>

      <tr>
         <th scope="col" colspan="1" style="width:10%;">Date</th>
         <th scope="col" colspan="2" style="width:35%;">{{Carbon\Carbon::parse($invoice->invoice_date)->format('d-M-Y')}}</th>
         <th scope="col" colspan="2" style="width:33%;">Invoice No</th>
         <th scope="col" colspan="3" style="width:22%;">CB/{{$invoice->invoice_no}}/20-21</th>
      </tr>
       <!-- <tr style="background: #999; color: #fff;">
          <th scope="col" colspan="2">Code No</th>
          <th scope="col" colspan="2">12345</th>
          <th scope="col" colspan="2">Name</th>
          <th scope="col" colspan="2" style="width: 50%">{{ $user->name }}</th>
       </tr> -->
       <tr>
          <th scope="col" colspan="3" style="width: 50%">For Customer</th>
          <th scope="col" colspan="5" style="width: 50%">{{$invoice->name}}</th>
       </tr>
      @php
        $netrate =  0;
        $sgstrate= 0;
        $cgstrate= 0;
        $igstrate= 0;
        $cessrate= 0;
        $totaltaxrate=0;
        $totalnetamount=0;

         $lab_netrate =  0;
        $lab_sgstrate= 0;
        $lab_cgstrate= 0;
        $lab_igstrate= 0;
        $lab_cessrate= 0;
        $lab_totaltaxrate=0;
        $lab_totalnetamount=0;

        $i=0;
        $count=0;
      @endphp
  
       <tr>
          <th scope="col" colspan="2" style="width: 25%">Item</th>
         
           <th scope="col" colspan="2" style="width: 25%">Qty</th>
            <th scope="col" colspan="2" style="width: 25%">Tax</th>
             <th scope="col" colspan="2" style="width: 25%">Total</th>
          
       </tr>
     
    @foreach($invoice->items as $item) 
      <tr>
          <td scope="col" colspan="2" style="width: 25%">{{ $item->product }}</td>
         
           <td scope="col" colspan="2" style="width: 25%">{{ $item->qty }}</td>
           @php             
           $netrate =  $netrate+$item->amount;
           $cgstrate= $cgstrate+$item->cgst;
           $sgstrate= $sgstrate+$item->sgst;
           $igstrate= $igstrate+$item->igst;
           $cessrate= $cessrate+$item->cess;
           $tax=$item->sgst+$item->cgst+$item->igst+$item->cess ;
           $totaltaxrate=$totaltaxrate+ $tax;
           $totalnetamount= $totalnetamount+$item->net_amount;
           $count=$count+1;
           @endphp

            <td scope="col" colspan="2" style="width: 25%">{{ $tax}}</td>
             <td scope="col" colspan="2" style="width: 25%">{{ $item->net_amount }}</td>
          
       </tr>
       @endforeach
     
     @for ($i =0; $i <= (5-$count)*5; $i++)
     <tr>                
       <td colspan="2" style="border-top: none; border-bottom: none;"></td>
      <td colspan="2" style="border-top: none; border-bottom: none;"></td>
       <td colspan="2"  style="border-top: none; border-bottom: none;"></td>
      <td colspan="2" style="border-top: none; border-bottom: none;"></td>

    </tr>

    @endfor
       <tr>
          <th scope="col" colspan="3" style="width: 50%">Total Amount </th>
         
           <th scope="col" colspan="5" style="width: 50%">{{ $totalnetamount }}</th>
          
       </tr>
        <tr>
          <th  colspan="3">Total Tax </th>
          <th  colspan="5">{{ $totaltaxrate }}</th>
       </tr>
      
  
     
   </tbody>
</table>  

<style type="text/css">
  td{
    padding: 10px;
  }
  th{
    padding: 5px;
  }
</style>

   </body>
</html>
