<?php
require_once(__DIR__ . '/../models/Pengiriman.php');
require_once(__DIR__ . '/../models/DetailKirim.php');

class PengirimanController
{
    private $pengiriman;
    private $detail;
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->pengiriman = new Pengiriman($conn);
        $this->detail = new DetailKirim($conn);
    }

    public function index()
    {
        $filters = [
            'awal' => $_GET['awal'] ?? null,
            'akhir' => $_GET['akhir'] ?? null,
            'nopol' => $_GET['nopol'] ?? null,
            'gudang' => $_GET['gudang'] ?? null,
            'mode' => $_GET['mode'] ?? 'rekap',
            'nama_barang' => $_GET['nama_barang'] ?? null
        ];

        $data = $this->pengiriman->getAll($filters);
        $kendaraan = $this->getAllKendaraan();
        $produk = $this->getAllProduk();
        $gudang = $this->getAllGudang();

        require_once(__DIR__ . '/../views/dashboard/pengiriman.php');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $kode = $_POST['kodekirim'];
                $tgl = $_POST['tglkirim'];
                $nopol = $_POST['nopol'];
                $details = json_decode($_POST['detail_data'], true);
                $totalqty = array_sum(array_column($details, 'qty'));

                $this->pengiriman->create($kode, $tgl, $nopol, $totalqty);
                $this->detail->createBatch($kode, $details);

                header("Location: index.php?controller=pengiriman&action=index&status=success&msg=Pengiriman berhasil disimpan");
                exit;
            } catch (Exception $e) {
                header("Location: index.php?controller=pengiriman&action=index&status=error&msg=" . urlencode($e->getMessage()));
                exit;
            }
        }
    }

    private function getAllKendaraan()
    {
        $stmt = $this->conn->prepare("SELECT * FROM kendaraan");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getAllProduk()
    {
        $stmt = $this->conn->prepare("SELECT DISTINCT nama_barang, kode_produk, satuan FROM produk");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getAllGudang()
    {
        $stmt = $this->conn->prepare("SELECT * FROM gudang");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
