<?php
session_start();
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm = trim($_POST['confirm_password']);

            if ($password !== $confirm) {
                $_SESSION['error'] = "Passwords do not match!";
                header("Location: ../public/register.php");
                exit;
            }

            if ($this->userModel->register($username, $email, $password)) {
                $_SESSION['success'] = "Registration successful!";
                header("Location: ../public/login.php");
                exit;
            } else {
                $_SESSION['error'] = "Registration failed. Try again.";
                header("Location: ../public/register.php");
                exit;
            }
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = $this->userModel->login($email, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['success'] = "Welcome, " . htmlspecialchars($user['username']) . "!";
                header("Location: ../public/index.php");
                exit;
            } else {
                $_SESSION['error'] = "Incorrect email or password!";
                header("Location: ../public/login.php");
                exit;
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: ../public/login.php");
        exit;
    }
}
