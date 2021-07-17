 @extends('layouts.app')
@section('title', 'Sale Credit Report | Admin')
@section('content')

    <div class="container-fluid">
        <h3 class="title">Sale Credit Receipt List </h3>
        
        <section>
            <sale_credits :total_balance="{{ json_encode($total_balance) }}"></sale_credits>
        </section>
    </div>
 
@endsection

@push('scripts')
@endpush