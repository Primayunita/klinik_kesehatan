<?php
// app/controllers/ObatController.php
require_once __DIR__ . '/../models/ObatModel.php';

class ObatController {
    public function list() {
        $q = $_GET['q'] ?? '';
        $page = max(1,(int)($_GET['page'] ?? 1));
        $res = ObatModel::paginate($q,$page,10);
        require __DIR__ . '/../views/obat/list.php';
    }

    public function create() {
        require __DIR__ . '/../views/obat/form.php';
    }

    public function store() {
        ObatModel::create($_POST);
        header('Location: ?page=obat&action=list');
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        $item = ObatModel::find($id);
        require __DIR__ . '/../views/obat/form.php';
    }

    public function update() {
        ObatModel::update($_POST['id'], $_POST);
        header('Location: ?page=obat&action=list');
    }

    public function delete() {
        ObatModel::softDelete($_GET['id']);
        header('Location: ?page=obat&action=list');
    }

    public function export_csv() {
        // simple export
        $rows = ObatModel::all();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="obat_export.csv"');
        $out = fopen('php://output','w');
        fputcsv($out,['id_obat','nama','stok','harga']);
        foreach($rows as $r) fputcsv($out, [$r['id_obat'],$r['nama'],$r['stok'],$r['harga']]);
        fclose($out);
        exit;
    }
}
