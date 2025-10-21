<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
?>

<?php require_once(__DIR__ . "/../components/landingPage/head.php"); ?>
<nav class="cart-navbar shadow-sm bg-body-tertiary border-bottom sticky-top z-3 py-3">
    <div class="container d-flex justify-content-between align-items-center px-3 px-lg-5 position-relative">
        <a class="btn position-relative z-1" href="index.php?controller=beranda&action=index" aria-label="Back">
            <i class="bi bi-arrow-left fs-4 text-success"></i>
        </a>
        <div class="position-absolute start-50 translate-middle-x text-center">
            <a class="navbar-brand me-4 me-lg-5 d-flex align-items-center text-decoration-none"
                href="index.php?controller=beranda&action=index">
                <i class="bi bi-cart-check-fill"
                    style="
                        font-size: 2.2rem;
                        background: linear-gradient(90deg, #15803d, #22c55e, #4ade80);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        margin-right: 10px;
                   "></i>
                <span class="logo-text-gradient">Skafarm</span>
            </a>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-3 mb-3">

            <!-- Sidebar for desktop (md up) -->
            <div class="blog-sidebar d-none d-md-block">
                <div class="nav flex-column">
                    <a class="blog-nav-link text-decoration-none" href="index.php?controller=cart&action=mycart"><i class="bi bi-bag"></i> Carts</a>
                    <a class="blog-nav-link text-decoration-none" href="index.php?controller=detailtransaksi&action=myhistory"><i class="bi bi-box"></i> History Orders</a>
                    <a class="blog-nav-link text-decoration-none active" href="index.php?controller=blog&action=myblog"><i class="bi bi-card-text"></i> Blog</a>
                    <a class="blog-nav-link text-decoration-none blog-logout-link" href="index.php?controller=auth&action=logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
                </div>
            </div>

            <!-- Sidebar as dropdown (visible only on small devices) -->
            <div class="d-md-none">
                <button class="btn btn-outline-success w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#blogMobileSidebar" aria-expanded="false" aria-controls="blogMobileSidebar">
                    ☰ Menu
                </button>

                <div class="collapse" id="blogMobileSidebar">
                    <div class="card card-body p-2" style="width: 100%">
                        <a class="blog-nav-link d-flex gap-2 text-decoration-none" href="index.php?controller=cart&action=mycart"><i class="bi bi-bag"></i> Carts</a>
                        <a class="blog-nav-link d-flex gap-2 text-decoration-none" href="index.php?controller=detailtransaksi&action=myhistory"><i style="color: #6c757d;" class="bi bi-box"></i> History Orders</a>
                        <a class="blog-nav-link active d-flex gap-2 text-decoration-none" href="index.php?controller=blog&action=myblog"><i style="color: #6c757d;" class="bi bi-card-text"></i> Blog</a>
                        <a class="blog-nav-link blog-logout-link d-flex gap-2 text-decoration-none" href="index.php?controller=auth&action=logout"><i class="bi bi-box-arrow-left"></i> Logout</a>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-9">
            <div class="blog-main-content">

                <!-- Search Order -->
                <div class="blog-search-order px-3 px-md-4 py-3">
                    <div class="row g-2 align-items-center">
                        <div class="col-8 col-md-10">
                            <h1 class="fw-bold fs-5">Daftar Blog</h1>
                        </div>

                        <!-- Button -->
                        <div class="col-4 col-md-2 text-end">
                            <button type="button" class="add-button btn btn-success btn-sm w-100 border-0 rounded-5" style="height: 40px;" data-bs-toggle="modal" data-bs-target="#blogCreateBlogModal">
                                <i class="bi bi-plus-circle"></i> <span class="d-none d-sm-inline">Tambah</span>
                            </button>
                        </div>
                    </div>
                </div>


                <!-- Tab Content -->
                <div class="blog-tab-content pb-5 mb-5 px-2 px-md-4" id="blogOrderTabContent">
                    <!-- All Orders Tab -->
                    <div class="tab-pane fade show active" id="blog-all-orders" role="tabpanel">

                        <!-- Table -->
                        <div class="table-responsive shadow-sm rounded mt-3">
                            <table class="table table-striped table-hover align-middle">
                                <thead class="table-success">
                                    <tr>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Judul</th>
                                        <th scope="col" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($blogs as $b): ?>
                                        <tr>
                                            <td><img src="uploads/<?= $b['img']; ?>" width="80px" alt=""></td>
                                            <td><?= $b['judul']; ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button onclick="openEditModal(
    '<?= $b['id_blog']; ?>', 
    '<?= addslashes($b['judul']); ?>', 
    '<?= addslashes(htmlspecialchars($b['artikel'])); ?>', 
    '<?= $b['img']; ?>'
  )" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#blogEditBlogModal">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" onclick="if(confirm('Yakin ingin menghapus blog ini?')){ window.location.href='index.php?controller=blog&action=delete&id_blog=<?= $b['id_blog']; ?>'; }">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="blogCreateBlogModal" tabindex="-1" aria-labelledby="blogCreateBlogModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg border-0 rounded-4">
                    <!-- Header -->
                    <div class="modal-header bg-success text-white rounded-top-4">
                        <h5 class="modal-title fw-bold" id="blogCreateBlogModalLabel"><i class="bi bi-journal-text me-2"></i> Buat Blog</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="blogCreateBlogForm" method="POST" action="index.php?controller=blog&action=store" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="blogTitle" class="form-label fw-semibold">Judul Blog</label>
                                <input type="text" class="form-control rounded-3" id="blogTitle" name="judul" placeholder="Masukkan judul blog" required>
                            </div>
                            <div class="mb-3">
                                <label for="blogImage" class="form-label fw-semibold">Gambar</label>
                                <input class="form-control rounded-3" type="file" id="blogImage" name="img" accept="image/*" required>
                            </div>
                            <div class="mb-3">
                                <label for="blogContent" class="form-label fw-semibold">Artikel</label>
                                <textarea class="form-control rounded-3" id="blogContent" name="artikel" rows="5" placeholder="Tulis isi blog di sini..." required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" form="blogCreateBlogForm" class="btn btn-success rounded-3">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="blogEditBlogModal" tabindex="-1" aria-labelledby="blogEditBlogModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content shadow-lg border-0 rounded-4">
                    <div class="modal-header bg-success text-white rounded-top-4">
                        <h5 class="modal-title fw-bold" id="blogEditBlogModalLabel"><i class="bi bi-journal-text me-2"></i> Edit Blog</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="blogEditBlogForm" method="POST" action="index.php?controller=blog&action=update" enctype="multipart/form-data">
                            <input type="hidden" name="id_blog" id="blogEditId">
                            <input type="hidden" name="old_img" id="blogEditOldImg">
                            <!-- Judul -->
                            <div class="mb-3">
                                <label for="blogEditTitle" class="form-label fw-semibold">Judul Blog</label>
                                <input type="text" class="form-control rounded-3" name="judul" placeholder="Masukkan judul blog" id="blogEditTitle" required>
                            </div>

                            <!-- Gambar -->
                            <div class="mb-3">
                                <label for="blogEditImage" class="form-label fw-semibold">Gambar</label>
                                <input class="form-control rounded-3" id="blogEditImage" type="file" name="img" accept="image/*">
                            </div>
                            <!-- Isi -->
                            <div class="mb-3">
                                <label for="blogEditContent" class="form-label fw-semibold">Isi Blog</label>
                                <textarea class="form-control rounded-3" name="artikel" id="blogEditContent" rows="5" placeholder="Tulis isi blog di sini..." required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" form="blogEditBlogForm" class="btn btn-success rounded-3">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/profile.js"></script>
<script src="assets/js/script.js"></script>
<script>
    function openEditModal(id, judul, artikel, img) {
        $('#blogEditId').val(id);
        $('#blogEditTitle').val(judul);
        $('#blogEditContent').val(artikel);
        $('#blogEditOldImg').val(img);
    }
</script>

</body>

</html>