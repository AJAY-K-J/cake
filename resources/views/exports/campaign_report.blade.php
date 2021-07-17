<table>
	<thead>
		<tr>
			<th>Sl No</th>
			<th>Campaign Name</th>
			<th>Code</th>
			<th>Period</th>
			<th>Participation Count</th>
			<th>Total Amount</th>
			<th>Redeem Amount</th>
			<th>Balance</th>
		</tr>
	</thead>
	<tbody>
		@foreach($campaigns as $campaign)
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $campaign->name }}</td>
				<td>{{ $campaign->code }}</td>
				<td>{{ $campaign->period }}</td>
				<td>{{ $campaign->total_bookings }}</td>
				<td>{{ $campaign->amount?$campaign->amount:"NA" }}</td>
				<td>{{ $campaign->total_redeemed }}</td>
				<td>{{ $campaign->amount?$campaign->amount - $campaign->total_redeemed:"NA" }}</td>
			</tr>
		@endforeach
	</tbody>
</table>