<?php
// app/controllers/PasienController.php
require_once __DIR__ . '/../models/PasienModel.php';

class PasienController {
    public function list() {
        $q = $_GET['q'] ?? '';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 10;
        $result = PasienModel::paginate($q, $page, $perPage);
        require __DIR__ . '/../views/pasien/list.php';
    }

    public function create() {
        require __DIR__ . '/../views/pasien/form.php';
    }

    public function store() {
        // basic server-side validation
        $nama = trim($_POST['nama'] ?? '');
        if ($nama === '') {
            $_SESSION['flash_error'] = "Nama wajib diisi";
            header('Location: ?page=pasien&action=create');
            exit;
        }
        PasienModel::create($_POST);
        header('Location: ?page=pasien&action=list');
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        $item = PasienModel::find($id);
        require __DIR__ . '/../views/pasien/form.php';
    }

    public function update() {
        $id = $_POST['id'] ?? null;
        PasienModel::update($id, $_POST);
        header('Location: ?page=pasien&action=list');
    }

    public function delete() {
        $id = $_GET['id'] ?? null;
        PasienModel::softDelete($id);
        header('Location: ?page=pasien&action=list');
    }
}
