<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = $_SESSION['username'] ?? '';
$imgs = [];
if (!empty($product['img'])) {
    $decoded = json_decode($product['img'], true);
    $imgs = is_array($decoded) ? $decoded : [$decoded];
}
if (empty($imgs)) {
    $imgs = ['default.jpg'];
}
?>

<?php require_once(__DIR__ . "/../components/landingPage/head.php"); ?>
<?php require_once(__DIR__ . "/../components/landingPage/navbar.php"); ?>
<?php require_once __DIR__ . '/../../helpers/time_helper.php'; ?>

<div class="container pt-5 mb-5">
    <div class="row g-4">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="position-relative">

                    <!-- Tombol prev -->
                    <button id="prevBtn"
                        class="btn btn-light position-absolute top-50 start-0 translate-middle-y ms-2 shadow-sm nav-btn">
                        <i class="bi bi-chevron-left fs-5"></i>
                    </button>

                    <!-- Gambar utama -->
                    <div class="ratio ratio-4x3 overflow-hidden rounded-3">
                        <img id="mainImage" src="uploads/<?= htmlspecialchars($imgs[0]) ?>"
                            class="w-100 h-100 object-fit-cover zoom"
                            alt="<?= htmlspecialchars($product['nama_barang']) ?>">
                    </div>

                    <!-- Tombol next -->
                    <button id="nextBtn"
                        class="btn btn-light position-absolute top-50 end-0 translate-middle-y me-2 shadow-sm nav-btn">
                        <i class="bi bi-chevron-right fs-5"></i>
                    </button>
                </div>

                <!-- Thumbnail bar (lebar sama dengan gambar utama) -->
                <div class="thumb-container mt-3">
                    <div class="d-flex justify-content-between gap-2 w-100">

                        <?php foreach ($imgs as $index => $imgFile): ?>
                            <img src="uploads/<?= htmlspecialchars($imgFile) ?>"
                                class="thumb-img rounded-2 <?= $index === 0 ? 'active' : '' ?>"
                                alt="thumb<?= $index + 1 ?>">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-12 col-md-6">
            <div class="card border-0 h-100">
                <div class="card-body d-flex flex-column">
                    <h3 class="fw-bold mb-3">
                        <i class="bi bi-box-seam text-success me-2"></i>
                        <?= htmlspecialchars($product['nama_barang']) ?>
                    </h3>

                    <p class="text-muted mb-3">
                        <i class="bi bi-cash-stack me-1 text-success"></i>
                        Stok: <?= htmlspecialchars($product['stok']) ?> |
                        <i class="bi bi-tag me-1 text-success"></i>
                        <span class="fw-semibold text-success"><?= htmlspecialchars($product['satuan']) ?></span>
                    </p>

                    <h4 class="fw-bold text-success mb-4">
                        <i class="bi bi-currency-dollar me-2"></i>
                        Rp <?= number_format($product['harga'], 0, ',', '.') ?>
                    </h4>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <?php if ($username): ?>
                            <form method="POST" action="index.php?controller=detailtransaksi&action=checkout"
                                class="flex-grow-1">
                                <input type="hidden" name="kode_barang" value="<?= $product['kode_barang']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-bag me-1"></i> Beli
                                </button>
                            </form>
                            <a href="index.php?controller=cart&action=add&id=<?= $product['kode_barang'] ?>"
                                class="btn btn-outline-success flex-grow-1">
                                <i class="bi bi-cart-plus me-1"></i> Tambah Keranjang
                            </a>
                        <?php else: ?>
                            <a href="index.php?controller=auth&action=showLogin" class="btn btn-success flex-grow-1">
                                <i class="bi bi-bag me-1"></i> Beli
                            </a>
                            <a href="index.php?controller=auth&action=showLogin"
                                class="btn btn-outline-success flex-grow-1">
                                <i class="bi bi-cart-plus me-1"></i> Tambah Keranjang
                            </a>
                        <?php endif; ?>
                    </div>

                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-info-circle text-success me-2"></i> Detail Produk
                    </h5>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item px-0">
                            <i class="bi bi-grid-fill text-success me-2"></i>
                            <strong>Kategori:</strong> <?= htmlspecialchars($product['nama_kategori'] ?? '-') ?>
                        </li>
                        <li class="list-group-item px-0">
                            <i class="bi bi-tag-fill text-success me-2"></i>
                            <strong>Satuan:</strong> <?= htmlspecialchars($product['satuan']) ?>
                        </li>
                        <li class="list-group-item px-0">
                            <i class="bi bi-building text-success me-2"></i>
                            <strong>Gudang:</strong> <?= htmlspecialchars($product['kode_gudang']) ?>
                        </li>
                    </ul>

                    <p class="text-secondary mb-0">
                        <i class="bi bi-file-text me-2 text-success"></i>
                        <?= nl2br(htmlspecialchars($product['deskripsi'])) ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="pb-5">
    <div class="container">
        <div class="row mb-2">
            <div class="col-12">
                <!-- <h1 class="fw-bold text-dark mb-0 fs-3">Customer Feedback</h1> -->
            </div>
        </div>

        <?php if ($ratings && $ratings->rowCount() > 0): ?>
            <div class="row mb-5">
                <div class="col-12">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-md-8 mb-4 mb-md-0">
                            <div class="d-flex flex-column gap-2">
                                <?php for ($i = 5; $i >= 1; $i--): ?>
                                    <div class="d-flex align-items-center">
                                        <span class="me-3 text-nowrap"><?= $i ?>★</span>
                                        <div class="progress flex-grow-1 me-3" style="height: 8px;">
                                            <div class="progress-bar bg-warning-custom"
                                                style="width: <?= $ratingData['stars'][$i] ?>%"></div>
                                        </div>
                                        <span class="text-muted small"><?= $ratingData['stars'][$i] ?>%</span>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="text-center text-md-start">
                                <div class="mb-3">
                                    <div class="text-muted small mb-1">Total Reviews</div>
                                    <div class="h4 fw-bold text-dark mb-0"><?= $ratingData['total_reviews'] ?> Reviews</div>
                                </div>
                                <div>
                                    <div class="text-muted small mb-1">Average Rating</div>
                                    <div class="h4 fw-bold text-dark mb-2"><?= $ratingData['average'] ?></div>
                                    <div class="text-warning-custom">
                                        <?php
                                        $fullStars = floor($ratingData['average']);
                                        $halfStar = ($ratingData['average'] - $fullStars >= 0.5);
                                        for ($i = 1; $i <= 5; $i++):
                                            if ($i <= $fullStars)
                                                echo '<i class="bi bi-star-fill"></i>';
                                            elseif ($halfStar && $i == $fullStars + 1)
                                                echo '<i class="bi bi-star-half"></i>';
                                            else
                                                echo '<i class="bi bi-star"></i>';
                                        endfor;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-2 opacity-25 mb-5">

            <div class="row">
                <div class="col-12">
                    <?php while ($rating = $ratings->fetch(PDO::FETCH_ASSOC)): ?>
                        <div class="border shadow-sm mb-4 rounded-3 position-relative">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex">
                                        <div>
                                            <div class="fw-semibold text-dark">
                                                <?= htmlspecialchars($rating['username'] ?? '-') ?>
                                            </div>
                                            <div class="text-muted small">
                                                <?= htmlspecialchars(timeAgo($rating['created_at'])) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-warning-custom">
                                        <?php
                                        $ratingValue = (int) ($rating['rating'] ?? 0);
                                        for ($i = 1; $i <= 5; $i++):
                                            echo $i <= $ratingValue
                                                ? '<i class="bi bi-star-fill"></i>'
                                                : '<i class="bi bi-star"></i>';
                                        endfor;
                                        ?>
                                    </div>
                                </div>

                                <p class="text-muted mb-3 lh-lg"><?= htmlspecialchars($rating['comment'] ?? '-') ?></p>

                                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $rating['user_id']): ?>
                                    <form action="index.php?controller=beranda&action=deleteComment" method="POST"
                                        class="position-absolute" style="bottom:10px; right:10px;">
                                        <?php if (!empty($rating['id_rating'])): ?>
                                            <input type="hidden" name="rating_id" value="<?= htmlspecialchars($rating['id_rating']) ?>">
                                        <?php endif; ?>
                                        <button type="submit" class="btn btn-link text-danger p-0" title="Hapus Komentar">
                                            <i class="bi bi-trash fs-5"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>

                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <p class="text-muted">Belum ada Rating tersedia.</p>
                </div>
            </div>
        <?php endif; ?>

        <hr class="border-2 opacity-25 mb-5">

        <?php if ($checktransaction != 0): ?>
            <div class="row">
                <div class="col-12">
                    <h4>Anda sudah komen.</h4>
                </div>
                </div>
            </div>
        <?php elseif ($transaksi_kode == '1'): ?>
            <div class="row"><h4>Anda harus beli sebelum komen.</h4></div>
        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <form class="card-body p-4" method="POST" action="index.php?controller=beranda&action=comment">
                            <h3 class="fw-bold text-dark mb-4 fs-5">Submit Your Review</h3>
                            <div class="mb-4">
                                <label class="form-label text-muted small mb-2">Add Your Rating</label>
                                <div class="text-secondary fs-4">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <span class="star" style="cursor:pointer; font-size:24px;" data-value="<?= $i ?>">
                                            <i class="bi bi-star-fill"></i>
                                        </span>
                                    <?php endfor; ?>
                                    <input type="hidden" id="rating" name="rating" required>
                                </div>
                            </div>
                            <div class="mb-2">
                                <label class="form-label fw-semibold text-dark mb-2">Write Your Review*</label>
                                <textarea class="form-control form-control-lg border-2 rounded-3" name="comment" rows="6"
                                    placeholder="Bagikan pengalaman Anda..."></textarea>
                                <input type="hidden" name="kode_barang"
                                    value="<?= htmlspecialchars($product['kode_barang']) ?>">
                            </div>
                            <div class="d-flex justify-content-center justify-content-md-end">
                                <button type="submit" class="btn btn-success btn-lg px-3 py-2 fw-bold rounded-3 shadow-sm">
                                    <i class="bi bi-send me-2"></i>Submit Review
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>


