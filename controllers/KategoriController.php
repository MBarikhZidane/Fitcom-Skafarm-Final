<?php
require_once(__DIR__ . '/../models/Kategori.php');

class KategoriController
{
    private $model;

    public function __construct($conn)
    {
        $this->model = new Kategori($conn);
    }

    public function index()
    {
        $data = $this->model->getAll();
        require_once(__DIR__ . '/../views/dashboard/kategori.php');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama_kategori'];
            $file = $_FILES; // ambil file upload

            $result = $this->model->create($nama, $file);

            if ($result) {
                header("Location: index.php?controller=kategori&action=index&status=success");
            } else {
                header("Location: index.php?controller=kategori&action=index&status=error");
            }
            exit;
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id   = $_POST['kode_kategori'];
            $nama = $_POST['nama_kategori'];
            $file = $_FILES; // ambil file upload

            $result = $this->model->update($id, $nama, $file);

            if ($result) {
                header("Location: index.php?controller=kategori&action=index&status=success");
            } else {
                header("Location: index.php?controller=kategori&action=index&status=error");
            }
            exit;
        }
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $result = $this->model->delete($_GET['id']);
            if ($result) {
                header("Location: index.php?controller=kategori&action=index&status=success");
            } else {
                header("Location: index.php?controller=kategori&action=index&status=error");
            }
            exit;
        }
    }
}
