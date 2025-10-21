<?php require_once(__DIR__ . "/../components/dashboard/head.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/sidebar.php"); ?>
<?php
if ($kategori instanceof PDOStatement) {
  $kategori = $kategori->fetchAll(PDO::FETCH_ASSOC);
}
if ($gudang instanceof PDOStatement) {
  $gudang = $gudang->fetchAll(PDO::FETCH_ASSOC);
}

$kategoriOptions = [];
foreach ($kategori as $kat) {
  $kategoriOptions[] = [
    'kode' => $kat['kode_kategori'],
    'nama' => $kat['nama_kategori']
  ];
}

$gudangOptions = [];
foreach ($gudang as $gd) {
  $gudangOptions[] = [
    'kode' => $gd['kode_gudang'],
    'nama' => $gd['nama_gudang']
  ];
}
?>
<div class="main-content" id="mainContent">
  <?php require_once(__DIR__ . "/../components/dashboard/header.php"); ?>

  <div class="table-section pt-5">
    <div class="table-card">
      <div class="table-header d-flex justify-content-between align-items-center">
        <h5><i class="bi bi-flower3 me-2"></i>Daftar Produk</h5>
        <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#productModal">
          <i class="bi bi-plus me-2"></i>Tambah Produk
        </button>
      </div>

      <form method="GET" action="index.php" class="p-3 border rounded mb-3 bg-light">
        <input type="hidden" name="controller" value="produk">
        <input type="hidden" name="action" value="index">
        <div class="row g-2">
          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-search"></i></span>
              <input type="text" class="form-control" name="search" placeholder="Cari produk..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
          </div>

          <div class="col-md-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-box"></i></span>
              <select name="satuan" class="form-control">
                <option value="">Semua Satuan</option>
                <option value="kg" <?= ($_GET['satuan'] ?? '') == 'kg' ? 'selected' : '' ?>>Kilogram</option>
                <option value="gram" <?= ($_GET['satuan'] ?? '') == 'gram' ? 'selected' : '' ?>>Gram</option>
                <option value="liter" <?= ($_GET['satuan'] ?? '') == 'liter' ? 'selected' : '' ?>>Liter</option>
                <option value="pcs" <?= ($_GET['satuan'] ?? '') == 'pcs' ? 'selected' : '' ?>>Pieces</option>
                <option value="pack" <?= ($_GET['satuan'] ?? '') == 'pack' ? 'selected' : '' ?>>Pack</option>
              </select>
            </div>
          </div>

          <div class="col-md-2">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-tags-fill"></i></span>
              <select name="kategori_id" class="form-control">
                <option value="">Semua Kategori</option>
                <?php foreach ($kategori as $kat): ?>
                  <option value="<?= $kat['kode_kategori'] ?>"
                    <?= ($_GET['kategori_id'] ?? '') == $kat['kode_kategori'] ? 'selected' : '' ?>>
                    <?= $kat['nama_kategori'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="col-md-2">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-building"></i></span>
              <select name="kode_gudang" class="form-control">
                <option value="">Semua Gudang</option>
                <?php foreach ($gudang as $gd): ?>
                  <option value="<?= $gd['kode_gudang'] ?>"
                    <?= ($_GET['kode_gudang'] ?? '') == $gd['kode_gudang'] ? 'selected' : '' ?>>
                    <?= $gd['nama_gudang'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="col-md-1">
            <button type="submit" class="btn btn-success w-100 form-control">
              <i class="bi bi-check-lg"></i>
            </button>
          </div>

          <div class="col-md-1">
            <a href="index.php?controller=produk&action=index" class="btn btn-secondary w-100 form-control">
              <i class="bi bi-arrow-repeat"></i>
            </a>
          </div>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Kode Produk</th>
              <th>Gambar</th>
              <th>Nama Produk</th>
              <th>Satuan</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Kategori</th>
              <th>Gudang</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($data && $data->rowCount() > 0): ?>
              <?php while ($row = $data->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                  <td><?= $row['kode_barang'] ?></td>
                  <td>
                    <?php
                    if (!empty($row['img'])):
                      $imgs = json_decode($row['img'], true);
                      if (is_array($imgs)):
                        foreach ($imgs as $imgFile):
                    ?>
                          <img src="uploads/<?= htmlspecialchars($imgFile) ?>" alt="Produk"
                            style="max-width:60px; height:60px; object-fit:cover; border:1px solid #ddd; border-radius:4px; margin-right:3px;">
                    <?php
                        endforeach;
                      endif;
                    endif;
                    ?>

                  </td>
                  <td><?= $row['nama_barang'] ?></td>
                  <td><?= $row['satuan'] ?></td>
                  <td><?= number_format($row['harga'], 0, ',', '.') ?></td>
                  <td><?= $row['stok'] ?></td>
                  <td><?= $row['nama_kategori'] ?></td>
                  <td><?= $row['nama_gudang'] ?></td>
                  <td>
                    <button class="action-btn btn-edit"
                      data-bs-toggle="modal"
                      data-bs-target="#productModal"
                      data-id="<?= $row['kode_barang'] ?>"
                      data-nama="<?= $row['nama_barang'] ?>"
                      data-satuan="<?= $row['satuan'] ?>"
                      data-harga="<?= $row['harga'] ?>"
                      data-stok="<?= $row['stok'] ?>"
                      data-kategori="<?= $row['kategori_id'] ?>"
                      data-gudang="<?= $row['kode_gudang'] ?>"
                      data-deskripsi="<?= $row['deskripsi'] ?>"
                      data-img='<?= htmlspecialchars($row["img"], ENT_QUOTES, "UTF-8") ?>'>

                      <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="action-btn btn-delete"
                      data-bs-toggle="modal"
                      data-bs-target="#confirmModal"
                      data-id="<?= $row['kode_barang'] ?>">
                      <i class="bi bi-trash"></i>
                    </button>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center">Belum ada data produk</td>
              </tr>
            <?php endif; ?>
          </tbody>

        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="productModal" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="POST" action="index.php?controller=produk&action=store" id="productForm" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-flower3 me-2"></i><span id="productModalTitle">Tambah Produk Baru</span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="kode_barang" id="kode_barang">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" class="form-control" name="nama_barang" id="nama_barang" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label class="form-label">Satuan</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-box"></i></span>
                  <select class="form-control" name="satuan" id="satuan" required>
                    <option value="">Pilih satuan...</option>
                    <option value="kg">Kilogram (kg)</option>
                    <option value="gram">Gram (g)</option>
                    <option value="liter">Liter (L)</option>
                    <option value="pcs">Pieces (pcs)</option>
                    <option value="pack">Pack</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label">Harga</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-cash-stack"></i></span>
                  <input type="number" class="form-control" name="harga" id="harga" required>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label">Stok</label>
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                  <input type="number" class="form-control" name="stok" id="stok" required>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label class="form-label">Kategori</label>
                <select class="form-control" name="kategori_id" id="kategori_id" required>
                  <option value="">Pilih kategori...</option>
                  <?php foreach ($kategoriOptions as $kat): ?>
                    <option value="<?= $kat['kode'] ?>"><?= $kat['nama'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group mb-3">
            <label class="form-label">Gudang</label>
            <select class="form-control" name="kode_gudang" id="kode_gudang" required>
              <option value="">Pilih gudang...</option>
              <?php foreach ($gudangOptions as $gd): ?>
                <option value="<?= $gd['kode'] ?>"><?= $gd['nama'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label class="form-label">Upload Gambar Produk (Wajib 4 Gambar)</label>

            <div class="file-upload text-center" id="uploadBox" onclick="document.getElementById('img').click()">
              <i class="bi bi-cloud-arrow-up fs-1"></i>
              <h6 class="mt-2">Drag & Drop atau Klik untuk Upload</h6>
              <p class="text-muted">Wajib 4 gambar — Format: JPG, PNG, maksimal 2MB</p>
              <input type="file" class="form-control" name="img[]" id="img" accept="image/*" multiple style="display:none">
            </div>

            <div id="previewBox" class="d-flex flex-wrap justify-content-center gap-3 mt-3" style="display:none;">
              <!-- Preview Gambar akan muncul di sini -->
            </div>

            <div class="text-center mt-2">
              <button type="button" class="btn btn-sm btn-outline-danger d-none" id="resetBtn" onclick="resetImages()">Hapus Semua Gambar</button>
            </div>

            <small class="text-danger d-none text-center mt-2" id="imgError">Wajib unggah tepat 4 gambar (tidak boleh kurang atau lebih)</small>
          </div>


          <div class="form-group mb-3">
            <label class="form-label">Deskripsi Produk</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
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
          <div class="alert-message">Apakah Anda yakin ingin menghapus produk ini?</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
      </div>
    </div>
  </div>
</div>
<script>
  const fileInput = $('#img');
  const uploadBox = $('#uploadBox');
  const previewBox = $('#previewBox');
  const imgError = $('#imgError');
  const resetBtn = $('#resetBtn');

  fileInput.on('change', function(e) {
    const files = e.target.files;
    previewBox.html('');
    imgError.addClass('d-none');

    if (files.length !== 4) {
      imgError.removeClass('d-none');
      previewBox.hide();
      resetBtn.addClass('d-none');
      fileInput.val('');
      return;
    }

    uploadBox.hide();
    previewBox.css('display', 'flex');
    resetBtn.removeClass('d-none');

    $.each(files, function(i, file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const imgWrapper = $('<div class="position-relative"></div>')
          .css({
            width: '120px',
            height: '120px'
          })
          .html(`
          <img src="${e.target.result}" class="rounded border" style="width:100%;height:100%;object-fit:cover;">
          <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-single" data-index="${i}">
            <i class="bi bi-x-lg"></i>
          </button>
        `);
        previewBox.append(imgWrapper);
      };
      reader.readAsDataURL(file);
    });
  });

  function resetImages() {
    fileInput.val('');
    previewBox.html('').hide();
    uploadBox.show();
    resetBtn.addClass('d-none');
    imgError.addClass('d-none');
  }

  previewBox.on('click', '.remove-single', function() {
    $(this).closest('div.position-relative').remove();
    if (previewBox.find('img').length < 4) {
      imgError.removeClass('d-none');
    }
  });

  function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
      $('#preview').attr('src', URL.createObjectURL(file));
      $('#uploadBox').hide();
      $('#previewBox').show();
    }
  }

  function resetImage() {
    $('#img').val('');
    $('#preview').attr('src', '');
    $('#previewBox').hide();
    $('#uploadBox').show();
  }

  $(function() {
    let deleteId = null;

    $('.btn-delete').on('click', function() {
      deleteId = $(this).data('id');
    });

    $('#confirmDeleteBtn').on('click', function() {
      if (deleteId) {
        window.location.href = 'index.php?controller=produk&action=delete&id=' + deleteId;
      }
    });

    $('.btn-edit').on('click', function() {

      $('#kode_barang').val($(this).data('id'));
      $('#nama_barang').val($(this).data('nama'));
      $('#satuan').val($(this).data('satuan'));
      $('#harga').val($(this).data('harga'));
      $('#stok').val($(this).data('stok'));
      $('#kategori_id').val($(this).data('kategori'));
      $('#kode_gudang').val($(this).data('gudang'));
      $('#deskripsi').val($(this).data('deskripsi'));
      const imgData = $(this).attr('data-img');

      resetImages();
      if (imgData) {
        try {
          const imgs = JSON.parse(imgData);
          if (Array.isArray(imgs)) {
            $('#uploadBox').hide();
            $('#previewBox').show();
            $('#resetBtn').removeClass('d-none');

            imgs.forEach((file, i) => {
              const imgWrapper = document.createElement('div');
              imgWrapper.classList.add('position-relative');
              imgWrapper.style.width = '120px';
              imgWrapper.style.height = '120px';
              imgWrapper.innerHTML = `
          <img src="uploads/${file}" 
               class="rounded border" 
               style="width:100%;height:100%;object-fit:cover;">
          <button type="button" 
                  class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-single"
                  data-index="${i}">
            <i class="bi bi-x-lg"></i>
          </button>`;
              document.getElementById('previewBox').appendChild(imgWrapper);
            });
          }
        } catch (e) {
          console.error("Gagal parse JSON gambar:", e);
        }
      }


      $('#productForm').attr('action', 'index.php?controller=produk&action=update');
      $('#productModalTitle').text('Edit Produk');
    });

    $("[data-bs-target='#productModal']").first().on('click', function() {
      $('#productForm')[0].reset();
      $('#productForm').attr('action', 'index.php?controller=produk&action=store');
      resetImage();
      $('#productModalTitle').text('Tambah Produk Baru');
    });


    $('#img').on('change', previewImage);
  });
</script>
<?php require_once(__DIR__ . "/../components/dashboard/modal.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/footer.php"); ?>