<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curves & Tees Admin Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #151311 0%, #241e19 55%, #181513 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .blob { position: fixed; border-radius: 50%; filter: blur(90px); opacity: .22; z-index: 0; }
        .blob-a { width: 440px; height: 440px; background: #c58b2b; top: -120px; right: -80px; }
        .blob-b { width: 400px; height: 400px; background: #a8721c; bottom: -140px; left: -90px; }
        .login-card {
            background: #fff; border-radius: 20px; padding: 40px 36px; width: 100%; max-width: 430px;
            box-shadow: 0 25px 60px rgba(0,0,0,.5); position: relative; z-index: 1;
            border: 1.5px solid rgba(197, 139, 43, 0.35);
        }
        .logo-wrap {
            background: #ffffff; padding: 14px 18px; border-radius: 14px;
            border: 1px solid rgba(197, 139, 43, 0.3); margin-bottom: 20px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06); text-align: center;
        }
        .logo-wrap img {
            max-width: 100%; height: 48px; object-fit: contain; margin: 0 auto; display: block;
        }
        .portal-title {
            text-align: center; margin-bottom: 24px;
        }
        .portal-title h2 {
            font-size: 16px; font-weight: 800; color: #181513; text-transform: uppercase; letter-spacing: 1px;
        }
        .portal-title p {
            color: #736c66; font-size: 13px; margin-top: 4px;
        }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 7px; color: #374151; }
        .form-group input {
            width: 100%; padding: 12px 15px; border: 1.5px solid #d1d5db; border-radius: 11px;
            font-size: 14.5px; transition: border-color .15s ease, box-shadow .15s ease;
        }
        .form-group input:focus { outline: none; border-color: #c58b2b; box-shadow: 0 0 0 3px rgba(197, 139, 43, 0.2); }
        .btn {
            width: 100%; padding: 13px; border: none; border-radius: 11px; background: #181513; color: #f5d496;
            font-size: 15px; font-weight: 700; cursor: pointer; transition: background .15s ease, transform .1s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,.3); border: 1px solid rgba(197, 139, 43, 0.4);
        }
        .btn:hover { background: #c58b2b; color: #fff; border-color: #c58b2b; }
        .btn:active { transform: translateY(1px); }
        .error {
            background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
            padding: 12px 14px; border-radius: 11px; font-size: 14px; margin-bottom: 18px;
        }
        .error div + div { margin-top: 4px; }
        .foot { margin-top: 22px; text-align: center; color: #9ca3af; font-size: 12px; }
        .back-to-store {
            display: block; text-align: center; margin-top: 14px; font-size: 13px; color: #c58b2b; font-weight: 700; text-decoration: none;
        }
        .back-to-store:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="blob blob-a"></div>
    <div class="blob blob-b"></div>
    <div class="login-card">
        <div class="logo-wrap">
            <img src="{{ asset('images/curves-logo.png') }}" alt="Curves & Tees Logo">
        </div>
        <div class="portal-title">
            <h2>Boutique Administration</h2>
            <p>Sign in to manage catalog, orders & client leads</p>
        </div>
        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="email">Admin Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', 'admin@curvesandtees.com') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn">Sign In to Dashboard</button>
        </form>
        <a href="{{ route('store.index') }}" class="back-to-store">← Return to Online Store</a>
        <div class="foot">Curves & Tees Ghana • Madina Estate, Accra</div>
    </div>
</body>
</html>