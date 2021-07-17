@extends('layouts.app')
@section('title', 'Pay Credit Report | Admin')

@section('content')
<div class="container-fluid">
    <payvendorcredit-report :camp_select="{{ json_encode($deliveries) }}"></payvendorcredit-report>
</div>
@endsection