<script>
    $(document).on("mouseenter mousemove mouseleave", ".zoom", function (e) {
        let $this = $(this);

        if (e.type === "mouseenter") {
            $this.addClass("zoomed");
        } else if (e.type === "mousemove" && $this.hasClass("zoomed")) {
            let {
                left,
                top
            } = $this.offset();
            let {
                width,
                height
            } = $this[0].getBoundingClientRect();
            let mouseX = e.pageX - left;
            let mouseY = e.pageY - top;
            let originX = (mouseX / width) * 50;
            let originY = (mouseY / height) * 50;
            $this.css("transform-origin", `${originX}% ${originY}%`);
        } else if (e.type === "mouseleave") {
            $this.removeClass("zoomed").css("transform-origin", "center center");
        }
    });

    const $mainImage = $("#mainImage");
    const $thumbs = $(".thumb-img");
    const $prevBtn = $("#prevBtn");
    const $nextBtn = $("#nextBtn");
    let currentIndex = 0;

    function updateActive(index) {
        $thumbs.removeClass("active");
        $thumbs.eq(index).addClass("active");
        $mainImage.attr("src", $thumbs.eq(index).attr("src"));
        currentIndex = index;
    }

    $thumbs.on("click", function () {
        const index = $thumbs.index(this);
        updateActive(index);
    });

    $prevBtn.on("click", function () {
        currentIndex = (currentIndex - 1 + $thumbs.length) % $thumbs.length;
        updateActive(currentIndex);
    });

    $nextBtn.on("click", function () {
        currentIndex = (currentIndex + 1) % $thumbs.length;
        updateActive(currentIndex);
    });

    updateActive(0);
</script>

<?php require_once(__DIR__ . "/../components/landingPage/footer.php"); ?>