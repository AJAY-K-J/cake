@extends('layouts.app')
@section('title', 'Redeem | Service')
@section('content')
	<div class="container-fluid">
		<redeem :services="{{ json_encode($services) }}"></redeem>
		
	</div>
@endsection

@push('scripts')
<script type="text/javascript">
	
</script>
@endpush