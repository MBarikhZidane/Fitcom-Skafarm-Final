<?php require_once(__DIR__ . "/../components/dashboard/head.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/sidebar.php"); ?>
<div class="main-content" id="mainContent">
  <?php require_once(__DIR__ . "/../components/dashboard/header.php"); ?>
  <div class="table-section pt-5">
    <div class="table-card">
      <div class="table-header">
        <h5><i class="bi bi-truck me-2"></i>Data Kendaraan</h5>
        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#kendaraanModal">
          <i class="bi bi-plus me-2"></i>Tambah Kendaraan
        </button>
      </div>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>No Polisi</th>
              <th>Foto</th>
              <th>Nama</th>
              <th>Jenis</th>
              <th>Driver</th>
              <th>Kontak</th>
              <th>Tahun</th>
              <th>Kapasitas</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($data && $data->rowCount() > 0): ?>
              <?php while ($row = $data->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                  <td><?= htmlspecialchars($row['nopol']) ?></td>
                  <td><?php if (!empty($row['foto'])): ?><img src="uploads/<?= $row['foto'] ?>" style="max-width:60px; border:1px solid #ddd; border-radius:4px;"><?php endif; ?></td>
                  <td><?= htmlspecialchars($row['namakendaraan']) ?></td>
                  <td><?= htmlspecialchars($row['jeniskendaraan']) ?></td>
                  <td><?= htmlspecialchars($row['namadriver']) ?></td>
                  <td><?= htmlspecialchars($row['kontakdriver']) ?></td>
                  <td><?= htmlspecialchars($row['tahun']) ?></td>
                  <td><?= htmlspecialchars($row['kapasitas']) ?></td>
                  <td>
                    <button class="action-btn btn-edit" data-bs-toggle="modal" data-bs-target="#kendaraanModal"
                      data-id="<?= $row['nopol'] ?>"
                      data-nama="<?= $row['namakendaraan'] ?>"
                      data-jenis="<?= $row['jeniskendaraan'] ?>"
                      data-driver="<?= $row['namadriver'] ?>"
                      data-kontak="<?= $row['kontakdriver'] ?>"
                      data-tahun="<?= $row['tahun'] ?>"
                      data-kapasitas="<?= $row['kapasitas'] ?>"
                      data-foto="<?= $row['foto'] ?>">
                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="action-btn btn-delete" data-bs-toggle="modal" data-bs-target="#confirmModal"
                      data-id="<?= $row['nopol'] ?>" data-foto="<?= $row['foto'] ?>">
                      <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center">Belum ada data kendaraan</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="kendaraanModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="index.php?controller=kendaraan&action=store" id="kendaraanForm" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-truck me-2"></i><span id="kendaraanModalTitle">Tambah Kendaraan</span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="old_foto" id="old_foto">
          <div class="row g-3">
            <input type="hidden" name="nopol_lama" id="nopol_lama">

            <div class="col-md-6"><label class="form-label">No Polisi</label><input type="text" class="form-control" name="nopol" id="nopol" required></div>
            <div class="col-md-6"><label class="form-label">Nama Kendaraan</label><input type="text" class="form-control" name="namakendaraan" id="namakendaraan" required></div>
            <div class="col-md-6"><label class="form-label">Jenis Kendaraan</label><input type="text" class="form-control" name="jeniskendaraan" id="jeniskendaraan" required></div>
            <div class="col-md-6"><label class="form-label">Nama Driver</label><input type="text" class="form-control" name="namadriver" id="namadriver" required></div>
            <div class="col-md-6"><label class="form-label">Kontak Driver</label><input type="text" class="form-control" name="kontakdriver" id="kontakdriver" required></div>
            <div class="col-md-6"><label class="form-label">Tahun</label><input type="date" class="form-control" name="tahun" id="tahun" required></div>
            <div class="col-md-6"><label class="form-label">Kapasitas</label><input type="text" class="form-control" name="kapasitas" id="kapasitas" required></div>
            <div class="col-md-6">
              <label class="form-label">Foto Kendaraan</label>
              <div class="file-upload" id="uploadBox" onclick="document.getElementById('foto').click()">
                <i class="bi bi-cloud-arrow-up"></i>
                <h6>Upload Foto</h6>
                <p class="text-muted">Format JPG/PNG maks 2MB</p>
                <input type="file" class="form-control" name="foto" id="foto" accept="image/*" style="display:none">
              </div>
              <div class="text-center" id="previewBox" style="display:none">
                <img id="preview" src="" style="max-width:180px; border:1px solid #ddd; border-radius:6px;">
                <div class="mt-2"><button type="button" class="btn btn-sm btn-outline-danger" onclick="resetImage()">Hapus Gambar</button></div>
              </div>
            </div>
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
        <div class="alert-icon warning"><i class="bi bi-exclamation-triangle-fill"></i></div>
        <div class="alert-content">
          <div class="alert-title">Konfirmasi Hapus</div>
          <div class="alert-message">Yakin ingin menghapus kendaraan ini?</div>
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
  function previewImage(event) {
    const f = event.target.files[0];
    if (f) {
      $('#preview').attr('src', URL.createObjectURL(f));
      $('#uploadBox').hide();
      $('#previewBox').show();
    }
  }

  function resetImage() {
    $('#foto').val('');
    $('#preview').attr('src', '');
    $('#previewBox').hide();
    $('#uploadBox').show();
  }
  $(function() {
    let id = null;
    $('.btn-delete').on('click', function() {
      id = $(this).data('id');
    });
    $('#confirmDeleteBtn').on('click', function() {
      if (id) {
        window.location.href = 'index.php?controller=kendaraan&action=delete&id=' + id;
      }
    });
    $('.btn-edit').on('click', function() {
      const r = $(this).data();
      $('#nopol').val(r.id);
      $('#nopol_lama').val(r.id);
      $('#namakendaraan').val(r.nama);
      $('#jeniskendaraan').val(r.jenis);
      $('#namadriver').val(r.driver);
      $('#kontakdriver').val(r.kontak);
      $('#tahun').val(r.tahun);
      $('#kapasitas').val(r.kapasitas);
      if (r.foto) {
        $('#preview').attr('src', 'uploads/' + r.foto);
        $('#uploadBox').hide();
        $('#previewBox').show();
      } else {
        resetImage();
      }
      $('#kendaraanForm').attr('action', 'index.php?controller=kendaraan&action=update');
      $('#kendaraanModalTitle').text('Edit Kendaraan');
    });
    $("[data-bs-target='#kendaraanModal']").first().on('click', function() {
      $('#kendaraanForm')[0].reset();
      $('#nopol').prop('readonly', false);
      resetImage();
      $('#kendaraanForm').attr('action', 'index.php?controller=kendaraan&action=store');
      $('#kendaraanModalTitle').text('Tambah Kendaraan');
    });
    $('#foto').on('change', previewImage);
  });
</script>