@extends('layouts.app-fronted')

@section('content')
    <section class="site-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>Dowcipy</h1>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    @foreach($jokes as $joke)




                </div>

               @include('inc.sidebar')





            </div>
        </div>
    </section>
@endsection
