@extends('layouts.app')
@section('title', 'Purchase Vendors | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title">Purchase Vendors <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addExpenseCategoryModal">Add Purchase Vendor</button></h3>
        
        <section>
            <vendors></vendors>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addExpenseCategoryModal" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD PURCHASE VENDOR</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-vendor></add-vendor>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush