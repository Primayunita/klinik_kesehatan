<?php
// app/models/ReportModel.php
require_once __DIR__ . '/../db.php';

class ReportModel {
    protected $pdo;
    public function __construct() { global $db; $this->pdo = $db; }

    public function refreshMaterialized() {
        try {
            // use CONCURRENTLY only if matview has unique index - else use plain REFRESH
            $this->pdo->exec("REFRESH MATERIALIZED VIEW CONCURRENTLY mv_top_diseases");
            return "Materialized view refreshed (CONCURRENTLY).";
        } catch (PDOException $e) {
            // fallback to non-concurrent
            $this->pdo->exec("REFRESH MATERIALIZED VIEW mv_top_diseases");
            return "Refreshed (non-concurrent).";
        }
    }

    public function explainQuery($withIndex = true) {
        // create/drop index for demo
        if ($withIndex) {
            $this->pdo->exec("CREATE INDEX IF NOT EXISTS idx_rekam_diagnosis ON rekam_medis USING btree (diagnosis)");
        } else {
            @$this->pdo->exec("DROP INDEX IF EXISTS idx_rekam_diagnosis");
        }
        $sql = "EXPLAIN ANALYZE SELECT diagnosis, count(*) FROM rekam_medis GROUP BY diagnosis ORDER BY count(*) DESC LIMIT 5";
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return implode("\\n", $rows);
    }

    public function transactionDemo() {
        try {
            $this->pdo->beginTransaction();
            // example: decrement obat stok for id_obat=1
            $this->pdo->exec("UPDATE obat SET stok = stok - 1 WHERE id_obat = 1");
            // force failure optional: uncomment to test rollback
            // $this->pdo->exec(\"INSERT INTO non_existing_table (x) VALUES (1)\");
            $this->pdo->commit();
            return "Transaction committed.";
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return "Transaction failed: " . $e->getMessage();
        }
    }

    public function callRegisterVisit($id_pasien, $id_dokter, $tanggal, $waktu) {
        // example stored procedure sp_register_visit(p_pasien integer, p_dokter integer, p_tanggal date, p_waktu time, OUT out_id integer)
        $stmt = $this->pdo->prepare("CALL sp_register_visit(:p_pasien,:p_dokter,:p_tanggal,:p_waktu, :out_id)");
        // PostgreSQL CALL with OUT param not directly available; use DO block or SELECT sp(...) if function
        // We'll illustrate using a function version get_registered_id(...)
        try {
            $fs = $this->pdo->prepare("SELECT sp_register_visit_return_id(:p_pasien,:p_dokter,:p_tanggal,:p_waktu) as out_id");
            $fs->execute([':p_pasien'=>$id_pasien,':p_dokter'=>$id_dokter,':p_tanggal'=>$tanggal,':p_waktu'=>$waktu]);
            return $fs->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['error'=>$e->getMessage()];
        }
    }

    public function getLaporanKunjunganPerDokter() {
        $sql = "SELECT * FROM laporan_klinik ORDER BY jumlah_kunjungan DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMaterializedTopDiseases($limit=10) {
        $stmt = $this->pdo->prepare("SELECT * FROM mv_top_diseases LIMIT :l");
        $stmt->bindValue(':l', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
