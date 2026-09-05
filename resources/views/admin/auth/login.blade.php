<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Streetman Cafe & Flames Admin Login</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, #0f1117 0%, #1a0f0f 55%, #111827 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .blob { position: fixed; border-radius: 50%; filter: blur(80px); opacity: .35; z-index: 0; }
        .blob-a { width: 420px; height: 420px; background: #b91c1c; top: -120px; right: -80px; }
        .blob-b { width: 380px; height: 380px; background: #f59e0b; bottom: -140px; left: -90px; }
        .login-card {
            background: #fff; border-radius: 20px; padding: 44px 40px; width: 100%; max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,.45); position: relative; z-index: 1;
        }
        .brand-row { display: flex; align-items: center; gap: 12px; margin-bottom: 8px; }
        .mark {
            width: 46px; height: 46px; border-radius: 13px; background: #b91c1c;
            display: flex; align-items: center; justify-content: center; color: #fff;
            font-size: 22px; font-weight: 800; box-shadow: 0 6px 16px rgba(185,28,28,.4);
            overflow: hidden;
        }
        .mark img { width: 100%; height: 100%; object-fit: cover; }
        .login-card h1 { font-size: 20px; font-weight: 900; letter-spacing: -0.5px; color: #111827; }
        .login-card h1 span { color: #b91c1c; }
        .login-card .sub { color: #6b7280; font-size: 13.5px; margin-bottom: 26px; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 13.5px; font-weight: 600; margin-bottom: 7px; color: #374151; }
        .form-group input {
            width: 100%; padding: 11px 15px; border: 1.5px solid #d1d5db; border-radius: 11px;
            font-size: 15px; transition: border-color .15s ease, box-shadow .15s ease;
        }
        .form-group input:focus { outline: none; border-color: #b91c1c; box-shadow: 0 0 0 3px rgba(185,28,28,.2); }
        .btn {
            width: 100%; padding: 13px; border: none; border-radius: 11px; background: #b91c1c; color: #fff;
            font-size: 15.5px; font-weight: 700; cursor: pointer; transition: background .15s ease, transform .1s ease;
            box-shadow: 0 4px 12px rgba(185,28,28,.35);
        }
        .btn:hover { background: #991b1b; }
        .btn:active { transform: translateY(1px); }
        .error {
            background: #fef2f2; border: 1px solid #fecaca; color: #991b1b;
            padding: 12px 14px; border-radius: 11px; font-size: 14px; margin-bottom: 18px;
        }
        .error div + div { margin-top: 4px; }
        .foot { margin-top: 22px; text-align: center; color: #9ca3af; font-size: 12.5px; }
    </style>
</head>
<body>
    <div class="blob blob-a"></div>
    <div class="blob blob-b"></div>
    <div class="login-card">
        <div class="brand-row">
            <div class="mark"><img src="/images/streetman-logo.png" alt="Streetman" onerror="this.onerror=null;this.parentElement.innerHTML='🔥';"></div>
            <h1>STREETMAN <span>CAFE & FLAMES</span></h1>
        </div>
        <p class="sub">Sign in to the administration portal</p>
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
                <input type="email" name="email" id="email" value="{{ old('email', 'admin@streetman.com') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>
        <div class="foot">Streetman Cafe & Flames Management System</div>
    </div>
</body>
</html>