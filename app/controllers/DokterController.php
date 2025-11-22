<?php
// app/controllers/DokterController.php
require_once __DIR__ . '/../models/DokterModel.php';

class DokterController {
    public function list() {
        $q = $_GET['q'] ?? '';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $res = DokterModel::paginate($q,$page,10);
        require __DIR__ . '/../views/dokter/list.php';
    }

    public function create() {
        require __DIR__ . '/../views/dokter/form.php';
    }

    public function store() {
        DokterModel::create($_POST);
        header('Location: ?page=dokter&action=list');
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        $item = DokterModel::find($id);
        require __DIR__ . '/../views/dokter/form.php';
    }

    public function update() {
        DokterModel::update($_POST['id'], $_POST);
        header('Location: ?page=dokter&action=list');
    }

    public function delete() {
        DokterModel::softDelete($_GET['id']);
        header('Location: ?page=dokter&action=list');
    }
}
