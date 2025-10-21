<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SkaFarm - Registrasi Akun</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" crossorigin="anonymous" />

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");

    body {
      font-family: "Inter", sans-serif;
      background-color: #fffbea;
    }

    .card-custom {
      border-radius: 2.5rem !important;
      box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      max-width: 960px;
      width: 100%;
      overflow: hidden;
    }

    .right-col-bg {
      background-image: linear-gradient(to bottom,
          rgba(0, 0, 0, 0.2),
          rgba(0, 0, 0, 0.7)),
        url("assets/images/reg.jpg");
      background-size: cover;
      background-position: center;
      height: 250px;
      border-radius: inherit;
    }

    .btn-primary-custom {
      background-color: #16a34a;
      border-color: #16a34a;
      transition: background-color 0.3s;
    }

    .btn-primary-custom:hover {
      background-color: #15803d;
      border-color: #15803d;
    }

    @media (min-width: 768px) {
      .card-custom {
        height: 650px;
      }

      .right-col-bg {
        height: 100%;
        border-radius: 0 2.5rem 2.5rem 0 !important;
      }

      .left-col-form {
        border-radius: 2.5rem 0 0 2.5rem !important;
      }
    }
  </style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100 p-3 p-md-4">
  <div class="card-custom bg-white d-flex flex-column flex-md-row">
    <div class="col-md-6 p-4 p-md-5 d-flex flex-column justify-content-center left-col-form">
      <h2 class="h3 fw-bold mb-2">Daftar Akun</h2>
      <p class="text-secondary mb-4">
        Buat akun baru untuk bergabung di ekosistem digital pertanian SkaFarm.
      </p>



      <form method="POST" action="index.php?controller=auth&action=register">
        <?php if (!empty($_GET['status'])): ?>
          <?php if ($_GET['status'] === 'error'): ?>
            <div class="alert alert-danger">Username / Email Sudah Tersedia.</div>
          <?php elseif ($_GET['status'] === 'success'): ?>
            <div class="alert alert-success">Operasi berhasil dilakukan.</div>
          <?php endif; ?>
        <?php endif; ?>

        <div class="mb-3">
          <label for="username" class="form-label fw-medium">Username</label>
          <input type="text" class="form-control form-control-lg rounded-3"
            name="username" id="username" placeholder="usernameunik" required />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label fw-medium">Email</label>
          <input type="email" class="form-control form-control-lg rounded-3"
            name="email" id="email" placeholder="user@skafarm.com" required />
        </div>
        <div class="mb-4">
          <label for="password" class="form-label fw-medium">Password</label>
          <input type="password" class="form-control form-control-lg rounded-3"
            name="password" id="password" placeholder="••••••••••" required />
        </div>

        <button type="submit"
          class="text-light btn btn-primary-custom btn-lg w-100 fw-semibold rounded-3">
          Daftar Sekarang
        </button>
      </form>

      <p class="text-center mt-4 mb-0">
        Sudah punya akun?
        <a href="index.php?controller=auth&action=showLogin"
          class="fw-semibold text-success text-decoration-none">
          Masuk sekarang
        </a>
      </p>
    </div>
    <div class="col-md-6 position-relative text-white right-col-bg d-flex align-items-center justify-content-center p-5">
      <div class="position-relative z-1 text-start">
        <h1 class="display-5 fw-bold lh-sm">
          Bergabunglah dengan <span style="color: #bbf7d0">SkaFarm</span><br />
          Masa Depan Pertanian Pintar
        </h1>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
</body>

</html>