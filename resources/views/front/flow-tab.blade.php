<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Flow Selection')</title>

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

    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo/favicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">
        <h2 class="text-2xl font-bold text-center mb-6">Select Inward or Outward</h2>
        <form method="POST" action="{{ route('flow-tab.select') }}">
            @csrf
            <div class="flex justify-around mb-6">
                <button type="submit" name="flow_type" value="inward"
                    class="px-6 py-3 rounded-lg text-white bg-blue-600 hover:bg-blue-700 font-semibold">
                    Inward Panel
                </button>
                <button type="submit" name="flow_type" value="outward"
                    class="px-6 py-3 rounded-lg text-white bg-gray-600 hover:bg-gray-700 font-semibold">
                    Outward Panel
                </button>
            </div>
        </form>

        <div class="text-sm text-gray-500 text-center">
            Company : {{ $company->name }} |
            Financial Year : {{ $financial_year->year }}
        </div>
    </div>
</body>
</html>