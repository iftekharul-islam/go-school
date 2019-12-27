<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">

    {{--    <link rel="stylesheet" href="css/icon-font.css">--}}
    <link rel="stylesheet" href="{{ asset('template/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/responsive.css') }}">

</head>

<body>
<header class="header">
    <div class="header__logo-box">
        <a href="{{ url('/') }}">
            <img src="{{ asset('logos/Logo-Icon-Only.png') }}" class="header__logo">
        </a>
    </div>
    <div class="inner-body effect5">
        <div class="header__text-box effect5">

            <h1 class="heading">
                <span class="heading--main"><img class="main-logo" src="{{ asset('logos/Logo-Text-Only.png') }}"></span>
                <span class="heading--sub"></span>
            </h1>

            <section class="section-book">
                <div class="row">
                    <div class="book">
                        <div class="book__form">
                            @auth()
                                <script>window.location = "{{ \Illuminate\Support\Facades\Auth::user()->role }}/home";</script>
                                {{--                                <a href="{{ url('/home') }}" class="button button--white button--animation">Home</a>--}}
                            @else
                                <form method="POST" action="{{ route('login') }}" class="form">
                                    {{ csrf_field() }}
                                    <div class="form__group">
                                        <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label for="email" class="form__label">Username/Email</label>
                                            <input type="text" class="form__input" placeholder="Email address" id="email" name="email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>

                                    <div class="form__group">
                                        <div class="col-lg-12 form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="name" class="form__label">Password</label>
                                            <input type="password" name="password" class="form__input" placeholder="Password" required>
                                        </div>
                                    </div>
                                    @if ($errors->has('email') || $errors->has('password'))
                                        <div class="error-message">
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                        </div>
                                    @endif

                                    <div class="form__group">
                                        <div class="form__radio-group">
                                            <input type="checkbox" checked="checked" type="radio"
                                                   class="form__radio-input" id="small" name="size">
                                            <label for="small" class="form__radio-label">
                                                <span class="form__radio-button"></span>
                                                Remember Me
                                            </label>
                                        </div>
                                        <div class="form__radio-group float-left">
                                            <label for="large" class="form__radio-label">
                                                <a href="{{ route('password.request') }}">Forgot Password?</a>
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="button button--login button--animation">LOGIN</button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</header>
</body>

</html>
