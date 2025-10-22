<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
$img = 'default.jpg';
if (!empty($row['img'])) {
    $decoded = json_decode($row['img'], true);
    if (is_array($decoded) && count($decoded) > 0) {
        $img = $decoded[0];
    } elseif (is_string($row['img'])) {
        $img = $row['img'];
    }
}
?>

<?php require_once(__DIR__ . "/../components/landingPage/head.php"); ?>
<?php require_once(__DIR__ . "/../components/landingPage/navbar.php"); ?>
<?php require_once(__DIR__ . "/../components/landingPage/carousle.php"); ?>

<section class="custom-container my-4" id="kategori">
    <div class="featured-header d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="mb-2 mb-md-0">Kategori Tersedia</h2>
        <div class="nav-buttons d-flex gap-2">
            <button class="btn btn-sm" id="prev-btn" aria-label="Kategori Sebelumnya">
                <i class="bi bi-arrow-left"></i>
            </button>
            <button class="btn btn-sm" id="next-btn" aria-label="Kategori Selanjutnya">
                <i class="bi bi-arrow-right"></i>
            </button>
        </div>
    </div>

    <div class="categories-wrapper" id="categories-wrapper">
        <div class="category-grid">
            <?php if ($kategori && $kategori->rowCount() > 0): ?>
                <?php $i = 1; ?>
                <?php while ($row = $kategori->fetch(PDO::FETCH_ASSOC)): ?>
                    <?php $bgClass = "bg-color-" . ($i % 10 == 0 ? 10 : $i % 10); ?>
                    <div class="col-category">
                        <a href="index.php?controller=beranda&action=index&kategori=<?= $row['kode_kategori'] ?>"
                            class="category-item <?= $bgClass ?> text-decoration-none <?= (($_GET['kategori'] ?? '') == $row['kode_kategori']) ? 'active' : '' ?>">
                            <img src="uploads/<?= htmlspecialchars($row['img'] ?: 'default.jpg') ?>"
                                alt="<?= htmlspecialchars($row['nama_kategori']) ?>" />
                            <div class="category-title"><?= htmlspecialchars($row['nama_kategori']) ?></div>
                            <div class="category-items-count"><?= $row['total_produk'] ?> items</div>
                        </a>
                    </div>
                    <?php $i++; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada kategori tersedia.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="custom-container" id="produk">
    <div class="mb-4">
        <h2 class="fw-bold m-0">Semua Produk</h2>
    </div>

    <div class="row g-4">
        <?php if ($produk && $produk->rowCount() > 0): ?>
            <?php while ($row = $produk->fetch(PDO::FETCH_ASSOC)): ?>
                <?php
                $img = 'default.jpg';
                if (!empty($row['img'])) {
                    $decoded = json_decode($row['img'], true);
                    if (is_array($decoded) && count($decoded) > 0) {
                        $img = $decoded[0];
                    } elseif (is_string($row['img'])) {
                        $img = $row['img'];
                    }
                }
                ?>
                <div class="col-6 col-sm-4 col-md-3 col-lg-1-5">
                    <div class="product-card bg-white d-flex flex-column">
                        <div class="product-img-wrapper">
                            <img src="uploads/<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($row['nama_barang']) ?>"
                                class="product-img" />
                        </div>

                        <div class="product-details">
                            <p class="product-category"><?= htmlspecialchars($row['nama_kategori'] ?? '-') ?></p>
                            <h5 class="product-title">
                                <a href="index.php?controller=beranda&action=detail&id=<?= $row['kode_produk'] ?>">
                                    <?= htmlspecialchars($row['nama_barang']) ?>
                                </a>
                            </h5>
                            <p class="product-sold">
                                Terjual (<span class="fw-bold"><?= $row['total_terjual'] ?></span>)
                            </p>
                            <p class="product-brand mb-0 mt-1">Oleh SkaFarm</p>
                        </div>
                        <div class="product-footer d-flex flex-wrap flex-md-nowrap justify-content-between align-items-center gap-2">
                            <div class="text-success fw-semibold">
                                Rp<?= number_format($row['harga'], 0, ',', '.') ?>
                            </div>

                            <?php if (isset($_SESSION['username'])): ?>
                                <a href="index.php?controller=cart&action=add&id=<?= $row['kode_produk'] ?>"
                                    class="btn-add-to-cart btn btn-sm btn-success px-3 py-1">
                                    <i class="bi bi-cart-plus me-1"></i> Add
                                </a>
                            <?php else: ?>
                                <a href="index.php?controller=auth&action=showLogin"
                                    class="btn-add-to-cart btn btn-sm btn-outline-success px-3 py-1">
                                    <i class="bi bi-cart-plus me-1"></i> Add
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">Belum ada produk tersedia.</p>
        <?php endif; ?>
    </div>

</section>


