<?php
require_once(__DIR__ . '/../models/Produk.php');
require_once(__DIR__ . '/../models/Kategori.php');
require_once(__DIR__ . '/../models/Gudang.php');

class ProdukController
{
    private $produkModel;
    private $kategoriModel;
    private $gudangModel;

    public function __construct($conn)
    {

        $this->produkModel   = new Produk($conn);
        $this->kategoriModel = new Kategori($conn);
        $this->gudangModel   = new Gudang($conn);
    }

    public function index()
    {
        $filters = [
            'search'      => $_GET['search'] ?? '',
            'satuan'      => $_GET['satuan'] ?? '',
            'kategori_id' => $_GET['kategori_id'] ?? '',
            'kode_gudang' => $_GET['kode_gudang'] ?? ''
        ];

        if (!empty($filters['search']) || !empty($filters['satuan']) || !empty($filters['kategori_id']) || !empty($filters['kode_gudang'])) {
            $data = $this->produkModel->getFiltered($filters);
        } else {
            $data = $this->produkModel->getAll();
        }

        $kategori = $this->kategoriModel->getAll();
        $gudang   = $this->gudangModel->getAll();
        require_once(__DIR__ . '/../views/dashboard/produk.php');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $result = $this->produkModel->create($_POST, $_FILES);
                if ($result) {
                    header("Location: index.php?controller=produk&action=index&status=success");
                } else {
                    header("Location: index.php?controller=produk&action=index&status=error");
                }
            } catch (Exception $e) {
                header("Location: index.php?controller=produk&action=index&status=error&message=" . urlencode($e->getMessage()));
            }
            exit;
        }
    }


    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $result = $this->produkModel->update($_POST, $_FILES);
                if ($result) {
                    header("Location: index.php?controller=produk&action=index&status=success");
                } else {
                    header("Location: index.php?controller=produk&action=index&status=error");
                }
            } catch (Exception $e) {
                header("Location: index.php?controller=produk&action=index&status=error&message=" . urlencode($e->getMessage()));
            }
            exit;
        }
    }


    public function delete()
    {
        if (isset($_GET['id'])) {
            $result = $this->produkModel->delete($_GET['id']);
            if ($result) {
                header("Location: index.php?controller=produk&action=index&status=success");
            } else {
                header("Location: index.php?controller=produk&action=index&status=error");
            }
            exit;
        }
    }
}
