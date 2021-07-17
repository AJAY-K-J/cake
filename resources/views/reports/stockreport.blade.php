@extends('layouts.app')
@section('title', 'Stock Report| Admin')
@section('content') 
<div class="container-fluid">
    <h3 class="title">STOCKS</h3> 
         <br>
   <section>
            <stock-report  :vendors = "{{ json_encode($vendors) }}"></stock-report>
        </section>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush