<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Restaurant</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* === NAVBAR STYLE === */
        .navbar {
            background-color: #003366; /* biru dongker seperti contoh */
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #ffffff !important;
        }

        .navbar-nav .nav-link {
            color: #dcdcdc !important;
            transition: color 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ffffff !important;
        }

        .navbar-nav .user-name {
            color: #ffffff;
            margin-right: 15px;
            font-weight: 500;
        }

        /* === LOGOUT BUTTON === */
        .btn-logout {
            background: linear-gradient(135deg, #0056b3, #00264d);
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 5px 18px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-logout:hover {
            transform: scale(1.08);
            box-shadow: 0 5px 15px rgba(0, 51, 102, 0.6);
            color: #fff;
        }

        /* Responsif */
        @media (max-width: 992px) {
            .navbar-nav .user-name {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- === NAVBAR === -->
    <nav class="navbar navbar-expand-lg shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                🍽️ Restaurant
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item user-name">
                            Hi, {{ Auth::user()->username }}
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-logout">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    @endauth

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
