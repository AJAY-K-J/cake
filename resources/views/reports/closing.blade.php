@extends('layouts.app')
@section('title', 'Closing Report | Admin')

@section('content')
<div class="container-fluid">
    <closing-report :payment_types="{{ $payment_types }}"></closing-report>
</div>
@endsection