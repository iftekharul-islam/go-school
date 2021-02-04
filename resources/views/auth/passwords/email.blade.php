<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Management System</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Dosis&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('template/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/responsive.css') }}">

</head>

<body>
<header class="header">
    <div class="header__logo-box">
        <a href="{{ url('/') }}">
            <img src="{{ asset('template/img/logo/logo.jpg') }}" class="header__logo">
        </a>
    </div>
    <div class="inner-body effect5">
        <div class="header__text-box effect5">

            <h1 class="heading">
                <span class="heading--main">Shoroborno</span>
                <span class="heading--sub"></span>
            </h1>

            <section class="section-book">
                <div class="row">
                    <div class="book">
                        <div class="book__form">
                            <div class="height-auto false-height">
                                <div class="header__text-box effect5">
                                    <h1 class="heading1 mt-5">
                                        <span class="heading--main">Password Reset</span>
                                    </h1>
                                    @if (session('status'))
                                        <div class="alert alert-success reset-alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                            @if ($errors->has('email'))
                                                <span class="help-block reset-password mt-5">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                            @endif
                                            <label for="email" class="col-md-12 text-left mg-t-30 mb-12 form__label">E-Mail Address</label>

                                            <div class="col-md-12">
                                                <input id="email" type="email" class="form-control form__input mb-5" placeholder="Email Address" name="email" value="{{ old('email') }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group justify-content-left">
                                            <div class="col-md-10">
                                                <button type="submit" class="button button--reset button--animation">
                                                    <b> Send Password Reset Link </b>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</header>
</body>

</html>

