<?php require_once(__DIR__ . "/../components/dashboard/head.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/sidebar.php"); ?>

<div class="main-content" id="mainContent">
  <?php require_once(__DIR__ . "/../components/dashboard/header.php"); ?>

  <div class="dashboard-banner d-flex justify-content-between align-items-center p-4 mb-4 bg-light rounded">
    <div class="banner-content">
      <h1>Skafarm Dashboard</h1>
      <p>Kelola bisnis pertanian Anda dengan mudah dan efisien</p>
    </div>
    <div class="banner-action">
      <a href="index.php?controller=produk&action=index" class="btn btn-success">
        Kelola Produk <i class="bi bi-plus ms-2"></i>
      </a>
    </div>
  </div>

  <div class="kpi-section">
    <div class="row g-4">
      <div class="col-lg-3 col-md-6">
        <div class="kpi-card products">
          <div class="card-icon"><i class="bi bi-flower3"></i></div>
          <h3><?= $totalProduk ?></h3>
          <p>Total Produk</p>
          <a href="index.php?controller=produk&action=index" class="card-link">
            More Info <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="kpi-card orders">
          <div class="card-icon"><i class="bi bi-cart-fill"></i></div>
          <h3><?= $totalPesanan ?></h3>
          <p>Total Pesanan</p>
          <a href="index.php?controller=transaksi&action=index" class="card-link">
            More Info <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="kpi-card revenue">
          <div class="card-icon"><i class="bi bi-cash-stack"></i></div>
          <h3>Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></h3>
          <p>Total Pendapatan</p>
          <a href="index.php?controller=transaksi&action=index" class="card-link">
            More Info <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-md-6">
        <div class="kpi-card stock">
          <div class="card-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
          <h3><?= $stokHampirHabis ?></h3>
          <p>Stok Hampir Habis (Jika Stok Kurang Dari 5)</p>
          <a href="index.php?controller=produk&action=index" class="card-link">
            More Info <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once(__DIR__ . "/../components/dashboard/modal.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/footer.php"); ?>