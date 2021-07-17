@extends('layouts.app')
@section('title', 'Students | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title">Students <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addStudent">Add Student</button></h3>
        
        <section>
            <students></students>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addStudent" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD STUDENT</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-student></add-student>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush