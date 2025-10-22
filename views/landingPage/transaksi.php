<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = $_SESSION['username'] ?? '';
?>

<?php require_once(__DIR__ . "/../components/landingPage/head.php"); ?>
<?php require_once(__DIR__ . "/../components/landingPage/navbar.php"); ?>

<?php if (!empty($transaction)): ?>
    <div class="container py-4 py-md-5">
        <form method="POST" action="index.php?controller=detailtransaksi&action=update">
            <div class="row g-4">

                <!-- Informasi Pengiriman -->
                <div class="col-12 col-md-7">
                    <div class="card shadow-lg border-0 h-100">
                        <div class="card-body">
                            <input type="hidden" name="kode_transaksi" value="<?= htmlspecialchars($transaction[0]['kode_transaksi']); ?>">
                            <input type="hidden" name="kode_produk" value="<?= htmlspecialchars($transaction[0]['kode_produk']); ?>">

                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-truck text-success me-2"></i> Informasi Pengiriman
                            </h5>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-geo-alt-fill me-1 text-danger"></i> Alamat Pengiriman
                                </label>
                                <textarea class="form-control" name="alamat" rows="3" placeholder="Masukkan alamat lengkapmu..." required></textarea>
                            </div>

                            <h6 class="fw-bold mt-4 mb-3">
                                <i class="bi bi-credit-card-2-front text-primary me-2"></i> Metode Pembayaran
                            </h6>
                            <div class="row row-cols-2 row-cols-sm-4 g-3">
                                <?php
                                $metode = $transaction[0]['metode_pembayaran'];
                                $opsi = [
                                    'tunai' => ['label' => 'Tunai', 'icon' => 'bi-cash-coin text-success'],
                                    'ovo'   => ['label' => 'OVO', 'icon' => 'bi-wallet2 text-purple'],
                                    'gopay' => ['label' => 'Gopay', 'icon' => 'bi-phone text-info'],
                                    'qris'  => ['label' => 'QRIS', 'icon' => 'bi-qr-code-scan text-dark']
                                ];
                                foreach ($opsi as $key => $data): ?>
                                    <div class="col">
                                        <div class="form-check p-3 border rounded-3 shadow-sm h-100 d-flex flex-column align-items-center">
                                            <input type="radio" id="bayar-<?= $key ?>" class="form-check-input mb-2"
                                                name="metode_pembayaran" value="<?= $key ?>"
                                                <?= $metode === $key ? 'checked' : '' ?> required>
                                            <label class="form-check-label fw-semibold text-center" for="bayar-<?= $key ?>">
                                                <i class="bi <?= $data['icon'] ?> fs-4 d-block mb-1"></i>
                                                <?= $data['label'] ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="col-12 col-md-5">
                    <div class="card shadow-lg border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-sm-row justify-content-between mb-2 small text-muted">
                                <span><i class="bi bi-upc-scan me-1"></i> <strong>Kode:</strong> <?= htmlspecialchars($transaction[0]['kode_transaksi']); ?></span>
                                <span><i class="bi bi-calendar3 me-1"></i> <strong>Tanggal:</strong> <?= $transaction[0]['tanggal_transaksi']; ?></span>
                            </div>
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 mb-3">
                                <i class="bi bi-check-circle-fill me-1"></i> Menunggu Pembayaran
                            </span>
                            <hr>

                            <h5 class="fw-bold mb-3">
                                <i class="bi bi-receipt text-warning me-2"></i> Ringkasan Pesanan
                            </h5>
                            <table class="table table-sm align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="bi bi-box-seam me-1"></i> Barang</th>
                                        <th><i class="bi bi-list-ol me-1"></i> Qty</th>
                                        <th><i class="bi bi-cash-stack me-1"></i> Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= $transaction[0]['nama_barang']; ?></td>
                                        <td><?= $transaction[0]['qty']; ?></td>
                                        <td class="fw-semibold text-success">Rp <?= number_format($transaction[0]['harga_total']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>

                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total Bayar</span>
                                <span class="text-success">Rp 220.000</span>
                            </div>
                            <button type="submit" class="btn btn-lg btn-success w-100 mt-4">
                                <i class="bi bi-check2-circle me-1"></i> Konfirmasi Pembayaran
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php else: ?>
    <div class="container py-5">
        <div class="alert alert-danger text-center shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Transaksi tidak ditemukan.
        </div>
    </div>
<?php endif; ?>

