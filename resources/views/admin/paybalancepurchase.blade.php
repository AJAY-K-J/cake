@extends('layouts.app')
@section('title', 'Pay Balance Details | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title">BALANCE PAYMENT PURCHASE DETAILS </h3>
        
        <section>
            <pay-balance-purchase :purchases="{{ json_encode($purchases) }}"></pay-balance-purchase>
        </section>
   
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush