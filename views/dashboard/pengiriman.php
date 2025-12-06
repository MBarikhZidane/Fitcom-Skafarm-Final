<?php require_once(__DIR__ . "/../components/dashboard/head.php"); ?>
<?php require_once(__DIR__ . "/../components/dashboard/sidebar.php"); ?>
<div class="main-content" id="mainContent">
    <?php require_once(__DIR__ . "/../components/dashboard/header.php"); ?>

    <div class="table-section pt-5">
        <div class="table-card">
            <div class="table-header d-flex justify-content-between align-items-center">
                <h5><i class="bi bi-truck me-2"></i>Daftar Pengiriman Barang</h5>
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#pengirimanModal">
                    <i class="bi bi-plus"></i> Buat Pengiriman Baru
                </button>
            </div>

            <form method="GET" action="index.php" class="p-3 border rounded bg-light mb-3">
                <input type="hidden" name="controller" value="pengiriman">
                <input type="hidden" name="action" value="index">
                <div class="row g-2">
                    <div class="col-md-1">
                        <input type="date" name="awal" class="form-control" value="<?= htmlspecialchars($_GET['awal'] ?? '') ?>">
                    </div>
                    <div class="col-md-1">
                        <input type="date" name="akhir" class="form-control" value="<?= htmlspecialchars($_GET['akhir'] ?? '') ?>">
                    </div>
                    <div class="col-md-2">
                        <select name="mode" class="form-control">
                            <option value="rekap" <?= ($_GET['mode'] ?? '') == 'rekap' ? 'selected' : '' ?>>Rekap</option>
                            <option value="detail" <?= ($_GET['mode'] ?? '') == 'detail' ? 'selected' : '' ?>>Detail</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="nama_barang" class="form-control">
                            <option value="">Semua Produk</option>
                            <?php foreach ($produk as $p): ?>
                                <option value="<?= htmlspecialchars($p['nama_barang']) ?>" <?= ($_GET['nama_barang'] ?? '') == $p['nama_barang'] ? 'selected' : '' ?>>
                                    <?= $p['nama_barang'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="nopol" class="form-control">
                            <option value="">Semua Kendaraan</option>
                            <?php foreach ($kendaraan as $k): ?>
                                <option value="<?= $k['nopol'] ?>" <?= ($_GET['nopol'] ?? '') == $k['nopol'] ? 'selected' : '' ?>>
                                    <?= $k['nopol'] ?> - <?= $k['namakendaraan'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="gudang" class="form-control">
                            <option value="">Semua Gudang</option>
                            <?php foreach ($gudang as $gd): ?>
                                <option value="<?= $gd['nama_gudang'] ?>" <?= ($_GET['gudang'] ?? '') == $gd['nama_gudang'] ? 'selected' : '' ?>>
                                    <?= $gd['nama_gudang'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-success w-100"><i class="bi bi-check-lg"></i></button>
                    </div>
                    <div class="col-md-1">
                        <a href="index.php?controller=pengiriman&action=index" class="btn btn-secondary w-100"><i class="bi bi-arrow-repeat"></i></a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Kode Kirim</th>
                            <th>Nama Gudang</th>
                            <th>Tanggal</th>
                            <th>Kendaraan</th>
                            <th>Driver</th>
                            <th>Total Qty</th>
                            <?php if (($_GET['mode'] ?? '') === 'detail'): ?>
                                <th>List Produk Dikirim</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data && $data->rowCount() > 0): ?>
                            <?php
                            $rows = $data->fetchAll(PDO::FETCH_ASSOC);
                            $grandTotal = 0;
                            $isFilterProduk = !empty($_GET['nama_barang']);

                            if (($_GET['mode'] ?? '') === 'detail') {
                                $grouped = [];
                                foreach ($rows as $r) {
                                    $grouped[$r['kodekirim']]['info'] = $r;
                                    $grouped[$r['kodekirim']]['produk'][] = [
                                        'nama_barang' => $r['nama_barang'],
                                        'qty' => $r['qty']
                                    ];
                                }

                                foreach ($grouped as $row):
                                    if ($isFilterProduk) {
                                        foreach ($row['produk'] as $p) {
                                            if ($p['nama_barang'] === $_GET['nama_barang']) {
                                                $grandTotal += (int)$p['qty'];
                                            }
                                        }
                                    } else {
                                        $grandTotal += (int)$row['info']['totalqty'];
                                    }
                            ?>
                                    <tr>
                                        <td><?= $row['info']['kodekirim'] ?></td>
                                        <td><?= $row['info']['nama_gudang'] ?></td>
                                        <td><?= $row['info']['tglkirim'] ?></td>
                                        <td><?= $row['info']['namakendaraan'] ?></td>
                                        <td><?= $row['info']['namadriver'] ?></td>
                                        <td><?= $row['info']['totalqty'] ?></td>
                                        <td>
                                            <table class="table table-sm table-borderless mb-0">
                                                <?php foreach ($row['produk'] as $p): ?>
                                                    <?php if (!$isFilterProduk || $p['nama_barang'] === $_GET['nama_barang']): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($p['nama_barang']) ?></td>
                                                            <td class="text-end"><?= (int)$p['qty'] ?></td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </table>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php } else {
                                foreach ($rows as $row):
                                    $grandTotal += (int)$row['totalqty'];
                                ?>
                                    <tr>
                                        <td><?= $row['kodekirim'] ?></td>
                                        <td><?= $row['nama_gudang'] ?></td>
                                        <td><?= $row['tglkirim'] ?></td>
                                        <td><?= $row['namakendaraan'] ?></td>
                                        <td><?= $row['namadriver'] ?></td>
                                        <td><?= $row['totalqty'] ?></td>
                                    </tr>
                            <?php endforeach;
                            } ?>

                            <tr class="table-success fw-bold">
                                <td colspan="<?= (($_GET['mode'] ?? '') === 'detail') ? 5 : 5 ?>" class="text-end">
                                    TOTAL KESELURUHAN <?= $isFilterProduk ? '(' . htmlspecialchars($_GET['nama_barang']) . ')' : '' ?>
                                </td>
                                <td><?= $grandTotal ?></td>
                                <?php if (($_GET['mode'] ?? '') === 'detail'): ?><td></td><?php endif; ?>
                            </tr>

                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Belum ada pengiriman</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>


            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pengirimanModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="index.php?controller=pengiriman&action=store" id="pengirimanForm">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-truck me-2"></i>Buat Pengiriman Produk Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Kode Pengiriman</label>
                            <input type="text" class="form-control" name="kodekirim" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tanggal Kirim</label>
                            <input type="date" class="form-control" name="tglkirim" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Kendaraan</label>
                            <select class="form-control" name="nopol" id="nopolSelect" required>
                                <option value="">Pilih Kendaraan</option>
                                <?php foreach ($kendaraan as $k): ?>
                                    <option value="<?= $k['nopol'] ?>" data-driver="<?= htmlspecialchars($k['namadriver']) ?>">
                                        <?= $k['nopol'] ?> - <?= $k['namakendaraan'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nama Driver</label>
                            <input type="text" class="form-control" id="namadriver" readonly>
                        </div>
                    </div>

                    <hr>
                    <h6 class="fw-bold mb-3">Detail Produk Dikirim</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="detailTable">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Satuan</th>
                                    <th>Kuantitas Kirim</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-outline-primary btn-sm" id="addRowBtn"><i class="bi bi-plus-circle"></i> Tambah Produk</button>
                    <div class="text-end mt-3">
                        <h6>Total Qty: <span id="totalQty">0</span></h6>
                    </div>
                    <input type="hidden" name="detail_data" id="detailData">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-save me-2"></i>Simpan Pengiriman</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let detailList = []
    let produkList = <?= json_encode($produk) ?>

    $('#nopolSelect').on('change', function() {
        let driver = $(this).find(':selected').data('driver') || ''
        $('#namadriver').val(driver)
    })

    $('#addRowBtn').on('click', function() {
        let rowId = Date.now()
        let selectHTML = '<select class="form-control kode-produk" data-row="' + rowId + '"><option value="">Pilih</option>'
        produkList.forEach(p => {
            selectHTML += `<option value="${p.kode_produk}" data-nama="${p.nama_barang}" data-satuan="${p.satuan}">${p.kode_produk}</option>`
        })
        selectHTML += '</select>'
        let row = `
        <tr data-id="${rowId}">
          <td>${selectHTML}</td>
          <td class="nama-produk"></td>
          <td class="satuan"></td>
          <td><input type="number" class="form-control qty" min="1" value="1"></td>
          <td><button type="button" class="btn btn-sm btn-danger removeRow"><i class="bi bi-trash"></i></button></td>
        </tr>`
        $('#detailTable tbody').append(row)
    })

    $(document).on('change', '.kode-produk', function() {
        let row = $(this).closest('tr')
        let nama = $(this).find(':selected').data('nama') || ''
        let satuan = $(this).find(':selected').data('satuan') || ''
        row.find('.nama-produk').text(nama)
        row.find('.satuan').text(satuan)
    })

    $(document).on('click', '.removeRow', function() {
        $(this).closest('tr').remove()
        updateTotal()
    })

    $(document).on('input', '.qty', updateTotal)

    function updateTotal() {
        let total = 0
        $('.qty').each(function() {
            total += parseInt($(this).val()) || 0
        })
        $('#totalQty').text(total)
    }

    $('#pengirimanForm').on('submit', function() {
        detailList = []
        $('#detailTable tbody tr').each(function() {
            let kode = $(this).find('.kode-produk').val()
            let qty = $(this).find('.qty').val()
            if (kode && qty > 0) detailList.push({
                kode_produk: kode,
                qty: parseInt(qty)
            })
        })
        $('#detailData').val(JSON.stringify(detailList))
    })
</script>
<?php require_once(__DIR__ . "/../components/dashboard/modal.php"); ?>

<?php require_once(__DIR__ . "/../components/dashboard/footer.php"); ?>