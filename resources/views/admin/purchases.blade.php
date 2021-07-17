@extends('layouts.app')
@section('title', 'Purchase Credits | Admin')

@section('content')
    <div class="container-fluid">
       
     
        <h3 class="title">Today Purchases<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addExpenseModal">Add Entry</button>&nbsp;&nbsp;<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addReturnModal">Return</button></h3>
       
        <section>
            <purchases :vendors = "{{ json_encode($vendors) }}" :products = "{{ json_encode($products) }}" :payment_types = "{{ json_encode($payment_types) }}">
            </purchases>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addReturnModal" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD RETURN</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <return-purchase :vendors = "{{ json_encode($vendors) }}" :products = "{{ json_encode($products) }}" ></return-purchase>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addExpenseModal" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD Entry</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-purchase :vendors = "{{ json_encode($vendors) }}" :products = "{{ json_encode($products) }}" :payment_types = "{{ json_encode($payment_types) }}"></add-purchase>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>

@endpush