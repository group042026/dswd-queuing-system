<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }} - Reset Password</title>

  <!-- Google Fonts for Modern Typography -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    /* ==========================================================================
       1. Core Design System & Variables
       ========================================================================== */
    :root {
      --dswd-blue: #0038a8;
      --dswd-blue-hover: #002878;
      --dswd-red: #ce1126;
      --dswd-red-hover: #b00e1f;
      --dswd-yellow: #fcd116;
      --white: #ffffff;

      --page-bg: #f8fafc;
      --text-main: #0f172a;
      --text-muted: #64748b;
      --border-color: #cbd5e1;
      --border-focus: #0038a8;

      --card-shadow: 0 25px 60px -15px rgba(0, 56, 168, 0.12), 0 0 1px rgba(0, 56, 168, 0.05);
      --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ==========================================================================
       2. General Reset & Background Layout
       ========================================================================== */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--page-bg);
      background-image:
        radial-gradient(at 0% 0%, rgba(0, 56, 168, 0.06) 0px, transparent 50%),
        radial-gradient(at 100% 0%, rgba(206, 17, 38, 0.04) 0px, transparent 50%),
        radial-gradient(at 50% 100%, rgba(252, 209, 22, 0.05) 0px, transparent 50%);
      background-attachment: fixed;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 24px;
      overflow-x: hidden;
      color: var(--text-main);
      position: relative;
    }

    body::before {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(0, 56, 168, 0.04) 0%, transparent 70%);
      top: 15%;
      left: 10%;
      pointer-events: none;
      z-index: 0;
    }

    body::after {
      content: '';
      position: absolute;
      width: 400px;
      height: 400px;
      background: radial-gradient(circle, rgba(206, 17, 38, 0.03) 0%, transparent 70%);
      bottom: 15%;
      right: 10%;
      pointer-events: none;
      z-index: 0;
    }

    /* ==========================================================================
       3. Vector Graphic Decorators (Floating Accents)
       ========================================================================== */
    .vector-element {
      position: absolute;
      pointer-events: none;
      z-index: 1;
      user-select: none;
    }

    .vector-queuing {
      left: 10%;
      bottom: 12%;
      width: 240px;
      height: 240px;
      animation: float 6s ease-in-out infinite;
      opacity: 0.9;
    }

    .vector-efficiency {
      right: 10%;
      top: 12%;
      width: 210px;
      height: 210px;
      animation: floatDelayed 7s ease-in-out infinite;
      opacity: 0.9;
    }

    /* ==========================================================================
       4. Centered Panel
       ========================================================================== */
    .login-panel {
      width: 100%;
      max-width: 450px;
      background: var(--white);
      border-radius: 24px;
      box-shadow: var(--card-shadow);
      border: 1px solid rgba(0, 56, 168, 0.06);
      padding: 48px;
      position: relative;
      z-index: 10;
      text-align: center;
      animation: fadeInUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .logo-container {
      margin-bottom: 24px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .dswd-logo-svg {
      width: 90px;
      height: auto;
      filter: drop-shadow(0 4px 10px rgba(0, 56, 168, 0.08));
      animation: pulseLogo 3s infinite ease-in-out;
    }

    .brand-title-dept {
      font-family: 'Outfit', sans-serif;
      font-size: 13.5px;
      font-weight: 700;
      color: var(--dswd-blue);
      text-transform: uppercase;
      letter-spacing: 0.05em;
      margin-bottom: 6px;
      line-height: 1.45;
    }

    .brand-title-sys {
      font-family: 'Outfit', sans-serif;
      font-size: 22px;
      font-weight: 800;
      color: var(--text-main);
      letter-spacing: -0.01em;
      margin-bottom: 18px;
    }

    .brand-divider {
      height: 4px;
      width: 90px;
      margin: 0 auto 28px;
      border-radius: 2px;
      background: linear-gradient(to right,
        var(--dswd-blue) 0%, var(--dswd-blue) 33.3%,
        var(--dswd-yellow) 33.3%, var(--dswd-yellow) 66.6%,
        var(--dswd-red) 66.6%, var(--dswd-red) 100%
      );
    }

    .section-header {
      margin-bottom: 12px;
    }

    .login-title {
      font-family: 'Outfit', sans-serif;
      font-size: 15px;
      font-weight: 700;
      letter-spacing: 0.18em;
      color: var(--text-muted);
      text-transform: uppercase;
    }

    .instruction-text {
      font-size: 13.5px;
      color: var(--text-muted);
      line-height: 1.6;
      margin-bottom: 28px;
    }

    /* ==========================================================================
       5. Form & Inputs Design
       ========================================================================== */
    .form-group {
      margin-bottom: 22px;
      text-align: left;
    }

    .form-label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: #475569;
      margin-bottom: 7px;
      letter-spacing: 0.01em;
    }

    .input-container {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: #94a3b8;
      display: flex;
      align-items: center;
      justify-content: center;
      pointer-events: none;
      transition: color 0.3s ease;
    }

    .form-input {
      width: 100%;
      height: 48px;
      background: #ffffff;
      border: 1.5px solid #e2e8f0;
      border-radius: 12px;
      padding: 0 16px 0 46px;
      font-size: 14.5px;
      font-family: inherit;
      color: var(--text-main);
      outline: none;
      transition: var(--transition-smooth);
    }

    .form-input::placeholder {
      color: #94a3b8;
    }

    .form-input:focus {
      border-color: var(--dswd-blue);
      box-shadow: 0 0 0 4px rgba(0, 56, 168, 0.08);
      background-color: #ffffff;
    }

    .form-input:focus ~ .input-icon {
      color: var(--dswd-blue);
    }

    .form-input.input-error {
      border-color: var(--dswd-red);
      background-color: #fef2f2;
    }

    .form-input.input-error ~ .input-icon {
      color: var(--dswd-red);
    }

    .error-message {
      font-size: 12px;
      color: var(--dswd-red);
      font-weight: 500;
      margin-top: 5px;
      display: flex;
      align-items: center;
      gap: 5px;
      animation: fadeIn 0.2s ease-in;
    }

    /* Toggle password visibility button */
    .toggle-password {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      color: #94a3b8;
      display: flex;
      align-items: center;
      padding: 4px;
      transition: color 0.2s ease;
    }

    .toggle-password:hover {
      color: var(--dswd-blue);
    }

    /* Action Button */
    .btn-submit {
      width: 100%;
      height: 50px;
      background: var(--dswd-red);
      color: var(--white);
      border: none;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 600;
      letter-spacing: 0.05em;
      cursor: pointer;
      transition: var(--transition-smooth);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      box-shadow: 0 4px 12px rgba(206, 17, 38, 0.18);
      position: relative;
    }

    .btn-submit:hover {
      background: var(--dswd-red-hover);
      transform: translateY(-1px);
      box-shadow: 0 8px 20px rgba(206, 17, 38, 0.28);
    }

    .btn-submit:active {
      transform: translateY(0);
      box-shadow: 0 2px 6px rgba(206, 17, 38, 0.18);
    }

    .btn-submit:disabled {
      background: #94a3b8;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    .spinner {
      width: 18px;
      height: 18px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: white;
      animation: spin 0.8s linear infinite;
      display: none;
    }

    /* Back to Login Link */
    .back-to-login {
      margin-top: 22px;
      font-size: 13.5px;
      color: var(--text-muted);
    }

    .back-to-login a {
      color: var(--dswd-blue);
      text-decoration: none;
      font-weight: 500;
      transition: color 0.2s ease;
    }

    .back-to-login a:hover {
      color: var(--dswd-red);
      text-decoration: underline;
    }

    /* ==========================================================================
       6. Keyframes & Animations
       ========================================================================== */
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-12px) rotate(1.5deg); }
    }

    @keyframes floatDelayed {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(10px) rotate(-1.5deg); }
    }

    @keyframes pulseLogo {
      0%, 100% { transform: scale(1); filter: drop-shadow(0 4px 10px rgba(0, 56, 168, 0.08)); }
      50% { transform: scale(1.03); filter: drop-shadow(0 8px 20px rgba(0, 56, 168, 0.16)); }
    }

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60% { transform: translateX(-6px); }
      40%, 80% { transform: translateX(6px); }
    }

    .shake-anim {
      animation: shake 0.4s ease-in-out;
    }

    @media (max-width: 1024px) {
      .vector-queuing { width: 180px; height: 180px; left: 5%; }
      .vector-efficiency { width: 160px; height: 160px; right: 5%; }
    }

    @media (max-width: 768px) {
      .vector-element { display: none !important; }
      body { padding: 16px; }
      .login-panel { padding: 32px 24px; border-radius: 20px; }
    }
  </style>
