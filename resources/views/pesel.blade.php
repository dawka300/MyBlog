@extends('layouts.app-fronted')

@section('content')
    <section class="site-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h1>Program PESEL</h1>
                </div>
            </div>
            <div class="row blog-entries">
                <div class="col-md-12 col-lg-8 main-content">
                    <p>program został napisany przeze mnie w języku JavaScript (JQuery).
                        Aplikacja sprawdza poprawność wprowadzonego numeru PESEL i wyświetla
                        podstawowe dane na temat użytkownika tego numeru, takie jak: wiek,
                        płeć, datę urodzin oraz kilka danych statystycznych.</p>
                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name">Podaj swój PESEL</label>
                                <input type="number" id="pesel" class="form-control ">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input id="check" type="button" value="Sprawdź" class="btn btn-primary">
                            </div>
                        </div>
                    </form>
                    <div class="col-12" id="display">

                    </div>




                </div>
                <script src="{{asset('js/moment.js')}}"></script>
                <script>
                    $('#check').on('click', function () {
                        $('div.new1').length && $('div.new1').remove();
                        let nrP = $('#pesel').val();
                        let regex = /^\d{11}/g;
                        var $target = $('#display');
                        var dnimies = ["styczeń", "luty", "marzec", "kwiecień", "maj", "czerwiec", "lipiec", "sierpień", "wrzesień", "październik", "listopad", "grudzień"];

                        if (regex.test(nrP)) {
                            let wynik = ((9 * nrP[0] + 7 * nrP[1] + 3 * nrP[2] + 1 * nrP[3] + 9 * nrP[4] + 7 * nrP[5] + 3 * nrP[6] + 1 * nrP[7] + 9 * nrP[8] + 7 * nrP[9]) % 10) % 10;
//         alert(wynik);
                            if (wynik === parseInt(nrP[10])&& nrP!=="00000000000") {
                                if (parseInt(nrP[9]) === 0 || parseInt(nrP[9]) === 2 || parseInt(nrP[9]) === 4 || parseInt(nrP[9]) === 6 || parseInt(nrP[9]) === 8) {
                                    var sex = "kobietą";
                                } else {
                                    sex = "mężczyną";
                                }

                                var month = parseInt(nrP[2] + nrP[3]);//zapisanie w formacie liczbowym miesiąca urodzin
                                var day = parseInt(nrP[4] + nrP[5]);//zapisanie w formacie liczbowym dnia
                                var year = nrP[0] + nrP[1];//zapisanie w formacie liczbowym roku


                                //warunek dodajacy prawidłową cyfrę początkową do roku
                                if (month >= 1 && month <= 12) {
                                    year = parseInt(19 + year);
                                } else if (month > 20 && month <= 32) {
                                    year = parseInt(20 + year);
                                } else {
                                    year = parseInt(18 + year);
                                }
                                ;
                                //warunek ustawiajacy prawidłową wartość miesiąca dla ludzi urodzonych po 2000 lub przed 1900
                                if (month >= 21 && month <= 32) {
                                    month = month - 20;
                                } else if (month > 32 && month < 95) {
                                    month = month - 80;
                                }
                                var birthdate = moment(month + ' ' + day + ' ' + year, "MM DD YYYY");
                                var passyear = parseInt(moment(year.toString()+month.toString(), "YYYYMM").fromNow());
                                var now = moment();
                                var nextBirthday = moment(month + ' ' + day + ' ' + now.year(), "MM DD YYYY");
                                if (nextBirthday <= now) {
                                    nextBirthday.add(1, 'year');
                                }

                                function displayTimeDifference(firstDate, secondDate) {
                                    let d1 = firstDate.clone(),
                                        d2 = secondDate.clone(),
                                        years = d1.diff(secondDate, 'years'),
                                        months = d1.subtract(years, 'years').diff(d2, 'months'),
                                        days = d1.subtract(months, 'months').diff(d2, 'days'),
                                        hours = d1.subtract(days, 'days').diff(d2, 'hours'),
                                        minutes = d1.subtract(hours, 'hours').diff(d2, 'minutes'),
                                        seconds = d1.subtract(minutes, 'minutes').diff(d2, 'seconds');

                                    return( years + ' lata ' + months + ' miesięcy ' + days + ' dni ' + hours + ' godzin ' + minutes + ' minut(y) ' + seconds+' sekund(y)');
                                }



                                //obliczenia numerologicznej cyfry urodzin - konwersja liczby na ciąg znaków, aby dostac się do tablicy
                                var rokC = year.toString();
                                var YourNumber;

                                var numerologia = parseInt(rokC[0]) + parseInt(rokC[1]) + parseInt(rokC[2]) + parseInt(rokC[3]) + parseInt(nrP[2]) + parseInt(nrP[3]) + parseInt(nrP[4]) + parseInt(nrP[5]);


                                if (numerologia === 11 || numerologia === 22 || numerologia === 33 || numerologia === 44 || numerologia < 10) {
                                    YourNumber = numerologia;
                                } else {
                                    numerologia = numerologia.toString();
                                    YourNumber = parseInt(numerologia[0]) + parseInt(numerologia[1]);
                                    // alert(YourNumber);
//            if (YourNumber===11) {
//               console.log("witaj");
//            }
                                    if (YourNumber >=10 && (YourNumber !== 11 && YourNumber !== 22 && YourNumber !== 33 && YourNumber !== 44)) {
                                        // alert(typeof(YourNumber));
                                        YourNumber=YourNumber.toString();
                                        YourNumber=parseInt(YourNumber[0])+parseInt(YourNumber[1]);

                                    }
                                }
                                ;
                                var deathwoman = [0.00355, 0.00056, 0.00037, 0.00042, 0.00097, 0.00109, 0.00133, 0.00193, 0.00306, 0.00523, 0.00910, 0.01538, 0.02533, 0.03980, 0.05964, 0.08813, 0.14380, 0.25199];
                                var deathman = [0.00448, 0.00072, 0.00052, 0.00067, 0.00240, 0.00442, 0.00513, 0.00671, 0.00956, 0.01513, 0.02501, 0.04031, 0.06302, 0.09354, 0.13039, 0.17797, 0.25240, 0.36168];
                                var zmien1 = 'Prawdopodobieństwo śmierci dla Twojego wieku i płci wynosi: ';
                                var zmien2 = '% - dane statystyczne tablic życia GUS';
                                if (sex === 'kobietą') {
                                    if (passyear < 1) {
                                        var chancedeath = zmien1 + deathwoman[0] + zmien2;
                                    } else if (passyear > 1 && passyear <= 5) {
                                        chancedeath = zmien1 + deathwoman[1] + zmien2;
                                    } else if (passyear > 5 && passyear <= 10) {
                                        chancedeath = zmien1 + deathwoman[2] + zmien2;
                                    } else if (passyear > 10 && passyear <= 15) {
                                        chancedeath = zmien1 + deathwoman[3] + zmien2;
                                    } else if (passyear > 15 && passyear <= 20) {
                                        chancedeath = zmien1 + deathwoman[4] + zmien2;
                                    } else if (passyear > 20 && passyear <= 25) {
                                        chancedeath = zmien1 + deathwoman[5] + zmien2;
                                    } else if (passyear > 25 && passyear <= 30) {
                                        chancedeath = zmien1 + deathwoman[6] + zmien2;
                                    } else if (passyear > 30 && passyear <= 35) {
                                        chancedeath = zmien1 + deathwoman[7] + zmien2;
                                    } else if (passyear > 35 && passyear <= 40) {
                                        chancedeath = zmien1 + deathwoman[8] + zmien2;
                                    } else if (passyear > 40 && passyear <= 45) {
                                        chancedeath = zmien1 + deathwoman[9] + zmien2;
                                    } else if (passyear > 45 && passyear <= 50) {
                                        chancedeath = zmien1 + deathwoman[10] + zmien2;
                                    } else if (passyear > 50 && passyear <= 55) {
                                        chancedeath = zmien1 + deathwoman[11] + zmien2;
                                    } else if (passyear > 55 && passyear <= 60) {
                                        chancedeath = zmien1 + deathwoman[12] + zmien2;
                                    } else if (passyear > 60 && passyear <= 65) {
                                        chancedeath = zmien1 + deathwoman[13] + zmien2;
                                    } else if (passyear > 65 && passyear <= 70) {
                                        chancedeath = zmien1 + deathwoman[13] + zmien2;
                                    } else if (passyear > 70 && passyear <= 75) {
                                        chancedeath = zmien1 + deathwoman[15] + zmien2;
                                    } else if (passyear > 75) {
                                        chancedeath = zmien1 + deathwoman[16] + zmien2;
                                    }



                                } else {
                                    if (passyear < 1) {
                                        chancedeath = zmien1 + deathman[0] + zmien2;
                                    } else if (passyear > 1 && passyear <= 5) {
                                        chancedeath = zmien1 + deathman[1] + zmien2;
                                    } else if (passyear > 5 && passyear <= 10) {
                                        chancedeath = zmien1 + deathman[2] + zmien2;
                                    } else if (passyear > 10 && passyear <= 15) {
                                        chancedeath = zmien1 + deathman[3] + zmien2;
                                    } else if (passyear > 15 && passyear <= 20) {
                                        chancedeath = zmien1 + deathman[4] + zmien2;
                                    } else if (passyear > 20 && passyear <= 25) {
                                        chancedeath = zmien1 + deathman[5] + zmien2;
                                    } else if (passyear > 25 && passyear <= 30) {
                                        chancedeath = zmien1 + deathman[6] + zmien2;
                                    } else if (passyear > 30 && passyear <= 35) {
                                        chancedeath = zmien1 + deathman[7] + zmien2;
                                    } else if (passyear > 35 && passyear <= 40) {
                                        chancedeath = zmien1 + deathman[8] + zmien2;
                                    } else if (passyear > 40 && passyear <= 45) {
                                        chancedeath = zmien1 + deathman[9] + zmien2;
                                    } else if (passyear > 45 && passyear <= 50) {
                                        chancedeath = zmien1 + deathman[10] + zmien2;
                                    } else if (passyear > 50 && passyear <= 55) {
                                        chancedeath = zmien1 + deathman[11] + zmien2;
                                    } else if (passyear > 55 && passyear <= 60) {
                                        chancedeath = zmien1 + deathman[12] + zmien2;
                                    } else if (passyear > 60 && passyear <= 65) {
                                        chancedeath = zmien1 + deathman[13] + zmien2;
                                    } else if (passyear > 65 && passyear <= 70) {
                                        chancedeath = zmien1 + deathman[14] + zmien2;
                                    } else if (passyear > 70 && passyear <= 75) {
                                        chancedeath = zmien1 + deathman[15] + zmien2;
                                    } else if (passyear > 75) {
                                        chancedeath = zmien1 + deathman[16] + zmien2;
                                    }
                                }
                                ;

                                $target.append($('<div></div>').addClass('new1').html("<br><br><p>Twoja data urodzenia to: " + day + " " + dnimies[month - 1] + " " + year + "</p><p>Jesteś: " + sex + "</p><p>Od chwili twoich narodzin minęło: "
                                    + displayTimeDifference(now, birthdate)+ "</p><p> Natępne urodziny masz za : " + displayTimeDifference( nextBirthday, now) +"</p>\
                                    <p> Twoja cyfra numerologiczna to: " + YourNumber + "</p><p>"+ chancedeath+"</p>"));

                            }

                            else {
                                $target.append($('<div></div>').addClass('alert alert-danger text-center').html("<h4>Ten PESEL jest niepoprawny (błędna suma kontrolna). Spróbuj jeszcze raz.</h4>"));
                                setTimeout(function () {
                                    $target.empty();
                                }, 6000);
                            }

                        } else {
                            $target.append($('<div></div>').addClass('alert alert-danger text-center').html("<h4>Błędny format!!!</h4>"));
                            setTimeout(function () {
                                $target.empty();
                            }, 6000);
                        }

                    })

                </script>

               @include('inc.sidebar')





            </div>
        </div>
    </section>
@endsection
