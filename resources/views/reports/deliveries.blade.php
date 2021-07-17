@extends('layouts.app')
@section('title', 'Delivery Report | Admin')

@section('content')
<div class="container-fluid">
    <delivery-report :camp_select="{{ json_encode($deliveries) }}" :company_id="{{ json_encode(Input::get('company_id')) }}" ></delivery-report>
</div>
@endsection
