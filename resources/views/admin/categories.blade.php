@extends('layouts.app')
@section('title', 'Categories | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title">Categories <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addExpenseCategoryModal">Add Category</button></h3>
        
        <section>
            <categories></categories>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addExpenseCategoryModal" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD CATEGORY</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-category></add-category>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush