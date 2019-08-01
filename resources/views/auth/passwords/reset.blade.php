
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

</head>

<body>
<header class="header">
    <div class="header__logo-box">
        <a href="{{ url('/') }}">
            <img src="{{ asset('template/img/logo/logo.jpg') }}" class="header__logo">
        </a>
    </div>
    <div class="inner-body effect5">
        <div class="header-text-reset effect5">

            <h1 class="heading">
                <span class="heading--main">Shoroborno</span>
                <span class="heading--sub"></span>
            </h1>

            <section class="section-book">
                <div class="row">
                    <div class="book">
                        <div class="book__form">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="panel panel-default">
                                        <div class="panel-reset-title">Reset Password</div>

                                        <div class="panel-body">
                                            <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="token" value="{{ $token }}">

                                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                                    @if ($errors->has('email'))
                                                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                                    @endif
                                                    <label for="email" class="col-md-6  form__label">E-Mail Address</label>
                                                    <div class="col-md-6">
                                                        <input id="email" type="email" class="form__input" name="email" value="{{ $email or old('email') }}" required autofocus>
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                                    @if ($errors->has('password'))
                                                        <span class="help-block">
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                            </span>
                                                    @endif
                                                    <label for="password" class="col-md-6  form__label">Password</label>
                                                    <div class="col-md-6">
                                                        <input id="password" type="password" class="form__input" name="password" required>
                                                    </div>
                                                </div>

                                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                                    <label for="password-confirm" class="col-md-6  form__label">Confirm Password</label>
                                                    <div class="col-md-6">
                                                        <input id="password-confirm" type="password" class="form__input" name="password_confirmation" required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-4">
                                                        <button type="submit" class="button button--login">
                                                            Reset Password
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
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