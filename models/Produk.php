<?php
class Produk
{
    private $conn;
    private $table = "master_barang";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getFiltered($filters)
    {
        $where = [];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "p.nama_barang LIKE :search";
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
                LEFT JOIN master_gudang g ON p.kode_gudang = g.kode_gudang
                $whereSql";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public function getAll()
    {
        $sql = "SELECT p.*, k.nama_kategori, g.nama_gudang
                FROM master_barang p
                LEFT JOIN master_kategori k ON p.kategori_id = k.kode_kategori
                LEFT JOIN master_gudang g ON p.kode_gudang = g.kode_gudang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function create($data, $files)
    {
        $nama = $data['nama_barang'];
        $satuan = $data['satuan'];
        $harga = $data['harga'];
        $stok = $data['stok'];
        $kategori = $data['kategori_id'];
        $gudang = $data['kode_gudang'];
        $deskripsi = $data['deskripsi'];

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
            (nama_barang, satuan, harga, stok, kategori_id, kode_gudang, deskripsi, img)
            VALUES (:nama, :satuan, :harga, :stok, :kategori, :gudang, :deskripsi, :img)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
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
        $id = $data['kode_barang'];
        $nama = $data['nama_barang'];
        $satuan = $data['satuan'];
        $harga = $data['harga'];
        $stok = $data['stok'];
        $kategori = $data['kategori_id'];
        $gudang = $data['kode_gudang'];
        $deskripsi = $data['deskripsi'];

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

            // hapus file lama yang tidak lagi dipakai
            $stmtOld = $this->conn->prepare("SELECT img FROM {$this->table} WHERE kode_barang = :id");
            $stmtOld->execute(['id' => $id]);
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
        nama_barang = :nama,
        satuan = :satuan,
        harga = :harga,
        stok = :stok,
        kategori_id = :kategori,
        kode_gudang = :gudang,
        deskripsi = :deskripsi,
        img = :img
        WHERE kode_barang = :id";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'nama' => $nama,
            'satuan' => $satuan,
            'harga' => $harga,
            'stok' => $stok,
            'kategori' => $kategori,
            'gudang' => $gudang,
            'deskripsi' => $deskripsi,
            'img' => json_encode(array_values($newImages)),
            'id' => $id
        ]);
    }


    public function delete($id)
    {
        $stmtOld = $this->conn->prepare("SELECT img FROM {$this->table} WHERE kode_barang = :id");
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

        $sql = "DELETE FROM {$this->table} WHERE kode_barang = :id";
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
                LEFT JOIN detail_transaksi d ON b.kode_barang = d.kode_barang
                GROUP BY b.kode_barang
                ORDER BY b.kode_barang DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function search($keyword)
    {
        $sql = "SELECT b.*, k.nama_kategori, 
                   IFNULL(SUM(d.qty), 0) AS total_terjual
            FROM master_barang b
            LEFT JOIN master_kategori k ON b.kategori_id = k.kode_kategori
            LEFT JOIN detail_transaksi d ON b.kode_barang = d.kode_barang
            WHERE b.nama_barang LIKE :keyword
            GROUP BY b.kode_barang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt;
    }

    public function findById($id)
    {
        $sql = "SELECT b.*, k.nama_kategori
            FROM master_barang b
            LEFT JOIN master_kategori k ON b.kategori_id = k.kode_kategori
            WHERE b.kode_barang = :id
            LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByKategori($kategoriId)
    {
        $sql = "SELECT b.*, k.nama_kategori, IFNULL(SUM(d.qty), 0) AS total_terjual
            FROM master_barang b
            LEFT JOIN master_kategori k ON b.kategori_id = k.kode_kategori
            LEFT JOIN detail_transaksi d ON b.kode_barang = d.kode_barang
            WHERE b.kategori_id = :kategoriId
            GROUP BY b.kode_barang
            ORDER BY b.kode_barang DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kategoriId' => $kategoriId]);
        return $stmt;
    }

    public function getHargaBarang($kode_barang)
    {
        $sql = "SELECT harga FROM master_barang WHERE kode_barang = :kode";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kode' => $kode_barang]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int) $row['harga'] : 0;
    }

    public function getTransactionkodeAll($kode_user, $kode_barang)
    {
        $user = (int) $kode_user;
        $barang = (int) $kode_barang;

        $sql = "SELECT 
                mt.kode_transaksi
            FROM master_transaksi mt
            JOIN detail_transaksi dt ON mt.id_transaksi = dt.id_transaksi
            WHERE mt.kode_user = :user AND dt.kode_barang = :barang";

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
        $sql = "SELECT COUNT(*) as total FROM products_ratings WHERE kode_transaksi IN ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($transaksi_kodes);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function insertComment($user_id, $rating, $comment, $transaksi_kode, $kode_barang)
    {
        $sql = "INSERT INTO products_ratings 
            (kode_transaksi, user_id, kode_barang, rating, comment, created_at) 
            VALUES (:kode_transaksi, :user_id, :kode_barang, :rating, :comment, CURDATE())";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'kode_transaksi' => $transaksi_kode,
            'user_id' => $user_id,
            'kode_barang' => $kode_barang,
            'rating' => $rating,
            'comment' => $comment
        ]);
    }

    public function getRating($id, $user_id = null)
    {
        if ($user_id) {
            $sql = "SELECT pr.*, mu.username 
                FROM products_ratings pr 
                JOIN master_barang mb ON pr.kode_barang = mb.kode_barang 
                JOIN master_user mu ON pr.user_id = mu.kode_user 
                WHERE pr.kode_barang = :kode_barang
                ORDER BY (pr.user_id = :user_id) DESC, pr.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'kode_barang' => $id,
                'user_id' => $user_id
            ]);
        } else {
            $sql = "SELECT pr.*, mu.username 
                FROM products_ratings pr 
                JOIN master_barang mb ON pr.kode_barang = mb.kode_barang 
                JOIN master_user mu ON pr.user_id = mu.kode_user 
                WHERE pr.kode_barang = :kode_barang
                ORDER BY pr.created_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['kode_barang' => $id]);
        }

        return $stmt;
    }


    public function getRatingDistribution($kode_barang)
    {
        $sql = "SELECT rating, COUNT(*) as total 
                FROM products_ratings 
                WHERE kode_barang = :kode_barang
                GROUP BY rating";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kode_barang' => $kode_barang]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAverageRating($kode_barang)
    {
        $sql = "SELECT AVG(rating) as avg_rating, COUNT(*) as total_reviews
                FROM products_ratings 
                WHERE kode_barang = :kode_barang";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['kode_barang' => $kode_barang]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteRating($rating_id, $user_id)
    {
        $sql = "DELETE FROM products_ratings WHERE id_rating = :id_rating AND user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'id_rating' => $rating_id,
            'user_id' => $user_id
        ]);
    }

    public function checkCommentByTransaction($kode_transaksi, $user_id)
    {
        $sql = "SELECT COUNT(*) FROM products_ratings 
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
