@extends('layouts.app')
@section('title', 'Invoice Report | Admin')

@section('content')

<div class="container-fluid">
    <invoice-report :companies="{{ json_encode($companies) }}" ></invoice-report>
</div>
@endsection
