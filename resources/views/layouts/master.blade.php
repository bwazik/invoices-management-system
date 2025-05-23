<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Invoices System" />
    <meta name="author" content="Abdullah Mohamed" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    @include('layouts.head')
</head>

<body>

    <div class="wrapper">

        <div id="pre-loader">
            <img src="{{ URL::asset('assets/images/pre-loader/loader-01.svg') }}" alt="">
        </div>

        @include('layouts.navbar')

        @include('layouts.sidebar')

        <!-- main-content -->
        <div class="content-wrapper profile-page">

            @include('layouts.header')

            @yield('content')

            @include('layouts.footer')
        </div>
    </div>
    </div>
    </div>

    @include('layouts.footer-scripts')

</body>

</html>
