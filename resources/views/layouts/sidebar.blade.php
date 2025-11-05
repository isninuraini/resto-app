<style>
.sidebar {
    width: 270px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: linear-gradient(135deg, #001f3f, #003366, #004080);
    background-size: 400% 400%;
    animation: gradientShift 8s ease infinite;
    color: #fff;
    z-index: 2000;
    padding: 25px 20px;
    box-shadow: 5px 0 20px rgba(0,0,0,0.4);
    overflow-y: auto;
}

@keyframes gradientShift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.sidebar img {
    transition: transform 0.5s;
}
.sidebar img:hover {
    transform: rotate(10deg) scale(1.15);
}

.sidebar h5 {
    font-weight: 700;
    color: #fff;
}

.sidebar .nav-link {
    color: #fff;
    border-radius: 10px;
    padding: 12px 15px;
    margin-bottom: 8px;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}
.sidebar .nav-link:hover {
    background: rgba(255,255,255,0.15);
    transform: translateX(5px);
    box-shadow: 0 0 10px rgba(0,198,255,0.3);
}
.sidebar .nav-link.active {
    background: rgba(255,255,255,0.25);
    border-left: 3px solid #00e0ff;
}
.sidebar .nav-link i {
    margin-right: 10px;
    color: #00e0ff;
}
.sidebar::-webkit-scrollbar {
    width: 6px;
}
.sidebar::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.2);
    border-radius: 10px;
}
</style>

@php
    $role = Auth::user()->role ?? 'administrator';
    $menus = [
        'administrator' => [
            ['route' => 'dashboard', 'icon' => 'bi-speedometer2', 'text' => 'Dashboard'],
            ['route' => 'meja.index', 'icon' => 'bi-grid-3x3-gap', 'text' => 'Entri Meja'],
            ['route' => 'menu.index', 'icon' => 'bi-box-seam', 'text' => 'Entri Barang'],
        ],
        'kasir' => [
            ['route' => 'dashboard', 'icon' => 'bi-speedometer2', 'text' => 'Dashboard'],
            ['route' => 'transaksi.index', 'icon' => 'bi-cash-stack', 'text' => 'Entri Transaksi'],
            ['route' => 'laporan.index', 'icon' => 'bi-file-earmark-text', 'text' => 'Laporan'],
        ],
        'owner' => [
            ['route' => 'dashboard', 'icon' => 'bi-speedometer2', 'text' => 'Dashboard'],
            ['route' => 'laporan.index', 'icon' => 'bi-file-earmark-text', 'text' => 'Laporan'],
        ],
        'waiter' => [
            ['route' => 'dashboard', 'icon' => 'bi-speedometer2', 'text' => 'Dashboard'],
            ['route' => 'menu.index', 'icon' => 'bi-journal-text', 'text' => 'Kelola Menu'],
            ['route' => 'pelanggan.index', 'icon' => 'bi-people', 'text' => 'Entri Pelanggan'],
            ['route' => 'pesanan.index', 'icon' => 'bi-receipt', 'text' => 'Entri Pesanan'],
            ['route' => 'laporan.index', 'icon' => 'bi-card-list', 'text' => 'Laporan'],
        ],
    ];
@endphp

<div class="sidebar">
    <div class="text-center mb-4">
        <img src="https://cdn-icons-png.flaticon.com/512/3075/3075977.png" width="60" class="mb-2">
        <h5 class="fw-bold">Resto {{ ucfirst($role) }}</h5>
        <small class="text-white-50">{{ ucfirst($role) }}</small>
    </div>

    <ul class="nav flex-column mt-3">
        @foreach($menus[$role] as $menu)
            <li class="nav-item">
                <a href="{{ route($menu['route']) }}" 
                   class="nav-link d-flex align-items-center {{ request()->routeIs($menu['route']) ? 'active' : '' }}">
                    <i class="bi {{ $menu['icon'] }}"></i> {{ $menu['text'] }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
