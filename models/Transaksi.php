<?php
class Transaksi
{
    private $conn;
    private $table = "master_transaksi";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT t.*, u.username
                FROM {$this->table} t
                JOIN master_user u ON t.kode_user = u.kode_user
                ORDER BY t.id_transaksi DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function getDetail($id_transaksi)
    {
        $sql = "SELECT d.*, b.nama_barang 
                FROM detail_transaksi d
                JOIN produk b ON d.kode_produk = b.kode_produk
                WHERE d.id_transaksi = :id_transaksi";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_transaksi', $id_transaksi);
        $stmt->execute();
        return $stmt;
    }

    public function updateStatus($id)
    {
        $sql = "UPDATE {$this->table} SET status='selesai' WHERE id_transaksi=:id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM master_transaksi";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function sumPendapatan()
    {
        $sql = "SELECT SUM(total_harga) as total FROM master_transaksi WHERE status='selesai'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }
}
