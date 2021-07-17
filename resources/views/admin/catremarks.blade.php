@extends('layouts.app')
@section('title', 'Remarks | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title">Remarks <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addModelModal">Add Remark</button></h3>
        
        <section>
            <catremarks :categories="{{ json_encode($categories) }}"></catremarks>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addModelModal" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD REMARK</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <add-catremark :categories="{{ json_encode($categories) }}"></add-catremark> 


                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush