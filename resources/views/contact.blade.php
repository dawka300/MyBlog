@extends('layouts.app-fronted')

@section('content')
    <section class="site-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>Napisz do mnie</h1>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">

                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="name">Imię i nazwisko</label>
                                <input type="text" id="name" class="form-control ">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="phone">Nr telefonu</label>
                                <input type="text" id="phone" class="form-control ">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control ">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="message">Wiadomość</label>
                                <textarea name="message" id="message" class="form-control " cols="30" rows="8"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="submit" value="Wyślij wiadomość" class="btn btn-primary">
                            </div>
                        </div>
                    </form>


                </div>

               @include('inc.sidebar')





            </div>
        </div>
    </section>
@endsection
