@extends('layouts.app')
@section('title', 'Sales | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title"> Today Sales <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addMakeModal">Add Sale</button></h3>
        
    <section>
            <today-sales :company_id="{{ json_encode(Input::get('company_id')) }}" :products = "{{ json_encode($products) }}" :payment_types = "{{ json_encode($payment_types) }}"></today-sales>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addMakeModal" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0" >ADD SALE</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-sale :company_id="{{ json_encode(Input::get('company_id')) }}" :products = "{{ json_encode($products) }}" :payment_types = "{{ json_encode($payment_types) }}"></add-sale>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush