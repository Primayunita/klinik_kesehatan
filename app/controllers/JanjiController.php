<?php
// app/controllers/JanjiController.php
require_once __DIR__ . '/../models/JanjiModel.php';
require_once __DIR__ . '/../models/DokterModel.php';
require_once __DIR__ . '/../models/PasienModel.php';

class JanjiController {
    public function list() {
        $q = $_GET['q'] ?? '';
        $page = max(1,(int)($_GET['page'] ?? 1));
        $res = JanjiModel::paginate($q,$page,10);
        require __DIR__ . '/../views/janji/list.php';
    }

    public function create() {
        $dokters = DokterModel::paginate('',1,1000)['data'];
        $pasiens = PasienModel::paginate('',1,1000)['data'];
        require __DIR__ . '/../views/janji/form.php';
    }

    public function store() {
        try {
            JanjiModel::create($_POST);
            header('Location: ?page=janji&action=list');
        } catch(Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
            header('Location: ?page=janji&action=create');
        }
    }

    public function confirm() {
        JanjiModel::confirm($_GET['id']);
        header('Location: ?page=janji&action=list');
    }

    public function delete() {
        JanjiModel::delete($_GET['id']);
        header('Location: ?page=janji&action=list');
    }
}
