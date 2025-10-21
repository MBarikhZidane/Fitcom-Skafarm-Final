<?php
require_once(__DIR__ . '/../models/Blog.php');


class BlogController
{
    private $model;

    public function __construct($conn)
    {
        $this->model = new Blog($conn);
    }

    public function myblog()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?controller=auth&action=showLogin");
            exit;
        }

        $blogs = $this->model->getByUser($_SESSION['user_id']);
        include 'views/landingPage/blog.php';
    }

    public function show()
    {
        $blog = $this->model->getById($_GET['id']);
        $blog = $blog->fetch(PDO::FETCH_ASSOC);
        include 'views/landingPage/detailBlog.php';
    }



    public function store()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $kode_user = $_SESSION['user_id'];
        $judul = $_POST['judul'];
        $artikel = $_POST['artikel'];

        $img = "";
        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $filename = uniqid("prd_") . "." . $ext;
            $target = __DIR__ . "/../uploads/" . $filename;

            if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
                $img = $filename;
            }
        }
        $this->model->insert($kode_user, $judul, $artikel, $img);
        header("Location: index.php?controller=blog&action=myblog");
    }

    public function edit()
    {
        $blog = $this->model->getById($_GET['id_blog']);
        include 'views/blog/blog.php';
    }

    public function update()
    {
        $id_blog = $_POST['id_blog'];
        $judul = $_POST['judul'];
        $artikel = $_POST['artikel'];
        $img = $_POST['old_img']; // default pakai gambar lama

        if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid("prd_") . "." . $ext;
            $target = __DIR__ . "/../uploads/" . $fileName;

            if (move_uploaded_file($_FILES['img']['tmp_name'], $target)) {
                $img = $fileName;
            }
        }

        $this->model->update($id_blog, $judul, $artikel, $img);
        header("Location: index.php?controller=blog&action=myblog");
    }

    public function delete()
    {
        $artikel = $this->model->getById($_GET['id_blog']);
        $blog = $artikel->fetch(PDO::FETCH_ASSOC);

        if (!empty($blog['img'])) {
            $filePath = __DIR__ . "/../uploads/" . $blog['img'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->model->delete($_GET['id_blog']);

        header("Location: index.php?controller=blog&action=myblog");
    }
}
