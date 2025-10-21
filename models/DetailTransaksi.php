<?php
class Detailtransaksi
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getHistory($kode_user)
    {
        $query = "SELECT b.nama_barang, b.harga, b.img, k.nama_kategori,
                 dt.qty, dt.harga_total FROM master_transaksi mt
                JOIN detail_transaksi dt ON mt.id_transaksi = dt.id_transaksi
                JOIN master_barang b ON dt.kode_barang = b.kode_barang
                JOIN master_kategori k ON b.kategori_id = k.kode_kategori
                WHERE mt.kode_user = :kode_user";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['kode_user' => $kode_user]);
        return $stmt;
    }

    public function getHargaBarang($kode_barang)
    {
        $query = "SELECT harga FROM master_barang WHERE kode_barang = :kode_barang";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['kode_barang' => $kode_barang]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['harga'] : 0;
    }

    public function insertMasterTransaksi($kode_transaksi, $kode_user, $total_harga)
    {
        $query = "INSERT INTO master_transaksi (kode_transaksi, kode_user, tanggal_transaksi, total_harga, status, alamat) 
                  VALUES (:kode_transaksi, :kode_user, CURDATE(), :total_harga, 'pending', 'belum')";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'kode_transaksi' => $kode_transaksi,
            'kode_user' => $kode_user,
            'total_harga' => $total_harga
        ]);
    }

    public function getLastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function insertDetailTransaksi($id_transaksi, $kode_barang, $qty, $harga_satuan, $harga_total)
    {
        $query = "INSERT INTO detail_transaksi (id_transaksi, kode_barang, qty, harga_satuan, harga_total) 
                  VALUES (:id_transaksi, :kode_barang, :qty, :harga_satuan, :harga_total)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'id_transaksi' => $id_transaksi,
            'kode_barang' => $kode_barang,
            'qty' => $qty,
            'harga_satuan' => $harga_satuan,
            'harga_total' => $harga_total
        ]);
    }

    public function getTransactionByKode($kode_transaksi)
    {
        $query = "SELECT 
                mt.kode_transaksi,
                mt.tanggal_transaksi,
                mt.metode_pembayaran,
                mt.alamat,
                dt.qty,
                dt.harga_total,
                b.nama_barang
              FROM master_transaksi mt
              JOIN detail_transaksi dt ON mt.id_transaksi = dt.id_transaksi
              JOIN master_barang b ON dt.kode_barang = b.kode_barang
              WHERE mt.kode_transaksi = :kode_transaksi";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['kode_transaksi' => $kode_transaksi]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTransaksi($kode_transaksi, $alamat, $metode)
    {
        $query = "UPDATE master_transaksi 
                  SET alamat = :alamat, metode_pembayaran = :metode 
                  WHERE kode_transaksi = :kode_transaksi";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            'alamat' => $alamat,
            'metode' => $metode,
            'kode_transaksi' => $kode_transaksi
        ]);
    }
}
