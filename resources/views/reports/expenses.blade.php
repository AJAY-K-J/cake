@extends('layouts.app')
@section('title', 'Expense Report | Admin')

@section('content')

<div class="container-fluid">
    <expense-report :expensecategories="{{ json_encode($expensecategories) }}" :company_id="{{ json_encode(Input::get('company_id')) }}" ></expense-report>
</div>
@endsection
