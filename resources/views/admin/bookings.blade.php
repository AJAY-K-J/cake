@extends('layouts.app')
@section('title', 'Bookings | Admin')

@section('content')
    <div class="container-fluid">
        <?php 
        use App\Http\Controllers\SMS;
        $api= Auth::user()->company->sms->api;
        $balance = SMS::getBalance($api) + Auth::user()->company->sms->buffer; ?>
        <h3 class="title">BOOKINGS<button class="btn btn-primary float-right" data-toggle="modal" data-target="#addBookingModal">Add Booking</button></h3>
        <h4 class="title" > <font color="red"> Balance SMS: {{ $balance }}</font></h5>
        <section>
            <bookings 
                :services = "{{ json_encode($services) }}">
            </bookings>
        </section>
    </div>
    <div class="container">
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="addBookingModal" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title title my-0">ADD BOOKING</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <add-booking :services="{{ json_encode($services) }}" :vehiclemakes="{{ json_encode($vehiclemakes) }}"></add-booking>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script type="text/javascript">
    
</script>

@endpush