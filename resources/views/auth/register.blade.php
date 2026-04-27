@extends('layouts.auth-clean')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <title>Register — BodaBoda Digital</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #2F6B3F;
            --primary-dark: #1e4d2b;
            --primary-light: #3E8E5A;
        }
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Poppins', sans-serif;
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
            padding: 52px 48px;
        }
        @media (max-width: 1023px) { .left-panel { display: none; } }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='100' viewBox='0 0 56 100'%3E%3Cpath d='M28 66L0 50L0 16L28 0L56 16L56 50L28 66L28 100' fill='none' stroke='%23ffffff' stroke-opacity='0.07' stroke-width='1.2'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 56px 100px;
            pointer-events: none;
        }

        .blob { position:absolute; border-radius:50%; filter:blur(80px); pointer-events:none; }
        .blob-1 { width:380px; height:380px; background:rgba(62,142,90,0.22); top:-100px; right:-80px; animation:blobPulse 6s ease-in-out infinite; }
        .blob-2 { width:280px; height:280px; background:rgba(18,46,25,0.5); bottom:-60px; left:-50px; animation:blobPulse 8s ease-in-out infinite reverse; }
        @keyframes blobPulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.08)} }

        /* ── Step tracker (left panel) ── */
        .tracker-step {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            position: relative;
        }
        .tracker-step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 19px;
            top: 42px;
            width: 2px;
            height: calc(100% - 4px);
            background: rgba(255,255,255,0.15);
        }
        .tracker-step.done::after  { background: rgba(255,255,255,0.4); }
        .tracker-num {
            width: 38px; height: 38px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 800; flex-shrink: 0;
            border: 2px solid rgba(255,255,255,0.2);
            color: rgba(255,255,255,0.5);
            background: rgba(255,255,255,0.06);
            transition: all 0.4s;
        }
        .tracker-step.active .tracker-num {
            background: #fff;
            color: var(--primary);
            border-color: #fff;
            box-shadow: 0 4px 16px rgba(0,0,0,0.2);
        }
        .tracker-step.done .tracker-num {
            background: rgba(255,255,255,0.18);
            color: #fff;
            border-color: rgba(255,255,255,0.5);
        }
        .tracker-label { padding-top: 8px; }
        .tracker-title {
            font-size: 13px; font-weight: 800; text-transform: uppercase;
            letter-spacing: 0.1em; transition: color 0.4s;
            color: rgba(255,255,255,0.4);
        }
        .tracker-step.active .tracker-title { color: #fff; }
        .tracker-step.done .tracker-title   { color: rgba(255,255,255,0.65); }
        .tracker-sub {
            font-size: 11px; color: rgba(255,255,255,0.3);
            margin-top: 2px; line-height: 1.4;
        }

        /* ── Stat card ── */
        .stat-card {
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.13);
            border-radius: 18px;
            padding: 16px 12px;
            text-align: center;
            transition: background 0.3s;
        }
        .stat-card:hover { background: rgba(255,255,255,0.14); }

        /* ═══ RIGHT FORM PANEL ═══ */
        .right-panel {
            background-color: #EAEFEF;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='56' height='100' viewBox='0 0 56 100'%3E%3Cpath d='M28 66L0 50L0 16L28 0L56 16L56 50L28 66L28 100' fill='none' stroke='%232F6B3F' stroke-opacity='0.08' stroke-width='1'/%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 56px 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            overflow-y: auto;
        }

        .form-card {
            background: #fff;
            border-radius: 32px;
            width: 100%;
            max-width: 460px;
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

        .form-body { padding: 32px 34px 28px; }
        @media (max-width:480px) { .form-body { padding: 24px 18px 20px; } }

        /* ── Badge ── */
        .badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(47,107,63,0.08);
            border: 1px solid rgba(47,107,63,0.2);
            border-radius: 999px; padding: 5px 14px; margin-bottom: 16px;
        }
        .badge-dot {
            width: 6px; height: 6px; border-radius: 50%;
            background: var(--primary);
            animation: dotPulse 2s ease-in-out infinite;
        }
        @keyframes dotPulse { 0%,100%{opacity:1} 50%{opacity:0.35} }
        .badge span { font-size: 10px; font-weight: 800; color: var(--primary); text-transform: uppercase; letter-spacing: 0.18em; }

        /* ── Step progress bar (inside card) ── */
        .step-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 24px;
        }
        .step-dot {
            width: 32px; height: 32px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800;
            border: 2px solid #e5e7eb;
            color: #d1d5db; background: #f9fafb;
            transition: all 0.35s cubic-bezier(0.22,1,0.36,1);
            position: relative; z-index: 1;
        }
        .step-dot.active {
            background: var(--primary); color: #fff;
            border-color: var(--primary);
            box-shadow: 0 4px 14px rgba(47,107,63,0.35);
        }
        .step-dot.done {
            background: #d1fae5; color: #059669;
            border-color: #6ee7b7;
        }
        .step-conn {
            flex: 1; height: 2px; max-width: 60px;
            background: #e5e7eb;
            transition: background 0.4s;
        }
        .step-conn.done { background: #6ee7b7; }
        .step-label-row {
            display: flex;
            justify-content: space-between;
            padding: 0 4px;
            margin-top: 6px;
            margin-bottom: 20px;
        }
        .step-lbl {
            font-size: 9px; font-weight: 800; text-transform: uppercase;
            letter-spacing: 0.12em; color: #d1d5db;
            text-align: center; flex:1;
            transition: color 0.35s;
        }
        .step-lbl.active { color: var(--primary); }
        .step-lbl.done   { color: #059669; }

        /* ── Input ── */
        .field-label {
            display: block; font-size: 10px; font-weight: 800;
            color: #9ca3af; text-transform: uppercase; letter-spacing: 0.18em;
            margin-bottom: 7px;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #aab5b0; font-size: 13px; pointer-events: none;
        }
        .form-input {
            width: 100%;
            padding: 13px 13px 13px 40px;
            background: #f4f7f5;
            border: 2px solid #e2ebe4;
            border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px; font-weight: 500; color: #1a1a1a;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        }
        .form-input::placeholder { color: #b0bdb5; font-weight: 400; }
        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(47,107,63,0.1);
            background: #fff;
        }
        .form-input.error { border-color: #f87171; }
        .field-error { font-size: 11px; color: #ef4444; margin-top: 5px; }

        /* ── Password strength ── */
        .strength-bar {
            height: 3px; border-radius: 2px; margin-top: 6px;
            background: #e5e7eb; overflow: hidden;
        }
        .strength-fill {
            height: 100%; border-radius: 2px;
            transition: width 0.4s, background 0.4s;
            width: 0%;
        }
        .strength-label { font-size: 10px; margin-top: 4px; font-weight: 700; }

        /* ── Review card ── */
        .review-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 10px 0; border-bottom: 1px solid #f3f4f6;
        }
        .review-row:last-child { border-bottom: none; }
        .review-key { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.12em; }
        .review-val { font-size: 13px; font-weight: 700; color: #111827; }

        /* ── Buttons ── */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white; border: none; border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 12px; font-weight: 800; letter-spacing: 0.14em;
            text-transform: uppercase; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 8px 24px rgba(47,107,63,0.3);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 14px 32px rgba(47,107,63,0.42); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: 0.65; cursor: not-allowed; transform: none; }

        .btn-back {
            padding: 14px 20px;
            background: #f4f7f5; color: #6b7280;
            border: 2px solid #e2ebe4; border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 12px; font-weight: 800; letter-spacing: 0.1em;
            text-transform: uppercase; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: all 0.2s;
        }
        .btn-back:hover { background: #e8f0ea; color: var(--primary); border-color: #c5dcc9; }

        .btn-next {
            flex: 1;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white; border: none; border-radius: 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 12px; font-weight: 800; letter-spacing: 0.12em;
            text-transform: uppercase; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 6px 18px rgba(47,107,63,0.28);
        }
        .btn-next:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(47,107,63,0.38); }

        /* ── Form steps ── */
        .form-step { display: none; animation: stepIn 0.4s cubic-bezier(0.22,1,0.36,1); }
        .form-step.active { display: block; }
        @keyframes stepIn { from{opacity:0;transform:translateX(16px)} to{opacity:1;transform:translateX(0)} }

        /* ── Alert ── */
        .alert-error   { background:#fef2f2; border:1px solid #fecaca; color:#dc2626; }
        .alert-success { background:#f0fdf4; border:1px solid #bbf7d0; color:#15803d; }
        .alert-base { border-radius:14px; padding:12px 14px; font-size:11px; font-weight:700; display:flex; align-items:flex-start; gap:8px; margin-bottom:16px; }

        /* ── Checkbox ── */
        input[type="checkbox"] { accent-color: var(--primary); }

        /* ── Divider ── */
        .divider { border:none; border-top:1px solid #f0f0f0; margin:20px 0; }

        /* ── Trust strip ── */
        .trust-strip { display:flex; align-items:center; justify-content:center; gap:20px; margin-top:16px; flex-wrap:wrap; }
        .trust-item  { display:flex; align-items:center; gap:6px; color:#b0bdb5; font-size:9px; font-weight:700; text-transform:uppercase; letter-spacing:0.14em; }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width:6px; }
        ::-webkit-scrollbar-track { background:#EAEFEF; }
        ::-webkit-scrollbar-thumb { background:linear-gradient(#2F6B3F,#3E8E5A); border-radius:6px; }

        /* ── Reveal ── */
        @keyframes fadeUp { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }
        .fade-up { animation:fadeUp 0.55s cubic-bezier(0.22,1,0.36,1) both; }
        .d1{animation-delay:.08s} .d2{animation-delay:.16s} .d3{animation-delay:.24s}
    </style>
</head>
<body>

<!-- ════════ LEFT — GREEN BRAND PANEL ════════ -->
<div class="left-panel">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <!-- Top: Brand + copy -->
    <div style="position:relative;z-index:1;">
        <div style="display:inline-flex;align-items:center;gap:10px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.18);border-radius:999px;padding:7px 18px;margin-bottom:36px;">
            <span style="width:7px;height:7px;border-radius:50%;background:#fff;animation:dotPulse 2s infinite;"></span>
            <span style="font-size:10px;font-weight:800;color:#fff;text-transform:uppercase;letter-spacing:0.2em;">BodaBoda Digital</span>
        </div>

        <h1 style="font-size:46px;font-weight:900;color:#fff;letter-spacing:-0.04em;line-height:0.88;text-transform:uppercase;margin-bottom:14px;">
            Join The <br>
            <span style="background:linear-gradient(135deg,#fff,rgba(255,255,255,0.45));-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Movement.</span>
        </h1>
        <p style="color:rgba(255,255,255,0.58);font-size:14px;line-height:1.7;max-width:270px;margin-bottom:36px;">
            Create your account in 3 easy steps and start riding smarter across Dodoma today.
        </p>

        <!-- Step tracker -->
        <div style="display:flex;flex-direction:column;gap:0;position:relative;">
            @php
            $trackerSteps = [
                ['Personal Info',  'Your name and phone number'],
                ['Account Setup',  'Email and secure password'],
                ['Review & Done',  'Confirm and create account'],
            ];
            @endphp
            @foreach($trackerSteps as $i => [$title, $sub])
            <div class="tracker-step {{ $i === 0 ? 'active' : '' }}" id="tracker-{{ $i+1 }}" style="padding-bottom:{{ $i < 2 ? '28px' : '0' }};">
                <div class="tracker-num">{{ $i+1 }}</div>
                <div class="tracker-label">
                    <div class="tracker-title">{{ $title }}</div>
                    <div class="tracker-sub">{{ $sub }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Bottom: Stats -->
    <div style="position:relative;z-index:1;">
        <div style="border-top:1px solid rgba(255,255,255,0.1);padding-top:24px;margin-top:10px;">
            <p style="font-size:9px;font-weight:800;color:rgba(255,255,255,0.28);text-transform:uppercase;letter-spacing:0.25em;margin-bottom:14px;">Why Join BodaBoda?</p>
            <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:8px;">
                @foreach([['10K+','Passengers','fa-users'],['4.9★','Rating','fa-star'],['Free','Sign Up','fa-gift']] as [$v,$l,$i])
                <div class="stat-card">
                    <i class="fas {{ $i }}" style="color:rgba(255,255,255,0.25);font-size:10px;margin-bottom:5px;display:block;"></i>
                    <div style="font-size:18px;font-weight:900;color:#fff;line-height:1;margin-bottom:3px;">{{ $v }}</div>
                    <div style="font-size:8px;font-weight:700;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.1em;">{{ $l }}</div>
                </div>
                @endforeach
            </div>
            <p style="font-size:9px;font-weight:600;color:rgba(255,255,255,0.18);text-align:center;margin-top:18px;text-transform:uppercase;letter-spacing:0.2em;">
                Secured by BodaBoda &middot; Dodoma, Tanzania
            </p>
        </div>
    </div>
</div>

<!-- ════════ RIGHT — FORM PANEL ════════ -->
<div class="right-panel">
    <div style="width:100%;max-width:460px;">

        <div class="form-card fade-up">
            <div class="card-accent"></div>
            <div class="form-body">

                <!-- Header -->
                <div class="fade-up d1" style="margin-bottom:20px;">
                    <div class="badge">
                        <span class="badge-dot"></span>
                        <span>Create Account</span>
                    </div>
                    <h2 style="font-size:28px;font-weight:900;color:#111827;letter-spacing:-0.04em;text-transform:uppercase;line-height:0.92;margin-bottom:6px;">
                        Get Started <br> Today.
                    </h2>
                    <p style="color:#9ca3af;font-size:12px;line-height:1.55;margin-top:8px;">
                        3 quick steps to join Dodoma's #1 ride-hailing platform.
                    </p>
                </div>

                <!-- Step progress bar -->
                <div class="fade-up d2">
                    <div class="step-bar">
                        <div class="step-dot active" id="dot-1">1</div>
                        <div class="step-conn" id="conn-1"></div>
                        <div class="step-dot" id="dot-2">2</div>
                        <div class="step-conn" id="conn-2"></div>
                        <div class="step-dot" id="dot-3">3</div>
                    </div>
                    <div class="step-label-row">
                        <span class="step-lbl active" id="lbl-1">Personal</span>
                        <span class="step-lbl" id="lbl-2">Account</span>
                        <span class="step-lbl" id="lbl-3">Review</span>
                    </div>
                </div>

                <!-- Errors -->
                @if($errors->any())
                <div class="alert-base alert-error fade-up">
                    <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:1px;"></i>
                    <div>
                        @foreach($errors->all() as $err)
                        <p>{{ $err }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('register') }}" method="POST" id="register-form">
                    @csrf

                    {{-- ─ STEP 1: Personal Info ─ --}}
                    <div class="form-step active" id="form-step-1">
                        <div style="display:flex;flex-direction:column;gap:16px;">

                            <div>
                                <label class="field-label">Full Name</label>
                                <div class="input-wrap">
                                    <i class="fas fa-user input-icon"></i>
                                    <input name="name" type="text" required
                                           value="{{ old('name') }}"
                                           class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                                           placeholder="e.g. John Doe" id="inp-name">
                                </div>
                                @error('name') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="field-label">Phone Number</label>
                                <div class="input-wrap">
                                    <i class="fas fa-phone input-icon"></i>
                                    <input name="phone" type="tel" required
                                           value="{{ old('phone') }}"
                                           class="form-input {{ $errors->has('phone') ? 'error' : '' }}"
                                           placeholder="+255 700 000 000" id="inp-phone">
                                </div>
                                @error('phone') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <button type="button" onclick="goNext(1)"
                                    class="btn-next" style="margin-top:4px;">
                                Continue
                                <i class="fas fa-arrow-right" style="font-size:11px;"></i>
                            </button>
                        </div>
                    </div>

                    {{-- ─ STEP 2: Account Info ─ --}}
                    <div class="form-step" id="form-step-2">
                        <div style="display:flex;flex-direction:column;gap:16px;">

                            <div>
                                <label class="field-label">Email Address</label>
                                <div class="input-wrap">
                                    <i class="fas fa-envelope input-icon"></i>
                                    <input name="email" type="email" required
                                           value="{{ old('email') }}"
                                           class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                                           placeholder="hello@bodaboda.co.tz" id="inp-email">
                                </div>
                                @error('email') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="field-label">Password</label>
                                <div class="input-wrap">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input name="password" type="password" required
                                           class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                                           placeholder="••••••••"
                                           id="inp-password"
                                           oninput="checkStrength(this.value)"
                                           style="padding-right:46px;">
                                    <button type="button" onclick="togglePwd('inp-password','eye-pw')"
                                            style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#aab5b0;font-size:13px;transition:color 0.2s;"
                                            onmouseover="this.style.color='#2F6B3F'" onmouseout="this.style.color='#aab5b0'">
                                        <i class="fas fa-eye" id="eye-pw"></i>
                                    </button>
                                </div>
                                <!-- Strength bar -->
                                <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
                                <p class="strength-label" id="strength-label" style="color:#d1d5db;">Enter a password</p>
                                @error('password') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="field-label">Confirm Password</label>
                                <div class="input-wrap">
                                    <i class="fas fa-lock input-icon"></i>
                                    <input name="password_confirmation" type="password" required
                                           class="form-input"
                                           placeholder="••••••••"
                                           id="inp-confirm"
                                           style="padding-right:46px;">
                                    <button type="button" onclick="togglePwd('inp-confirm','eye-cf')"
                                            style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#aab5b0;font-size:13px;transition:color 0.2s;"
                                            onmouseover="this.style.color='#2F6B3F'" onmouseout="this.style.color='#aab5b0'">
                                        <i class="fas fa-eye" id="eye-cf"></i>
                                    </button>
                                </div>
                            </div>

                            <div style="display:flex;gap:10px;margin-top:4px;">
                                <button type="button" onclick="goBack(2)" class="btn-back">
                                    <i class="fas fa-arrow-left" style="font-size:11px;"></i> Back
                                </button>
                                <button type="button" onclick="goNext(2)" class="btn-next">
                                    Continue <i class="fas fa-arrow-right" style="font-size:11px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- ─ STEP 3: Review & Submit ─ --}}
                    <div class="form-step" id="form-step-3">
                        <div style="display:flex;flex-direction:column;gap:16px;">

                            <!-- Review card -->
                            <div style="background:#f8faf9;border:1px solid #e2ebe4;border-radius:20px;padding:20px 20px 14px;">
                                <p style="font-size:10px;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.16em;margin-bottom:12px;">
                                    <i class="fas fa-clipboard-check" style="color:#2F6B3F;margin-right:6px;"></i>
                                    Review Your Details
                                </p>
                                <div class="review-row">
                                    <span class="review-key">Full Name</span>
                                    <span class="review-val" id="rv-name">—</span>
                                </div>
                                <div class="review-row">
                                    <span class="review-key">Phone</span>
                                    <span class="review-val" id="rv-phone">—</span>
                                </div>
                                <div class="review-row">
                                    <span class="review-key">Email</span>
                                    <span class="review-val" id="rv-email" style="word-break:break-all;">—</span>
                                </div>
                                <div class="review-row">
                                    <span class="review-key">Password</span>
                                    <span class="review-val">••••••••</span>
                                </div>
                            </div>

                            <!-- Terms -->
                            <div style="display:flex;align-items:flex-start;gap:10px;padding:14px 16px;background:#f4f7f5;border:1px solid #d1e8d9;border-radius:14px;">
                                <input type="checkbox" name="terms" id="terms" required
                                       style="margin-top:2px;width:15px;height:15px;flex-shrink:0;accent-color:#2F6B3F;cursor:pointer;">
                                <label for="terms" style="font-size:12px;color:#6b7280;line-height:1.5;cursor:pointer;">
                                    I agree to the
                                    <a href="#" style="color:#2F6B3F;font-weight:700;text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Terms & Conditions</a>
                                    and
                                    <a href="#" style="color:#2F6B3F;font-weight:700;text-decoration:none;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Privacy Policy</a>
                                </label>
                            </div>

                            <div style="display:flex;gap:10px;margin-top:4px;">
                                <button type="button" onclick="goBack(3)" class="btn-back">
                                    <i class="fas fa-arrow-left" style="font-size:11px;"></i> Back
                                </button>
                                <button type="submit" class="btn-next" id="submit-btn">
                                    <i class="fas fa-check" id="submit-icon" style="font-size:11px;"></i>
                                    <span id="submit-text">Create Account</span>
                                </button>
                            </div>
                        </div>
                    </div>

                </form>

                <hr class="divider">

                <div style="text-align:center;" class="fade-up d3">
                    <p style="font-size:12px;color:#9ca3af;font-weight:600;">
                        Already have an account?
                        <a href="{{ route('login') }}"
                           style="color:var(--primary);font-weight:800;text-decoration:none;margin-left:4px;"
                           onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            Sign In
                        </a>
                    </p>
                    <a href="{{ route('home') }}"
                       style="display:inline-flex;align-items:center;gap:6px;font-size:10px;font-weight:800;color:#c4cfc8;text-transform:uppercase;letter-spacing:0.15em;text-decoration:none;margin-top:8px;transition:color 0.2s;"
                       onmouseover="this.style.color='#2F6B3F'" onmouseout="this.style.color='#c4cfc8'">
                        <i class="fas fa-arrow-left" style="font-size:10px;"></i>
                        Back to Home
                    </a>
                </div>

            </div>
        </div>

        <!-- Trust strip -->
        <div class="trust-strip">
            <div class="trust-item"><i class="fas fa-shield-alt" style="font-size:11px;"></i> <span>Safe & Secure</span></div>
            <div class="trust-item"><i class="fas fa-lock" style="font-size:11px;"></i> <span>Encrypted Data</span></div>
            <div class="trust-item"><i class="fas fa-gift" style="font-size:11px;"></i> <span>Free to Join</span></div>
        </div>

    </div>
</div>

<script>
    let currentStep = 1;

    /* ── Step UI update ── */
    function updateUI(step) {
        // Card dots
        [1,2,3].forEach(n => {
            const dot = document.getElementById(`dot-${n}`);
            const lbl = document.getElementById(`lbl-${n}`);
            dot.className = 'step-dot';
            lbl.className = 'step-lbl';
            if (n < step)  { dot.classList.add('done');   lbl.classList.add('done');   dot.innerHTML = '<i class="fas fa-check" style="font-size:10px;"></i>'; }
            if (n === step){ dot.classList.add('active'); lbl.classList.add('active'); dot.innerHTML = n; }
            if (n > step)  { dot.innerHTML = n; }
        });
        // Connectors
        [1,2].forEach(n => {
            const conn = document.getElementById(`conn-${n}`);
            conn.className = n < step ? 'step-conn done' : 'step-conn';
        });
        // Left panel tracker
        [1,2,3].forEach(n => {
            const t = document.getElementById(`tracker-${n}`);
            if (!t) return;
            t.className = 'tracker-step';
            if (n < step)  t.classList.add('done');
            if (n === step) t.classList.add('active');
        });
    }

    function showStep(step) {
        document.querySelectorAll('.form-step').forEach(el => el.classList.remove('active'));
        document.getElementById(`form-step-${step}`).classList.add('active');
        updateUI(step);
        if (step === 3) populateReview();
    }

    /* ── Navigation ── */
    function goNext(from) {
        if (from === 1) {
            const name  = document.getElementById('inp-name').value.trim();
            const phone = document.getElementById('inp-phone').value.trim();
            if (!name)  { shake('inp-name');  return; }
            if (!phone) { shake('inp-phone'); return; }
        }
        if (from === 2) {
            const email = document.getElementById('inp-email').value.trim();
            const pw    = document.getElementById('inp-password').value;
            const cf    = document.getElementById('inp-confirm').value;
            if (!email) { shake('inp-email'); return; }
            if (!pw)    { shake('inp-password'); return; }
            if (pw !== cf) {
                shake('inp-confirm');
                document.getElementById('inp-confirm').style.borderColor = '#f87171';
                document.getElementById('inp-confirm').style.boxShadow = '0 0 0 4px rgba(248,113,113,0.15)';
                setTimeout(() => {
                    document.getElementById('inp-confirm').style.borderColor = '';
                    document.getElementById('inp-confirm').style.boxShadow = '';
                }, 2000);
                return;
            }
        }
        currentStep = from + 1;
        showStep(currentStep);
    }

    function goBack(from) {
        currentStep = from - 1;
        showStep(currentStep);
    }

    /* ── Shake animation ── */
    function shake(id) {
        const el = document.getElementById(id);
        el.style.animation = 'none';
        el.style.borderColor = '#f87171';
        el.style.boxShadow = '0 0 0 4px rgba(248,113,113,0.15)';
        el.style.transform = 'translateX(0)';
        setTimeout(() => {
            el.style.animation = 'shakeIt 0.4s ease';
            setTimeout(() => {
                el.style.animation = '';
                el.style.borderColor = '';
                el.style.boxShadow = '';
            }, 450);
        }, 10);
        el.focus();
    }

    /* ── Populate review ── */
    function populateReview() {
        document.getElementById('rv-name').textContent  = document.getElementById('inp-name').value  || '—';
        document.getElementById('rv-phone').textContent = document.getElementById('inp-phone').value || '—';
        document.getElementById('rv-email').textContent = document.getElementById('inp-email').value || '—';
    }

    /* ── Password toggle ── */
    function togglePwd(inputId, iconId) {
        const inp  = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (inp.type === 'password') {
            inp.type = 'text';
            icon.classList.replace('fa-eye','fa-eye-slash');
        } else {
            inp.type = 'password';
            icon.classList.replace('fa-eye-slash','fa-eye');
        }
    }

    /* ── Password strength ── */
    function checkStrength(val) {
        const fill  = document.getElementById('strength-fill');
        const label = document.getElementById('strength-label');
        let score = 0;
        if (val.length >= 8)            score++;
        if (/[A-Z]/.test(val))         score++;
        if (/[0-9]/.test(val))         score++;
        if (/[^A-Za-z0-9]/.test(val))  score++;

        const levels = [
            { w:'0%',   bg:'#e5e7eb', text:'Enter a password',  color:'#d1d5db' },
            { w:'25%',  bg:'#f87171', text:'Weak',              color:'#ef4444' },
            { w:'50%',  bg:'#fb923c', text:'Fair',              color:'#f97316' },
            { w:'75%',  bg:'#facc15', text:'Good',              color:'#ca8a04' },
            { w:'100%', bg:'#4ade80', text:'Strong ✓',          color:'#16a34a' },
        ];
        const lvl = val.length === 0 ? levels[0] : levels[score];
        fill.style.width      = lvl.w;
        fill.style.background = lvl.bg;
        label.textContent     = lvl.text;
        label.style.color     = lvl.color;
    }

    /* ── Submit loading ── */
    document.getElementById('register-form').addEventListener('submit', function() {
        const btn  = document.getElementById('submit-btn');
        const icon = document.getElementById('submit-icon');
        const text = document.getElementById('submit-text');
        btn.disabled = true;
        icon.className = 'fas fa-spinner fa-spin';
        icon.style.fontSize = '11px';
        text.textContent = 'Creating Account…';
    });

    /* ── Auto-focus ── */
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('inp-name')?.focus();
        // If errors exist, jump to relevant step
        @if($errors->has('name') || $errors->has('phone'))
            showStep(1);
        @elseif($errors->has('email') || $errors->has('password'))
            currentStep = 2; showStep(2);
        @endif
    });
</script>

<style>
    @keyframes shakeIt {
        0%,100% { transform: translateX(0); }
        20%      { transform: translateX(-6px); }
        40%      { transform: translateX(6px); }
        60%      { transform: translateX(-4px); }
        80%      { transform: translateX(4px); }
    }
    @keyframes dotPulse { 0%,100%{opacity:1} 50%{opacity:0.35} }
</style>
</body>
</html>
@endsection