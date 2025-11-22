<?php

class HomeController {

    public function index() {
        if (!isset($_SESSION['user'])) {
            header("Location: ?page=auth");
            exit;
        }

        require "../app/views/home/dashboard.php";
    }
}
