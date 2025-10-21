<?php
require_once(__DIR__ . '/../models/Transaksi.php');

class TransaksiController
{
    private $transaksiModel;

    public function __construct($conn)
    {
        $this->transaksiModel = new Transaksi($conn);
    }

    public function index()
    {
        $data = $this->transaksiModel->getAll();
        require_once(__DIR__ . '/../views/dashboard/pesanan.php');
    }

    public function detail($id)
    {
        $detail = $this->transaksiModel->getDetail($id);
        return $detail;
    }

    public function updateStatus()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $this->transaksiModel->updateStatus($id);
            header("Location: index.php?controller=transaksi&action=index&status=success");
            exit;
        }
    }

    
}
