<?php
class Produk
{
    private $conn;
    private $table = "produk";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getFiltered($filters)
    {
        $where = [];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(p.nama_barang LIKE :search OR p.kode_produk LIKE :search)";
            $params['search'] = "%" . $filters['search'] . "%";
        }


        if (!empty($filters['satuan'])) {
            $where[] = "p.satuan = :satuan";
            $params['satuan'] = $filters['satuan'];
        }

        if (!empty($filters['kategori_id'])) {
            $where[] = "p.kategori_id = :kategori";
            $params['kategori'] = $filters['kategori_id'];
        }

        if (!empty($filters['kode_gudang'])) {
            $where[] = "p.kode_gudang = :gudang";
            $params['gudang'] = $filters['kode_gudang'];
        }

        $whereSql = "";
        if (count($where) > 0) {
            $whereSql = "WHERE " . implode(" AND ", $where);
        }

        $sql = "SELECT p.*, k.nama_kategori, g.nama_gudang
                FROM {$this->table} p
                LEFT JOIN master_kategori k ON p.kategori_id = k.kode_kategori
                LEFT JOIN gudang g ON p.kode_gudang = g.kode_gudang
                $whereSql";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function getAll()
    {
        $sql = "SELECT p.*, k.nama_kategori, g.nama_gudang
                FROM produk p
                LEFT JOIN master_kategori k ON p.kategori_id = k.kode_kategori
                LEFT JOIN gudang g ON p.kode_gudang = g.kode_gudang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    public function create($data, $files)
    {
        $kode = $data['kode_produk'];
        $nama = $data['nama_barang'];
        $satuan = $data['satuan'];
        $harga = $data['harga'];
        $stok = $data['stok'];
        $kategori = $data['kategori_id'];
        $gudang = $data['kode_gudang'];
        $deskripsi = $data['deskripsi'];

        $check = $this->conn->prepare("SELECT COUNT(*) FROM produk WHERE kode_produk = :kode");
        $check->execute(['kode' => $kode]);
        if ($check->fetchColumn() > 0) {
            throw new Exception("Kode produk sudah digunakan, gunakan kode lain.");
        }

        if (!isset($files['img']) || count(array_filter($files['img']['name'])) !== 4) {
            throw new Exception("Harus mengupload tepat 4 gambar.");
        }

        $uploaded = [];
        for ($i = 0; $i < 4; $i++) {
            $tmpName = $files['img']['tmp_name'][$i];
            $fileName = uniqid("prd_") . "." . pathinfo($files['img']['name'][$i], PATHINFO_EXTENSION);
            $target = __DIR__ . "/../uploads/" . $fileName;
            if (move_uploaded_file($tmpName, $target)) {
                $uploaded[] = $fileName;
            }
        }

        $sql = "INSERT INTO {$this->table}
        (kode_produk, nama_barang, satuan, harga, stok, kategori_id, kode_gudang, deskripsi, img)
        VALUES (:kode, :nama, :satuan, :harga, :stok, :kategori, :gudang, :deskripsi, :img)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'kode' => $kode,
            'nama' => $nama,
            'satuan' => $satuan,
            'harga' => $harga,
            'stok' => $stok,
            'kategori' => $kategori,
            'gudang' => $gudang,
            'deskripsi' => $deskripsi,
            'img' => json_encode($uploaded)
        ]);
    }




    public function update($data, $files)
    {
        $kodeBaru = $data['kode_produk'];
        $kodeLama = $data['kode_lama'];

        $nama = $data['nama_barang'];
        $satuan = $data['satuan'];
        $harga = $data['harga'];
        $stok = $data['stok'];
        $kategori = $data['kategori_id'];
        $gudang = $data['kode_gudang'];
        $deskripsi = $data['deskripsi'];

        $check = $this->conn->prepare("SELECT COUNT(*) FROM produk WHERE kode_produk = :kode_lama");
        $check->execute(['kode_lama' => $kodeBaru]);
        if ($check->fetchColumn() > 0 && $kodeBaru !== $kodeLama) {
            throw new Exception("Kode produk sudah digunakan, gunakan kode lain.");
        }



        $oldImages = [];
        if (!empty($data['old_images'])) {
            $decoded = json_decode($data['old_images'], true);
            if (is_array($decoded))
                $oldImages = $decoded;
        }

        $newImages = $oldImages;

        if (!empty($files['img']['name'][0])) {
            $newUploads = [];
            $countNew = count(array_filter($files['img']['name']));

            for ($i = 0; $i < $countNew; $i++) {
                $tmpName = $files['img']['tmp_name'][$i];
                $fileName = uniqid("prd_") . "." . pathinfo($files['img']['name'][$i], PATHINFO_EXTENSION);
                $target = __DIR__ . "/../uploads/" . $fileName;
                if (move_uploaded_file($tmpName, $target)) {
                    $newUploads[] = $fileName;
                }
            }

            $stmtOld = $this->conn->prepare("SELECT img FROM {$this->table} WHERE kode_produk = :kode_lama");
            $stmtOld->execute(['kode_lama' => $kodeLama]);
            $oldRow = $stmtOld->fetch(PDO::FETCH_ASSOC);
            if ($oldRow) {
                $previous = json_decode($oldRow['img'], true);
                if (is_array($previous)) {
                    foreach ($previous as $img) {
                        if (!in_array($img, $newImages)) {
                            $path = __DIR__ . "/../uploads/" . $img;
                            if (file_exists($path))
                                unlink($path);
                        }
                    }
                }
            }

            $newImages = array_merge($newImages, $newUploads);
            if (count($newImages) !== 4)
                throw new Exception("Total gambar wajib tetap 4.");
        }

        $sql = "UPDATE {$this->table} SET 
          kode_produk = :kode_baru,
    nama_barang = :nama,
    satuan = :satuan,
    harga = :harga,
    stok = :stok,
    kategori_id = :kategori,
    kode_gudang = :gudang,
    deskripsi = :deskripsi,
    img = :img
    WHERE kode_produk = :kode_lama";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'kode_baru' => $kodeBaru,
            'nama' => $nama,
            'satuan' => $satuan,
            'harga' => $harga,
            'stok' => $stok,
            'kategori' => $kategori,
            'gudang' => $gudang,
            'deskripsi' => $deskripsi,
            'img' => json_encode(array_values($newImages)),
            'kode_lama' => $kodeLama
        ]);
    }


    public function delete($id)
    {
        $stmtOld = $this->conn->prepare("SELECT img FROM {$this->table} WHERE kode_produk = :id");
        $stmtOld->execute(['id' => $id]);
        $row = $stmtOld->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $imgs = json_decode($row['img'], true);
            if (is_array($imgs)) {
                foreach ($imgs as $img) {
                    $filePath = __DIR__ . "/../uploads/" . $img;
                    if (file_exists($filePath))
                        unlink($filePath);
                }
            }
        }

        $sql = "DELETE FROM {$this->table} WHERE kode_produk = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function countLowStock()
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE stok <= 5";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function getAllLP()
    {
        $sql = "SELECT b.*, k.nama_kategori, IFNULL(SUM(d.qty), 0) as total_terjual
                FROM {$this->table} b
                LEFT JOIN master_kategori k ON b.kategori_id = k.kode_kategori
                LEFT JOIN detail_transaksi d ON b.kode_produk = d.kode_produk
                GROUP BY b.kode_produk
                ORDER BY b.kode_produk DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function search($keyword)
    {
        $sql = "SELECT b.*, k.nama_kategori, 
                   IFNULL(SUM(d.qty), 0) AS total_terjual
            FROM produk b
            LEFT JOIN master_kategori k ON b.kategori_id = k.kode_kategori
            LEFT JOIN detail_transaksi d ON b.kode_produk = d.kode_produk
            WHERE b.nama_barang LIKE :keyword
            GROUP BY b.kode_produk";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt;
    }

    public function findById($id)
    {
        $sql = "SELECT b.*, k.nama_kategori
            FROM produk b
            LEFT JOIN master_kategori k ON b.kategori_id = k.kode_kategori
            WHERE b.kode_produk = :id
            LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByKategori($kategoriId)
    {
        $sql = "SELECT b.*, k.nama_kategori, IFNULL(SUM(d.qty), 0) AS total_terjual
            FROM produk b
            LEFT JOIN master_kategori k ON b.kategori_id = k.kode_kategori
            LEFT JOIN detail_transaksi d ON b.kode_produk = d.kode_produk
            WHERE b.kategori_id = :kategoriId
            GROUP BY b.kode_produk
            ORDER BY b.kode_produk DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kategoriId' => $kategoriId]);
        return $stmt;
    }

    public function getHargaBarang($kode_produk)
    {
        $sql = "SELECT harga FROM produk WHERE kode_produk = :kode";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kode' => $kode_produk]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int) $row['harga'] : 0;
    }

    public function getTransactionkodeAll($kode_user, $kode_produk)
    {
        $user = (int) $kode_user;
        $barang = (int) $kode_produk;

        $sql = "SELECT 
                mt.kode_transaksi
            FROM master_transaksi mt
            JOIN detail_transaksi dt ON mt.id_transaksi = dt.id_transaksi
            WHERE mt.kode_user = :user AND dt.kode_produk = :barang";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'user' => $user,
            'barang' => $barang
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkTransactionMultiple(array $transaksi_kodes)
    {
        $placeholders = implode(',', array_fill(0, count($transaksi_kodes), '?'));
        $sql = "SELECT COUNT(*) as total FROM produks_ratings WHERE kode_transaksi IN ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($transaksi_kodes);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function insertComment($user_id, $rating, $comment, $transaksi_kode, $kode_produk)
    {
        $sql = "INSERT INTO produks_ratings 
            (kode_transaksi, user_id, kode_produk, rating, comment, created_at) 
            VALUES (:kode_transaksi, :user_id, :kode_produk, :rating, :comment, CURDATE())";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'kode_transaksi' => $transaksi_kode,
            'user_id' => $user_id,
            'kode_produk' => $kode_produk,
            'rating' => $rating,
            'comment' => $comment
        ]);
    }

    public function getRating($id, $user_id = null)
    {
        if ($user_id) {
            $sql = "SELECT pr.*, mu.username 
                FROM produks_ratings pr 
                JOIN produk mb ON pr.kode_produk = mb.kode_produk 
                JOIN master_user mu ON pr.user_id = mu.kode_user 
                WHERE pr.kode_produk = :kode_produk
                ORDER BY (pr.user_id = :user_id) DESC, pr.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'kode_produk' => $id,
                'user_id' => $user_id
            ]);
        } else {
            $sql = "SELECT pr.*, mu.username 
                FROM produks_ratings pr 
                JOIN produk mb ON pr.kode_produk = mb.kode_produk 
                JOIN master_user mu ON pr.user_id = mu.kode_user 
                WHERE pr.kode_produk = :kode_produk
                ORDER BY pr.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['kode_produk' => $id]);
        }

        return $stmt;
    }


    public function getRatingDistribution($kode_produk)
    {
        $sql = "SELECT rating, COUNT(*) as total 
                FROM produks_ratings 
                WHERE kode_produk = :kode_produk
                GROUP BY rating";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kode_produk' => $kode_produk]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAverageRating($kode_produk)
    {
        $sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews
                FROM produks_ratings 
                WHERE kode_produk = :kode_produk";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kode_produk' => $kode_produk]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteRating($rating_id, $user_id)
    {
        $sql = "DELETE FROM produks_ratings WHERE id_rating = :id_rating AND user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'id_rating' => $rating_id,
            'user_id' => $user_id
        ]);
    }

    public function checkCommentByTransaction($kode_transaksi, $user_id)
    {
        $sql = "SELECT COUNT(*) FROM produks_ratings 
            WHERE kode_transaksi = :kode_transaksi 
            AND user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'kode_transaksi' => $kode_transaksi,
            'user_id' => $user_id
        ]);
        return $stmt->fetchColumn() > 0;
    }
}
