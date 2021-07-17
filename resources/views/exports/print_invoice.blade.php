<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
       
        <title>Invoice</title>
    </head>

    <style type="text/css">
      * {
    font-size: 12px;
    font-family: 'Times New Roman';
}

td,
th,
tr,
table {
   
    border-collapse: collapse;
}
table.test {
   
    border-collapse: collapse;
}
td.description,
th.description {
    width: 75px;
    max-width: 75px;
}

td.quantity,
th.quantity {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

td.price,
th.price {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
}

.centered {
    text-align: center;
    align-content: center;
}

.right {
    text-align: right;
    align-content: right;
}

.ticket {
    width: 200px;
    max-width: 200px;
}

img {
    max-width: inherit;
    width: inherit;
}

@media print {
    .hidden-print,
    .hidden-print * {
        display: none !important;
    }
}

      
    </style>
    <body>
        <div class="ticket">
            
         
               
            <table>
                <tr>
                <td colspan="4" align="center"> CAKE BOX INN
                </td>
            </tr>
            <tr>
                 <td colspan="4" align="center"> YMCA CROSS ROAD
                </td>
            </tr>
                <tr>
                 <td colspan="4" align="center"> KERALA - 673011
                </td>
            </tr>
            <tr>
                 <td colspan="4" align="center"> Ph: 8891 87 84 24
                </td>
            </tr>
            </tr>
            <tr>
                 <td colspan="4" align="center">  GST No: 32ATMPM6185B2ZO
                </td>
            </tr>
               


                    <tr>
                        <td colspan="2"> Customer</td>
                        <td colspan="2"> {{$invoice->name}}</td>
                    </tr>
                    <tr>
                        <td colspan="2"> Mobile </td>
                        <td  colspan="2"> {{$invoice->mobile}}</td>
                    </tr>
                     <thead>
                    <tr>
                        
                        <th class="description">Item</th>
                        <th class="quantity">Q.</th>
                        <th class="price">Rate</th>
                         
                        <th class="price">Total</th>
                    </tr>
                </thead>

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
                        $netqty=0;
                        $i=0;
                        $count=0;
                    @endphp
                <tbody>

                    @foreach($invoice->items as $item) 
                    <tr>
                      @if($item->gst_percentage) 

                        <td class="description">{{ $item->product }}-{{$item->gst_percentage}}% GST </td>

                      @else

                        <td class="description">{{ $item->product }}</td>

                      @endif
                 
                 
                   <td class="quantity">{{ $item->qty }}</td>
                   
                   @php             
                       $netrate =  $netrate+$item->amount;
                       $netqty=$netqty+$item->qty;
                       $cgstrate= $cgstrate+$item->cgst;
                       $sgstrate= $sgstrate+$item->sgst;
                       $igstrate= $igstrate+$item->igst;
                       $cessrate= $cessrate+$item->cess;
                       $tax=$item->sgst+$item->cgst+$item->igst+$item->cess ;
                       $totaltaxrate=$totaltaxrate+ $tax;
                       $totalnetamount= $totalnetamount+$item->net_amount;
                       $count=$count+1;
                   @endphp

                    <td class="price">{{ $item->rate}}</td>
                   
                    <td class="price">{{ $item->amount }}</td>

                    </tr>
                    @endforeach
                    
                    <td class="description">Total</td>
                 
                    <td class="quantity">{{ $netqty }}</td>
                     <td class="price"></td>
                     
                    <td class="price">{{ $totalnetamount }}</td>
                 
                    
                </tbody>
            </table>
            @if($totaltaxrate)
            <p class="left">Total GST : {{$totaltaxrate}}</p>
            @endif

             <p class="right"> <b>Total Amount : {{$totalnetamount}} </b></p>
            <p class="centered">Thanks for your purchase!</p>
                
        </div>
        
    </body>
</html>