<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sistem PPS - Kementerian ATR/BPN' }}</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Warna Resmi & Identitas ATR/BPN */
            --bpn-navy: #0c2340;
            --bpn-navy-light: #162e4d;
            --bpn-navy-dark: #08172c;
            --bpn-gold: #fbc02d;
            --bpn-gold-hover: #f59e0b;
            --bpn-gold-light: #fffbeb;
            
            --bg: #f8fafc;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --card-bg: #ffffff;
            --border: #e2e8f0;
            --danger: #ef4444;
            --danger-light: #fef2f2;
            --success: #10b981;
            --success-light: #ecfdf5;
            --radius: 10px;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { 
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; 
            background: var(--bg); 
            color: var(--text-dark); 
            display: flex; 
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        /* Sidebar Navigation */
        .sidebar { 
            width: 280px; 
            background: var(--bpn-navy); 
            color: #ffffff; 
            display: flex; 
            flex-direction: column; 
            position: fixed; 
            height: 100vh; 
            overflow-y: auto; 
            z-index: 100;
            box-shadow: 4px 0 15px rgba(0,0,0,0.05);
        }

        /* Header / Brand Logo ATR/BPN */
        .sidebar-brand { 
            padding: 20px 18px; 
            border-bottom: 1px solid rgba(255, 255, 255, 0.1); 
            display: flex; 
            align-items: center; 
            gap: 12px;
            background: var(--bpn-navy-dark);
        }
        .sidebar-brand img {
            width: 44px;
            height: auto;
            object-fit: contain;
        }
        .sidebar-brand-text {
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand-text .institution {
            font-size: 11px;
            font-weight: 600;
            line-height: 1.25;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }
        .sidebar-brand-text .app-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--bpn-gold);
            margin-top: 3px;
            letter-spacing: 0.03em;
        }

        /* Sidebar Menu Items */
        .sidebar-menu { list-style: none; padding: 20px 14px; flex: 1; }
        .sidebar-menu li { margin-bottom: 6px; }
        .sidebar-menu a { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            padding: 12px 16px; 
            color: #94a3b8; 
            text-decoration: none; 
            font-size: 13.5px; 
            font-weight: 500;
            border-radius: var(--radius);
            transition: all 0.2s ease; 
            cursor: pointer; 
        }
        .sidebar-menu a:hover { 
            background: var(--bpn-navy-light); 
            color: #ffffff; 
        }
        
        /* Menu Utama Aktif */
        .sidebar-menu > li > a.active-parent { 
            background: var(--bpn-gold); 
            color: var(--bpn-navy-dark) !important; 
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(251, 192, 45, 0.3);
        }

        /* Dropdown Submenu */
        .sidebar-submenu {
            list-style: none;
            background: rgba(0, 0, 0, 0.2);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s cubic-bezier(0, 1, 0, 1);
            border-radius: var(--radius);
            margin-top: 4px;
            margin-bottom: 4px;
        }
        .sidebar-submenu.open {
            max-height: 300px;
            transition: max-height 0.3s ease-in-out;
            padding: 6px 0;
        }
        
        .sidebar-submenu li a {
            padding: 10px 16px 10px 42px;
            font-size: 13px;
            color: #cbd5e1;
            position: relative;
        }
        .sidebar-submenu li a:hover, .sidebar-submenu li a.active {
            color: var(--bpn-gold);
            background: transparent;
            font-weight: 600;
        }
        .sidebar-submenu li a.active::before {
            content: '';
            position: absolute;
            left: 24px;
            top: 50%;
            transform: translateY(-50%);
            width: 6px;
            height: 6px;
            background: var(--bpn-gold);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--bpn-gold);
        }

        .arrow {
            transition: transform 0.2s ease;
            font-size: 10px;
            opacity: 0.8;
        }
        .dropdown.open .arrow {
            transform: rotate(180deg);
        }

        /* Content Area & Topbar Header */
        .content { margin-left: 280px; flex: 1; display: flex; flex-direction: column; min-width: 0; }
        .topbar { 
            background: #ffffff; 
            border-bottom: 1px solid var(--border); 
            padding: 16px 36px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: var(--shadow-sm);
            position: sticky;
            top: 0;
            z-index: 90;
        }
        .topbar h3 {
            font-size: 18px;
            font-weight: 700;
            color: var(--bpn-navy);
            letter-spacing: -0.01em;
        }

        .user-info { display: flex; align-items: center; gap: 14px; font-size: 14px; }
        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--bpn-navy);
            color: var(--bpn-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        .btn-logout { 
            background: var(--danger-light); 
            color: var(--danger); 
            border: 1px solid rgba(239, 68, 68, 0.2); 
            padding: 7px 14px; 
            border-radius: var(--radius); 
            cursor: pointer; 
            font-weight: 600; 
            font-size: 13px;
            transition: all 0.2s; 
        }
        .btn-logout:hover { 
            background: var(--danger); 
            color: #ffffff; 
        }

        /* Main Container Content */
        .container { padding: 32px 36px; }

        /* Modern UI Cards */
        .card { 
            background: var(--card-bg); 
            border-radius: var(--radius); 
            border: 1px solid var(--border); 
            padding: 24px; 
            margin-bottom: 24px; 
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.2s;
        }
        .card:hover {
            box-shadow: var(--shadow);
        }

        /* Buttons Style (Kuning khas BPN) */
        .btn { 
            background: var(--bpn-gold); 
            color: var(--bpn-navy-dark); 
            padding: 9px 18px; 
            border: none; 
            border-radius: var(--radius); 
            cursor: pointer; 
            font-weight: 600; 
            font-size: 14px;
            text-decoration: none; 
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(251, 192, 45, 0.25);
        }
        .btn:hover { 
            background: var(--bpn-gold-hover); 
            transform: translateY(-1px);
        }
        .btn-danger { background: var(--danger); color: #fff; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2); }
        .btn-danger:hover { background: #dc2626; }
        .btn-sm { padding: 5px 10px; font-size: 12.5px; border-radius: 6px; }

        /* Form Components */
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; color: #334155; }
        .form-control { 
            width: 100%; 
            padding: 10px 14px; 
            border: 1px solid var(--border); 
            border-radius: var(--radius); 
            font-size: 14px;
            font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--bpn-navy);
            box-shadow: 0 0 0 3px rgba(12, 35, 64, 0.12);
        }

        /* Table Styling */
        .table-responsive { overflow-x: auto; border-radius: var(--radius); border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; font-size: 14px; text-align: left; }
        th, td { padding: 14px 16px; border-bottom: 1px solid var(--border); }
        th { background: #f8fafc; color: var(--text-muted); font-weight: 600; font-size: 12.5px; text-transform: uppercase; letter-spacing: 0.03em; }
        tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #f8fafc; }

        /* Alerts */
        .alert { 
            padding: 14px 20px; 
            border-radius: var(--radius); 
            margin-bottom: 24px; 
            font-size: 14px; 
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
        }
        .alert-success { background: var(--success-light); color: #065f46; border: 1px solid rgba(16, 185, 129, 0.2); }
        .alert-danger { background: var(--danger-light); color: #991b1b; border: 1px solid rgba(239, 68, 68, 0.2); }
    </style>

    <!-- Slot khusus untuk CSS tambahan dari view/child page -->
    @stack('styles')
</head>
<body>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <!-- Brand Logo ATR/BPN -->
        <div class="sidebar-brand">
            <img src="{{ asset('images/logo-bpn.png') }}" alt="Logo ATR/BPN">
            <div class="sidebar-brand-text">
                <span class="institution">Kementerian ATR / BPN</span>
                <span class="app-name">SISTEM PPS</span>
            </div>
        </div>

        <ul class="sidebar-menu">
            <!-- Menu Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active-parent' : '' }}" style="justify-content: flex-start; gap: 12px;">
                    <span>📊</span> Dashboard
                </a>
            </li>
            
            <!-- Menu Dropdown: Daftar Perkara -->
            <li class="dropdown {{ request()->routeIs('perkara.*') || request()->routeIs('putusan.*') || request()->routeIs('laporan.*') ? 'open' : '' }}">
                <a href="javascript:void(0)" onclick="toggleDropdown(this)" class="{{ request()->routeIs('perkara.*') || request()->routeIs('putusan.*') || request()->routeIs('laporan.*') ? 'active-parent' : '' }}">
                    <span style="display: flex; align-items: center; gap: 12px;">
                        <span>📁</span> Daftar Perkara
                    </span>
                    <span class="arrow">▼</span>
                </a>
                <ul class="sidebar-submenu {{ request()->routeIs('perkara.*') || request()->routeIs('putusan.*') || request()->routeIs('laporan.*') ? 'open' : '' }}">
                    <li>
                        <a href="{{ route('perkara.index') }}" class="{{ request()->routeIs('perkara.*') ? 'active' : '' }}">
                            Data Perkara
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('putusan.index') }}" class="{{ request()->routeIs('putusan.*') ? 'active' : '' }}">
                            Putusan Perkara
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                            Laporan
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Menu Dropdown: Daftar Mediasi (Diletakkan di atas Jadwal Sidang) -->
            <li class="dropdown {{ request()->routeIs('surat-perintah.*') || request()->routeIs('undangan-mediasi.*') || request()->routeIs('notulensi.*') ? 'open' : '' }}">
                <a href="javascript:void(0)" onclick="toggleDropdown(this)" class="{{ request()->routeIs('surat-perintah.*') || request()->routeIs('undangan-mediasi.*') || request()->routeIs('notulensi.*') ? 'active-parent' : '' }}">
                    <span style="display: flex; align-items: center; gap: 12px;">
                        <span>🤝</span> Daftar Mediasi
                    </span>
                    <span class="arrow">▼</span>
                </a>
                <ul class="sidebar-submenu {{ request()->routeIs('surat-perintah.*') || request()->routeIs('undangan-mediasi.*') || request()->routeIs('notulensi.*') ? 'open' : '' }}">
                    <li>
                        <a href="{{ route('surat-perintah.index') }}" class="{{ request()->routeIs('surat-perintah.*') ? 'active' : '' }}">
                            Surat Perintah
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('undangan-mediasi.index') }}" class="{{ request()->routeIs('undangan-mediasi.*') ? 'active' : '' }}">
                            Undangan Mediasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('notulensi.index') }}" class="{{ request()->routeIs('notulensi.*') ? 'active' : '' }}">
                            Notulensi
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Menu Mandiri: Data Jadwal Sidang -->
            <li>
                <a href="{{ route('schedules.index') }}" class="{{ request()->routeIs('schedules.*') ? 'active-parent' : '' }}" style="justify-content: flex-start; gap: 12px;">
                    <span>📅</span> Data Jadwal Sidang
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content Area -->
    <div class="content">
        <header class="topbar">
            <h3>{{ $title ?? 'Dashboard' }}</h3>
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->username ?? 'A', 0, 1)) }}
                </div>
                <span>Halo, <strong>{{ auth()->user()->username ?? 'Admin' }}</strong></span>
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="btn-logout">Logout</button>
                </form>
            </div>
        </header>

        <main class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Script JavaScript Dropdown Sidebar -->
    <script>
        function toggleDropdown(element) {
            const parentLi = element.parentElement;
            const submenu = parentLi.querySelector('.sidebar-submenu');
            
            parentLi.classList.toggle('open');
            submenu.classList.toggle('open');
        }
    </script>

    <!-- Slot khusus untuk JavaScript tambahan dari view/child page -->
    @stack('scripts')
</body>
</html>