@extends('layouts.app')
@section('title', 'Item Report | Admin')

@section('content')

<div class="container-fluid">
    <item-report :products="{{ json_encode($products) }}"></item-report>
</div>
@endsection

