<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?> — SalesPulse</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>

<!-- Sidebar Navigation -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">SP</div>
        <span class="brand-name">SalesPulse</span>
    </div>
    <nav class="sidebar-nav">
        <a href="<?= BASE_URL ?>/" class="nav-item <?= (strpos($_SERVER['REQUEST_URI'],'sales') === false && strpos($_SERVER['REQUEST_URI'],'product') === false && strpos($_SERVER['REQUEST_URI'],'customer') === false) ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            <span>Dashboard</span>
        </a>
        <a href="<?= BASE_URL ?>/sales" class="nav-item <?= strpos($_SERVER['REQUEST_URI'],'sales') !== false ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            <span>Sales</span>
        </a>
        <a href="<?= BASE_URL ?>/products" class="nav-item <?= strpos($_SERVER['REQUEST_URI'],'product') !== false ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            <span>Products</span>
        </a>
        <a href="<?= BASE_URL ?>/customers" class="nav-item <?= strpos($_SERVER['REQUEST_URI'],'customer') !== false ? 'active' : '' ?>">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            <span>Customers</span>
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">AD</div>
            <div>
                <div class="user-name">Admin</div>
                <div class="user-role">Analytics Manager</div>
            </div>
        </div>
    </div>
</aside>

<!-- Main Content -->
<main class="main-content">
    <header class="top-bar">
        <div class="page-title">
            <h1><?= htmlspecialchars($title ?? 'Dashboard') ?></h1>
            <span class="page-date"><?= date('l, F j, Y') ?></span>
        </div>
        <div class="top-bar-actions">
            <?php if (!empty($_SESSION['flash'])): ?>
                <div class="flash flash-<?= $_SESSION['flash']['type'] ?>">
                    <?= htmlspecialchars($_SESSION['flash']['msg']) ?>
                </div>
                <?php unset($_SESSION['flash']); ?>
            <?php endif; ?>
        </div>
    </header>
    <div class="content-body">
