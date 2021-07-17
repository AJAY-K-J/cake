@extends('layouts.app')
@section('title', 'Sale Order | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title"> Today Sale Orders <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addMakeModal">Add Sale Order </button></h3>
        
    <section>
            <today-sale_orders :company_id="{{ json_encode(Input::get('company_id')) }}" :products = "{{ json_encode($products) }}" 
            :rubbers = "{{ json_encode($rubbers) }}"   :companies = "{{ json_encode($companies) }}"  :payment_types = "{{ json_encode($payment_types) }}"></today-sale_orders>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addMakeModal" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0" >ADD SALE ORDER</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-sale_order :company_id="{{ json_encode(Input::get('company_id')) }}" :products = "{{ json_encode($products) }}" :rubbers = "{{ json_encode($rubbers) }}"   :companies = "{{ json_encode($companies) }}"  :payment_types = "{{ json_encode($payment_types) }}"></add-sale_order>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush