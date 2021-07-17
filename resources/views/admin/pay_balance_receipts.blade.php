@extends('layouts.app')
@section('title', 'Pay Balance Receipts| Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title">BALANCE PAYMENT RECEIPT REPORT </h3>
        
        <section>
            <pay-balance-receipt :total_balance="{{ json_encode($total_balance) }}"></pay-balance-receipt>
        </section>
    
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-2.2.4.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(window).bind("pageshow", onload=function(){
  var e=document.getElementById("refreshed");
   if(e.value=="no")e.value="yes";
      else{e.value="no";location.reload();}

});
    
</script>
@endpush