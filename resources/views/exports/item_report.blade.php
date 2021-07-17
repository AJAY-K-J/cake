<table>
    <thead>
        <tr>
            <th>Slno</th>
            <th>Item</th>
            <th>Date</th>
            <th>Qty</th>
            <th>Status</th>
            <th>Purchase NO/Invoice NO</th>
            <th>Vendor Name</th>
        </tr>
    </thead>
    <tbody>
       
        @foreach($updations as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data['product']}}</td>
                <td>{{Carbon\Carbon::parse($data['created_at'])->format('d-M-Y h:i:s')}}</td>
                <td>{{ $data['qty'] }}</td>
                
                <td>{{ $data['status'] }}</td>
                <td>{{ $data['invoice'] }}</td>
                <td>{{ $data['customer'] }}</td>
            </tr>  
        @endforeach
    </tbody>
</table>