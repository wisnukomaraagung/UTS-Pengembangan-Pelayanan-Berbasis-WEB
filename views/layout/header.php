<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?? 'E-Commerce MVC' ?> - Ecommerce</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --sidebar-w: 240px;
            --primary: #1e3a5f;
            --accent: #f0a500;
        }
        body { background: #f4f6fa; font-family: 'Segoe UI', sans-serif; }

        /* SIDEBAR */
        #sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--primary);
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            transition: .3s;
        }
        #sidebar .brand {
            padding: 20px 16px;
            background: rgba(0,0,0,.2);
            color: #fff;
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        #sidebar .brand span { color: var(--accent); }
        #sidebar .nav-link {
            color: rgba(255,255,255,.75);
            padding: 12px 20px;
            border-left: 3px solid transparent;
            transition: .2s;
            font-size: .95rem;
        }
        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,.1);
            border-left-color: var(--accent);
        }
        #sidebar .nav-link i { width: 22px; }

        /* MAIN CONTENT */
        #main { margin-left: var(--sidebar-w); padding: 24px; }

        /* TOPBAR */
        .topbar {
            background: #fff;
            padding: 14px 24px;
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0,0,0,.08);
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .topbar h5 { margin: 0; color: var(--primary); font-weight: 700; }

        /* CARDS */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,.07);
        }
        .card-header {
            background: var(--primary);
            color: #fff;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }

        /* STAT CARDS */
        .stat-card {
            border-radius: 12px;
            color: #fff;
            padding: 20px;
        }
        .stat-card .number { font-size: 2rem; font-weight: 700; }
        .stat-card .label  { opacity: .85; font-size: .9rem; }

        /* TABLE */
        .table th { background: #f0f4ff; color: var(--primary); font-weight: 600; }
        .table td { vertical-align: middle; }

        /* BTN */
        .btn-accent { background: var(--accent); color: #fff; border: none; }
        .btn-accent:hover { background: #d4900a; color: #fff; }

        /* BADGE STATUS */
        .badge-pending  { background: #ffc107; color: #333; }
        .badge-selesai  { background: #28a745; color: #fff; }
        .badge-batal    { background: #dc3545; color: #fff; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<nav id="sidebar">
    <div class="brand">🛒 Toko<span>MVC</span></div>
    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a href="?page=kategori" class="nav-link <?= (isset($_GET['page']) && $_GET['page']=='kategori') ? 'active' : ((!isset($_GET['page'])) ? 'active' : '') ?>">
                <i class="fas fa-tags"></i> Kategori
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=produk" class="nav-link <?= (isset($_GET['page']) && $_GET['page']=='produk') ? 'active' : '' ?>">
                <i class="fas fa-box"></i> Produk
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=supplier" class="nav-link <?= (isset($_GET['page']) && $_GET['page']=='supplier') ? 'active' : '' ?>">
                <i class="fas fa-truck"></i> Supplier
            </a>
        </li>
        <li class="nav-item">
            <a href="?page=transaksi" class="nav-link <?= (isset($_GET['page']) && $_GET['page']=='transaksi') ? 'active' : '' ?>">
                <i class="fas fa-receipt"></i> Transaksi
            </a>
        </li>
    </ul>
    <div style="position:absolute; bottom:20px; left:0; right:0; padding:0 16px;">
        <small class="text-white-50">E-Commerce MVC &copy; 2026</small>
    </div>
</nav>

<!-- MAIN -->
<div id="main">
    <!-- Topbar -->
    <div class="topbar">
        <h5><i class="fas fa-store me-2"></i><?= $data['title'] ?? '' ?></h5>
        <span class="text-muted"><i class="fas fa-calendar me-1"></i><?= date('d F Y') ?></span>
    </div>
