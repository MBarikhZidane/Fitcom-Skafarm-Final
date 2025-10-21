<?php

function isActive($controller, $action = 'beranda')
{
    return ($_GET['controller'] === $controller && $_GET['action'] === $action)
        ? 'active'
        : '';
}
?>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class="bi bi-leaf logo-icon"></i>
        <span class="logo-text">Skafarm</span>
    </div>

    <nav class="sidebar-menu">
        <a href="index.php?controller=dashboard&action=beranda"
            class="menu-item <?= isActive('dashboard', 'beranda') ?>">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard </span>


        </a>

        <a href="index.php?controller=produk&action=index"
            class="menu-item <?= isActive('produk', 'index') ?>">
            <i class="bi bi-flower3"></i>
            <span>Produk</span>
        </a>

        <a href="index.php?controller=dashboard&action=pesanan"
            class="menu-item <?= isActive('dashboard', 'pesanan') ?>">
            <i class="bi bi-cart-fill"></i>
            <span>Pesanan</span>
        </a>

        <a href="index.php?controller=kategori&action=index"
            class="menu-item <?= isActive('kategori', 'index') ?>">
            <i class="bi bi-tags-fill"></i>
            <span>Kategori</span>
        </a>

        <a href="index.php?controller=gudang&action=index"
            class="menu-item <?= isActive('gudang', 'index') ?>">
            <i class="bi bi-building"></i>
            <span>Gudang</span>
        </a>
        <?php  ?>
        <?php  ?>
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar"><?= getInitials($_SESSION['username'] ?? "User") ?></div>
            <div class="user-info">
                <div style="font-weight: 600; font-size: 14px"><?= $_SESSION['username']?></div>
                <div style="font-size: 12px; opacity: 0.8"><?= $_SESSION['email']?></div>
            </div>
        </div>
    </div>
</div>