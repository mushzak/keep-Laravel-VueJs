{{-- Google Analytics --}}
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{env('GOOGLE_TRACKING_ID','UA-106356302-1')}}"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    };
    gtag("js", new Date());

    gtag("config", "{{env('GOOGLE_TRACKING_ID','UA-106356302-1')}}");
</script>