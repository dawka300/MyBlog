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
                        W przypadku wpisaniu numeru KRS są do wyboru dodatkowe opcje.</p>
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
                            <div class="col-12 additional_options" style="display: block;">
                                <div class="row">
                                    <div class="col-5">
                                        <p>Dodatkowe opcje:</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10">
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
                                // console.log(name);
                                if(name === 'krs' && this.additionalOptionDiv.is(':hidden')) {
                                   this.additionalOptionDiv.fadeIn('slow');
                                }
                            },
                            offDisable: function () {
                                for (let i in this.form) {
                                    if ($('#' + this.form[i]).attr('disabled')) {
                                        $('#' + this.form[i]).attr('disabled', false);
                                    }
                                }
                                if(this.additionalOptionDiv.is(':visible')) {
                                    this.additionalOptionDiv.fadeOut('slow');
                                }
                            },
                            clearFields: function () {
                                $('input[type=number]').val(null).attr('disabled', false);
                            },
                            submit: function (e) {
                                var that = this;
                                e.preventDefault();
                                if (!this.validate()) {
                                    this.clearFields();
                                } else {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        method: 'post',
                                        url: '{{route('ajax_krs')}}',
                                        data: {
                                            // g_recaptcha_response: grecaptcha.getResponse(),
                                            nip: $('#nip').val(),
                                            regon: $('#regon').val(),
                                            krs:{
                                                number: $('#krs').val(),
                                                type: $('input[type=radio]:checked').val(),
                                            }
                                            },
                                        success: function (data) {
                                            if (data.response.error) {
                                                alert(data.response.error);

                                                return;
                                            }
                                            if (Array.isArray(data.response)){

                                            }else {

                                            };
                                            console.log(data.response);
                                            return;
                                            that.clearFields();
                                            let basic = data.response.basic;

                                            let button = '';
                                            if (typeof report.ErrorCode === 'undefined') {
                                                button = '<a class="btn btn-outline-primary" target="_blank" href="{{route('ajax_gus_pdf')}}">Pobierz raport</a>'
                                            }
                                            console.log(typeof report.ErrorCode === 'undefined' );
                                            $('#display')
                                                .html(`
                                                    <p class="mt-3"><b>Nazwa:</b> ${basic.name}</p><p><b>Województwo:</b> ${basic.province}</p>
                                                    <p><b>Powiat:</b> ${basic.district}</p><p><b>Gmina:</b> ${basic.community}</p>
                                                    <p><b>Miasto:</b> ${basic.city}</p><p><b>Kod pocztowy:</b> ${basic.zip}</p>
                                                    <p><b>Ulica:</b> ${basic.street}</p><p><b>Numer budynku::</b> ${basic.propertyNumber}</p>
                                                    <p><b>Regon:</b> ${basic.regon}</p><p><b>Regon 14:</b> ${basic.regon14}</p>
                                                    <p><b>Nip:</b> ${basic.nip}</p><p><b>Status NIP:</b> ${basic.nipStatus}</p>
                                                    <p><b>Data zakończenia działaności:</b> ${basic.activityEnd}</p>${button}
                                                    `);
                                        },
                                        fail: function () {
                                            alert('Błąd z aplikacją. Spróbuj później');
                                        }
                                    })
                                }
                                ;


                            },
                            validate: function () {
                                if (!this.editField) {
                                    alert('Uzupełnij pole!');

                                    return false;
                                }
                                let recaptchaResponse = grecaptcha.getResponse();
                                // if (recaptchaResponse.length === 0) {
                                //     alert('Zaznacz pole z Catpchą');
                                //
                                //     return false;
                                // }
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
                                console.log(data);
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
