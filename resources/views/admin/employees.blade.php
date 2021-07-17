@extends('layouts.app')
@section('title', 'Employees| Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title">Employees <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addMakeModal">Add Employee</button></h3>
        
        <section>
            <employees :designations="{{ json_encode($designations) }}" ></employees>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addMakeModal" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD EMPLOYEE</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-employee :designations="{{ json_encode($designations) }}"></add-employee>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush