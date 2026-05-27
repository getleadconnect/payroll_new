<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ASHWANIINFRA-PAYROLL</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/images/favicon.png')}}">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/vendor/fontawesome-free-5.15-web/css/all.min.css')}}" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #4aa3df;
            --brand-primary-dark: #2e7fb8;
            --brand-accent: #7ec4ef;
        }

        html, body {
            height: 100%;
            font-family: 'Poppins', sans-serif;
        }

        body.login-body {
            background: #eef3f7;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .login-shell {
            width: 100%;
            max-width: 980px;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(15, 35, 70, 0.12);
            display: flex;
            min-height: 560px;
        }

        .login-brand {
            flex: 1 1 50%;
            position: relative;
            background:
                linear-gradient(135deg, rgba(46, 127, 184, 0.92), rgba(74, 163, 223, 0.85)),
                url("{{ asset('assets/images/big/img1.jpg') }}") center/cover no-repeat;
            color: #fff;
            padding: 56px 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .login-brand::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(255,255,255,0.12), transparent 40%),
                radial-gradient(circle at 80% 80%, rgba(255,255,255,0.08), transparent 45%);
            pointer-events: none;
        }

        .login-brand > * {
            position: relative;
            z-index: 1;
        }

        .login-brand .brand-logo img {
            max-height: 56px;
            background: rgba(255,255,255,0.9);
            padding: 8px 14px;
            border-radius: 10px;
        }

        .login-brand h1 {
            font-size: 30px;
            font-weight: 600;
            line-height: 1.25;
            margin-top: 32px;
        }

        .login-brand p.tagline {
            font-size: 14.5px;
            opacity: 0.92;
            max-width: 380px;
            line-height: 1.7;
            margin-top: 14px;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 28px 0 0;
        }

        .feature-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            font-size: 14px;
            opacity: 0.95;
        }

        .feature-list li i {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,0.15);
            border-radius: 8px;
            font-size: 13px;
        }

        .brand-footer {
            font-size: 12px;
            opacity: 0.75;
        }

        .login-form-wrap {
            flex: 1 1 50%;
            padding: 56px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-wrap h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1f2d3d;
            margin: 0 0 6px;
        }

        .login-form-wrap p.sub {
            font-size: 13.5px;
            color: #6b7a8f;
            margin: 0 0 28px;
        }

        .login-form .form-group {
            margin-bottom: 18px;
        }

        .login-form label {
            font-size: 12.5px;
            font-weight: 500;
            color: #3a4a5e;
            letter-spacing: 0.2px;
            margin-bottom: 6px;
            display: block;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .input-icon {
            position: absolute;
            top: 50%;
            left: 14px;
            transform: translateY(-50%);
            color: #9aa6b8;
            font-size: 14px;
        }

        .input-wrap .toggle-pass {
            position: absolute;
            top: 50%;
            right: 12px;
            transform: translateY(-50%);
            color: #9aa6b8;
            background: transparent;
            border: 0;
            padding: 4px;
            cursor: pointer;
        }

        .input-wrap .toggle-pass:hover {
            color: var(--brand-primary);
        }

        .login-form .form-control {
            height: 46px;
            border-radius: 10px;
            border: 1px solid #dfe5ee;
            background: #f7f9fc;
            padding-left: 40px;
            font-size: 14px;
            color: #1f2d3d;
            transition: border-color .15s, box-shadow .15s, background .15s;
        }

        .login-form .form-control:focus {
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px rgba(74, 163, 223, 0.18);
            background: #fff;
            outline: 0;
        }

        .login-form .form-control[name="password"] {
            padding-right: 42px;
        }

        .btn-signin {
            width: 100%;
            height: 46px;
            border: 0;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--brand-primary-dark), var(--brand-accent));
            color: #fff;
            font-weight: 500;
            font-size: 14.5px;
            letter-spacing: 0.3px;
            box-shadow: 0 8px 20px rgba(74, 163, 223, 0.30);
            transition: transform .12s ease, box-shadow .12s ease, opacity .12s ease;
            cursor: pointer;
        }

        .btn-signin:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 24px rgba(46, 127, 184, 0.36);
        }

        .btn-signin:active {
            transform: translateY(0);
            opacity: 0.95;
        }

        .login-error {
            background: #fdecec;
            border: 1px solid #f5c2c2;
            color: #c0392b;
            font-size: 13px;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12.5px;
            color: #6b7a8f;
            margin: 4px 0 22px;
        }

        .form-meta a {
            color: var(--brand-primary);
            text-decoration: none;
            font-weight: 500;
        }

        .form-meta a:hover {
            text-decoration: underline;
        }

        .form-meta .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .form-meta .remember input {
            accent-color: var(--brand-primary);
        }

        .mobile-logo {
            display: none;
            text-align: center;
            margin-bottom: 20px;
        }

        .mobile-logo img {
            max-height: 48px;
        }

        @media (max-width: 860px) {
            .login-shell {
                flex-direction: column;
                min-height: auto;
            }
            .login-brand {
                display: none;
            }
            .login-form-wrap {
                padding: 36px 28px;
            }
            .mobile-logo {
                display: block;
            }
        }
    </style>
</head>

<body class="login-body">

    <div class="login-shell">

        <!-- Brand panel -->
        <div class="login-brand">
            <div class="brand-logo">
                <img src="{{ asset('assets/images/logo-1.png') }}" alt="Ashwani Infra">
            </div>

            <div>
                <h1>Welcome back to<br>Ashwani Infra Payroll</h1>
                <p class="tagline">Manage projects, labour, materials, subcontractors and payroll from a single construction management dashboard.</p>

                <ul class="feature-list">
                    <li><i class="fas fa-building"></i> Project &amp; site cost tracking</li>
                    <li><i class="fas fa-users"></i> Labour &amp; staff payroll</li>
                    <li><i class="fas fa-chart-line"></i> Real-time reports &amp; analytics</li>
                </ul>
            </div>

            <div class="brand-footer">
                &copy; {{ date('Y') }} Ashwani Infra. All rights reserved.
            </div>
        </div>

        <!-- Form panel -->
        <div class="login-form-wrap">
            <div class="mobile-logo">
                <img src="{{ asset('assets/images/logo-1.png') }}" alt="Ashwani Infra">
            </div>

            <h2>Sign in to your account</h2>
            <p class="sub">Enter your credentials below to access the dashboard.</p>

            @if($errors->has('err'))
                <div class="login-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first('err') }}</span>
                </div>
            @endif

            <form class="login-form" method="POST" action="{{ route('authenticate') }}" autocomplete="off">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        <button type="button" class="toggle-pass" id="togglePass" aria-label="Show password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="form-meta">
                    <label class="remember">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <!-- <a href="#">Forgot password?</a> -->
                </div>

                <button type="submit" class="btn-signin">
                    <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                </button>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('togglePass');
            var input = document.getElementById('password');
            if (!btn || !input) return;
            btn.addEventListener('click', function () {
                var isPwd = input.type === 'password';
                input.type = isPwd ? 'text' : 'password';
                btn.querySelector('i').className = isPwd ? 'fas fa-eye-slash' : 'fas fa-eye';
            });
        })();
    </script>

</body>

</html>
