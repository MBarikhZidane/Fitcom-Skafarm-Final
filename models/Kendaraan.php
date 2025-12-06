<?php
class Kendaraan
{
    private $conn;
    private $table = "kendaraan";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function create($data, $file)
    {
        $foto = null;
        if (isset($file['foto']) && $file['foto']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($file['foto']['name'], PATHINFO_EXTENSION);
            $filename = uniqid("kendaraan_") . "." . $ext;
            $target = __DIR__ . "/../uploads/" . $filename;
            if (move_uploaded_file($file['foto']['tmp_name'], $target)) {
                $foto = $filename;
            }
        }

        $sql = "INSERT INTO {$this->table} 
                (nopol, namakendaraan, jeniskendaraan, namadriver, kontakdriver, tahun, kapasitas, foto)
                VALUES (:nopol, :nama, :jenis, :driver, :kontak, :tahun, :kapasitas, :foto)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            'nopol' => $data['nopol'],
            'nama' => $data['namakendaraan'],
            'jenis' => $data['jeniskendaraan'],
            'driver' => $data['namadriver'],
            'kontak' => $data['kontakdriver'],
            'tahun' => $data['tahun'],
            'kapasitas' => $data['kapasitas'],
            'foto' => $foto
        ]);
    }

    public function update($oldId, $data, $file)
    {
        $setFoto = "";
        $params = [
            'nopol_baru' => $data['nopol'],
            'nama' => $data['namakendaraan'],
            'jenis' => $data['jeniskendaraan'],
            'driver' => $data['namadriver'],
            'kontak' => $data['kontakdriver'],
            'tahun' => $data['tahun'],
            'kapasitas' => $data['kapasitas'],
            'oldId' => $oldId
        ];

        if (isset($file['foto']) && $file['foto']['error'] === UPLOAD_ERR_OK) {
            $stmtOld = $this->conn->prepare("SELECT foto FROM {$this->table} WHERE nopol = :id");
            $stmtOld->execute(['id' => $oldId]);
            $row = $stmtOld->fetch(PDO::FETCH_ASSOC);
            if ($row && !empty($row['foto']) && file_exists(__DIR__ . "/../uploads/" . $row['foto'])) {
                unlink(__DIR__ . "/../uploads/" . $row['foto']);
            }
            $ext = pathinfo($file['foto']['name'], PATHINFO_EXTENSION);
            $filename = uniqid("kendaraan_") . "." . $ext;
            $target = __DIR__ . "/../uploads/" . $filename;
            if (move_uploaded_file($file['foto']['tmp_name'], $target)) {
                $setFoto = ", foto = :foto";
                $params['foto'] = $filename;
            }
        }

        $sql = "UPDATE {$this->table} 
                SET nopol = :nopol_baru, namakendaraan = :nama, jeniskendaraan = :jenis,
                    namadriver = :driver, kontakdriver = :kontak, tahun = :tahun, kapasitas = :kapasitas $setFoto
                WHERE nopol = :oldId";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete($id)
    {
        $stmtOld = $this->conn->prepare("SELECT foto FROM {$this->table} WHERE nopol = :id");
        $stmtOld->execute(['id' => $id]);
        $row = $stmtOld->fetch(PDO::FETCH_ASSOC);
        if ($row && !empty($row['foto']) && file_exists(__DIR__ . "/../uploads/" . $row['foto'])) {
            unlink(__DIR__ . "/../uploads/" . $row['foto']);
        }
        $sql = "DELETE FROM {$this->table} WHERE nopol = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
