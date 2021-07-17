<table>
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Customer Voice</th>
            <th>Make</th>
            <th>Model</th>
            <th>Serial No</th>
            <th>Jobcard no</th>
            <th>Amount</th>
            <th>Discount Amount</th>
            <th>Total Amount</th>
            <th>Payment Type</th>
            
        </tr>
    </thead>
    <tbody>

        @php

        $total_labour=0;
        $total_spare=0;
        $total_discount=0;
        $total=0;

        @endphp
        @foreach($deliveries as $delivery)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $delivery->name }}</td>
                <td>{{ $delivery->mobile }}</td>
                <td>{{ $delivery->customer_voice?$delivery->customer_voice:"NA" }}</td>
                <td>{{ $delivery->make }}</td>
                @if($delivery->recovery==0)
                <td>{{ $delivery->model }}</td>
                <td>{{ $delivery->serial_no }}</td>
                @else
                <td>{{ $delivery->item_type }}</td>
                <td>{{ $delivery->item_size }}</td>
                @endif

                <td>JC000{{ $delivery->jobcard_no}}</td>
                <td>{{ $delivery->spare_amount?$delivery->spare_amount:'0' }}</td>
                <td>{{ $delivery->discount?$delivery->discount:'0' }}</td>
                <td>{{ $delivery->total_amount }}</td>
                <td>{{ $delivery->payment_type }}</td>
               
            </tr>

            @php
            if((int)$delivery->labour_amount>0)
            $total_labour= $total_labour+(int)$delivery->labour_amount;
            if((int)$delivery->spare_amount>0)
            $total_spare= $total_spare+(int)$delivery->spare_amount;
            if((int)$delivery->discount>0)
            $total_discount= $total_discount+(int)$delivery->discount;


            @endphp
        @endforeach

        @php
            $total = $total_labour+ $total_spare-$total_discount;

        @endphp

        <tr>
            <td colspan="10" align="right">Total Spare</td>
            <td colspan="2"><b>{{ $total_spare}}</b></td>
        

        </tr>
        <tr>
            <td colspan="10" align="right">Total Labour</td>
            <td colspan="2"><b>{{ $total_labour}}</b></td>
        

        </tr>
        <tr>
            <td colspan="10" align="right"> Total Discount</td>
            <td colspan="2"><b>{{ $total_discount}}</b></td>
        

        </tr>
        <tr>
            <td colspan="10" align="right">Total </td>
            <td colspan="2"><b>{{ $total}}</b></td>
        

        </tr>
    </tbody>
</table>