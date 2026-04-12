<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | RK HRM</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        /* 1. Full-Screen Background Photo with Dark Overlay */
        .bg-image {
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                              url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&q=80&w=1600');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        /* 2. Glassmorphism Card Effect */
        .login-card {
            background: rgba(255, 255, 255, 0.12);
            backdrop-filter: blur(25px);
            -webkit-backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translatey(0px); }
            50% { transform: translatey(-12px); }
            100% { transform: translatey(0px); }
        }

        .login-logo-img {
            max-width: 90px;
            border-radius: 15px;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .login-card h3 {
            color: #ffffff;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .login-card .subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 30px;
        }

        /* Modern Styled Inputs */
        .input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 18px;
            color: rgba(255, 255, 255, 0.6);
            z-index: 10;
        }

        .modern-input {
            background: rgba(255, 255, 255, 0.08) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            border-radius: 14px !important;
            padding: 12px 12px 12px 50px !important;
            color: #fff !important;
            height: 55px !important;
            transition: all 0.3s ease;
        }

        .modern-input:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: #00d2ff !important;
            box-shadow: 0 0 15px rgba(0, 210, 255, 0.3);
        }

        /* Sign In Button */
        .btn-gorgeous {
            background: linear-gradient(45deg, #00d2ff 0%, #3a7bd5 100%);
            border: none;
            border-radius: 14px;
            padding: 14px;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            width: 100%;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(58, 123, 213, 0.4);
        }

        .btn-gorgeous:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 22px rgba(58, 123, 213, 0.5);
            color: #fff;
        }

        /* Multi-Login Links Section */
        .portal-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 25px 0;
            position: relative;
        }

        .portal-divider span {
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            padding: 0 15px;
            color: rgba(255,255,255,0.5);
            font-size: 0.75rem;
            border-radius: 10px;
        }

        .portal-links a {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            transition: 0.3s;
            text-decoration: none;
            display: block;
            padding: 8px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .portal-links a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #00d2ff;
            border-color: rgba(0, 210, 255, 0.3);
        }

        .custom-control-label { color: #fff; }
    </style>
</head>
<body>

<div class="bg-image">
    <div class="login-card">
        <div class="text-center">
            <img src="{{ asset('images/rk_logo.jpg') }}" class="login-logo-img" alt="Logo"/>
            <h3>RK HRM</h3>
            <p class="subtitle">Admin Control Portal</p>
        </div>

        @if (Session::has('error'))
            <div class="alert alert-danger py-2 text-center" style="border-radius: 12px; font-size: 0.85rem; background: rgba(220, 53, 69, 0.2); border: 1px solid rgba(220, 53, 69, 0.4); color: #ff8e97;">
                {{ Session::get('error') }}
            </div>
        @endif

        <form action="{{ route('authenticate') }}" method="post">
            @csrf

            <div class="input-wrapper">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" class="form-control modern-input" placeholder="Admin Email" required>
                @error('email') <small class="text-warning">{{ $message }}</small> @enderror
            </div>

            <div class="input-wrapper">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" class="form-control modern-input" placeholder="Password" required>
                @error('password') <small class="text-warning">{{ $message }}</small> @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mt-2 mb-4">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="remember">
                    <label class="custom-control-label" for="remember">Keep me logged in</label>
                </div>
            </div>

            <button type="submit" class="btn btn-gorgeous">
                Access Admin Dashboard
            </button>
        </form>

        <div class="portal-divider">
            {{-- <span>Switch Portal</span> --}}
        </div>

        <div class="row text-center portal-links">
            <div class="col-4">
                <a href="{{ route('army.login') }}">
                    <i class="fas fa-shield-alt d-block mb-1"></i> BD Army
                </a>
            </div>
            <div class="col-4">
                <a href="{{ route('management.login') }}">
                    <i class="fas fa-users-cog d-block mb-1"></i> Management
                </a>
            </div>
            <div class="col-4">
                <a href="{{ route('employee.login') }}">
                    <i class="fas fa-user d-block mb-1"></i> Employee
                </a>
            </div>
        </div>

        <div class="text-center mt-4">
            <small style="color: rgba(255,255,255,0.4)">© 2026 RK Software (BD) Limited</small>
        </div>
    </div>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
