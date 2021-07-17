@extends('layouts.app')
@section('title', 'Campaigns | Admin')

@section('content')
	<div class="container-fluid">
        <?php 
        use App\Http\Controllers\SMS;
        $api= Auth::user()->company->sms->api;
        $balance = SMS::getBalance($api) + Auth::user()->company->sms->buffer;?>
		<h3 class="title">CAMPAIGNS<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addCampaignModal">Add Campaign</button></h3>
        <h4 class="title" > <font color="red"> Balance SMS: {{ $balance }}</font></h5>

		<section>
			<campaigns 
                :campaign_types= {{ json_encode(config('custom.campaign_types')) }} 
                :services      = "{{ json_encode($services) }}">
            </campaigns>
		</section>
	</div>
	<div class="container">
	</div>
	<div class="modal fade" tabindex="-1" role="dialog" id="addCampaignModal" data-backdrop="static">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title title my-0">ADD CAMPAIGN</h3>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<add-campaign :services="{{ json_encode($services) }}" :campaign_types="{{ json_encode(config('custom.campaign_types')) }}"></add-campaign>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
<script type="text/javascript">
	
</script>
@endpush