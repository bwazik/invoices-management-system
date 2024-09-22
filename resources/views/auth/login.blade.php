<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Webmin - Bootstrap 4 & Angular 5 Admin Dashboard Template" />
    <meta name="author" content="potenzaglobalsolutions.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>{{ trans('login.title') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('assets/images/favicon.png') }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" />

    <!-- Font -->
    @if (App::getLocale() == 'en')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900">
    @else
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap" rel="stylesheet">
    @endif

    @if (App::getLocale() == 'en')
    <link href="{{ URL::asset('assets/css/ltr.css') }}" rel="stylesheet">
    @else
    <link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">
    @endif

</head>

<body>

    <div class="wrapper">

        <!--=================================
    preloader -->
        <div id="pre-loader" style="display: none;">
            <img src="{{ URL::asset('assets/images/pre-loader/loader-01.svg') }}" alt="">
        </div>
        <!--=================================
    preloader -->

        <!--=================================
    login-->
        <section class="height-100vh d-flex align-items-center page-section-ptb login"
            style="background-image: url(assets/images/login-bg.jpg);">
            <div class="container">
                <div class="row justify-content-center g-0 vertical-align">
                    <div class="col-lg-4 col-md-6 bg-white">
                        <div class="login-fancy pb-40 clearfix">
                            <div class="row mb-20">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <a class="col button gray small mr-2"
                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                                @endforeach
                            </div>
                            <h3 class="mb-30">{{ trans('login.login') }}</h3>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="section-field mb-20">
                                    <label class="mb-10" for="name">{{ trans('login.email') }}</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="bwazik@outlook.com" autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="section-field mb-20">
                                    <label class="mb-10" for="Password">{{ trans('login.password') }}</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" value="123456789">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <button class="button"><span>{{ trans('login.submit') }}</span></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 login-fancy-bg bg"
                        style="background-image: url(assets/images/login-inner-bg.jpg);">
                        <div class="login-fancy">
                            <h2 class="text-white mb-20">{{ trans('login.system') }}</h2>
                            <p class="mb-20 text-white">{{ trans('login.p') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--=================================
    login-->
    </div>

<!-- jquery -->
<script src="{{ URL::asset('assets/js/jquery-3.3.1.min.js') }}"></script>

<!-- plugins-jquery -->
<script src="{{ URL::asset('assets/js/plugins-jquery.js') }}"></script>

<!-- plugin_path -->
<script type="text/javascript">
    var plugin_path = '{{ asset('assets/js') }}/';
</script>

<!-- custom -->
<script src="{{ URL::asset('assets/js/custom.js') }}"></script>


</body>

</html>
