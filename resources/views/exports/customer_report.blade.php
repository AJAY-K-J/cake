<table>
    <thead>
        <tr>
           
            <th>NAME</th>
            <th>REGNO</th>
            <th>MOBNO</th>
            <th>TYPE</th>
        </tr>
    </thead>

    <tbody>
        @foreach($deliveries as $delivery)
            <tr>
               
                <td>{{ $delivery->name }}</td>
                <td>{{ $delivery->reg_no }}</td>
                <td>{{ $delivery->mobile }}</td>
                @if($delivery->type=='0')
                <td>{{ "CAMPAIGN" }}</td>
            @else
            <td>{{ "BOOKING" }}</td>
            @endif
            
            </tr>
        @endforeach
    </tbody>
</table>