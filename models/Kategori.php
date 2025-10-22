<?php
class Kategori
{
    private $conn;
    private $table = "master_kategori";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT k.*, COUNT(b.kode_produk) AS total_produk
                FROM master_kategori k
                LEFT JOIN produk b ON k.kode_kategori = b.kategori_id
                GROUP BY k.kode_kategori";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function create($nama, $file)
    {
        $img = null;

        if (isset($file['img']) && $file['img']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($file['img']['name'], PATHINFO_EXTENSION);
            $filename = uniqid("kat_") . "." . $ext;
            $target = __DIR__ . "/../uploads/" . $filename;

            if (move_uploaded_file($file['img']['tmp_name'], $target)) {
                $img = $filename;
            }
        }

        $sql = "INSERT INTO {$this->table} (nama_kategori, img) VALUES (:nama, :img)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'nama' => $nama,
            'img' => $img
        ]);
    }

    public function update($id, $nama, $file)
    {
        $setImg = "";
        $params = ['nama' => $nama, 'id' => $id];

        if (isset($file['img']) && $file['img']['error'] === UPLOAD_ERR_OK) {
            $stmtOld = $this->conn->prepare("SELECT img FROM {$this->table} WHERE kode_kategori = :id");
            $stmtOld->execute(['id' => $id]);
            $row = $stmtOld->fetch(PDO::FETCH_ASSOC);

            if ($row && !empty($row['img']) && file_exists(__DIR__ . "/../uploads/" . $row['img'])) {
                unlink(__DIR__ . "/../uploads/" . $row['img']);
            }

            $ext = pathinfo($file['img']['name'], PATHINFO_EXTENSION);
            $filename = uniqid("kat_") . "." . $ext;
            $target = __DIR__ . "/../uploads/" . $filename;

            if (move_uploaded_file($file['img']['tmp_name'], $target)) {
                $setImg = ", img = :img";
                $params['img'] = $filename;
            }
        }

        $sql = "UPDATE {$this->table} 
                SET nama_kategori = :nama $setImg 
                WHERE kode_kategori = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmtOld = $this->conn->prepare("SELECT img FROM {$this->table} WHERE kode_kategori = :id");
        $stmtOld->execute(['id' => $id]);
        $row = $stmtOld->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['img']) && file_exists(__DIR__ . "/../uploads/" . $row['img'])) {
            unlink(__DIR__ . "/../uploads/" . $row['img']);
        }

        $sql = "DELETE FROM {$this->table} WHERE kode_kategori = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
