<?php
class DetailtransaksiController
{
    private $cartModel;
    private $detailTransaksiModel;

    public function __construct($conn)
    {
        require_once 'models/Cart.php';
        require_once 'models/DetailTransaksi.php';

        $this->cartModel = new Cart($conn);
        $this->detailTransaksiModel = new Detailtransaksi($conn);
    }

    public function checkout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $kode_user = $_SESSION['user_id'];

        if (isset($_POST['kode_produk']) && isset($_POST['quantity']) && isset($_POST['stok'])) {
            $kode_produk = $_POST['kode_produk'];
            $qty = (int) $_POST['quantity'];
            $stok = $_POST['stok'];

            if ($qty > $stok) {
                header("Location: index.php?controller=cart&action=mycart&status=error&msg=" . urlencode("Stok tersisa tinggal " . $stok));
                exit;
            }

            $harga_satuan = $this->detailTransaksiModel->getHargaBarang($kode_produk);
            $total_harga = $harga_satuan * $qty;

            $kode_transaksi = 'TRX' . time();

            $this->detailTransaksiModel->insertMasterTransaksi($kode_transaksi, $kode_user, $total_harga);

            $id_transaksi = $this->detailTransaksiModel->getLastInsertId();

            $this->detailTransaksiModel->insertDetailTransaksi($id_transaksi, $kode_produk, $qty, $harga_satuan, $total_harga);

            header("Location: index.php?controller=detailtransaksi&action=detail&kode_transaksi=$kode_transaksi");
            exit;
        }
    }




    public function myhistory()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=showLogin");
            exit;
        }

        $kode_user = $_SESSION['user_id'];
        $historyItems = $this->detailTransaksiModel->getHistory($kode_user);

        include 'views/landingPage/history.php';
    }

    public function detail()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_GET['kode_transaksi'])) {
            $kode_transaksi = $_GET['kode_transaksi'];
            $transaction = $this->detailTransaksiModel->getTransactionByKode($kode_transaksi);

            include 'views/landingPage/transaksi.php';
        } else {
            echo "Transaksi tidak ditemukan.";
        }
    }
    public function update()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_POST['kode_transaksi'], $_POST['alamat'], $_POST['metode_pembayaran'])) {
            $kode_transaksi = $_POST['kode_transaksi'];
            $alamat = $_POST['alamat'];
            $metode = $_POST['metode_pembayaran'];
            $kode_produk = $_POST['kode_produk'];

            try {
                $result = $this->detailTransaksiModel->updateTransaksi($kode_transaksi, $alamat, $metode, $kode_produk);

                if ($result) {
                    header("Location: index.php?controller=detailtransaksi&action=myhistory&status=success");
                } else {
                    $errorMsg = "Gagal memperbarui transaksi.";
                    header("Location: index.php?controller=detailtransaksi&action=myhistory&status=error&msg=" . urlencode($errorMsg));
                }
            } catch (Throwable $e) {
                $errorMsg = $e->getMessage();
                header("Location: index.php?controller=detailtransaksi&action=myhistory&status=error&msg=" . urlencode($errorMsg));
            }
            exit;
        } else {
            $errorMsg = "Data tidak valid.";
            header("Location: index.php?controller=detailtransaksi&action=myhistory&status=error&msg=" . urlencode($errorMsg));
            exit;
        }
    }
}
