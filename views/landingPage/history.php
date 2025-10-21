<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<?php require_once(__DIR__ . "/../components/landingPage/head.php"); ?>
<nav class="cart-navbar shadow-sm bg-body-tertiary border-bottom sticky-top z-3 py-3">
    <div class="container d-flex justify-content-between align-items-center px-3 px-lg-5 position-relative">
        <a class="btn position-relative z-1" href="index.php?controller=beranda&action=index" aria-label="Back">
            <i class="bi bi-arrow-left fs-4 text-success"></i>
        </a>
        <div class="position-absolute start-50 translate-middle-x text-center">
            <a class="navbar-brand me-4 me-lg-5 d-flex align-items-center text-decoration-none"
                href="index.php?controller=beranda&action=index">
                <i class="bi bi-cart-check-fill"
                    style="
                        font-size: 2.2rem;
                        background: linear-gradient(90deg, #15803d, #22c55e, #4ade80);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        margin-right: 10px;
                   "></i>
                <span class="logo-text-gradient">Skafarm</span>
            </a>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <div class="row">
        <div class="col-md-3 mb-3">

            <!-- Sidebar for desktop (md up) -->
            <div class="blog-sidebar d-none d-md-block">
                <div class="nav flex-column">
                    <a class="blog-nav-link text-decoration-none" href="index.php?controller=cart&action=mycart"><i class="bi bi-bag"></i> Carts</a>
                    <a class="blog-nav-link active text-decoration-none" href="index.php?controller=detailtransaksi&action=myhistory"><i class="bi bi-box"></i> History Orders</a>
                    <a class="blog-nav-link text-decoration-none" href="index.php?controller=blog&action=myblog"><i class="bi bi-card-text"></i> Blog</a>
                    <a class="blog-nav-link text-decoration-none blog-logout-link" href="index.php?controller=auth&action=logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
                </div>
            </div>

            <!-- Sidebar as dropdown (visible only on small devices) -->
            <div class="d-md-none">
                <button class="btn btn-outline-success w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#blogMobileSidebar" aria-expanded="false" aria-controls="blogMobileSidebar">
                    ☰ Menu
                </button>

                <div class="collapse" id="blogMobileSidebar">
                    <div class="card card-body p-2" style="width: 100%">
                        <a class="blog-nav-link d-flex gap-2 text-decoration-none" href="index.php?controller=cart&action=mycart"><i class="bi bi-bag"></i> Carts</a>
                        <a class="blog-nav-link d-flex gap-2 active text-decoration-none" href="index.php?controller=detailtransaksi&action=myhistory"><i style="color: #6c757d;" class="bi bi-box"></i> History Orders</a>
                        <a class="blog-nav-link active d-flex gap-2 text-decoration-none" href="index.php?controller=blog&action=myblog"><i style="color: #6c757d;" class="bi bi-card-text"></i> Blog</a>
                        <a class="blog-nav-link blog-logout-link d-flex gap-2 text-decoration-none" href="index.php?controller=auth&action=logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
                    </div>
                </div>
            </div>

        </div>


        <!-- Main Content Area -->
        <div class="col-md-9">
            <div class="cart-main-content pt-5">
                <div class="cart-tab-content pb-5 mb-5 px-2 px-md-4" id="cartOrderTabContent">
                    <?php if (!empty($_GET['status'])): ?>
                        <?php if ($_GET['status'] === 'error'): ?>
                            <div class="alert alert-danger">
                                <?= htmlspecialchars($_GET['msg'] ?? 'Gagal Melakukan Operasi, Coba Lagi.') ?>
                            </div>
                        <?php elseif ($_GET['status'] === 'success'): ?>
                            <div class="alert alert-success">
                                <?= htmlspecialchars($_GET['msg'] ?? 'Berhasil Melakukan Operasi.') ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="tab-pane fade show active" id="cart-all-orders" role="tabpanel">

                        <?php foreach ($historyItems as $item): ?>
                            <?php
                            $img = 'default.jpg';
                            if (!empty($item['img'])) {
                                $decoded = json_decode($item['img'], true);
                                if (is_array($decoded) && count($decoded) > 0) {
                                    $img = $decoded[0];
                                } elseif (is_string($item['img'])) {
                                    $img = $item['img'];
                                }
                            }
                            ?>
                            <div class="cart-order-card border rounded-3 shadow-sm bg-white p-3 p-md-4 mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="badge bg-secondary-subtle text-dark px-3 py-2 rounded-pill">History Order</span>
                                    <small class="text-muted"><?= date("d M Y", strtotime($item['tanggal_transaksi'] ?? 'now')) ?></small>
                                </div>

                                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                                    <div class="flex-shrink-0">
                                        <img src="uploads/<?= htmlspecialchars($img) ?>"
                                            class="rounded-3 img-fluid"
                                            style="width: 90px; height: 90px; object-fit: cover;">
                                    </div>

                                    <div class="flex-grow-1 w-100 d-flex flex-column flex-md-row justify-content-between gap-3">
                                        <div>
                                            <h6 class="fw-semibold mb-1"><?= htmlspecialchars($item['nama_barang']) ?></h6>
                                            <div class="text-success fw-bold mb-1">Rp <?= number_format($item['harga']) ?></div>
                                            <div class="text-muted small">Kategori: <?= htmlspecialchars($item['nama_kategori']) ?></div>
                                        </div>

                                        <div class="text-md-end">
                                            <div class="small text-muted mb-1">Qty: <?= htmlspecialchars($item['qty']) ?></div>
                                            <div class="fw-semibold">
                                                Total: <span class="text-success">Rp <?= number_format($item['harga_total']) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/profil.js"></script>