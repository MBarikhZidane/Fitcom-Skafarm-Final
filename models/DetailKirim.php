<?php
class DetailKirim
{
    private $conn;
    private $table = "detailkirim";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createBatch($kodekirim, $details)
    {
        try {
            $this->conn->beginTransaction();

            $sqlInsert = "INSERT INTO {$this->table} (kodekirim, kode_produk, qty)
                          VALUES (:kodekirim, :kode_produk, :qty)";
            $stmtInsert = $this->conn->prepare($sqlInsert);

            $sqlUpdateStok = "UPDATE produk 
                              SET stok = stok - :qty
                              WHERE kode_produk = :kode_produk";
            $stmtUpdate = $this->conn->prepare($sqlUpdateStok);

            $stmtCek = $this->conn->prepare("SELECT nama_barang, stok FROM produk WHERE kode_produk = :kode");

            foreach ($details as $d) {
                $stmtCek->execute(['kode' => $d['kode_produk']]);
                $produk = $stmtCek->fetch(PDO::FETCH_ASSOC);

                if (!$produk) {
                    throw new Exception("Produk dengan kode {$d['kode_produk']} tidak ditemukan.");
                }

                if ((int)$produk['stok'] < (int)$d['qty']) {
                    throw new Exception("Stok untuk produk {$produk['nama_barang']} tidak mencukupi. 
                    Stok tersedia: {$produk['stok']}, diminta: {$d['qty']}.");
                }

                $stmtInsert->execute([
                    'kodekirim' => $kodekirim,
                    'kode_produk' => $d['kode_produk'],
                    'qty' => (int)$d['qty']
                ]);

                $stmtUpdate->execute([
                    'qty' => (int)$d['qty'],
                    'kode_produk' => $d['kode_produk']
                ]);
            }

            $this->conn->commit();
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw new Exception("Gagal menyimpan pengiriman: " . $e->getMessage());
        }
    }


    public function getByKode($kodekirim)
    {
        $sql = "SELECT d.*, p.nama_barang, p.satuan 
                FROM {$this->table} d 
                JOIN produk p ON d.kode_produk = p.kode_produk 
                WHERE d.kodekirim = :kode";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kode' => $kodekirim]);
        return $stmt;
    }
}
