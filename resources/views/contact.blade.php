@extends('layouts.app-fronted')

@section('content')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @include('inc.error')
    <section class="site-section">
        @if(Session::has('success-mail'))
            <div class="alert alert-success">
                <p>{{Session::get('success-mail')}}</p>
            </div>
        @endif
        @if(Session::has('fail-mail'))
            <div class="alert alert-danger">
                <p>{{Session::get('fail-mail')}}</p>
            </div>
        @endif
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>Napisz do mnie</h1>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <div class="col-12 mb-4">
                        <p><strong>Mój adres mailowy: </strong><a id="mailShow" href="javascript:void(0)">Kliknij, aby
                                zobaczyć mail</a></p>
                    </div>
                    <form id="contact" action="{{route('mail')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="name">Imię i nazwisko*</label>
                                <input name="name" type="text" id="name" class="form-control " required>
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="phone">Nr telefonu</label>
                                <input name="phone" type="number" id="phone" class="form-control ">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="email">Email*</label>
                                <input name="email" type="email" id="email" class="form-control " required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="message">Wiadomość*</label>
                                <textarea name="message" id="message" class="form-control " cols="30" rows="8"
                                          required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input type="checkbox" name="rodo" id="rodo" class="form-check-input" required>
                                    <label class="form-check-label" for="rodo">Zapoznałem się z <a target="_blank"
                                                                                                   href="{{asset('storage/files/1_dawka300/blog/polityka_rodo.pdf')}}">klauzulą
                                            informacyjną RODO</a></label>

                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 10px;" class="g-recaptcha"
                             data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                        <div class="row mt-4">
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
    <script>
        $(document).ready(function () {
            $('#mailShow').click(function () {
                $link = '<a href="mailto:{{$settings->email}}">{{$settings->email}}</a>';
                $(this).parent().append($link);
                $(this).remove();
            });
            $('form#contact').submit(function (e) {
                let response = grecaptcha.getResponse();
                if (response.length === 0) {
                    e.preventDefault();
                    alert('Zaznacz pole z Catpchą');
                }

            });
        });
    </script>
@endsection
