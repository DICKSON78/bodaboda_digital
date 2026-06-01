@extends('layouts.auth-clean')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password — BodaBoda Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Elms+Sans:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Elms Sans', 'sans-serif'] },
                    colors: { primary: '#2F6B3F', 'primary-dark': '#255732' }
                }
            }
        }
    </script>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Elms Sans', sans-serif; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #EAEFEF;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='100' viewBox='0 0 56 100'%3E%3Cpath d='M28 66L0 50L0 16L28 0L56 16L56 50L28 66L28 100' fill='none' stroke='%232F6B3F' stroke-opacity='0.08' stroke-width='1'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 56px 100px;
            padding: 24px;
        }
        .card {
            background: #fff;
            border-radius: 32px;
            width: 100%;
            max-width: 420px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(47,107,63,0.13);
        }
        .card-accent {
            height: 5px;
            background: linear-gradient(90deg, #1e4d2b, #2F6B3F, #3E8E5A, #2F6B3F, #1e4d2b);
            background-size: 300% 100%;
            animation: gradMove 4s linear infinite;
        }
        @keyframes gradMove { 0%{background-position:0% 50%} 100%{background-position:200% 50%} }
        .body { padding: 36px; }
        .field-label {
            display: block; font-size: 10px; font-weight: 800;
            color: #9ca3af; text-transform: uppercase; letter-spacing: 0.18em;
            margin-bottom: 8px;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #aab5b0; font-size: 14px; pointer-events: none;
        }
        .form-input {
            width: 100%;
            padding: 14px 14px 14px 42px;
            background: #f4f7f5;
            border: 2px solid #e2ebe4;
            border-radius: 14px;
            font-size: 14px; font-weight: 500; color: #1a1a1a;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .form-input:focus {
            border-color: #2F6B3F;
            box-shadow: 0 0 0 4px rgba(47,107,63,0.1);
            background: #fff;
        }
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #2F6B3F 0%, #1e4d2b 100%);
            color: white; border: none; border-radius: 14px;
            font-size: 12px; font-weight: 800; letter-spacing: 0.14em;
            text-transform: uppercase; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 8px 24px rgba(47,107,63,0.3);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(47,107,63,0.42); }
        .alert-error { background:#fef2f2; border:1px solid #fecaca; color:#dc2626; border-radius:14px; padding:12px 14px; font-size:11px; font-weight:700; display:flex; align-items:flex-start; gap:8px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-accent"></div>
        <div class="body">
            <div style="text-align:center;margin-bottom:24px;">
                <div style="width:56px;height:56px;border-radius:16px;background:rgba(47,107,63,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                    <i class="fas fa-shield-alt" style="color:#2F6B3F;font-size:22px;"></i>
                </div>
                <h2 style="font-size:24px;font-weight:900;color:#111827;text-transform:uppercase;letter-spacing:-0.02em;margin-bottom:6px;">Confirm Password</h2>
                <p style="color:#9ca3af;font-size:13px;">Please confirm your password before performing this sensitive action.</p>
            </div>

            @if($errors->any())
            <div class="alert-error" style="margin-bottom:16px;">
                <i class="fas fa-exclamation-circle" style="margin-top:1px;"></i>
                <div>
                    @foreach($errors->all() as $err)
                    <p>{{ $err }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            <form action="{{ route('password.confirm') }}" method="POST">
                @csrf
                <div style="margin-bottom:20px;">
                    <label class="field-label">Your Password</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" required class="form-input" placeholder="Enter your password to continue">
                    </div>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-check-circle"></i> Confirm
                </button>
            </form>

            <p style="text-align:center;margin-top:16px;">
                <a href="{{ route('dashboard') }}" style="font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.15em;text-decoration:none;">
                    <i class="fas fa-arrow-left" style="margin-right:6px;"></i>Back to Dashboard
                </a>
            </p>
        </div>
    </div>
</body>
</html>
@endsection
