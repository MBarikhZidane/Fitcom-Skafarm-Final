<?php

require_once(__DIR__ . "/config/database.php");


$controller = $_GET['controller'] ?? 'landing'; 
$action     = $_GET['action'] ?? 'beranda';
$id         = $_GET['id'] ?? null;

switch ($controller) {
    case 'dashboard':
        require_once(__DIR__ . "/controllers/DashboardController.php");
        $dashboardController = new DashboardController($conn);
        switch ($action) {
            case 'beranda':
                $dashboardController->beranda();
                break;
            case 'pesanan':
                require_once(__DIR__ . "/controllers/TransaksiController.php");
                $transaksiController = new TransaksiController($conn);
                $transaksiController->index();
                break;
            default:
                $dashboardController->beranda();
                break;
        }
        break;

    case 'kategori':
        require_once(__DIR__ . "/controllers/KategoriController.php");
        $kategoriController = new KategoriController($conn);
        switch ($action) {
            case 'index':
                $kategoriController->index();
                break;
            case 'store':
                $kategoriController->store();
                break;
            case 'update':
                $kategoriController->update();
                break;
            case 'delete':
                $kategoriController->delete();
                break;
        }
        break;

    case 'gudang':
        require_once(__DIR__ . "/controllers/GudangController.php");
        $gudangController = new GudangController($conn);
        switch ($action) {
            case 'index':
                $gudangController->index();
                break;
            case 'store':
                $gudangController->store();
                break;
            case 'update':
                $gudangController->update();
                break;
            case 'delete':
                $gudangController->delete();
                break;
        }
        break;

    case 'produk':
        require_once(__DIR__ . "/controllers/ProdukController.php");
        $produkController = new ProdukController($conn);
        switch ($action) {
            case 'index':
                $produkController->index();
                break;
            case 'store':
                $produkController->store();
                break;
            case 'update':
                $produkController->update();
                break;
            case 'delete':
                $produkController->delete();
                break;
        }
        break;

    case 'blog':
        require_once(__DIR__ . "/controllers/BlogController.php");
        $blogController = new BlogController($conn);
        switch ($action) {
            case 'myblog':
                $blogController->myblog();
                break;
            case 'store':
                $blogController->store();
                break;
            case 'update':
                $blogController->update();
                break;
            case 'delete':
                $blogController->delete();
                break;
            case 'show':
                $blogController->show();
                break;
        }
        break;

    case 'cart':
        require_once(__DIR__ . "/controllers/CartController.php");
        $cartController = new CartController($conn);
        switch ($action) {
            case 'mycart':
                $cartController->mycart();
                break;
            case 'add':
                $cartController->add();
                break;
            case 'update':
                $cartController->update();
                break;
            case 'delete':
                $cartController->delete();
                break;
        }
        break;

    case 'detailtransaksi':
        require_once(__DIR__ . "/controllers/DetailtransaksiController.php");
        $detailtransaksi = new DetailtransaksiController($conn);
        switch ($action) {
            case 'checkout':
                $detailtransaksi->checkout();
                break;
            case 'myhistory':
                $detailtransaksi->myhistory();
                break;
            case 'update':
                $detailtransaksi->update();
                break;
            case 'detail':
                $detailtransaksi->detail();
                break;
        }
        break;

    case 'transaksi':
        require_once(__DIR__ . "/controllers/TransaksiController.php");
        $transaksiController = new TransaksiController($conn);
        switch ($action) {
            case 'index':
                $transaksiController->index();
                break;
            case 'updateStatus':
                $transaksiController->updateStatus();
                break;
        }
        break;

    case 'auth':
        require_once(__DIR__ . "/controllers/AuthController.php");
        $authController = new AuthController($conn);
        switch ($action) {
            case 'showLogin':
                $authController->showLogin();
                break;
            case 'login':
                $authController->login();
                break;
            case 'showRegister':
                $authController->showRegister();
                break;
            case 'register':
                $authController->register();
                break;
            case 'logout':
                $authController->logout();
                break;
            default:
                $authController->showLogin();
                break;
        }
        break;

    case 'beranda':
        require_once(__DIR__ . "/controllers/BerandaController.php");
        $berandaController = new BerandaController($conn);
        switch ($action) {
            case 'detail':
                $berandaController->detail();
                break;
            case 'comment':
                $berandaController->comment();
                break;
            case 'deleteComment':
                $berandaController->deleteComment();
                break;
            case 'index':
            default:
                $berandaController->index();
                break;
        }
        break;


    default:
        require_once(__DIR__ . "/controllers/BerandaController.php");
        $berandaController = new BerandaController($conn);
        $berandaController->index();
        break;
}
