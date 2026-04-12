<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Management Login | RK HRM</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: 'Poppins', sans-serif;
    }

    /* 1. Full-Screen Background Photo */
    .bg-image {
        background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                          url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1600');
        background-size: cover;
        background-position: center;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* 2. Glassmorphism Card Effect */
    .login-card {
        background: rgba(255, 255, 255, 0.15); /* Semi-transparent */
        backdrop-filter: blur(20px); /* Blur effect */
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 40px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        animation: float 6s ease-in-out infinite;
    }

    /* Floating Animation */
    @keyframes float {
        0% { transform: translatey(0px); }
        50% { transform: translatey(-15px); }
        100% { transform: translatey(0px); }
    }

    .login-logo-img {
        max-width: 100px;
        border-radius: 15px;
        filter: drop-shadow(0px 4px 10px rgba(0,0,0,0.3));
        margin-bottom: 20px;
    }

    .login-card h3 {
        color: #ffffff;
        font-weight: 700;
        margin-bottom: 10px;
        text-align: center;
    }

    .login-card p {
        color: #e0e0e0;
        text-align: center;
        font-size: 0.9rem;
        margin-bottom: 30px;
    }

    /* Modern Styled Inputs */
    .form-group label {
        color: #ffffff;
        font-weight: 500;
        font-size: 0.85rem;
    }

    .input-wrapper {
        position: relative;
    }

    .input-wrapper i {
        position: absolute;
        left: 15px;
        top: 17px;
        color: rgba(255, 255, 255, 0.7);
    }

    .modern-input {
        background: rgba(255, 255, 255, 0.1) !important;
        border: 1px solid rgba(255, 255, 255, 0.3) !important;
        border-radius: 12px !important;
        padding: 12px 12px 12px 45px !important;
        color: #fff !important;
        height: 55px !important;
        transition: 0.3s;
    }

    .modern-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .modern-input:focus {
        background: rgba(255, 255, 255, 0.2) !important;
        border-color: #00d2ff !important;
        box-shadow: 0 0 15px rgba(0, 210, 255, 0.3);
    }

    /* Gorgeous Gradient Button */
    .btn-gorgeous {
        background: linear-gradient(45deg, #00d2ff 0%, #3a7bd5 100%);
        border: none;
        border-radius: 12px;
        padding: 14px;
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        width: 100%;
        margin-top: 20px;
        transition: 0.4s;
        box-shadow: 0 4px 15px rgba(58, 123, 213, 0.4);
    }

    .btn-gorgeous:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 20px rgba(58, 123, 213, 0.6);
        color: #fff;
    }

    .custom-control-label {
        color: #fff;
        cursor: pointer;
    }

    .forgot-link {
        color: #00d2ff;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .forgot-link:hover {
        color: #fff;
        text-decoration: underline;
    }
  </style>
</head>
<body>

<div class="bg-image">
    <div class="login-card">
        <div class="text-center">
            <img src="{{ asset('images/rk_logo.jpg') }}" class="login-logo-img" alt="Logo"/>
            <h3>RK HRM</h3>
            <p>Management Login Portal</p>
        </div>

        @if (Session::has('error'))
            <div class="alert alert-danger py-2" style="border-radius: 10px; font-size: 0.8rem;">
                {{ Session::get('error') }}
            </div>
        @endif

        <form action="{{ route('management.authenticate') }}" method="post">
            @csrf

            <div class="form-group">
                <div class="input-wrapper">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control modern-input" placeholder="Email Address" required>
                </div>
            </div>

            <div class="form-group mt-3">
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control modern-input" placeholder="Password" required>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="remember">
                    <label class="custom-control-label" for="remember">Remember me</label>
                </div>
                <a href="#" class="forgot-link">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-gorgeous">
                Sign In Now
            </button>
        </form>

        <div class="text-center mt-4">
            <small style="color: rgba(255,255,255,0.5)">© {{ date('Y') }} RK Software (BD) Limited</small>
        </div>
    </div>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
