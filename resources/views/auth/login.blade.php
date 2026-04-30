@extends('layouts.auth-clean')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <title>Login — BodaBoda Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Elms+Sans:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Elms Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: '#2F6B3F',
                        'primary-dark': '#255732',
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --primary: #2F6B3F;
            --primary-dark: #1e4d2b;
            --primary-light: #3E8E5A;
        }
        * { margin:0; padding:0; box-sizing:border-box; font-family: 'Elms Sans', sans-serif; }

        body {
            font-family: 'Elms Sans', sans-serif;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        @media (max-width: 1023px) { body { grid-template-columns: 1fr; } }

        /* ═══ LEFT GREEN PANEL ═══ */
        .left-panel {
            background: linear-gradient(155deg, #2F6B3F 0%, #1e4d2b 55%, #122e19 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 56px 52px;
        }
        @media (max-width: 1023px) { .left-panel { display: none; } }

        /* Honeycomb overlay on green panel */
        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='100' viewBox='0 0 56 100'%3E%3Cpath d='M28 66L0 50L0 16L28 0L56 16L56 50L28 66L28 100' fill='none' stroke='%23ffffff' stroke-opacity='0.07' stroke-width='1.2'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 56px 100px;
            pointer-events: none;
        }

        /* blobs */
        .blob { position:absolute; border-radius:50%; filter:blur(80px); pointer-events:none; }
        .blob-1 { width:420px; height:420px; background:rgba(62,142,90,0.25); top:-120px; right:-100px; animation:blobPulse 6s ease-in-out infinite; }
        .blob-2 { width:300px; height:300px; background:rgba(18,46,25,0.5); bottom:-80px; left:-60px; animation:blobPulse 8s ease-in-out infinite reverse; }
        @keyframes blobPulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.08)} }

        /* ── Stat card ── */
        .stat-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.13);
            border-radius: 18px;
            padding: 18px 14px;
            text-align: center;
            transition: background 0.3s;
        }
        .stat-card:hover { background: rgba(255,255,255,0.15); }

        /* ── Feature row ── */
        .feature-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 16px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.09);
            border-radius: 16px;
            transition: background 0.3s, transform 0.3s;
            cursor: default;
        }
        .feature-row:hover { background: rgba(255,255,255,0.13); transform: translateX(5px); }

        .feature-icon {
            width: 36px; height: 36px; border-radius: 10px;
            background: rgba(255,255,255,0.14);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        /* ═══ RIGHT FORM PANEL ═══ */
        .right-panel {
            background-color: #EAEFEF;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='100' viewBox='0 0 56 100'%3E%3Cpath d='M28 66L0 50L0 16L28 0L56 16L56 50L28 66L28 100' fill='none' stroke='%232F6B3F' stroke-opacity='0.08' stroke-width='1'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 56px 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 24px;
            position: relative;
        }

        .form-card {
            background: #ffffff;
            border-radius: 32px;
            width: 100%;
            max-width: 440px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(47,107,63,0.13), 0 4px 16px rgba(0,0,0,0.06);
        }

        /* top accent bar */
        .card-accent {
            height: 5px;
            background: linear-gradient(90deg, #1e4d2b, #2F6B3F, #3E8E5A, #2F6B3F, #1e4d2b);
            background-size: 300% 100%;
            animation: gradMove 4s linear infinite;
        }
        @keyframes gradMove { 0%{background-position:0% 50%} 100%{background-position:200% 50%} }

        .form-body { padding: 36px 36px 32px; }
        @media (max-width: 480px) { .form-body { padding: 28px 20px 24px; } }

        /* ── Badge ── */
        .badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(47,107,63,0.08);
            border: 1px solid rgba(47,107,63,0.2);
            border-radius: 999px;
            padding: 5px 14px; margin-bottom: 20px;
        }
        .badge-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--primary);
            animation: dotPulse 2s ease-in-out infinite;
        }
        @keyframes dotPulse { 0%,100%{opacity:1} 50%{opacity:0.4} }
        .badge span { font-size: 10px; font-weight: 800; color: var(--primary); text-transform: uppercase; letter-spacing: 0.18em; }

        /* ── Input ── */
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
            font-family: 'Elms Sans', sans-serif;
            font-size: 14px; font-weight: 500; color: #1a1a1a;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .form-input::placeholder { color: #b0bdb5; font-weight: 400; }
        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(47,107,63,0.1);
            background: #fff;
        }
        .input-hint { font-size: 10px; color: #aab5b0; margin-top: 6px; }

        /* ── Submit ── */
        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white; border: none; border-radius: 14px;
            font-family: 'Elms Sans', sans-serif;
            font-size: 12px; font-weight: 800; letter-spacing: 0.14em;
            text-transform: uppercase; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 8px 24px rgba(47,107,63,0.3);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(47,107,63,0.42); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }

        /* ── Divider ── */
        .divider { border: none; border-top: 1px solid #f0f0f0; margin: 24px 0; }

        /* ── Checkbox ── */
        input[type="checkbox"] { accent-color: var(--primary); }

        /* ── Trust strip ── */
        .trust-strip { display:flex; align-items:center; justify-content:center; gap:20px; margin-top:18px; }
        .trust-item { display:flex; align-items:center; gap:6px; color:#b0bdb5; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:0.14em; }

        /* ── Progress bar ── */
        .progress-wrap {
            position: fixed; top:0; left:0; width:100%; height:3px;
            background: rgba(47,107,63,0.12); z-index:9999;
            opacity:0; visibility:hidden; transition:opacity 0.2s;
        }
        .progress-wrap.active { opacity:1; visibility:visible; }
        .progress-bar { height:100%; background:linear-gradient(90deg,#1e4d2b,#3E8E5A,#1e4d2b); background-size:200%; }
        .progress-bar.running { animation:progSlide 1.3s ease-in-out infinite, gradMove 1.5s linear infinite; width:100%; }
        @keyframes progSlide { 0%{transform:translateX(-100%)} 100%{transform:translateX(100%)} }

        /* ── Modal ── */
        .modal {
            position:fixed; inset:0; background:rgba(0,0,0,0.5);
            display:flex; align-items:center; justify-content:center;
            z-index:1000; opacity:0; visibility:hidden;
            transition:opacity 0.3s, visibility 0.3s;
            backdrop-filter:blur(6px);
        }
        .modal.active { opacity:1; visibility:visible; }
        .modal-box {
            background:#fff; border-radius:28px; max-width:420px; width:90%;
            transform:scale(0.92); transition:transform 0.3s;
            box-shadow:0 32px 72px rgba(0,0,0,0.18); overflow:hidden;
        }
        .modal.active .modal-box { transform:scale(1); }

        /* ── Alerts ── */
        .alert-error   { background:#fef2f2; border:1px solid #fecaca; color:#dc2626; }
        .alert-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; }
        .alert-base { border-radius:14px; padding:12px 14px; font-size:11px; font-weight:700; display:flex; align-items:flex-start; gap:8px; }

        /* ── Scroll ── */
        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-track { background:#EAEFEF; }
        ::-webkit-scrollbar-thumb { background:linear-gradient(#2F6B3F,#3E8E5A); border-radius:6px; }

        /* ── Reveal ── */
        @keyframes fadeUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
        .fade-up { animation:fadeUp 0.55s cubic-bezier(0.22,1,0.36,1) both; }
        .d1{animation-delay:.08s} .d2{animation-delay:.16s} .d3{animation-delay:.24s}
        .d4{animation-delay:.32s} .d5{animation-delay:.4s}
    </style>
</head>
<body>

<!-- Progress Bar -->
<div class="progress-wrap" id="progressWrap">
    <div class="progress-bar" id="progressBar"></div>
</div>

<!-- ════════ LEFT — GREEN BRAND PANEL ════════ -->
<div class="left-panel">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <!-- Top: brand + copy -->
    <div style="position:relative;z-index:1;">
        <!-- Brand pill -->
        <div style="display:inline-flex;align-items:center;gap:10px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.18);border-radius:999px;padding:7px 18px;margin-bottom:40px;">
            <span style="width:7px;height:7px;border-radius:50%;background:#fff;animation:dotPulse 2s infinite;"></span>
            <span style="font-size:10px;font-weight:800;color:#fff;text-transform:uppercase;letter-spacing:0.2em;">BodaBoda Digital</span>
        </div>

        <h1 style="font-size:52px;font-weight:900;color:#fff;letter-spacing:-0.04em;line-height:0.88;text-transform:uppercase;margin-bottom:18px;">
            Ride <br>
            <span style="background:linear-gradient(135deg,#fff,rgba(255,255,255,0.45));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Smarter.</span>
        </h1>
        <p style="color:rgba(255,255,255,0.6);font-size:15px;line-height:1.65;max-width:280px;margin-bottom:36px;">
            Dodoma's most trusted motorcycle ride-hailing platform — fast, safe, and always transparent.
        </p>

        <!-- Features -->
        <div style="display:flex;flex-direction:column;gap:10px;">
            @foreach([
                ['fa-map-marker-alt', 'Real-time GPS Tracking',   'Know exactly where your rider is'],
                ['fa-tag',            'Transparent Flat Pricing',  'No surge. No hidden fees. Ever.'],
                ['fa-user-shield',    'Verified & Vetted Riders',  'Every rider background-checked'],
                ['fa-headset',        '24 / 7 Customer Support',   'We\'re always here for you'],
            ] as [$ico, $title, $sub])
            <div class="feature-row">
                <div class="feature-icon">
                    <i class="fas {{ $ico }}" style="color:#fff;font-size:13px;"></i>
                </div>
                <div>
                    <p style="color:#fff;font-size:13px;font-weight:700;line-height:1.2;">{{ $title }}</p>
                    <p style="color:rgba(255,255,255,0.48);font-size:11px;margin-top:1px;">{{ $sub }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Bottom: stats -->
    <div style="position:relative;z-index:1;">
        <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:28px;margin-top:10px;">
            <p style="font-size:9px;font-weight:800;color:rgba(255,255,255,0.3);text-transform:uppercase;letter-spacing:0.25em;margin-bottom:16px;">Platform Stats</p>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
                @foreach([
                    ['10K+',  'Passengers', 'fa-users'],
                    ['4.9 ★', 'Avg Rating', 'fa-star'],
                    ['3 Min', 'Pickup',     'fa-clock'],
                ] as [$v,$l,$i])
                <div class="stat-card">
                    <i class="fas {{ $i }}" style="color:rgba(255,255,255,0.25);font-size:11px;margin-bottom:6px;display:block;"></i>
                    <div style="font-size:20px;font-weight:900;color:#fff;line-height:1;margin-bottom:4px;">{{ $v }}</div>
                    <div style="font-size:9px;font-weight:700;color:rgba(255,255,255,0.45);text-transform:uppercase;letter-spacing:0.12em;line-height:1.3;">{{ $l }}</div>
                </div>
                @endforeach
            </div>
            <p style="font-size:9px;font-weight:600;color:rgba(255,255,255,0.2);text-align:center;margin-top:20px;text-transform:uppercase;letter-spacing:0.2em;">
                Secured by BodaBoda &middot; Dodoma, Tanzania
            </p>
        </div>
    </div>
</div>

<!-- ════════ RIGHT — FORM PANEL ════════ -->
<div class="right-panel">
    <div style="width:100%;max-width:440px;">

        <!-- Card -->
        <div class="form-card fade-up">
            <div class="card-accent"></div>
            <div class="form-body">

                <!-- Header -->
                <div class="fade-up d1">
                    <div class="badge">
                        <span class="badge-dot"></span>
                        <span>Secure Login</span>
                    </div>
                    <h2 style="font-size:32px;font-weight:900;color:#111827;letter-spacing:-0.04em;text-transform:uppercase;line-height:0.92;margin-bottom:8px;">
                        Welcome <br> Back.
                    </h2>
                    <p style="color:#9ca3af;font-size:13px;line-height:1.6;margin-top:10px;">
                        Sign in to book rides, track deliveries, and manage your account.
                    </p>
                </div>

                <!-- Errors -->
                @if($errors->any())
                <div class="alert-base alert-error fade-up" style="margin-top:18px;">
                    <i class="fas fa-exclamation-circle" style="margin-top:1px;flex-shrink:0;"></i>
                    <div>
                        @foreach($errors->all() as $err)
                        <p>{{ $err }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(session('success'))
                <div class="alert-base alert-success fade-up" style="margin-top:18px;">
                    <i class="fas fa-check-circle" style="margin-top:1px;flex-shrink:0;"></i>
                    <p>{{ session('success') }}</p>
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login') }}" method="POST" id="login-form" style="margin-top:22px;">
                    @csrf

                    <!-- Email -->
                    <div style="margin-bottom:18px;" class="fade-up d2">
                        <label class="field-label">Email Address or Card Number</label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="text" name="email" id="email"
                                   value="{{ old('email') }}" required
                                   class="form-input"
                                   placeholder="hello@bodaboda.co.tz or BODA-2025-0001">
                        </div>
                        <p class="input-hint"><i class="fas fa-info-circle"></i> Members can use their rider card number</p>
                    </div>

                    <!-- Password -->
                    <div style="margin-bottom:14px;" class="fade-up d3">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                            <label class="field-label" style="margin-bottom:0;">Password</label>
                            <a href="#" onclick="openModal('forgot-modal')"
                               style="font-size:10px;font-weight:800;color:var(--primary);text-transform:uppercase;letter-spacing:0.14em;text-decoration:none;">
                                Forgot Password?
                            </a>
                        </div>
                        <div class="input-wrap">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" id="password"
                                   required class="form-input" style="padding-right:46px;"
                                   placeholder="••••••••">
                            <button type="button" onclick="togglePassword()"
                                    style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#aab5b0;font-size:14px;transition:color 0.2s;"
                                    onmouseover="this.style.color='#2F6B3F'" onmouseout="this.style.color='#aab5b0'">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember -->
                    <div style="display:flex;align-items:center;gap:10px;margin-bottom:22px;" class="fade-up d3">
                        <input type="checkbox" name="remember" id="remember"
                               style="width:15px;height:15px;border-radius:4px;cursor:pointer;accent-color:#2F6B3F;">
                        <label for="remember"
                               style="font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.15em;cursor:pointer;user-select:none;">
                            Keep me signed in
                        </label>
                    </div>

                    <!-- Submit -->
                    <div class="fade-up d4">
                        <button type="submit" class="btn-submit" id="submit-btn">
                            <i class="fas fa-sign-in-alt" id="submit-icon"></i>
                            <span id="submit-text">Sign In</span>
                            <i class="fas fa-arrow-right" style="font-size:11px;"></i>
                        </button>
                    </div>
                </form>

                <hr class="divider">

                <!-- Footer -->
                <div class="fade-up d5" style="text-align:center;">
                    <p style="font-size:12px;color:#9ca3af;font-weight:600;margin-bottom:10px;">
                        New to BodaBoda?
                        <a href="{{ route('register') }}"
                           style="color:var(--primary);font-weight:800;text-decoration:none;margin-left:4px;"
                           onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            Create Free Account
                        </a>
                    </p>
                    <a href="{{ route('home') }}"
                       style="display:inline-flex;align-items:center;gap:6px;font-size:10px;font-weight:800;color:#c4cfc8;text-transform:uppercase;letter-spacing:0.15em;text-decoration:none;transition:color 0.2s;"
                       onmouseover="this.style.color='#2F6B3F'" onmouseout="this.style.color='#c4cfc8'">
                        <i class="fas fa-arrow-left" style="font-size:10px;"></i>
                        Back to Home
                    </a>
                </div>

            </div>
        </div>

        <!-- Trust strip -->
        <div class="trust-strip">
            @foreach(['fa-shield-alt,Verified Riders', 'fa-lock,Secure & Encrypted', 'fa-headset,24/7 Support'] as $item)
            @php [$ico, $txt] = explode(',', $item); @endphp
            <div class="trust-item">
                <i class="fas {{ $ico }}" style="font-size:11px;"></i>
                <span>{{ $txt }}</span>
            </div>
            @endforeach
        </div>

    </div>
</div>

<!-- ════════ FORGOT PASSWORD MODAL ════════ -->
<div id="forgot-modal" class="modal">
    <div class="modal-box">
        <div style="height:4px;background:linear-gradient(90deg,#2F6B3F,#3E8E5A);"></div>
        <div style="padding:28px 28px 24px;position:relative;">
            <button onclick="closeModal('forgot-modal')"
                    style="position:absolute;top:18px;right:18px;width:32px;height:32px;border-radius:50%;background:#f3f4f6;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:#6b7280;font-size:14px;transition:background 0.2s;"
                    onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                <i class="fas fa-times"></i>
            </button>

            <div style="text-align:center;margin-bottom:22px;">
                <div style="width:52px;height:52px;border-radius:16px;background:rgba(47,107,63,0.1);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                    <i class="fas fa-key" style="color:#2F6B3F;font-size:20px;"></i>
                </div>
                <h3 style="font-size:20px;font-weight:900;color:#111827;text-transform:uppercase;letter-spacing:-0.02em;margin-bottom:4px;">Reset Password</h3>
                <p style="font-size:13px;color:#9ca3af;">Enter your email to receive a reset link.</p>
            </div>

            <div id="forgot-error" class="alert-base alert-error" style="display:none;margin-bottom:14px;">
                <i class="fas fa-exclamation-circle" style="flex-shrink:0;"></i>
                <span id="forgot-error-text"></span>
            </div>
            <div id="forgot-success" class="alert-base alert-success" style="display:none;margin-bottom:14px;">
                <i class="fas fa-check-circle" style="flex-shrink:0;"></i>
                <span id="forgot-success-text"></span>
            </div>

            <form id="reset-form" action="{{ route('password.email') }}" method="POST" style="margin-bottom:16px;">
                @csrf
                <label class="field-label" style="margin-bottom:8px;display:block;">Registration Email</label>
                <input type="email" name="email" id="reset-email"
                       class="form-input" style="padding-left:14px;margin-bottom:14px;"
                       placeholder="hello@bodaboda.co.tz" required>
                <button type="submit" id="reset-btn" class="btn-submit">
                    <i class="fas fa-paper-plane" id="reset-icon"></i>
                    <span id="reset-text">Send Reset Link</span>
                </button>
            </form>

            <div style="background:#f4f7f5;border:1px solid #d1e8d9;border-radius:14px;padding:14px;">
                <p style="font-size:10px;font-weight:800;color:#6b7280;text-transform:uppercase;letter-spacing:0.15em;margin-bottom:8px;">Need Help?</p>
                <p style="font-size:12px;color:#9ca3af;margin-bottom:4px;"><i class="fas fa-phone" style="color:#2F6B3F;margin-right:6px;"></i>+255 700 000 000</p>
                <p style="font-size:12px;color:#9ca3af;"><i class="fas fa-envelope" style="color:#2F6B3F;margin-right:6px;"></i>support@bodaboda.co.tz</p>
            </div>

            <p style="text-align:center;font-size:12px;color:#9ca3af;margin-top:14px;">
                Remember your password?
                <a href="#" onclick="closeModal('forgot-modal')" style="color:#2F6B3F;font-weight:700;">Sign In</a>
            </p>
        </div>
    </div>
</div>

<!-- ════════ ALERT MODAL ════════ -->
<div id="alert-modal" class="modal">
    <div class="modal-box" style="padding:28px;text-align:center;">
        <div id="alert-icon-wrap" style="width:60px;height:60px;border-radius:50%;background:#dcfce7;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <i id="alert-icon" class="fas fa-check-circle" style="font-size:26px;color:#16a34a;"></i>
        </div>
        <h3 id="alert-title" style="font-size:18px;font-weight:900;color:#111827;text-transform:uppercase;margin-bottom:8px;">Success!</h3>
        <p id="alert-msg" style="color:#9ca3af;font-size:13px;margin-bottom:20px;">Your message here.</p>
        <button onclick="closeModal('alert-modal')" class="btn-submit" style="padding:12px;">
            <i class="fas fa-check"></i> Got It
        </button>
    </div>
</div>

<script>
    function openModal(id)  { document.getElementById(id).classList.add('active'); document.body.style.overflow='hidden'; }
    function closeModal(id) { document.getElementById(id).classList.remove('active'); document.body.style.overflow=''; }

    window.addEventListener('click', e => { if(e.target.classList.contains('modal')) closeModal(e.target.id); });
    document.addEventListener('keydown', e => { if(e.key==='Escape') document.querySelectorAll('.modal.active').forEach(m=>closeModal(m.id)); });

    function togglePassword() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye','fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash','fa-eye');
        }
    }

    document.getElementById('login-form').addEventListener('submit', function() {
        const wrap = document.getElementById('progressWrap');
        const bar  = document.getElementById('progressBar');
        const btn  = document.getElementById('submit-btn');
        wrap.classList.add('active');
        bar.classList.add('running');
        btn.disabled = true;
        document.getElementById('submit-icon').className = 'fas fa-spinner fa-spin';
        document.getElementById('submit-text').textContent = 'Signing In…';
    });

    window.addEventListener('pageshow', e => {
        if (e.persisted) {
            document.getElementById('progressWrap').classList.remove('active');
            document.getElementById('progressBar').classList.remove('running');
            const btn = document.getElementById('submit-btn');
            btn.disabled = false;
            document.getElementById('submit-icon').className = 'fas fa-sign-in-alt';
            document.getElementById('submit-text').textContent = 'Sign In';
        }
    });

    document.getElementById('reset-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn  = document.getElementById('reset-btn');
        const errD = document.getElementById('forgot-error');
        const errT = document.getElementById('forgot-error-text');
        const okD  = document.getElementById('forgot-success');
        const okT  = document.getElementById('forgot-success-text');

        errD.style.display = 'none'; okD.style.display = 'none';
        btn.disabled = true;
        document.getElementById('reset-icon').className = 'fas fa-spinner fa-spin';
        document.getElementById('reset-text').textContent = 'Sending…';

        fetch(this.action, { method:'POST', body:new FormData(this), headers:{'X-Requested-With':'XMLHttpRequest'} })
        .then(r => r.json().then(d => ({status:r.status, d})))
        .then(({status, d}) => {
            btn.disabled = false;
            document.getElementById('reset-icon').className = 'fas fa-paper-plane';
            document.getElementById('reset-text').textContent = 'Send Reset Link';
            if (status === 200 || d.success) {
                okT.textContent = d.message || 'Reset link sent! Check your inbox.';
                okD.style.display = 'flex';
                this.reset();
                setTimeout(() => { closeModal('forgot-modal'); showAlert('success','Email Sent!',okT.textContent); }, 2000);
            } else {
                errT.textContent = d.message || d.errors?.email?.[0] || 'Something went wrong.';
                errD.style.display = 'flex';
            }
        })
        .catch(() => {
            btn.disabled = false;
            document.getElementById('reset-icon').className = 'fas fa-paper-plane';
            document.getElementById('reset-text').textContent = 'Send Reset Link';
            errT.textContent = 'Network error. Please try again.';
            errD.style.display = 'flex';
        });
    });

    function showAlert(type, title, msg) {
        const map = {
            success: { bg:'#dcfce7', ico:'fa-check-circle', color:'#16a34a' },
            error:   { bg:'#fee2e2', ico:'fa-times-circle', color:'#dc2626' },
        };
        const c = map[type] || map.success;
        document.getElementById('alert-icon-wrap').style.background = c.bg;
        document.getElementById('alert-icon').className = `fas ${c.ico}`;
        document.getElementById('alert-icon').style.color = c.color;
        document.getElementById('alert-title').textContent = title;
        document.getElementById('alert-msg').textContent = msg;
        openModal('alert-modal');
    }

    document.addEventListener('DOMContentLoaded', () => document.getElementById('email')?.focus());
</script>
</body>
</html>
@endsection