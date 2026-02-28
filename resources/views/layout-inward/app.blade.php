<DOCTYPE html>
<html lang="en">
<head>
    <!-- Basic SEO Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Delivery Challan App')</title>
    <meta name="description" content="@yield('meta_description', 'Manage your delivery challans efficiently with our application.')">
    <meta name="keywords" content="@yield('meta_keywords', 'delivery challan, challan management, invoice system, billing')">
    <meta name="author" content="Your Company Name">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', 'Delivery Challan App')">
    <meta property="og:description" content="@yield('og_description', 'A powerful tool to manage delivery challans efficiently.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/img/logo/favicon.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Delivery Challan App')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Easily manage your delivery challans online.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('assets/img/logo/favicon.png'))">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <!-- Structured Data (JSON-LD for SEO) -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebApplication",
        "name": "@yield('title', 'Delivery Challan App')",
        "url": "{{ url()->current() }}",
        "description": "@yield('meta_description', 'Manage your delivery challans efficiently with our application.')",
        "author": {
            "@type": "Organization",
            "name": "Your Company Name"
        },
        "applicationCategory": "BusinessApplication",
        "offers": {
            "@type": "Offer",
            "price": "0.00",
            "priceCurrency": "USD"
        }
    }
    </script>

    <!-- Favicon -->
    <!-- <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontasosome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/clash-display.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">   -->

    <link rel="shortcut icon" href="{{ asset('assets/img/logo/favicon.png') }}">
   <!--nice select css-->
   <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
   <!--datepicker css-->
   <link rel="stylesheet" href="{{ asset('assets/css/datepickerboot.css') }}">
   <!--main css-->
   <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<!-- Latest Font Awesome -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

   <!-- DataTables CSS -->


<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
@stack('styles')
   
</head>
<body>

    <!--==================== Preloader Start ====================-->
    <!-- <div class="preloader">
        <div class="animation-container">
            <div class="lightning-container">
                <div class="lightning white"></div>
                <div class="lightning red"></div>
            </div>
            <div class="boom-container">
                <div class="shape circle big white"></div>
                <div class="shape circle white"></div>
                <div class="shape triangle big yellow"></div>
                <div class="shape disc white"></div>
                <div class="shape triangle blue"></div>
            </div>
            <div class="boom-container second">
                <div class="shape circle big white"></div>
                <div class="shape circle white"></div>
                <div class="shape disc white"></div>
                <div class="shape triangle blue"></div>
            </div>
        </div>
    </div> -->
    <!--==================== Preloader End ====================-->
    
                @include('layout.header')
    
                    @yield('content')
                <!-- ==================== Footer Start Here ==================== -->
            
                <!-- ==================== Footer Start Here ==================== -->
                @include('layout-inward.footer')
                <!-- ==================== Footer End Here ==================== -->
        <script data-cfasync="false" src="{{ asset('cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
       <!--Bootstrap bundle Js-->
       <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
       <!--Viewport Jquery Js-->
       <script src="{{ asset('assets/js/viewport.jquery.js') }}"></script>
       <!--Odometer min Js-->
       <script src="{{ asset('assets/js/odometer.min.js') }}"></script>
       <!--date picker Js-->
       <script src="{{ asset('assets/js/bootstrap-datepicker.js') }}"></script>
       <!--Magnifiw Popup Js-->
       <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
       <!--nice select Js-->
       <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
       <!--Wow min Js-->
       <script src="{{ asset('assets/js/wow.min.js') }}"></script>
       <!--Owl carousel min Js-->
       <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
       <!--Prijm Js-->
       <script src="{{ asset('assets/js/prism.js') }}"></script>
       <!--main Js-->
       <script src="{{ asset('assets/js/main.js') }}"></script>

        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

<!-- Global Keyboard Shortcuts -->
<script>
document.addEventListener('keydown', function(e) {
    // Alt + N: Create New
    if (e.altKey && e.key.toLowerCase() === 'n') {
        const createBtn = document.querySelector('.btn-create-premium, a[href*="create"]');
        if (createBtn) createBtn.click();
    }
    
    // Alt + I: Bulk Import
    if (e.altKey && e.key.toLowerCase() === 'i') {
        const importBtn = document.querySelector('.btn-bulk-import, [data-bs-target="#importExcelModal"]');
        if (importBtn) importBtn.click();
    }

    // Alt + H: Home Dashboard
    if (e.altKey && e.key.toLowerCase() === 'h') {
        window.location.href = "{{ route('flow-tab') }}";
    }

    // Alt + B: Back
    if (e.altKey && e.key.toLowerCase() === 'b') {
        const backBtn = document.querySelector('.btn-back, .btn-light[href], a[href*="dashboard"]');
        if (backBtn) backBtn.click();
        else window.history.back();
    }

    // Alt + S: Save/Submit Form
    if (e.altKey && e.key.toLowerCase() === 's') {
        const submitBtn = document.querySelector('button[type="submit"]');
        if (submitBtn) {
            e.preventDefault();
            submitBtn.click();
        }
    }

    // Forward Slash (/): Focus Search
    if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
        const searchInput = document.querySelector('.dataTables_filter input, input[type="search"]');
        if (searchInput) {
            e.preventDefault();
            searchInput.focus();
        }
    }

    // Escape: Close
    if (e.key === 'Escape') {
        const closeBtn = document.querySelector('.btn-close, [data-bs-dismiss="modal"]');
        if (closeBtn) closeBtn.click();
    }
});
</script>

@stack('scripts')

</body>
</html>