</head>
<body>

  <!-- Floating vector ornament (Left) -->
  <div class="vector-element vector-queuing">
    <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M20 170 C55 170, 45 110, 100 110 C155 110, 145 50, 180 50" stroke="rgba(0, 56, 168, 0.15)" stroke-width="3" stroke-linecap="round" stroke-dasharray="6 8" />
      <g transform="translate(25, 125)">
        <circle cx="15" cy="15" r="9" fill="#0038a8" fill-opacity="0.8" />
        <path d="M2 38 C2 28, 28 28, 28 38 Z" fill="#0038a8" fill-opacity="0.8" />
      </g>
      <g transform="translate(85, 65)">
        <circle cx="15" cy="15" r="9" fill="#ce1126" fill-opacity="0.85" />
        <path d="M2 38 C2 28, 28 28, 28 38 Z" fill="#ce1126" fill-opacity="0.85" />
      </g>
      <g transform="translate(145, 5)">
        <circle cx="15" cy="15" r="9" fill="#fcd116" />
        <path d="M2 38 C2 28, 28 28, 28 38 Z" fill="#fcd116" />
      </g>
      <circle cx="178" cy="38" r="14" fill="rgba(206, 17, 38, 0.05)" stroke="#ce1126" stroke-width="1.5" stroke-dasharray="2 2" />
      <path d="M173 38 L177 42 L183 34" stroke="#ce1126" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </div>

  <!-- Floating vector ornament (Right) -->
  <div class="vector-element vector-efficiency">
    <svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="100" cy="100" r="75" stroke="rgba(252, 209, 22, 0.2)" stroke-width="4" stroke-dasharray="8 8" />
      <circle cx="100" cy="100" r="60" stroke="rgba(0, 56, 168, 0.06)" stroke-width="2" />
      <circle cx="100" cy="100" r="46" stroke="#0038a8" stroke-width="7" stroke-dasharray="14 8" stroke-opacity="0.85" />
      <circle cx="100" cy="100" r="35" fill="white" stroke="#0038a8" stroke-width="1.5" stroke-opacity="0.85" />
      <line x1="100" y1="100" x2="100" y2="76" stroke="#ce1126" stroke-width="3.5" stroke-linecap="round" />
      <line x1="100" y1="100" x2="116" y2="100" stroke="#fcd116" stroke-width="3.5" stroke-linecap="round" />
      <circle cx="100" cy="100" r="4.5" fill="#0f172a" />
      <path d="M32 55 L16 55" stroke="#ce1126" stroke-width="3" stroke-linecap="round" stroke-opacity="0.8" />
      <path d="M40 35 L26 35" stroke="#fcd116" stroke-width="2.5" stroke-linecap="round" />
      <path d="M38 75 L22 75" stroke="#0038a8" stroke-width="3" stroke-linecap="round" stroke-opacity="0.8" />
    </svg>
  </div>

  <!-- Centered Panel Card -->
  <section class="login-panel" id="resetPasswordCard">

    <!-- DSWD Logo -->
    <div class="logo-container">
      <svg class="dswd-logo-svg" viewBox="0 0 177.58324 192.76212" version="1.1" id="svg8">
        <g id="layer1" transform="translate(-5.1854501,-26.571163)">
          <path id="rect3046"
            style="color:#000000;fill:#ffffff;fill-opacity:1;stroke:#fcd116;stroke-width:4.4979167;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
            d="m 51.956418,49.456777 h 83.563352 24.69356 v 95.440503 c 0,13.68028 -11.01328,24.69356 -24.69356,24.69356 H 51.956418 C 38.276137,169.58819 27.262856,158.57623 27.262856,144.89728 V 49.456777 Z" />
          <path style="fill:#0038a8;fill-opacity:1;stroke-width:0.26458332" id="path2987"
            d="m 45.027775,60.820631 v 31.797625 l 45.005624,36.967584 v 29.56189 H 62.18865 V 140.27897 L 37.060906,117.26552 V 60.808725 Z" />
          <path style="fill:#0038a8;fill-opacity:1;stroke-width:0.26458332" id="path2987-7"
            d="M 142.44656,60.820631 V 92.618256 L 97.440939,129.58584 v 29.56189 h 27.844751 v -18.86876 l 25.12774,-23.01345 V 60.808725 Z" />
          <path style="fill:#ce1126;fill-opacity:1;stroke-width:0.26458332" id="path3025-4"
            d="M 50.584025,88.924673 V 63.821535 c 0,-1.79406 1.313127,-2.507853 2.507853,-2.507853 h 32.453791 l 8.192294,7.054057 8.192297,-7.054057 h 32.45379 c 1.19472,0 2.50785,0.713793 2.50785,2.507853 V 88.924673 L 93.73836,122.70403 Z" />
          <g aria-label="DSWD"
            style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:38.79579163px;line-height:1.25;font-family:'Square721 BdEx BT';-inkscape-font-specification:'Square721 BdEx BT Bold';font-variant-ligatures:normal;font-variant-caps:normal;font-variant-numeric:normal;font-feature-settings:normal;text-align:center;letter-spacing:4.84947395px;writing-mode:lr-tb;text-anchor:middle;opacity:1;fill:#0038a8;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:square;stroke-linejoin:bevel;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1"
            id="text845">
            <path d="m 35.121142,203.32779 h 4.603212 q 3.997027,0 5.777694,-2.08376 1.799609,-2.1027 1.799609,-6.80063 0,-4.67898 -1.667007,-6.8764 -1.667006,-2.19742 -5.209395,-2.19742 h -5.304113 z m -5.626147,5.03891 v -27.90342 h 10.93026 q 6.421764,0 9.566345,3.46662 3.163524,3.46661 3.163524,10.5135 0,3.82654 -1.174482,6.7438 -1.155539,2.91727 -3.3719,4.69793 -1.667007,1.32603 -3.788652,1.91327 -2.121645,0.5683 -5.948183,0.5683 z"
              style="font-family:'Swis721 BT';letter-spacing:4.84947395px;fill:#0038a8;fill-opacity:1;stroke:none;" id="path1002" />
            <path d="m 61.243894,199.74752 h 5.664034 q 0.322035,2.29213 1.875383,3.40978 1.553347,1.09871 4.489552,1.09871 2.50051,0 3.769708,-0.89033 1.269198,-0.89033 1.269198,-2.63311 0,-2.5384 -7.293154,-4.20541 -0.09472,-0.0189 -0.170489,-0.0379 -0.189433,-0.0379 -0.587241,-0.13261 -3.902311,-0.85244 -5.569318,-1.91327 -1.477574,-0.94716 -2.254248,-2.53839 -0.776673,-1.61018 -0.776673,-3.78865 0,-4.0728 2.765715,-6.23233 2.765716,-2.17848 7.994055,-2.17848 4.887361,0 7.634133,2.31108 2.765716,2.31108 2.917262,6.51648 h -5.512488 q -0.151546,-2.02693 -1.553348,-3.08775 -1.401801,-1.06082 -3.997027,-1.06082 -2.254248,0 -3.485559,0.89033 -1.212369,0.87139 -1.212369,2.50051 0,2.21636 4.754758,3.31507 1.288141,0.30309 2.007985,0.47358 3.049865,0.77667 4.319063,1.21237 1.288141,0.43569 2.235304,0.9661 1.704894,0.94717 2.55734,2.51946 0.852447,1.55334 0.852447,3.73182 0,4.35695 -2.936205,6.76274 -2.936205,2.38685 -8.278204,2.38685 -5.266225,0 -8.25926,-2.44368 -2.993035,-2.44368 -3.220354,-6.95217 z"
              style="font-family:'Swis721 BT';letter-spacing:4.84947395px;fill:#0038a8;fill-opacity:1;stroke:none;" id="path1004" />
            <path d="m 98.713658,208.3667 -7.994054,-27.90342 h 5.948183 l 4.773703,19.68205 4.03491,-19.68205 h 6.11867 l 4.03492,19.68205 4.7737,-19.68205 h 5.89135 l -7.97511,27.90342 h -5.4746 l -4.31906,-21.368 -4.33801,21.368 z"
              style="font-family:'Swis721 BT';letter-spacing:4.84947395px;fill:#0038a8;fill-opacity:1;stroke:none;" id="path1006" />
            <path d="m 139.99102,203.32779 h 4.60321 q 3.99702,0 5.77769,-2.08376 1.79961,-2.1027 1.79961,-6.80063 0,-4.67898 -1.66701,-6.8764 -1.667,-2.19742 -5.20939,-2.19742 h -5.30411 z m -5.62615,5.03891 v -27.90342 h 10.93026 q 6.42176,0 9.56634,3.46662 3.16353,3.46661 3.16353,10.5135 0,3.82654 -1.17449,6.7438 -1.15553,2.91727 -3.3719,4.69793 -1.667,1.32603 -3.78865,1.91327 -2.12164,0.5683 -5.94818,0.5683 z"
              style="font-family:'Swis721 BT';letter-spacing:4.84947395px;fill:#0038a8;fill-opacity:1;stroke:none;" id="path1008" />
          </g>
        </g>
      </svg>
    </div>

    <div class="brand-text">
      <div class="brand-title-dept">Department of Social Welfare and Development</div>
      <div class="brand-title-sys">Smart Queueing System</div>
    </div>

    <!-- Tri-color Brand Stripe -->
    <div class="brand-divider"></div>

    <div class="section-header">
      <h2 class="login-title">RESET PASSWORD</h2>
    </div>

    <p class="instruction-text">
      Choose a strong new password for your account below.
    </p>

    <!-- Reset Password Form -->
    <form method="POST" action="{{ route('password.store') }}" id="resetPasswordForm" novalidate>
      @csrf

      <!-- Hidden Token -->
      <input type="hidden" name="token" value="{{ $request->route('token') }}">

      <!-- Email -->
      <div class="form-group">
        <label class="form-label" for="email">Email</label>
        <div class="input-container">
          <input
            type="email"
            id="email"
            name="email"
            class="form-input @error('email') input-error @enderror"
            placeholder="Enter your email"
            value="{{ old('email', $request->email) }}"
            required
            autofocus
            autocomplete="username"
          >
          <span class="input-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
              <circle cx="12" cy="7" r="4" />
            </svg>
          </span>
        </div>
        @error('email')
          <div class="error-message" id="emailError">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      <!-- New Password -->
      <div class="form-group">
        <label class="form-label" for="password">New Password</label>
        <div class="input-container">
          <input
            type="password"
            id="password"
            name="password"
            class="form-input @error('password') input-error @enderror"
            placeholder="••••••••"
            required
            autocomplete="new-password"
          >
          <span class="input-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
              <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            </svg>
          </span>
          <button type="button" class="toggle-password" id="togglePassword" aria-label="Toggle password visibility">
            <!-- Eye icon -->
            <svg id="eyeIconPassword" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </button>
        </div>
        @error('password')
          <div class="error-message" id="passwordError">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div class="form-group">
        <label class="form-label" for="password_confirmation">Confirm Password</label>
        <div class="input-container">
          <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            class="form-input @error('password_confirmation') input-error @enderror"
            placeholder="••••••••"
            required
            autocomplete="new-password"
          >
          <span class="input-icon">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
              <path d="M7 11V7a5 5 0 0 1 10 0v4" />
            </svg>
          </span>
          <button type="button" class="toggle-password" id="toggleConfirm" aria-label="Toggle confirm password visibility">
            <svg id="eyeIconConfirm" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
              <circle cx="12" cy="12" r="3"></circle>
            </svg>
          </button>
        </div>
        @error('password_confirmation')
          <div class="error-message" id="confirmError">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
            {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn-submit" id="submitBtn">
        <span>RESET PASSWORD</span>
        <div class="spinner" id="btnSpinner"></div>
      </button>

    </form>

    <!-- Back to Login -->
    <div class="back-to-login">
      Remembered your password?
      <a href="{{ route('login') }}" id="backToLoginLink">Back to Login</a>
    </div>

  </section>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const resetForm = document.getElementById('resetPasswordForm');
      const resetCard = document.getElementById('resetPasswordCard');
      const submitBtn = document.getElementById('submitBtn');
      const spinner  = document.getElementById('btnSpinner');

      // Submit animation
      resetForm.addEventListener('submit', () => {
        submitBtn.disabled = true;
        submitBtn.querySelector('span').innerText = 'RESETTING...';
        spinner.style.display = 'block';
      });

      // Real-time error clear
      ['email', 'password', 'password_confirmation'].forEach(id => {
        const input = document.getElementById(id);
        const errorId = { email: 'emailError', password: 'passwordError', password_confirmation: 'confirmError' }[id];
        if (input) {
          input.addEventListener('input', () => {
            input.classList.remove('input-error');
            const err = document.getElementById(errorId);
            if (err) err.style.display = 'none';
          });
        }
      });

      // Toggle password visibility
      function setupToggle(btnId, inputId, iconId) {
        const btn   = document.getElementById(btnId);
        const input = document.getElementById(inputId);
        if (!btn || !input) return;
        btn.addEventListener('click', () => {
          const isPassword = input.type === 'password';
          input.type = isPassword ? 'text' : 'password';
          const icon = document.getElementById(iconId);
          icon.innerHTML = isPassword
            ? `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>`
            : `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>`;
        });
      }

      setupToggle('togglePassword', 'password', 'eyeIconPassword');
      setupToggle('toggleConfirm', 'password_confirmation', 'eyeIconConfirm');

      // Shake animation on validation errors
      @if ($errors->any())
        resetCard.classList.add('shake-anim');
        setTimeout(() => resetCard.classList.remove('shake-anim'), 400);
      @endif
    });
  </script>
</body>
</html>
