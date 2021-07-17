<table>
	<tr>
		<td colspan="6" style="text-align: center;font-size: 20px;"><b>{{ $employee->name }} - SME REPORT - {{ $date }}</b></td>
	</tr>
	<tr>
		<td>Name</td>
		<td>RegNo</td>
		<td>Mobile</td>
		<td>Campaign</td>
		<td>Added Date</td>
		<td>Redeemed Date</td>
	</tr>
	@foreach($customers as $customer)
	<tr>
		<td>{{ $customer->name }}</td>
		<td>{{ $customer->reg_no }}</td>
		<td>{{ $customer->mobile }}</td>
		<td>{{ $customer->campaigns ? $customer->campaigns->name : '' }}</td>
		<td>{{ $customer->added_date ? DATE('d-m-Y', strtotime($customer->added_date)) : '' }}</td>
		<td>{{ $customer->redeem_date ? DATE('d-m-Y', strtotime($customer->redeem_date)) : '' }}</td>
	</tr>
	@endforeach
</table>