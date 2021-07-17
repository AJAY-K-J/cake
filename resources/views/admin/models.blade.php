@extends('layouts.app')
@section('title', 'Vehicle Models | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title">Models <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addModelModal">Add Model</button></h3>
        
        <section>
            <models :vehiclemakes="{{ json_encode($vehiclemakes) }}"></models>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addModelModal" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD MODEL</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <add-model :vehiclemakes="{{ json_encode($vehiclemakes) }}"></add-model> 


                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush