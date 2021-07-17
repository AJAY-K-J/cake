@extends('layouts.app')
@section('title', 'Campaign Report | Admin')

@section('content')
<div class="container-fluid">
	<campaigns-report :camp_select="{{ json_encode($camp_select) }}"></campaigns-report>
</div>
@endsection
