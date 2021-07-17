@extends('layouts.app')
@section('title', 'Jobcards | Admin')

@section('content')
    <div class="container-fluid">
               <?php 
               use App\Http\Controllers\SMS;
               use Illuminate\Support\Facades\Input;
               $api= Auth::user()->company->sms->api;
               $balance = SMS::getBalance($api) + Auth::user()->company->sms->buffer;

              $company_id=Input::has('company_id');
              $company=DB::table('companies')->where('id','=',$comp_id)->first();
              $company_name=$company?$company->name:'';
                       ?>
            @if(!$company_id)
            @if(Auth::user()->company->type ==2)
               <h4 class="title" > <font color="red"> Balance SMS: {{ $balance }}</font></h4>
        <h3 class="title">JOBCARDS<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addRecoveryModal">Add Recovery</button><button class="btn btn-primary float-right" data-toggle="modal" data-target="#addBookingModal">Add Jobcard</button></h3>
        @else
               <h4 class="title" > <font color="red"> Balance SMS: {{ $balance }}</font></h4>
        <h3 class="title">JOBCARDS<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addBookingModal">Add Jobcard</button></h3>
        @endif
            @elseif($company_id)
               <h3 class="title"> <font color="red"> {{ $company_name }}</font></h3>
        
        @endif
      
       
        <section>
            <jobcards 
                :services = "{{ json_encode($services) }}" :vehiclemakes="{{ json_encode($vehiclemakes)  }}" :technicians="{{ json_encode($technicians) }}" :jobadvisors="{{ json_encode($jobadvisors) }}" :company_id="{{ json_encode(Input::get('company_id')) }}" :categories="{{ json_encode($categories) }}" :products="{{ json_encode($products) }}">
            </jobcards>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addBookingModal" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD JOBCARD</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-jobcard :services="{{ json_encode($services) }}" :technicians="{{ json_encode($technicians) }}" :jobadvisors="{{ json_encode($jobadvisors) }}" :vehiclemakes="{{ json_encode($vehiclemakes) }}" :categories="{{ json_encode($categories) }}" :company_id="{{ json_encode(Input::get('company_id')) }}" :products="{{ json_encode($products) }}"></add-jobcard>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="addRecoveryModal" data-backdrop="static">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD JOBCARD</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-recovery :services="{{ json_encode($services) }}" :technicians="{{ json_encode($technicians) }}" :jobadvisors="{{ json_encode($jobadvisors) }}" :vehiclemakes="{{ json_encode($vehiclemakes) }}" :categories="{{ json_encode($categories) }}" :company_id="{{ json_encode(Input::get('company_id')) }}" :products="{{ json_encode($products) }}"></add-recovery>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>

@endpush