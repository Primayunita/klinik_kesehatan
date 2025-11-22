<?php
// app/controllers/RekamController.php
require_once __DIR__ . '/../models/RekamModel.php';
require_once __DIR__ . '/../models/PasienModel.php';
require_once __DIR__ . '/../models/DokterModel.php';
require_once __DIR__ . '/../models/ObatModel.php';

class RekamController {
    public function list() {
        $q = $_GET['q'] ?? '';
        $page = max(1,(int)($_GET['page'] ?? 1));
        $res = RekamModel::paginate($q,$page,10);
        require __DIR__ . '/../views/rekam/list.php';
    }

    public function create() {
        $pasiens = PasienModel::paginate('',1,1000)['data'];
        $dokters = DokterModel::paginate('',1,1000)['data'];
        $obats = ObatModel::paginate('',1,1000)['data'];
        require __DIR__ . '/../views/rekam/form.php';
    }

    public function store() {
        try {
            RekamModel::createWithTransaction($_POST);
            header('Location: ?page=rekam&action=list');
        } catch (Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
            header('Location: ?page=rekam&action=create');
        }
    }
}