<section class="custom-container" id="tentang">
    <!-- Bagian Header (Judul dan Deskripsi) -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="header-content">
                <h1 class="main-heading">Tentang Kami</h1>
                <p class="sub-text">
                    Smart Farm hadir sebagai solusi terdepan untuk petani modern di
                    Indonesia.
                </p>
            </div>
        </div>
    </div>

    <!-- Bagian Card Fitur (3 Kolom) -->
    <div class="row row-gap-5">
        <!-- Menerapkan kelas row-gap-5 untuk jarak antar kartu -->

        <!-- Card 1: Kuning/Jingga - Misi Kami -->
        <div class="col-lg-4 col-md-6 d-flex">
            <div class="feature-card card-yellow">
                <div class="feature-card-icon">
                    <i class="bi bi-rocket-takeoff-fill"></i>
                    <!-- Mengganti Icon: Misi -->
                </div>
                <h5 class="card-title">Misi Kami: Produktivitas</h5>
                <p class="card-text">
                    Mendukung petani untuk mencapai hasil panen maksimal melalui
                    penggunaan teknologi pertanian presisi yang mudah diakses dan
                    berkelanjutan.
                </p>
            </div>
        </div>

        <!-- Card 2: Hijau - Visi Kami -->
        <div class="col-lg-4 col-md-6 d-flex">
            <div class="feature-card card-green">
                <div class="feature-card-icon">
                    <i class="bi bi-globe-americas"></i>
                    <!-- Mengganti Icon: Visi -->
                </div>
                <h5 class="card-title">Visi Kami: Pertanian Hijau</h5>
                <p class="card-text">
                    Menjadi pelopor agrikultur cerdas di Asia Tenggara, menciptakan
                    ekosistem pertanian yang efisien, ramah lingkungan, dan inovatif.
                </p>
            </div>
        </div>

        <!-- Card 3: Ungu - Nilai Utama Kami -->
        <div class="col-lg-4 col-md-12 d-flex">
            <div class="feature-card card-purple">
                <div class="feature-card-icon">
                    <i class="bi bi-gem"></i>
                    <!-- Mengganti Icon: Nilai -->
                </div>
                <h5 class="card-title">Nilai Utama: Inovasi & Edukasi</h5>
                <p class="card-text">
                    Kami berkomitmen pada inovasi berkelanjutan dan edukasi,
                    memastikan setiap petani dapat memanfaatkan teknologi untuk masa
                    depan pangan yang lebih baik.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="custom-max-width-wrapper mt-5 py-5" id="blog">
    <div class="text-center mb-5">
        <h1 class="section-title display-5 mb-2" style="color: var(--primary-color)">
            Jurnal Pertanian Cerdas
        </h1>
        <p class="section-subtitle">Wawasan terbaru seputar Smart Farming, teknologi agrikultur, dan kesejahteraan
            petani.</p>
        <hr class="w-25 mx-auto mt-4 mb-5" style="border-color: #ccc" />
    </div>

    <!-- Bagian Unggulan + Side -->
    <div class="row g-4 mb-5">
        <!-- Unggulan -->
        <div class="col-lg-8">
            <?php if ($blogFeatured && $blogFeatured->rowCount() > 0): ?>
                <?php $featured = $blogFeatured->fetch(PDO::FETCH_ASSOC); ?>
                <div class="featured-image-container">
                    <img src="uploads/<?= htmlspecialchars($featured['img'] ?: 'default.jpg') ?>" class="img-fluid"
                        alt="<?= htmlspecialchars($featured['judul']) ?>" />
                    <div class="featured-card-body w-100">
                        <h3 class="mb-3"><?= htmlspecialchars($featured['judul']) ?></h3>
                        <div class="featured-meta mb-3">
                            <i class="bi bi-calendar"></i> <?= date('F d, Y', strtotime($featured['created_at'])) ?>
                            <span class="mx-2">|</span>
                            <i class="bi bi-person"></i> <?= htmlspecialchars($featured['penulis'] ?? 'Admin') ?>
                        </div>
                        <p class="d-none d-sm-block"><?= substr(strip_tags($featured['artikel']), 0, 50) ?>...</p>
                        <div class="mt-2">
                            <a href="index.php?controller=blog&action=show&id=<?= htmlspecialchars($featured['id_blog']) ?>"
                                class="read-more text-white">
                                Baca Lebih Lanjut <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Side Artikel -->
        <div class="col-lg-4 d-flex flex-column justify-content-between">
            <h6 class="text-uppercase fw-bold text-muted mb-3">TEKNOLOGI AGRIKULTUR</h6>
            <?php if ($blogSide && $blogSide->rowCount() > 0): ?>
                <?php while ($row = $blogSide->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="side-article mb-3">
                        <h6 class="mb-2"><?= htmlspecialchars($row['judul']) ?></h6>
                        <small class="text-muted"><i class="bi bi-calendar"></i>
                            <?= date('F d, Y', strtotime($row['created_at'])) ?></small>
                        <div class="mt-2">
                            <a href="index.php?controller=blog&action=show&id=<?= htmlspecialchars($row['id_blog']) ?>"
                                class="read-more">
                                Baca Lebih Lanjut <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada artikel lain.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Jelajahi Artikel Terbaru -->
    <div class="row g-4 mb-4 mt-5 align-items-end">
        <div class="col-lg-6">
            <h2 class="section-title display-6 mb-1">Edukasi & Kisah Petani</h2>
        </div>
        <div class="col-lg-6">
            <p class="section-subtitle text-lg-end mb-0">
                Temukan panduan praktis dan kisah inspiratif dari komunitas petani di Indonesia.
            </p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <?php if ($blogAll && $blogAll->rowCount() > 0): ?>
            <?php while ($row = $blogAll->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <img src="uploads/<?= htmlspecialchars($row['img'] ?: 'default.jpg') ?>" class="card-img-top"
                            alt="<?= htmlspecialchars($row['judul']) ?>" />
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($row['judul']) ?></h5>
                            <small class="text-muted"><i class="bi bi-calendar"></i>
                                <?= date('F d, Y', strtotime($row['created_at'])) ?></small>
                            <div class="mt-3">
                                <a href="index.php?controller=blog&action=show&id=<?= htmlspecialchars($row['id_blog']) ?>"
                                    class="read-more">
                                    Baca Lebih Lanjut <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-muted">Belum ada artikel tersedia.</p>
        <?php endif; ?>
    </div>
</section>


<?php require_once(__DIR__ . "/../components/landingPage/modal.php"); ?>
<?php require_once(__DIR__ . "/../components/landingPage/footer.php"); ?>