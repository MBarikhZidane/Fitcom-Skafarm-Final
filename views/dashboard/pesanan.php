<?php require_once(__DIR__ . "/../components/dashboard/head.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/sidebar.php"); ?>
<div class="main-content" id="mainContent">
  <?php require_once(__DIR__ . "/../components/dashboard/header.php"); ?>

  <div class="table-section pt-5">
    <div class="table-card">
      <div class="table-header">
        <h5><i class="bi bi-cart-fill me-2"></i>Pesanan Terbaru</h5>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Kode Pesanan</th>
              <th>User</th>
              <th>Detail Produk</th>
              <th>Total Harga</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($data && $data->rowCount() > 0): ?>
              <?php while ($row = $data->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                  <td>#<?= $row['kode_transaksi'] ?></td>
                  <td><?= $row['username'] ?></td>
                  <td>
                    <ul class="mb-0">
                      <?php
                      $detail = $this->transaksiModel->getDetail($row['id_transaksi']);
                      while ($d = $detail->fetch(PDO::FETCH_ASSOC)):
                      ?>
                        <li>
                          <?= $d['nama_barang'] ?>
                          (<?= $d['qty'] ?> x Rp <?= number_format($d['harga_satuan'], 0, ',', '.') ?>)
                          = Rp <?= number_format($d['harga_total'], 0, ',', '.') ?>
                        </li>
                      <?php endwhile; ?>
                    </ul>
                  </td>
                  <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                  <td>
                    <?php if ($row['status'] === 'pending'): ?>
                      <span class="order-status status-process">Proses</span>
                    <?php elseif ($row['status'] === 'selesai'): ?>
                      <span class="order-status status-completed">Selesai</span>
                    <?php else: ?>
                      <span class="order-status status-shipped"><?= ucfirst($row['status']) ?></span>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if ($row['status'] !== 'selesai'): ?>
                      <button class="action-btn btn-success btn-confirm"
                        data-id="<?= $row['id_transaksi'] ?>">
                        <i class="bi bi-check-lg"></i>
                      </button>
                    <?php else: ?>
                      <i class="text-muted">✔</i>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center">Belum ada pesanan</td>
              </tr>
            <?php endif; ?>
          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-alert-modal" id="confirmModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="alert-icon warning">
          <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div class="alert-content">
          <div class="alert-title">Konfirmasi Pesanan</div>
          <div class="alert-message">
            Apakah Anda yakin ingin mengonfirmasi pesanan ini?
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-success" id="confirmYesBtn">Ya, Konfirmasi</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-alert-modal" id="successModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="alert-icon success">
          <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="alert-content">
          <div class="alert-title">Berhasil</div>
          <div class="alert-message">Pesanan berhasil dikonfirmasi!</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-bs-dismiss="modal"
          onclick="location.reload()">OK</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade custom-alert-modal" id="errorModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="alert-icon danger">
          <i class="bi bi-x-circle-fill"></i>
        </div>
        <div class="alert-content">
          <div class="alert-title">Gagal</div>
          <div class="alert-message">Terjadi kesalahan, coba lagi!</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?php require_once(__DIR__ . "/../components/dashboard/modal.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/footer.php"); ?>
<script>
  let selectedId = null;

  $('.btn-confirm').on('click', function() {
    selectedId = $(this).data('id');
    const modal = new bootstrap.Modal($('#confirmModal')[0]);
    modal.show();
  });

  $('#confirmYesBtn').on('click', function() {
    if (selectedId) {
      $.ajax({
        url: 'index.php?controller=transaksi&action=updateStatus&id=' + selectedId,
        method: 'GET',
        success: function() {
          const modal = new bootstrap.Modal($('#successModal')[0]);
          modal.show();
        },
        error: function() {
          const modal = new bootstrap.Modal($('#errorModal')[0]);
          modal.show();
        }
      });
    }
  });
</script>