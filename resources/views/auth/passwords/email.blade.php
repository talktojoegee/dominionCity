<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Reset Password" name="description" />
    <meta content="{{env('APP_NAME')}}" name="author" />
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    <link href="/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="//assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center mb-5 text-muted">
                    <a href="{{route("login")}}" class="d-block auth-logo">
                        <img src="/assets/drive/logo/logo-dark.png" alt="" height="74" width="74" class="auth-logo-dark mx-auto">
                    </a>
                    <p class="mt-3">Forgotten password? No need to worry.</p>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-8 col-xl-8">
                <div class="card">

                    <div class="card-body">

                        <div class="p-2">
                            <div class="text-center">
                                <div class="p-2 mt-4">
                                    <h4>Reset Password</h4>
                                    <p class="text-muted">Just enter your registered email address in the field provided below. We'll walk you through the process.</p>
                                    @if (session('status'))
                                        <p class="alert alert-success">{{ session('status') }}</p>
                                    @endif
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                                            <br>
                                            <div class="col-md-6">
                                                <input placeholder="Enter email address" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-md-6 offset-md-4">
                                                <button type="submit" class="btn btn-primary">
                                                    {{ __('Send Password Reset Link') }}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="mt-4 text-center">
                                            Or <a href="{{ route('login') }}" class="text-muted"> Login Here</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="mt-5 text-center">

                    <p>© <script>document.write(new Date().getFullYear())</script>
                        {{env('APP_NAME')}}.</p>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="/assets/libs/jquery/jquery.min.js"></script>
<script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="/assets/libs/simplebar/simplebar.min.js"></script>
<script src="/assets/libs/node-waves/waves.min.js"></script>
<script src="/assets/js/app.js"></script>
</body>
</html>

