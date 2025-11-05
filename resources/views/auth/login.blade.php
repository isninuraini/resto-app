<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Restaurant</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at 30% 30%, #002147, #000d1a);
            overflow: hidden;
            position: relative;
            color: #fff;
        }

        /* === Efek partikel lembut === */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 1%, transparent 1%) 0 0 / 45px 45px;
            animation: moveParticles 35s linear infinite;
        }

        @keyframes moveParticles {
            from { transform: translate(0, 0); }
            to { transform: translate(-50px, -50px); }
        }

        /* === Efek cahaya biru halus === */
        .glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(0, 123, 255, 0.2), transparent 70%);
            border-radius: 50%;
            filter: blur(90px);
            top: -100px;
            left: -100px;
            animation: floatGlow 20s ease-in-out infinite alternate;
        }

        .glow2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 70, 200, 0.25), transparent 70%);
            border-radius: 50%;
            filter: blur(100px);
            bottom: -100px;
            right: -80px;
            animation: floatGlow2 18s ease-in-out infinite alternate;
        }

        @keyframes floatGlow {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(100px, 80px) scale(1.1); }
        }

        @keyframes floatGlow2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-80px, -60px) scale(1.1); }
        }

        /* === Card login === */
        .login-card {
            width: 400px;
            border: none;
            border-radius: 25px;
            padding: 2.5rem;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(25px);
            box-shadow: 0 8px 35px rgba(0, 0, 0, 0.5);
            z-index: 2;
            animation: fadeInUp 1s ease both;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(25px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* === Logo === */
        .login-logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #003366, #0056b3);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            margin: 0 auto 20px;
            box-shadow: 0 0 25px rgba(0, 102, 255, 0.4);
            animation: pulseLogo 2.5s infinite;
        }

        @keyframes pulseLogo {
            0%, 100% { transform: scale(1); box-shadow: 0 0 15px rgba(0,102,255,0.4); }
            50% { transform: scale(1.08); box-shadow: 0 0 30px rgba(0,102,255,0.7); }
        }

        .login-title {
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #f1f5ff;
        }

        .form-label {
            color: #d3e1ff;
            font-weight: 500;
        }

        .form-control {
            border-radius: 12px;
            padding: 10px 45px 10px 12px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.4);
            background: rgba(255, 255, 255, 0.25);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .icon-eye {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 1.2rem;
            color: rgba(255,255,255,0.7);
            transition: color 0.3s;
        }

        .icon-eye:hover {
            color: #66aaff;
        }

        /* === Tombol === */
        .btn-primary {
            background: linear-gradient(90deg, #002b80, #0056b3);
            border: none;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
            letter-spacing: 0.3px;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #0048b3, #007bff);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.5);
        }

        .btn-primary:active {
            transform: scale(0.98);
        }

        .alert {
            font-size: 0.9rem;
            border-radius: 10px;
        }

        .footer-text {
            position: absolute;
            bottom: 10px;
            font-size: 0.85rem;
            color: rgba(255,255,255,0.6);
            text-shadow: 0 0 5px rgba(255,255,255,0.2);
            z-index: 3;
        }
    </style>
</head>

<body class="d-flex justify-content-center align-items-center">
    <div class="glow"></div>
    <div class="glow2"></div>

    <div class="login-card text-center">
        <div class="login-logo">
            <i class="bi bi-shop fs-2"></i>
        </div>

        <h3 class="login-title mb-1">Login Restaurant</h3>
        <p class="text-light small mb-4">Masuk untuk mengelola sistem restoranmu 🍽️</p>

        {{-- Alert success --}}
        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif

        {{-- Alert error --}}
        @if($errors->any())
            <div class="alert alert-danger py-2">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            {{-- Username --}}
            <div class="mb-3 text-start">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control"
                       value="{{ old('username') }}" placeholder="Masukkan username" required>
            </div>

            {{-- Password --}}
            <div class="mb-3 text-start">
                <label class="form-label">Password</label>
                <div class="position-relative">
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Masukkan password" required>
                    <i class="bi bi-eye-slash icon-eye" id="togglePassword"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-2">Masuk</button>
        </form>
    </div>

    <div class="footer-text text-center w-100">
        &copy; {{ date('Y') }} Resto Management System
    </div>

    <script>
        const toggle = document.getElementById('togglePassword');
        const password = document.getElementById('password');

        toggle.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
