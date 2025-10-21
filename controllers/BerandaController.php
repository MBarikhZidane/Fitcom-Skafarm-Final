<?php
require_once(__DIR__ . '/../models/Kategori.php');
require_once(__DIR__ . '/../models/Produk.php');
require_once(__DIR__ . '/../models/Blog.php');

class BerandaController
{
    private $kategoriModel;
    private $produkModel;
    private $blogModel;

    public function __construct($conn)
    {
        $this->kategoriModel = new Kategori($conn);
        $this->produkModel = new Produk($conn);
        $this->blogModel = new Blog($conn);
    }

    public function index()
    {
        $kategori = $this->kategoriModel->getAll();

        $keyword = $_GET['search'] ?? null;
        $kategoriId = $_GET['kategori'] ?? null;

        if ($keyword) {
            $produk = $this->produkModel->search($keyword);
        } elseif ($kategoriId) {
            $produk = $this->produkModel->getByKategori($kategoriId);
        } else {
            $produk = $this->produkModel->getAllLP();
        }

        $blogFeatured = $this->blogModel->getLimit(1);
        $blogSide = $this->blogModel->getLimit(3, 1);
        $blogAll = $this->blogModel->getAll();

        require_once(__DIR__ . '/../views/landingPage/beranda.php');
    }

    public function showProductRating($kode_barang)
    {
        $distribution = $this->produkModel->getRatingDistribution($kode_barang);
        $average = $this->produkModel->getAverageRating($kode_barang);

        $total = $average['total_reviews'] ?? 1;
        $stars = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        foreach ($distribution as $row) {
            $stars[$row['rating']] = round(($row['total'] / $total) * 100);
        }

        return [
            'average' => round($average['avg_rating'] ?? 0, 1),
            'total_reviews' => $average['total_reviews'] ?? 0,
            'stars' => $stars
        ];
    }

    public function detail()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user = $_SESSION['user_id'] ?? null;


        if (!isset($_GET['id'])) {
            header("Location: index.php?controller=beranda&action=index");
            exit;
        }

        $id = $_GET['id'];
        $product = $this->produkModel->findById($id);
        $ratings = $this->produkModel->getRating($id, $user);
        $ratingData = $this->showProductRating($id);

        $kode_user = (int) $user;
        $transaksiList = $this->produkModel->getTransactionkodeAll($kode_user, $id);

        $transaksiBelumKomen = [];
        foreach ($transaksiList as $trx) {
            if (!$this->produkModel->checkCommentByTransaction($trx['kode_transaksi'], $kode_user)) {
                $transaksiBelumKomen[] = $trx['kode_transaksi'];
            }
        }

        if (!$product) {
            header("Location: index.php?controller=beranda&action=index&status=notfound");
            exit;
        }

        require_once(__DIR__ . '/../views/landingPage/detailProduk.php');
    }

    public function comment()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $kode_user = $_SESSION['user_id'] ?? null;

        if (!$kode_user) {
            header("Location: index.php?controller=auth&action=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rating = intval($_POST['rating'] ?? 0);
            $comment = trim($_POST['comment'] ?? '');
            $kode_barang = intval($_POST['kode_barang'] ?? 0);
            $kode_transaksi = $_POST['kode_transaksi'] ?? null;

            if (empty($kode_barang) || empty($rating) || empty($comment)) {
                header("Location: index.php?controller=beranda&action=detail&id=$kode_barang&status=invalid_input");
                exit;
            }

            if ($kode_transaksi) {
                $alreadyCommented = $this->produkModel->checkCommentByTransaction($kode_transaksi, $kode_user);

                if (!$alreadyCommented) {
                    $this->produkModel->insertComment($kode_user, $rating, $comment, $kode_transaksi, $kode_barang);
                    header("Location: index.php?controller=beranda&action=detail&id=$kode_barang&status=success");
                } else {
                    header("Location: index.php?controller=beranda&action=detail&id=$kode_barang&status=already_commented");
                }
                exit;
            }

            else {
                $transaksiList = $this->produkModel->getTransactionkodeAll($kode_user, $kode_barang);
                $inserted = false;

                foreach ($transaksiList as $transaksi) {
                    $kode_transaksi = $transaksi['kode_transaksi'];

                    $alreadyCommented = $this->produkModel->checkCommentByTransaction($kode_transaksi, $kode_user);

                    if (!$alreadyCommented) {
                        $this->produkModel->insertComment($kode_user, $rating, $comment, $kode_transaksi, $kode_barang);
                        $inserted = true;
                        break;
                    }
                }

                if ($inserted) {
                    header("Location: index.php?controller=beranda&action=detail&id=$kode_barang&status=success");
                } else {
                    header("Location: index.php?controller=beranda&action=detail&id=$kode_barang&status=already_commented");
                }
                exit;
            }
        }
    }



    public function deleteComment()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user = $_SESSION['user_id'];
        $kode_user = (int) $user;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rating_id = $_POST['rating_id'] ?? null;

            if ($rating_id && $kode_user) {
                $this->produkModel->deleteRating($rating_id, $kode_user);
            }

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }


}
