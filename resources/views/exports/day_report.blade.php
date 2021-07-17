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
<h4>DATE: {{$details['date']}} </h4>
<table  id="receipt_table" class="table" style="width:100%" cellspacing="0" cellpadding="1" border="0">
    <thead>
        <tr>
            <th colspan="3">SUMMERY</th>
        </tr>
    </thead>
    <tbody>
        @if($details['opening_balance']=='0.00')
          <tr>
            <td width="100%"><span>Opening Blanace Not Found!!!</span></td>
            <td></td>
            <td></td>
         </tr>
        @else   
          <tr>
           <td width="40%">Opening</td>
           <td width="30%">
           @foreach($details['openings'] as $type) 
           {{ $type['type'] }} : {{ $type['amount'] }} &nbsp;
           @endforeach 
            </td>
           <td width="30%"><b>{{ $details['opening_balance']}}</b></td>
         </tr>
         <tr>
           <td>Collection</td>
           <td>
           @foreach($details['collections'] as $type) 
           {{ $type['type'] }} : {{ $type['amount'] }} &nbsp;
           @endforeach    
           </td>
           <td><b>{{ $details['total_coll']}}</b></td>
         </tr>
         <tr>
           <td>Expense</td>
           <td>
           @foreach($details['expense'] as $type) 
           {{ $type['type'] }} : {{ $type['amount'] }} &nbsp;
           @endforeach   
           </td>
           <td><b>{{ $details['total_exp'] }}</b></td>
         </tr>
         
         <tr>
           <td>Balance Amount</td>
           <td>
           @foreach($details['balances'] as $type) 
           {{ $type['type'] }} : {{ $type['amount'] }} &nbsp;
           @endforeach   
           </td>
           <td><b>{{ $details['balance_amount'] }}</b></td>
         </tr>
         
        @endif 
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
                 <td width="30%"><b>{{ $details['sales'] }}</b></td>
               </tr>
                
              
               
               <tr>
                 <td>Invoice Total Discount</td>
                 <td><b>{{ $details['sale_total_discount']  }}</b></td>
               </tr>
               <tr>
                 <td>Invoice Total Amount</td>
                 <td><b>{{ $details['sale_total_amount']  }}</b></td>
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
                 <td width="30%"><b>{{ $details['expenses'] }}</b></td>
               </tr>
             @if($details['cats']!='')
              @foreach($details['cats'] as $detail)    
               <tr>
                 <td>{{ $detail['name'] }}</td>
                 <td><b>{{ $detail['amount'] }}</b></td>
               </tr>
              @endforeach 
             @endif 
               <tr>
                 <td>Sale Total Amount</td>
                 <td><b>{{ $details['exp_total_amount'] }}</b></td>
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
             @if($details['parts'])  
              @foreach($details['parts'] as $part)    
               <tr>
                 <td>{{ $part['name'] }}</td>
                 <td>{{ $part['qty'] }}</td>
                 <td>{{ $part['amount'] }}</td>
               </tr>
              @endforeach 
            @endif  
              
    </tbody>
     <tfoot>
                <tr>
                 <td>Total</td>
                 <td><b>{{ $details['item_total_qty'] }}</b></td>
                 <td><b>{{ $details['item_total_amount'] }}</b></td>
                </tr> 
               </tfoot>

</table>