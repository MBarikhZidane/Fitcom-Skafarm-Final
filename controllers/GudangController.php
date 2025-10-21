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
            $nama = $_POST['nama_gudang'];
            $golongan = $_POST['golongan'];
            $keterangan = $_POST['keterangan'];

            $result = $this->model->create($nama, $golongan, $keterangan);
            if ($result) {
                header("Location: index.php?controller=gudang&action=index&status=success");
            } else {
                header("Location: index.php?controller=gudang&action=index&status=error");
            }
            exit;
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['kode_gudang'];
            $nama = $_POST['nama_gudang'];
            $golongan = $_POST['golongan'];
            $keterangan = $_POST['keterangan'];

            $result = $this->model->update($id, $nama, $golongan, $keterangan);
            if ($result) {
                header("Location: index.php?controller=gudang&action=index&status=success");
            } else {
                header("Location: index.php?controller=gudang&action=index&status=error");
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
