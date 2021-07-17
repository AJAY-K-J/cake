@extends('layouts.app')
@section('title', 'Invoices | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title"> Today Invoices<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addMakeModal">Add Invoice </button>&nbsp;&nbsp;<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addReturnModal">Sale Return</button></h3>
        
    <section>
            <today-invoices :company_id="{{ json_encode(Input::get('company_id')) }}" :products = "{{ json_encode($products) }}" 
            :companies = "{{ json_encode($companies) }}" :payment_types = "{{ json_encode($payment_types) }}"></today-invoices>
        </section>
    </div>
    <div class="container">
    </div>
        <div class="modal fade" tabindex="-1" role="dialog" id="addReturnModal" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD SALE RETURN</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <return-sale  :products = "{{ json_encode($products) }}" ></return-sale>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addMakeModal" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0" >ADD INVOICE</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-invoice :company_id="{{ json_encode(Input::get('company_id')) }}" :products = "{{ json_encode($products) }}"
                      :companies = "{{ json_encode($companies) }}"   :payment_types = "{{ json_encode($payment_types) }}"></add-invoice>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush