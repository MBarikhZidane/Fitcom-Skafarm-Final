<?php require_once(__DIR__ . "/../components/dashboard/head.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/sidebar.php"); ?>
<div class="main-content" id="mainContent">
  <?php require_once(__DIR__ . "/../components/dashboard/header.php"); ?>

  <div class="table-section pt-5">
    <div class="table-card">
      <div class="table-header">
        <h5><i class="bi bi-building me-2"></i>Daftar Gudang</h5>
        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#gudangModal">
          <i class="bi bi-plus me-2"></i>Tambah Gudang
        </button>
      </div>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Kode Gudang</th>
              <th>Nama Gudang</th>
              <th>Golongan</th>
              <th>Keterangan</th>
              <th>Jumlah Produk</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($data && $data->rowCount() > 0): ?>
              <?php while ($row = $data->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                  <td><?= $row['kode_gudang'] ?></td>
                  <td><?= $row['nama_gudang'] ?></td>
                  <td><?= $row['golongan'] ?></td>
                  <td><?= $row['keterangan'] ?></td>
                  <td><?= $row['total_produk'] ?> produk</td>
                  <td>
                    <button class="action-btn btn-edit"
                      data-bs-toggle="modal"
                      data-bs-target="#gudangModal"
                      data-id="<?= $row['kode_gudang'] ?>"
                      data-nama="<?= $row['nama_gudang'] ?>"
                      data-golongan="<?= $row['golongan'] ?>"
                      data-keterangan="<?= $row['keterangan'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="action-btn btn-delete"
                      data-bs-toggle="modal"
                      data-bs-target="#confirmModal"
                      data-id="<?= $row['kode_gudang'] ?>">
                      <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center">Belum ada data gudang</td>
              </tr>
            <?php endif; ?>
          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="gudangModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <form method="POST" action="index.php?controller=gudang&action=store" id="gudangForm">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="bi bi-building me-2"></i>
            <span id="gudangModalTitle">Tambah Gudang Baru</span>
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="kode_gudang" id="kode_gudang">
          <div class="form-group mb-3">
            <label class="form-label">Nama Gudang</label>
            <input type="text" class="form-control" name="nama_gudang" id="nama_gudang" required>
          </div>
          <div class="form-group mb-3">
            <label class="form-label">Golongan</label>
            <input type="text" class="form-control" name="golongan" id="golongan" required>
          </div>
          <div class="form-group mb-3">
            <label class="form-label">Keterangan</label>
            <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success"><i class="bi bi-save me-2"></i>Simpan</button>
        </div>
      </form>
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
          <div class="alert-title" id="confirmTitle">Konfirmasi Hapus</div>
          <div class="alert-message" id="confirmMessage">
            Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan.
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
      </div>
    </div>
  </div>
</div>

<?php require_once(__DIR__ . "/../components/dashboard/modal.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/footer.php"); ?>

<script>
  $(function() {
    let deleteId = null;

    $('.btn-delete').on('click', function() {
      deleteId = $(this).data('id');
    });

    $('#confirmDeleteBtn').on('click', function() {
      if (deleteId) {
        window.location.href = 'index.php?controller=gudang&action=delete&id=' + deleteId;
      }
    });

    $('.btn-edit').on('click', function() {
      $('#kode_gudang').val($(this).data('id'));
      $('#nama_gudang').val($(this).data('nama'));
      $('#golongan').val($(this).data('golongan'));
      $('#keterangan').val($(this).data('keterangan'));
      $('#gudangForm').attr('action', 'index.php?controller=gudang&action=update');
      $('#gudangModalTitle').text('Edit Gudang');
    });

    $("[data-bs-target='#gudangModal']").first().on('click', function() {
      $('#gudangForm')[0].reset();
      $('#gudangForm').attr('action', 'index.php?controller=gudang&action=store');
      $('#gudangModalTitle').text('Tambah Gudang Baru');
    });

  });
</script>