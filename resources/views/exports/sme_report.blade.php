<table>
	<tr>
		<td colspan="6" style="text-align: center;"><b>SME REPORT - {{ $date }}</b></td>
	</tr>
	<tr>
		<td>Name</td>
		<td>Booking Count</td>
		<td>Conversion Count</td>
		<td>Conversion %</td>
	</tr>
	@foreach($smes as $sme)
	<tr>
		<td>{{ $sme->name }}</td>
		<td>{{ $sme->bookings }}</td>
		<td>{{ $sme->redeemed }}</td>
		<td>{{ $sme->bookings ? round($sme->redeemed/$sme->bookings*100,2) : '0.00' }}%</td>
	</tr>
	@endforeach
</table>