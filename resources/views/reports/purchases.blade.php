@extends('layouts.app')
@section('title', 'Purchses Report | Admin')

@section('content')

<div class="container-fluid">
    <purchase-report :vendors="{{ json_encode($vendors) }}" :company_id="{{ json_encode(Input::get('company_id')) }}" ></purchase-report>
</div>
@endsection
