<?php
class Blog
{
    private $conn;
    private $table = "master_blog";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function getLimit($limit, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT $offset, $limit";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function getAllBlogs()
    {
        $query = "SELECT master_blog.*, master_user.username 
                  FROM master_blog 
                  JOIN master_user ON master_blog.kode_user = master_user.kode_user
                  ORDER BY id_blog DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT master_blog.*, master_user.username 
              FROM master_blog 
              JOIN master_user ON master_blog.kode_user = master_user.kode_user
              WHERE id_blog = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt;
    }

    public function getByUser($kode_user)
    {
        $query = "SELECT * FROM master_blog WHERE kode_user = :kode_user ORDER BY id_blog DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['kode_user' => $kode_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($kode_user, $judul, $artikel, $img)
    {
        $query = "INSERT INTO master_blog (kode_user, judul, artikel, img, created_at) 
                  VALUES (:kode_user, :judul, :artikel, :img, NOW())";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'kode_user' => $kode_user,
            'judul' => $judul,
            'artikel' => $artikel,
            'img' => $img
        ]);
    }

    public function update($id_blog, $judul, $artikel, $img)
    {
        $query = "UPDATE master_blog SET judul=:judul, artikel=:artikel, img=:img WHERE id_blog=:id_blog";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'judul' => $judul,
            'artikel' => $artikel,
            'img' => $img,
            'id_blog' => $id_blog
        ]);
    }

    public function delete($id)
    {
        $query = "DELETE FROM master_blog WHERE id_blog = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}
