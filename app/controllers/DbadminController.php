<?php
// app/controllers/DbadminController.php
require_once __DIR__ . '/../models/ReportModel.php';

class DbadminController {
    public function refresh_matview() {
        $rm = new ReportModel();
        $msg = $rm->refreshMaterialized();
        require __DIR__ . '/../views/matview/list.php';
    }

    public function explain_index_demo() {
        $rm = new ReportModel();
        $before = $rm->explainQuery(false);
        $after = $rm->explainQuery(true);
        require __DIR__ . '/../views/admin/explain.php';
    }

    public function transaction_demo() {
        $rm = new ReportModel();
        $msg = $rm->transactionDemo();
        echo "<pre>" . htmlspecialchars($msg) . "</pre>";
    }

    public function call_stored_proc() {
        // example call: sp_register_visit
        $rm = new ReportModel();
        $out = $rm->callRegisterVisit($_POST['id_pasien'], $_POST['id_dokter'], $_POST['tanggal'], $_POST['waktu']);
        echo "<pre>" . print_r($out, true) . "</pre>";
    }
}
