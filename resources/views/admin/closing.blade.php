@extends('layouts.app')
@section('title', 'Counter Cash| Admin')
@section('content')
<div class="container-fluid">
   <h2>Set Counter Cash <a class="float-right"><?php $date = date("d-m-Y")   ?> {{ $date }}</a></h2>
</div>
<div class="container-fluid">
   <section>
   		<accoption :payment_types = "{{ json_encode($payment_types) }}" :collections = "{{ json_encode($collections) }}" :expenses = "{{ json_encode($expenses) }}"></accoption>
   </section>
</div>
	
 
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>
@endpush