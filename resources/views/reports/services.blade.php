@extends('layouts.app')
@section('title', 'Service Report | Admin')

@section('content')
<div class="container-fluid">
	<services-report :service_selct="{{ json_encode($service_selct) }}"></services-report>
</div>
@endsection