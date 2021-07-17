@extends('layouts.app')
@section('title', 'Payments | Admin')
@section('content')

	<div class="container-fluid">
		<h3 class="title">Payments <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addPaymentModal">Add Payment</button><a href="{{ URL::previous() }}" class="btn btn-primary float-right">
          Back   
        </a>
        </h3>
		
		<section>
			<rec_payments :sale="{{ $sale }}" :payment_types="{{ $payment_types }}"></rec_payments>
		</section>
	</div>
	<div class="container">
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" id="addPaymentModal" data-backdrop="static">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title title my-0">Add Payment</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<add-rec_payment :sale="{{ $sale }}" :payment_types="{{ $payment_types }}"></add-rec_payment>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
<script type="text/javascript">
	
</script>
@endpush