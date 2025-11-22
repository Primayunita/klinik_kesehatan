<?php

require_once "../app/models/UserModel.php";

class AuthController {

    public function index() {
        require "../app/views/auth/login.php";
    }

    public function login() {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $data = UserModel::find($user, $pass);

        if ($data) {
            $_SESSION["user"] = $data;
            header("Location: " . BASE_URL);
        } else {
            echo "Login gagal!";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: " . BASE_URL . "?page=auth");
    }
}
