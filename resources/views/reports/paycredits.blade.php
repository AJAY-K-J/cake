@extends('layouts.app')
@section('title', 'Pay Credit Report | Admin')

@section('content')
<div class="container-fluid">
    <paycredit-report :camp_select="{{ json_encode($deliveries) }}"></paycredit-report>
</div>
@endsection
