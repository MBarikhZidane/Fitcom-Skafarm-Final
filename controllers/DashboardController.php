<?php
require_once(__DIR__ . '/../models/Produk.php');
require_once(__DIR__ . '/../models/Transaksi.php');

class DashboardController
{
    private $produkModel;
    private $transaksiModel;

    public function __construct($conn)
    {
        $this->produkModel   = new Produk($conn);
        $this->transaksiModel = new Transaksi($conn);
    }

    public function beranda()
    {
        $totalProduk     = $this->produkModel->countAll();
        $totalPesanan    = $this->transaksiModel->countAll();
        $totalPendapatan = $this->transaksiModel->sumPendapatan();
        $stokHampirHabis = $this->produkModel->countLowStock();

        require_once(__DIR__ . '/../views/dashboard/beranda.php');
    }
}
