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
            background: linear-gradient(135deg, #151311 0%, #29221c 55%, #191614 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .blob { position: fixed; border-radius: 50%; filter: blur(90px); opacity: .25; z-index: 0; }
        .blob-a { width: 440px; height: 440px; background: #c98a58; top: -120px; right: -80px; }
        .blob-b { width: 400px; height: 400px; background: #a86c3d; bottom: -140px; left: -90px; }
        .login-card {
            background: #fff; border-radius: 20px; padding: 44px 40px; width: 100%; max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,.5); position: relative; z-index: 1;
            border: 1px solid rgba(229, 184, 143, 0.2);
        }
        .brand-row { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
        .mark {
            width: 46px; height: 46px; border-radius: 13px;
            background: linear-gradient(135deg, #2b231d 0%, #4a3c31 100%);
            display: flex; align-items: center; justify-content: center; color: #e5b88f;
            font-size: 18px; font-weight: 800; box-shadow: 0 6px 16px rgba(0,0,0,.3);
            border: 1px solid rgba(229,184,143,0.3);
        }
        .login-card h1 { font-size: 20px; font-weight: 900; letter-spacing: -0.5px; color: #191614; }
        .login-card h1 span { color: #a86c3d; }
        .login-card .sub { color: #736c66; font-size: 13.5px; margin-bottom: 26px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 7px; color: #374151; }
        .form-group input {
            width: 100%; padding: 11px 15px; border: 1.5px solid #d1d5db; border-radius: 11px;
            font-size: 15px; transition: border-color .15s ease, box-shadow .15s ease;
        }
        .form-group input:focus { outline: none; border-color: #a86c3d; box-shadow: 0 0 0 3px rgba(168,108,61,.2); }
        .btn {
            width: 100%; padding: 13px; border: none; border-radius: 11px; background: #191614; color: #fff;
            font-size: 15.5px; font-weight: 700; cursor: pointer; transition: background .15s ease, transform .1s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,.3);
        }
        .btn:hover { background: #a86c3d; }
        .btn:active { transform: translateY(1px); }
        .error {
            background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
            padding: 12px 14px; border-radius: 11px; font-size: 14px; margin-bottom: 18px;
        }
        .error div + div { margin-top: 4px; }
        .foot { margin-top: 22px; text-align: center; color: #9ca3af; font-size: 12.5px; }
        .back-to-store {
            display: block; text-align: center; margin-top: 14px; font-size: 13px; color: #a86c3d; font-weight: 600; text-decoration: none;
        }
        .back-to-store:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="blob blob-a"></div>
    <div class="blob blob-b"></div>
    <div class="login-card">
        <div class="brand-row">
            <div class="mark">C&T</div>
            <h1>CURVES & <span>TEES</span></h1>
        </div>
        <p class="sub">Sign in to the boutique management portal</p>
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
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', 'admin@curvesandtees.com') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>
        <a href="{{ route('store.index') }}" class="back-to-store">← Return to Online Store</a>
        <div class="foot">Curves & Tees Ghana • Madina Estate</div>
    </div>
</body>
</html>