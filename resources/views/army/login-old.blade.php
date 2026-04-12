<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BD Army Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <style>
        /* Setting the page background to light gray.
           The button's inner mask will match this color to achieve transparency. */
        body {

        }

        /* 1. Base style for the button container */
        .gradient-border-button {
            position: relative;
            padding: 5px;
            width: 100%;
            /* --- UPDATE: Button background is transparent now --- */
            background: transparent;
            /* Text color is black for contrast against the light gray background */
            color: #000000;
            /* font-size: 1.125rem;
            font-weight: 700; */
            z-index: 10;
            border: none;
            cursor: pointer;
            border-radius: 0.5rem;
            overflow: hidden;
            letter-spacing: 0.5px;
            white-space: nowrap;
            /* Optional: Add a slight lift shadow to emphasize the element */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* 2. Create the gradient background layer (the "border") */
        .gradient-border-button::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            /* Apply the rainbow gradient */
            background: linear-gradient(
                45deg,
                #ff00ff,
                #ffa500,
                #ffff00,
                #00ff00,
                #00ffff,
                #0000ff,
                #ff00ff
            );
            border-radius: 0.625rem;
            z-index: -1;
            /* Animation for subtle movement (optional but cool) */
            background-size: 400% 400%;
            animation: gradient-shift 15s ease infinite;
        }

        /* 3. Create the inner mask to turn the gradient into a thin border */
        .gradient-border-button::after {
            content: '';
            position: absolute;
            /* --- CRITICAL UPDATE: The mask background must match the body background color --- */
            background: #f5f5f5;
            /* Define the border thickness by pushing the mask inward (2px border) */
            top: 2px;
            left: 2px;
            right: 2px;
            bottom: 2px;
            border-radius: 0.5rem;
            z-index: -1;
        }

        /* Keyframe animation for subtle gradient movement */
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Hover effect */
        .gradient-border-button:hover::before {
            filter: brightness(1.2);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.7);
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        @if (Session::has('success'))
                                <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            @if (Session::has('error'))
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    {{ Session::get('error') }}
                                </div>
                            @endif
      <img src="{{ asset('images/rk_logo.jpg') }}"/>
    </div>
    <div class="card-body">
        <p class="login-box-msg">RK HRM | BD Army Login</p>
        <form action="{{ route('army.authenticate') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            @error('email')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            @error('password')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                            Remember Me
                        </label>
                    </div>
                </div>

                <div class="col-4">
                    <button type="submit" class="gradient-border-button">Sign In</button>
                </div>

            </div>
        </form>

        <p class="mb-1">
            <a href="#">I forgot my password</a>
          </p>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
</body>
</html>
