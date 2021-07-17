@extends('layouts.app')
@section('title', 'Companies | Superadmin')
@section('content')

	<div class="container-fluid">
		<h3 class="title">Companies <button class="btn btn-primary float-right" data-toggle="modal" data-target="#addCompanyModal" onclick="bus.$emit('clear_data')">Add Company</button></h3>
		<section>
			<companies></companies>
		</section>
	</div>
	<div class="container">
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" id="addCompanyModal" data-backdrop="static">
		<div class="modal-dialog mt-5" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title title my-0">ADD COMPANY</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<add-company></add-company>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
<script type="text/javascript">
	
</script>
@endpush