@extends('layouts.app')
@section('title', 'Return    Report | Admin')

@section('content')
<div class="container-fluid">
    <return-report :deliveries="{{ json_encode($deliveries) }}"></return-report>
</div>
@endsection
