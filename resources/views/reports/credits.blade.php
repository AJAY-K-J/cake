    @extends('layouts.app')
    @section('title', 'Credit Report | Admin')
    @section('content')

        <div class="container-fluid">
            <h3 class="title">Credit Customer List </h3>
            
            <section>
                <credits></credits>
            </section>
        </div>
     
    @endsection

    @push('scripts')
    @endpush