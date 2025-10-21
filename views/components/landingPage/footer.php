  <footer class="w-100">
      <div class="footer-top-bar">
          <div class="footer-container">
              <div class="d-flex justify-content-center overflow-auto">
                  <div class="top-item me-4">
                      <i class="bi bi-asterisk"></i> Barang Berkualitas
                  </div>
                  <div class="top-item me-4">
                      <i class="bi bi-asterisk"></i> Harga Bersaing
                  </div>
                  <div class="top-item me-4">
                      <i class="bi bi-asterisk"></i> Produk Pertanian Modern
                  </div>
                  <div class="top-item me-4">
                      <i class="bi bi-asterisk"></i> Pengiriman Cepat
                  </div>
                  <div class="top-item me-4">
                      <i class="bi bi-asterisk"></i> Layanan Pelanggan 24/7
                  </div>

              </div>
          </div>
      </div>

      <div class="footer-main">
          <div class="footer-container">
              <div class="row pb-5">
                  <div class="col-lg-4 col-md-12 mb-4">
                      <div class="d-flex align-items-center mb-3">
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
                      <p class="footer-text pe-lg-5">
                          Platform terdepan untuk solusi pertanian cerdas, membantu Anda
                          mengoptimalkan hasil panen dengan teknologi terbaru.
                      </p>
                      <div class="mt-4">
                          <a href="https://www.facebook.com/google" class="social-icon"><i class="bi bi-facebook"></i></a>
                          <a href="https://x.com/google" class="social-icon"><i class="bi bi-twitter"></i></a>
                          <a href="https://wa.me/6281234567890" class="social-icon"><i class="bi bi-whatsapp"></i></a>
                          <a href="https://www.instagram.com/google" class="social-icon"><i class="bi bi-instagram"></i></a>
                          <a href="https://www.youtube.com/@Google" class="social-icon"><i class="bi bi-youtube"></i></a>
                      </div>
                  </div>

                  <div class="col-lg-2 col-md-3 col-6 mb-4">
                      <p class="footer-link-title">Company</p>
                      <ul class="footer-link-list">
                          <li><a href="index.php?controller=beranda&action=index">Home</a></li>
                          <li><a href="#kategori">Kategori</a></li>
                          <li><a href="#produk">Produk</a></li>
                          <li><a href="#tentang">Tentang Kami</a></li>
                          <li><a href="#blog">Blog</a></li>
                      </ul>
                  </div>

                  <div class="col-lg-3 col-md-4 col-6 mb-4 footer-col-contact">
                      <p class="footer-link-title">Contact</p>
                      <ul class="footer-link-list">
                          <li><i class="bi bi-telephone"></i> +62-21-987-654</li>
                          <li><i class="bi bi-envelope"></i> info@smartfarm.com</li>
                          <li class="mt-3">
                              <i class="bi bi-geo-alt"></i> Jl. Pertanian No. 123<br />Jakarta,
                              Indonesia 12345
                          </li>
                      </ul>
                  </div>

                  <div class="col-lg-3 col-md-5 mb-4 footer-col-subscribe">
                      <p class="footer-link-title">Dapatkan Info Terbaru</p>
                      <div class="input-group email-input-group">
                          <input type="email" class="form-control" placeholder="Email address" aria-label="Email address" id="emailInput" />
                          <button class="btn" type="button" id="subscribeBtn">
                              <i class="bi bi-arrow-right-short fs-4"></i>
                          </button>
                      </div>
                  </div>
              </div>

              <div class="footer-bottom-bar">
                  <div class="row">
                      <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                          Copyright © 2025
                          <span style="color: var(--color-secondary); font-weight: 600">Skafarm</span>. All Rights Reserved.
                      </div>
                      <div class="col-md-6 text-center text-md-end">
                          <a href="#" class="me-3">Syarat & Ketentuan</a> |
                          <a href="#" class="ms-3">Kebijakan Privasi</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/assets/js/profile.js"></script>

  <script>
      $(function() {
          $('#subscribeBtn').on('click', function() {
              const email = $('#emailInput').val();
              const subject = "Langganan Info Skafarm";
              const body = email ? `Halo, saya ingin berlangganan dengan email: ${email}` : "Halo, saya ingin berlangganan info terbaru.";
              window.location.href = `mailto:skafarm@gmail.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
          });
      });
      
    $(document).ready(function () {
        $(".star").on("click", function () {
            let val = $(this).data("value");
            $("#rating").val(val);
            $(".star").removeClass("selected");
            $(this).prevAll().addBack().addClass("selected");
        });
    });
  </script>

  </body>

  </html>