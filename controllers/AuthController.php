<?php
require_once(__DIR__ . '/../models/User.php');

class AuthController
{
    private $userModel;

    public function __construct($conn)
    {
        $this->userModel = new User($conn);
    }

    public function showLogin()
    {
        require_once(__DIR__ . '/../views/auth/login.php');
    }

    public function showRegister()
    {
        require_once(__DIR__ . '/../views/auth/register.php');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($email) || empty($password)) {
                header("Location: index.php?controller=auth&action=showRegister&status=error");
                exit;
            }

            $existing = $this->userModel->findByEmail($email);
            if ($existing) {
                header("Location: index.php?controller=auth&action=showRegister&status=error");
                exit;
            }

            $created = $this->userModel->create([
                'username' => $username,
                'email'    => $email,
                'password' => $password,
                'role'     => 'pengunjung'
            ]);

            if ($created) {
                header("Location: index.php?controller=auth&action=showLogin&status=success");
            } else {
                header("Location: index.php?controller=auth&action=showRegister&status=error");
            }
            exit;
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id']  = $user['kode_user'];
                $_SESSION['role']     = $user['role'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];

                // Admin -> dashboard
                if ($user['role'] === 'admin') {
                    header("Location: index.php?controller=dashboard&action=beranda&status=success");
                } else {
                    // Pengunjung -> landing page
                    header("Location: index.php?controller=landing&action=beranda&status=success");
                }
                exit;
            } else {
                header("Location: index.php?controller=auth&action=showLogin&status=error");
                exit;
            }
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: index.php?controller=landing&action=beranda&status=success");
        exit;
    }
}
