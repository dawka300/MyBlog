@extends('layouts.app-fronted')

@section('content')
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <section class="site-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>Pobieranie danych z KRS na temat przedsiebiorców</h1>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <p>Aplikacja służy do pobierania danych z Krajowego Rejestru Sądowego. Należy podać numer NIP lub
                        REGON albo KRS.
                        W przypadku wpisaniu numeru KRS są do wyboru dodatkowe opcje.
                        W aplikacji nie można pobrać aktualnego odpisu KRS, także zapoznać się z numerami PESEL osób
                        wpisanych do KRS. Dane, które aplikacja udostępnia, pojawiają się z kilkudniowym opóźnieniem w stosunku
                        do danych znajdujących sie na serwerach Krajowego Rejestru Sądowego. W celu pobrania odpisu,
                        zapoznania się z najbardziej aktualnymi danymi należy skorzystać z
                        <a href="https://ekrs.ms.gov.pl/web/wyszukiwarka-krs/strona-glowna/index.html" target="_blank">wyszukiwarki KRS</a>
                    </p>
                    <p class="small">Aplikacja jest ciągle rozwijana. Jeżeli mają Państwo jakieś uwagi lub sugestie,
                        proszę kierować
                        je na mail-a - bedę bardzo wdzięczny.</p>
                    <form action="" id="krs_api">
                        <div class="row">
                            <div class="form-group col-5">
                                <label for="nip">Numer NIP</label>
                                <input type="number" name="nip" id="nip" min="0" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-5">
                                <label for="regon">Numer REGON</label>
                                <input type="number" name="regon" id="regon" min="0" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-5">
                                <label for="krs">Numer KRS</label>
                                <input type="number" name="krs" id="krs" min="0" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 additional_options" style="display: none;">
                                <div class="row">
                                    <div class="col-5">
                                        <p>Dodatkowe opcje:</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10" >
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type[]" id="regular"
                                                   value="regular" checked>
                                            <label class="form-check-label" for="regular">
                                                Normalny raport
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type[]" id="entries"
                                                   value="entries">
                                            <label class="form-check-label" for="entries">
                                                Wszystkie wpisy
                                                <i class="fa fa-info-circle" style="cursor: pointer;"
                                                   data-toggle="tooltip"
                                                   data-placement="right"
                                                   title="Pobierane dane o wszystkich dokanych wpisach"></i>
                                            </label>
                                        </div>
                                        <div class="form-check disabled">
                                            <input class="form-check-input" type="radio" name="type[]"
                                                   id="relations" value="relations">
                                            <label class="form-check-label" for="relations">
                                                Powiązania z osobami
                                                <i class="fa fa-info-circle" style="cursor: pointer;"
                                                   data-toggle="tooltip" data-placement="right"
                                                   title="Wyświetla osoby fizyczne i prawne powiązane ze spółką."></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 col-xl-5">
                                <div class="g-recaptcha mt-4 mb-4"
                                     data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input id="check" type="submit" value="Szukaj" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                    <div class="col-12" id="display">

                    </div>
                </div>
                <script>
                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip()
                        let form = {
                            form: ['nip', 'regon', 'krs'],
                            submitForm: $('#krs_api'),
                            messageNipKrs: 'Pole może składać się wyłącznie z 10 cyfr',
                            messageRegon: 'Pole może składać się wyłącznie z 9 cyfr',
                            editField: null,
                            additionalOptionDiv: $('div.additional_options'),
                            onInit: function () {
                                this.addEvents();
                                this.submitForm.submit((e) => {
                                    this.submit(e);
                                });
                            },
                            addEvents: function () {
                                var that = this;
                                for (let item in this.form) {
                                    $('#' + this.form[item]).on('change keyup', function () {
                                        if ($(this).val().length > 0) {
                                            that.editField = $(this);
                                            that.onDisable($(this).attr('name'));
                                        } else {
                                            that.editField = null;
                                            that.offDisable();
                                        }
                                    })
                                }
                            },
                            onDisable: function (name) {
                                for (let i in this.form) {
                                    if (this.form[i] !== name) {
                                        $('#' + this.form[i]).attr('disabled', true);
                                    }
                                }
                                if (name === 'krs' && this.additionalOptionDiv.is(':hidden')) {
                                    this.additionalOptionDiv.fadeIn('slow');
                                }
                            },
                            offDisable: function () {
                                for (let i in this.form) {
                                    if ($('#' + this.form[i]).attr('disabled')) {
                                        $('#' + this.form[i]).attr('disabled', false);
                                    }
                                }
                                if (this.additionalOptionDiv.is(':visible')) {
                                    this.additionalOptionDiv.fadeOut('slow');
                                }
                            },
                            clearFields: function () {
                                $('input[type=number]').val(null).attr('disabled', false);
                            },
                            submit: function (e) {
                                var that = this;
                                e.preventDefault();

                                if(this.validate()) {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        method: 'post',
                                        url: '{{route('ajax_krs')}}',
                                        data: {
                                            nip: $('#nip').val(),
                                            regon: $('#regon').val(),
                                            krs: {
                                                number: $('#krs').val(),
                                                type: $('input[type=radio]:checked').val(),
                                            },
                                            g_recaptcha_response: grecaptcha.getResponse(),
                                        },
                                        success: function (data) {
                                            if (data.response.error) {
                                                alert(data.response.error);

                                                return;
                                            }
                                            grecaptcha.reset();
                                            that.clearFields();
                                            let display = null;
                                            if (Array.isArray(data.response)) {
                                                 display = that.displayArray(data.response);
                                            } else {
                                                display = that.displayObject(data.response);
                                            }
                                            //todo dorobić wydruk pdf
                                            // if (typeof report.ErrorCode === 'undefined') {
                                            {{--    button = '<a class="btn btn-outline-primary" target="_blank" href="{{route('ajax_gus_pdf')}}">Pobierz raport</a>'--}}
                                            // }
                                            $('#display').html(display);
                                        },
                                        fail: function () {
                                            alert('Błąd z aplikacją. Spróbuj później');
                                        }
                                    })
                                }
                            },
                            validate: function () {
                                if (!this.editField) {
                                    alert('Uzupełnij pole!');

                                    return false;
                                }
                                let recaptchaResponse = grecaptcha.getResponse();
                                if (recaptchaResponse.length === 0) {
                                    alert('Zaznacz pole z Catpchą');

                                    return false;
                                }
                                let name = this.editField.attr('name');
                                let value = this.editField.val().toString();
                                if ((name === 'nip' || name === 'krs') && value.length !== 10) {
                                    alert(this.messageNipKrs);

                                    return false;
                                } else if (name === 'regon' && value.length !== 9) {
                                    alert(this.messageRegon);

                                    return false
                                } else {
                                    return true
                                }
                            },
                            displayObject: function (data) {
                            let text = `<p class="mt-3"><b>Nazwa:</b> ${data.name}</p><p><b>Nazwa skrócona:</b> ${data.name_short}</p>
                                        <p><b>Forma działalności:</b> ${data.legal_form}</p><p><b>Kraj:</b> ${data.address.country}</p>
                                        <p><b>Miasto:</b> ${data.address.city}</p><p><b>Kod pocztowy:</b> ${data.address.code}</p>
                                        <p><b>Ulica:</b> ${data.address.street}</p><p><b>Numer budynku::</b> ${data.address.house_no}</p>
                                        <p><b>Regon:</b> ${data.regon}</p><p><b>Data pierwszego wpisu:</b> ${data.first_entry_date}</p>
                                        <p><b>Liczba powiązań z osobami lub spółkami:</b> ${data.current_relations_count}</p>
                                        <p><b>Liczba historycznych powiązań z osobami lub spółkami:</b> ${data.historical_relations_count}</p>
                                    `;

                                return text;
                            },
                            displayArray: function (data) {
                                let text = '';
                                for (let key in data) {
                                    if(data.hasOwnProperty(key)){
                                        if(data[key].signature){
                                            text += `<div class="mt-1">
                                                <p>Nazwa sądu: ${data[key].court}</p>
                                                <p>Data złożenia wniosku: ${data[key].date}</p>
                                                <p>Data dokonania wpisu: ${data[key].date_end}</p>
                                                <p>Numer wniosku: ${data[key].number}</p>
                                                <p>Sygnatura sprawy: ${data[key].signature}</p>
                                                </div><hr>`;
                                        }else {
                                            text += this.displayArrayRelations(data[key]);
                                        }
                                    }

                                }

                                return text;
                            },
                            displayArrayRelations: function (data) {
                                let text = '';
                                if (data.first_name){
                                    text = `<div class="mt-1">
                                    <p>Imię i nazwisko: ${data.name}</p>
                                    <p>Drugię imię: ${data.second_names}</p>
                                    <p>Numer indentyfikacyjny osoby w KRS: ${data.id}</p>
                                    </div><hr>`;
                                }else {
                                    text = `<div class="mt-1">
                                    <p>Nazwa spółka: ${data.name}</p>
                                    <p>Nazwa skrócona: ${data.name_short}</p>
                                    <p>Forma prawna: ${data.legal_form}</p>
                                    <p>Numer KRS: ${data.krs}</p>
                                    <p>Numer NIP: ${data.nip}</p>
                                    <p>Numer Regon: ${data.regon}</p>
                                    </div><hr>`;
                                }
                                return text;
                            }

                        }
                        form.onInit();

                    });

                </script>
                @include('inc.sidebar')
            </div>
        </div>
    </section>
@endsection
