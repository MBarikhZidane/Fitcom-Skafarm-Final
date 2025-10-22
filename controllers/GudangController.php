<?php
require_once(__DIR__ . '/../models/Gudang.php');

class GudangController
{
    private $model;

    public function __construct($conn)
    {
        $this->model = new Gudang($conn);
    }

    public function index()
    {
        $data = $this->model->getAll();
        require_once(__DIR__ . '/../views/dashboard/gudang.php');
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kode = $_POST['kode_gudang'];
            $nama = $_POST['nama_gudang'];
            $golongan = $_POST['golongan'];
            $keterangan = $_POST['keterangan'];

            try {
                $result = $this->model->create($kode, $nama, $golongan, $keterangan);
                if ($result) {
                    header("Location: index.php?controller=gudang&action=index&status=success");
                } else {
                    header("Location: index.php?controller=gudang&action=index&status=error");
                }
            } catch (Exception $e) {
                header("Location: index.php?controller=gudang&action=index&status=error&message=" . urlencode($e->getMessage()));
            }
            exit;
        }
    }


    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $kodeLama = $_POST['kode_lama'];
            $kodeBaru = $_POST['kode_gudang'];
            $nama = $_POST['nama_gudang'];
            $golongan = $_POST['golongan'];
            $keterangan = $_POST['keterangan'];

            try {
                $result = $this->model->update($kodeLama, $kodeBaru, $nama, $golongan, $keterangan);
                if ($result) {
                    header("Location: index.php?controller=gudang&action=index&status=success");
                } else {
                    header("Location: index.php?controller=gudang&action=index&status=error");
                }
            } catch (Exception $e) {
                header("Location: index.php?controller=gudang&action=index&status=error&message=" . urlencode($e->getMessage()));
            }
            exit;
        }
    }


    public function delete()
    {
        if (isset($_GET['id'])) {
            $result = $this->model->delete($_GET['id']);
            if ($result) {
                header("Location: index.php?controller=gudang&action=index&status=success");
            } else {
                header("Location: index.php?controller=gudang&action=index&status=error");
            }
            exit;
        }
    }
}
