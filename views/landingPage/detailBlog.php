<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = $_SESSION['username'] ?? '';
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

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-8">
            <article class="card border-0 shadow-lg rounded-4 overflow-hidden">
                
                <?php if (!empty($blog['img'])): ?>
                    <div class="ratio ratio-16x9">
                        <img src="uploads/<?= htmlspecialchars($blog['img']) ?>" 
                             class="w-100 h-100 object-fit-cover" 
                             alt="Gambar Artikel">
                    </div>
                <?php endif; ?>

                <div class="card-body p-4 p-md-5">
                    <h1 class="fw-bold mb-3"><?= htmlspecialchars($blog['judul']) ?></h1>
                    
                    <div class="d-flex flex-wrap align-items-center text-muted small mb-4 gap-3">
                        <span>
                            <i class="bi bi-person-circle me-1 text-success"></i> 
                            <?= htmlspecialchars($blog['username']) ?>
                        </span>
                        <span>
                            <i class="bi bi-calendar-event me-1 text-primary"></i> 
                            <?= date("d F Y", strtotime($blog['created_at'])) ?>
                        </span>
                        <span>
                            <i class="bi bi-clock-history me-1 text-warning"></i>
                            <?= date("H:i", strtotime($blog['created_at'])) ?> WIB
                        </span>
                    </div>

                    <div class="fs-6 lh-lg mb-4 text-body">
                        <?= nl2br(htmlspecialchars($blog['artikel'])) ?>
                    </div>

                    <hr class="my-4">

                    
                </div>
            </article>
        </div>
    </div>
</div>

<?php require_once(__DIR__ . "/../components/landingPage/footer.php"); ?>
