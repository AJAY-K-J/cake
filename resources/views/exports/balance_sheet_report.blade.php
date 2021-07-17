

<table>
    <thead>
        <tr>
            <td colspan="6" style="text-align: center;font-size: 20px;"><b>Opening Balance : {{ $bal }}</b></td>
        </tr>
     
        <tr>
            <th>Sl No</th>
            <th>Date</th>
            <th>JCNo/Description</th>
            <th>Credit</th>
            <th>Debit</th>
            <th>Payment Type</th>
            <th>Balance</th>

        </tr>
    </thead>
    <tbody>
        @php
            $amount=$bal;
        @endphp
        @foreach($transactions as $transaction)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{Carbon\Carbon::parse($transaction->transaction_date)->format('d-M-Y H:i:s')}}</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ $transaction->credit?$transaction->credit:'' }}</td>
                <td>{{ $transaction->debit?$transaction->debit:'' }}</td>
            <td>{{ $transaction->payment_type?$transaction->payment_type:'' }}</td>
                @php
                if($transaction->credit) {
                    $amount= $amount+$transaction->credit;
                   }
                  
                   if($transaction->debit){
                    $amount= $amount-$transaction->debit;
                   }

               
                @endphp
                <td>{{ $amount  }}</td>
            </tr>
        @endforeach
    </tbody>
</table>