<table>
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Date</th>
            <th>Expense Category</th>
            <th>Expense Description</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($expenses as $expense)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{Carbon\Carbon::parse($expense->created_at)->format('d-M-Y H:i:s')}}</td>
                <td>{{ $expense->expensecategory }}</td>
                <td>{{ $expense->name }}</td>
                <td>{{ $expense->amount }}</td>
            </tr>
        @endforeach
    </tbody>
</table>