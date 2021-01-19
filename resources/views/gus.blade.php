@extends('layouts.app-fronted')

@section('content')
    <section class="site-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>Pobieranie danych z GUS na temat przedsiebiorców</h1>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                  <p>Aplikacja służy do pobierania danych z GUS. Należy podać numer NIP lub REGON albo KRS (w przypadku osoby prawnej będzie możliwy
                      do pobrania szczegółowy raport).</p>
                    <p class="small">Aplikacja jest ciągle rozwijana. Jeżeli mają Państwo jakieś uwagi lub sugestie, proszę kierować
                        je na mail-a - bedę bardzo wdzięczny.</p>
                <form action="">
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
                    <div style="margin-top: 10px;" class="g-recaptcha"
                         data-sitekey="{{env('GOOGLE_RECAPTCHA_KEY')}}"></div>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <input id="check" type="button" value="Szukaj" class="btn btn-primary">
                        </div>
                    </div>
                </form>
                    <div class="col-12" id="display">

                    </div>
                </div>
                <script>
                    $(function(){
                        let form = {
                            form: ['nip', 'regon', 'krs'],
                            submitButton: $('#check'),
                            messageNipKrs: 'Pole może składać się wyłącznie z 10 cyfr',
                            messageRegon: 'Pole może składać się wyłącznie z 9 cyfr',
                            editField: null,
                            onInit: function (){
                                this.addEvents();
                                this.submitButton.click((e) => {
                                    this.submit(e);
                                });
                            },
                            addEvents: function(){
                                var that = this;
                                for (let item in this.form) {
                                    $('#' + this.form[item]).on('change keyup', function() {
                                        if($(this).val() > 0) {
                                            that.editField = $(this);
                                            that.onDisable($(this).attr('name'));
                                        }else {
                                            that.editField = null;
                                            that.offDisable();
                                        }
                                    })
                                }
                            },
                            onDisable:  function (name){
                                   for(let i in this.form){
                                       if(this.form[i] !== name){
                                           $('#' + this.form[i]).attr('disabled', true);
                                       }
                                   }
                            },
                            offDisable: function (){
                                for(let i in this.form){
                                    if($('#' + this.form[i]).attr('disabled')){
                                        $('#' + this.form[i]).attr('disabled', false);
                                    }
                                }
                            },
                            clearFields: function (){
                                $('input[type=number]').val(null).attr('disabled', false);
                            },
                            submit: function (e){
                                var that = this;
                                e.preventDefault();
                                if(!this.validate()){
                                    this.clearFields();
                                }else{
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        method: 'post',
                                        url: '{{route('ajax_gus')}}',
                                        data: {nip: $('#nip').val(), regon: $('#regon').val(), krs: $('#krs').val()},
                                        success: function (data){
                                            if (data.response.error) {
                                                alert(data.response.error);
                                            }else {
                                                that.clearFields();
                                                let basic = data.response.basic;
                                                let report = data.response.report[0];
                                                let button = '';
                                                if (typeof report.ErrorCode === 'undefined') {
                                                    button = '<a class="btn btn-outline-primary" target="_blank" href="{{route('ajax_gus_pdf')}}">Pobierz raport</a>'
                                                }
                                                // console.log(typeof report.ErrorCode === 'undefined' );
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
                                            }
                                        },
                                        fail: function (data){
                                            console.log('failed');
                                        }
                                    })
                                };


                            },
                            validate: function (){
                                if(!this.editField){
                                    alert('Uzupełnij pole!')

                                    return false;
                                }
                                // let response = grecaptcha.getResponse();
                                // if (response.length === 0) {
                                //     alert('Zaznacz pole z Catpchą');
                                // }
                                let name = this.editField.attr('name');
                                let value = this.editField.val().toString();
                                if((name === 'nip' || name === 'krs') && value.length !== 10){
                                    alert(this.messageNipKrs);

                                    return false;
                                }else if(name === 'regon' && value.length !== 9){
                                    alert(this.messageRegon);

                                    return false
                                }else{
                                    return true
                                }
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
