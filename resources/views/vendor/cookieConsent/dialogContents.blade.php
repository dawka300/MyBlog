{{--<div class="js-cookie-consent cookie-consent">

    <span class="cookie-consent__message">

    </span>

    <button class="js-cookie-consent-agree cookie-consent__agree">

    </button>

</div>--}}
<div class="js-cookie-consent cookie-consent cookie text-white">
    <div class="container">
        <h2 class="text-white">Polityka cookie</h2>
        <p> {!! trans('cookieConsent::texts.message') !!}<a href="{{route('cookie')}}"> Dowiedz się więcej...</a>
        </p>
        <button class="btn btn-outline-success js-cookie-consent-agree cookie-consent__agree" type="button">{{ trans('cookieConsent::texts.agree') }}</button>
        <button class="btn btn-outline-danger" type="button" onclick="window.location.href='https://google.com'">{{ trans('cookieConsent::texts.disagree') }}</button>
    </div>
</div>
<style>
    .cookie {
        background-color: #020101;
        opacity: 0.7;
        width: 100%;
        height: 15rem;
        position: fixed;
        top: 0;
        z-index: 99;
    }
</style>
