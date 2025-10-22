<?php
class Gudang
{
    private $conn;
    private $table = "gudang";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT g.*, COUNT(b.kode_produk) AS total_produk
                FROM gudang g
                LEFT JOIN produk b ON g.kode_gudang = b.kode_gudang
                GROUP BY g.kode_gudang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function create($kode, $nama, $golongan, $keterangan)
    {
        $check = $this->conn->prepare("SELECT COUNT(*) FROM {$this->table} WHERE kode_gudang = :kode");
        $check->execute(['kode' => $kode]);
        if ($check->fetchColumn() > 0) {
            return false;
        }

        $sql = "INSERT INTO {$this->table} (kode_gudang, nama_gudang, golongan, keterangan) 
            VALUES (:kode, :nama, :golongan, :keterangan)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'kode' => $kode,
            'nama' => $nama,
            'golongan' => $golongan,
            'keterangan' => $keterangan
        ]);
    }

    public function update($kodeLama, $kodeBaru, $nama, $golongan, $keterangan)
    {
        $check = $this->conn->prepare("SELECT COUNT(*) FROM gudang WHERE kode_gudang = :kode");
        $check->execute(['kode' => $kodeBaru]);
        if ($check->fetchColumn() > 0 && $kodeBaru !== $kodeLama) {
            throw new Exception("Kode gudang sudah digunakan, gunakan kode lain.");
        }

        $sql = "UPDATE {$this->table}  
            SET kode_gudang = :kode_baru,
                nama_gudang = :nama,
                golongan = :golongan,
                keterangan = :keterangan
            WHERE kode_gudang = :kode_lama";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'kode_baru' => $kodeBaru,
            'nama' => $nama,
            'golongan' => $golongan,
            'keterangan' => $keterangan,
            'kode_lama' => $kodeLama
        ]);
    }


    public function delete($kode)
    {
        $sql = "DELETE FROM {$this->table} WHERE kode_gudang = :kode";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['kode' => $kode]);
    }
}
