<?php
class Pengiriman
{
    private $conn;
    private $table = "masterkirim";

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getAll($filters = [])
    {
        $mode = $filters['mode'] ?? 'rekap';
        $namaBarang = $filters['nama_barang'] ?? null;

        if ($mode === 'rekap') {
            $query = "SELECT 
                    m.kodekirim,
                    MAX(m.tglkirim) AS tglkirim,
                    MAX(m.nopol) AS nopol,
                    MAX(m.totalqty) AS totalqty,

                    MAX(k.namakendaraan) AS namakendaraan,
                    MAX(k.namadriver) AS namadriver,

                    GROUP_CONCAT(DISTINCT g.nama_gudang) AS nama_gudang

                  FROM {$this->table} m
                  LEFT JOIN kendaraan k ON m.nopol = k.nopol
                  LEFT JOIN detailkirim d ON m.kodekirim = d.kodekirim
                  LEFT JOIN produk p ON d.kode_produk = p.kode_produk
                  LEFT JOIN gudang g ON p.kode_gudang = g.kode_gudang
                  WHERE 1=1";
        } else {
            $query = "SELECT 
                    m.kodekirim,
                    m.tglkirim,
                    m.nopol,
                    m.totalqty,
                    k.namakendaraan, 
                    k.namadriver,
                    g.nama_gudang,
                    p.nama_barang,
                    d.qty
                  FROM {$this->table} m
                  LEFT JOIN kendaraan k ON m.nopol = k.nopol
                  LEFT JOIN detailkirim d ON m.kodekirim = d.kodekirim
                  LEFT JOIN produk p ON d.kode_produk = p.kode_produk
                  LEFT JOIN gudang g ON p.kode_gudang = g.kode_gudang
                  WHERE 1=1";
        }

        $params = [];

        if (!empty($filters['awal']) && !empty($filters['akhir'])) {
            $query .= " AND m.tglkirim BETWEEN :awal AND :akhir";
            $params['awal'] = $filters['awal'];
            $params['akhir'] = $filters['akhir'];
        }

        if (!empty($filters['nopol'])) {
            $query .= " AND m.nopol = :nopol";
            $params['nopol'] = $filters['nopol'];
        }

        if (!empty($filters['gudang'])) {
            $query .= " AND g.nama_gudang = :gudang";
            $params['gudang'] = $filters['gudang'];
        }

        if (!empty($namaBarang)) {
            $query .= " AND p.nama_barang = :nama_barang";
            $params['nama_barang'] = $namaBarang;
        }

        if ($mode === 'rekap') {
            $query .= " GROUP BY m.kodekirim 
                    ORDER BY MAX(m.tglkirim) DESC";
        } else {
            $query .= " ORDER BY m.tglkirim DESC";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    public function create($kode, $tgl, $nopol, $totalqty)
    {
        $sql = "INSERT INTO {$this->table} (kodekirim, tglkirim, nopol, totalqty)
                VALUES (:kode, :tgl, :nopol, :total)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'kode' => $kode,
            'tgl' => $tgl,
            'nopol' => $nopol,
            'total' => $totalqty
        ]);
    }

    public function getAllKendaraan()
    {
        $sql = "SELECT * FROM kendaraan";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProduk()
    {
        $sql = "SELECT kode_produk, nama_barang, satuan FROM produk";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllGudang()
    {
        $sql = "SELECT * FROM gudang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
