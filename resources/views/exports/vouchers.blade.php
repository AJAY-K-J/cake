<!DOCTYPE html>
<html>
<head>
	<title>Vouchers</title>
	<style>
	@page {
		margin: 0px;
	}
	body {
		margin: 0;
	}

	table tr td {
		width: 13.5cm;
		height: 9.05cm;
		border-spacing: 0;
		border-collapse: separate;
		vertical-align: middle;
		padding: 20px;
		/*background-image: url('{{ asset('images/am_logo.png') }}');
		background-repeat: no-repeat;
		background-position: 95% 0.5cm;*/
		text-align: left;
		position: relative;
	}

	td:first-child{
		border-right:1px solid #eee;
	}

	tr:nth-child(odd) td{
		border-bottom: 1px solid #eee;
	}

	.page-break{
		page-break-after: always;
	}

	.logo {
		position: absolute;
		max-width: 150px;
		max-height: 50px;
		object-fit: contain;
		object-position: top right;
		right: 5px;
		top: 5px;
	}

</style>

</head>

<body>
	@foreach ($messages as $message)
	@if($loop->iteration % 4 == 1)
	<table>
		<tbody>
			@endif
			@if($loop->iteration % 2 != 0 || $loop->first)
			<tr>
				@endif
				<td>

					<img src="{{ asset('storage/'.$logo) }}" class="logo">
					{!! str_replace(' ', '&nbsp;', nl2br($message['template'])) !!}
				</td>
				@if($loop->iteration % 2 == 0 || $loop->last)
					@if($loop->count%2 != 0 && $loop->last)
						<td>&nbsp;</td>
					@endif
			</tr>
			@endif
			@if($loop->iteration % 4 == 0)
		</tbody>
	</table>
	<div class="page-break"></div>
	@endif
	@endforeach
</body>
</html>