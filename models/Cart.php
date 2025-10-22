<?php
class Cart
{
    private $conn;
    private $table = "master_cart";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCartByUser($kode_user)
    {
        $query = "SELECT c.id_cart, c.*, b.nama_barang, b.harga, b.img, k.nama_kategori, b.stok
              FROM master_cart c
              JOIN produk b ON c.kode_produk = b.kode_produk
              JOIN master_kategori k ON b.kategori_id = k.kode_kategori
              WHERE c.kode_user = :kode_user";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['kode_user' => $kode_user]);
        return $stmt;
    }

    public function getSummaryByUser($kode_user)
    {
        $query = "SELECT 
                SUM(qty) AS total_produk, 
                SUM(subtotal) AS total_harga 
              FROM master_cart 
              WHERE kode_user = :kode_user";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['kode_user' => $kode_user]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addToCart($kode_user, $kode_produk, $qty, $harga)
    {
        $subtotal = $qty * $harga;
        $query = "SELECT * FROM master_cart WHERE kode_user = :kode_user AND kode_produk = :kode_produk";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['kode_user' => $kode_user, 'kode_produk' => $kode_produk]);
        if ($stmt->rowCount() > 0) {
            $query = "UPDATE master_cart 
                      SET qty = qty + :qty, subtotal = subtotal + :subtotal
                      WHERE kode_user = :kode_user AND kode_produk = :kode_produk";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'qty' => $qty,
                'subtotal' => $subtotal,
                'kode_user' => $kode_user,
                'kode_produk' => $kode_produk
            ]);
        } else {
            $query = "INSERT INTO master_cart (kode_user, kode_produk, qty, harga_satuan, subtotal)
                      VALUES (:kode_user, :kode_produk, :qty, :harga, :subtotal)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute([
                'kode_user' => $kode_user,
                'kode_produk' => $kode_produk,
                'qty' => $qty,
                'harga' => $harga,
                'subtotal' => $subtotal
            ]);
        }
    }

    public function getHargaBarang($kode_produk)
    {
        $query = "SELECT harga FROM produk WHERE kode_produk = :kode_produk";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['kode_produk' => $kode_produk]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? $data['harga'] : 0;
    }

    public function deleteFromCartById($kode_user, $id_cart)
    {
        $query = "DELETE FROM master_cart WHERE id_cart = :id_cart AND kode_user = :kode_user";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id_cart' => $id_cart, 'kode_user' => $kode_user]);
    }
}
