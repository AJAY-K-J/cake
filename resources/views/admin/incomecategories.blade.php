@extends('layouts.app')
@section('title', 'Income Categories | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title">Income Categories <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addExpenseCategoryModal">Add Income Category</button></h3>
        
        <section>
            <incomecategories></incomecategories>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addExpenseCategoryModal" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD INCOME CATEGORY</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-incomecategory></add-incomecategory>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush