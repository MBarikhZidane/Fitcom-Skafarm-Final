<?php
class DetailtransaksiController {
    private $cartModel;
    private $detailTransaksiModel;

    public function __construct($conn)
    {
    require_once 'models/Cart.php';
    require_once 'models/Detailtransaksi.php';

    $this->cartModel = new Cart($conn);
    $this->detailTransaksiModel = new Detailtransaksi($conn);
    }

    public function checkout() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $kode_user = $_SESSION['user_id'];

    if (isset($_POST['kode_barang']) && isset($_POST['quantity'])) {
        $kode_barang = $_POST['kode_barang'];
        $qty = (int) $_POST['quantity'];

        $harga_satuan = $this->detailTransaksiModel->getHargaBarang($kode_barang);
        $total_harga = $harga_satuan * $qty;

        $kode_transaksi = 'TRX' . time();

        $this->detailTransaksiModel->insertMasterTransaksi($kode_transaksi, $kode_user, $total_harga);

        $id_transaksi = $this->detailTransaksiModel->getLastInsertId();

        $this->detailTransaksiModel->insertDetailTransaksi($id_transaksi, $kode_barang, $qty, $harga_satuan, $total_harga);

        header("Location: index.php?controller=detailtransaksi&action=detail&kode_transaksi=$kode_transaksi");
        exit;
    }
    }



    public function myhistory() {
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

    public function detail() {
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
   public function update() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_POST['kode_transaksi'], $_POST['alamat'], $_POST['metode_pembayaran'])) {
        $kode_transaksi = $_POST['kode_transaksi'];
        $alamat = $_POST['alamat'];
        $metode = $_POST['metode_pembayaran'];

        $this->detailTransaksiModel->updateTransaksi($kode_transaksi, $alamat, $metode);

        header("Location: index.php?controller=detailtransaksi&action=myhistory");
        exit;
    } else {
        echo "Data update tidak valid.";
    }
   }



}
?>
