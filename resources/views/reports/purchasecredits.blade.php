@extends('layouts.app')
@section('title', 'Purchase Credit List | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title">Purchase Credit List </h3>
        
        <section>
            <purchasecredits :payment_types = "{{ json_encode($payment_types) }}"></purchasecredits>
        </section>
    </div>
 
@endsection

@push('scripts')
@endpush