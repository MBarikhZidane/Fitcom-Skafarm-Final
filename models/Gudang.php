<?php
class Gudang
{
    private $conn;
    private $table = "master_gudang";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT g.*, COUNT(b.kode_barang) AS total_produk
                FROM master_gudang g
                LEFT JOIN master_barang b ON g.kode_gudang = b.kode_gudang
                GROUP BY g.kode_gudang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function create($nama, $golongan, $keterangan)
    {
        $sql = "INSERT INTO {$this->table} (nama_gudang, golongan, keterangan) 
                VALUES (:nama, :golongan, :keterangan)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'nama' => $nama,
            'golongan' => $golongan,
            'keterangan' => $keterangan
        ]);
    }

    public function update($id, $nama, $golongan, $keterangan)
    {
        $sql = "UPDATE {$this->table} 
                SET nama_gudang = :nama, golongan = :golongan, keterangan = :keterangan
                WHERE kode_gudang = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'nama' => $nama,
            'golongan' => $golongan,
            'keterangan' => $keterangan,
            'id' => $id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE kode_gudang = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
