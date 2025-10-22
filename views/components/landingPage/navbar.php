<header class="shadow-sm bg-white sticky-top">
    <nav class="navbar navbar-expand-lg border-bottom py-3">
        <div class="container" style="max-width: 1700px">
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

            <div class="d-none d-lg-flex flex-grow-1 mx-5 search-bar">
                <form method="GET" action="index.php" class="w-100">
                    <input type="hidden" name="controller" value="beranda">
                    <input type="hidden" name="action" value="index">

                    <div class="input-group">
                        <input type="text" class="form-control" name="search"
                            placeholder="Search for items..."
                            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        <button class="btn btn-outline-secondary border-start-0" type="submit">
                            <i class="bi bi-search text-custom"></i>
                        </button>
                    </div>
                </form>
            </div>



            <div class="d-flex align-items-center ms-auto">
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="dropdown me-3 me-md-4">
                        <a href="index.php?controller=cart&action=mycart"
                            class="nav-link text-secondary d-flex align-items-center">
                            <i class="bi bi-person-circle fs-5 me-2 text-custom"></i>
                            <span class="d-none d-md-inline small fw-semibold">
                                <?= htmlspecialchars($_SESSION['username']) ?>
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="index.php?controller=auth&action=logout">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>

                    <a href="index.php?controller=cart&action=mycart"
                        class="nav-link text-secondary position-relative me-3 me-md-4">
                        <i class="bi bi-cart-fill fs-5"></i>
                        <span class="d-none d-md-inline small fw-semibold ms-1">Cart</span>
                       
                    </a>
                <?php else: ?>
                    <a href="index.php?controller=auth&action=showLogin"
                        class="nav-link text-secondary d-none d-sm-flex align-items-center me-3 me-md-4">
                        <i class="bi bi-person-circle fs-5 me-2 text-custom"></i>
                        <span class="d-none d-md-inline small fw-semibold">Sign In / Register</span>
                    </a>

                    <a href="index.php?controller=auth&action=showLogin"
                        class="nav-link text-secondary position-relative me-3 me-md-4">
                        <i class="bi bi-cart-fill fs-5"></i>
                        <span class="d-none d-md-inline small fw-semibold ms-1">Cart</span>
                    </a>
                <?php endif; ?>
            </div>

            <button class="btn border-0 d-lg-none p-2" type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar"
                aria-label="Toggle navigation">
                <i class="bi bi-list fs-5"></i>
            </button>
        </div>
    </nav>
    <div class="d-lg-none py-2 px-3 border-bottom">
        <div class="input-group search-bar">
            <input type="text" class="form-control" placeholder="Search for items..." />
            <button class="btn btn-outline-secondary border-start-0" type="button">
                <i class="bi bi-search text-custom"></i>
            </button>
        </div>
    </div>

    <nav class="d-none d-lg-block border-top border-light">
        <div class="container py-3">
            <div class="d-flex align-items-center">
                <a href="#kategori"
                    class="btn btn-custom btn-lg shadow-sm py-2 px-4 rounded-3 d-flex align-items-center">
                    <i class="bi bi-grid-fill me-2"></i>
                    Lihat Semua Kategori
                </a>


                <ul class="nav mx-auto">
                    <li class="nav-item"><a href="index.php?controller=beranda&action=index" class="nav-link text-dark fw-semibold px-3">Beranda</a></li>
                    <li class="nav-item"><a href="#kategori" class="nav-link text-dark fw-semibold px-3">Kategori</a></li>
                    <li class="nav-item dropdown">
                        <a href="#produk" class="nav-link text-dark fw-semibold px-3">Produk</a>
                    </li>
                    <li class="nav-item"><a href="#tentang" class="nav-link text-dark fw-semibold px-3">Tentang Kami</a></li>
                    <li class="nav-item"><a href="#blog" class="nav-link text-dark fw-semibold px-3">Blog</a></li>
                </ul>

                <div class="d-flex align-items-center">
                    <i class="bi bi-telephone-fill fs-4 text-custom me-2"></i>
                    <div class="text-start">
                        <span class="d-block small text-muted">Hubungi Kami</span>
                        <span class="d-block fw-bold text-dark">+62 858-5434-2825</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu Navigasi</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">


            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li class="nav-item"><a href="index.php?controller=beranda&action=index" class="nav-link text-dark fw-semibold px-3">Beranda</a></li>
                <li class="nav-item"><a href="#kategori" class="nav-link text-dark fw-semibold px-3">kategori</a></li>
                <li class="nav-item dropdown">
                    <a href="#produk" class="nav-link text-dark fw-semibold px-3">Produk</a>
                </li>
                <li class="nav-item"><a href="#tentang" class="nav-link text-dark fw-semibold px-3">Tentang Kami</a></li>
                <li class="nav-item"><a href="#blog" class="nav-link text-dark fw-semibold px-3">Blog</a></li>
                <li class="nav-item">
                    <hr class="dropdown-divider" />
                </li>

                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link text-custom fw-semibold" href="index.php?controller=auth&action=logout">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link text-custom fw-semibold" href="index.php?controller=auth&action=showLogin">
                            <i class="bi bi-person-circle me-2"></i> Sign In / Register
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex align-items-center mt-4 pt-3 border-top">
                <i class="bi bi-telephone-fill fs-4 text-custom me-2"></i>
                <div>
                    <span class="d-block small text-muted">Hubungi Kami</span>
                    <span class="d-block fw-bold text-dark">+62 858-5434-2825</span>
                </div>
            </div>
        </div>
    </div>
</header>