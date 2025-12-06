<?php
require_once(__DIR__ . '/../models/Kendaraan.php');

class KendaraanController
{
    private $model;

    public function __construct($conn)
    {
        $this->model = new Kendaraan($conn);
    }

    public function index()
    {
        $data = $this->model->getAll();
        require_once(__DIR__ . '/../views/dashboard/kendaraan.php');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $file = $_FILES;
            $result = $this->model->create($data, $file);
            if ($result) {
                header("Location: index.php?controller=kendaraan&action=index&status=success");
            } else {
                header("Location: index.php?controller=kendaraan&action=index&status=error");
            }
            exit;
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['nopol_lama'];
            $data = $_POST;
            $file = $_FILES;
            $result = $this->model->update($id, $data, $file);
            if ($result) {
                header("Location: index.php?controller=kendaraan&action=index&status=success");
            } else {
                header("Location: index.php?controller=kendaraan&action=index&status=error");
            }
            exit;
        }
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            $result = $this->model->delete($_GET['id']);
            if ($result) {
                header("Location: index.php?controller=kendaraan&action=index&status=success");
            } else {
                header("Location: index.php?controller=kendaraan&action=index&status=error");
            }
            exit;
        }
    }
}
