<?php
// app/models/RekamModel.php
require_once __DIR__ . '/../db.php';

class RekamModel {
    public static function paginate($q,$page,$perPage) {
        global $db;
        $offset = ($page-1)*$perPage;
        if ($q) {
            $sql = "SELECT r.*, p.nama_pasien, d.nama AS nama_dokter
                    FROM rekam_medis r
                    JOIN pasien p ON r.id_pasien = p.id_pasien
                    JOIN dokter d ON r.id_dokter = d.id_dokter
                    WHERE (p.nama_pasien ILIKE :q OR r.diagnosis ILIKE :q)
                    ORDER BY r.tanggal DESC LIMIT :l OFFSET :o";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':q','%'.$q.'%');
        } else {
            $sql = "SELECT r.*, p.nama_pasien, d.nama AS nama_dokter
                    FROM rekam_medis r
                    JOIN pasien p ON r.id_pasien = p.id_pasien
                    JOIN dokter d ON r.id_dokter = d.id_dokter
                    ORDER BY r.tanggal DESC LIMIT :l OFFSET :o";
            $stmt = $db->prepare($sql);
        }
        $stmt->bindValue(':l',$perPage,PDO::PARAM_INT);
        $stmt->bindValue(':o',$offset,PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cSql = $q ? "SELECT count(*) FROM rekam_medis r JOIN pasien p ON r.id_pasien=p.id_pasien JOIN dokter d ON r.id_dokter=d.id_dokter WHERE (p.nama_pasien ILIKE :q OR r.diagnosis ILIKE :q)" : "SELECT count(*) FROM rekam_medis";
        $c = $db->prepare($cSql);
        if ($q) $c->bindValue(':q','%'.$q.'%');
        $c->execute();
        $total = (int)$c->fetchColumn();

        return ['data'=>$data,'total'=>$total,'page'=>$page,'perPage'=>$perPage];
    }

    public static function createWithTransaction($d) {
        global $db;
        try {
            $db->beginTransaction();
            $stmt = $db->prepare("INSERT INTO rekam_medis (id_pasien, id_dokter, tanggal, diagnosis, tindakan, resep) VALUES (:pas, :dok, :tgl, :diag, :tind, :resep)");
            $stmt->execute([
                ':pas'=>intval($d['id_pasien']),
                ':dok'=>intval($d['id_dokter']),
                ':tgl'=>$d['tanggal'],
                ':diag'=>$d['diagnosis'],
                ':tind'=>$d['tindakan'] ?? null,
                ':resep'=>$d['resep'] ?? null
            ]);
            // if obat prescribed, reduce stok
            if (!empty($d['id_obat'])) {
                $qty = max(1, intval($d['qty'] ?? 1));
                $u = $db->prepare("UPDATE obat SET stok = stok - :qty WHERE id_obat = :id AND stok >= :qty");
                $u->execute([':qty'=>$qty, ':id'=>intval($d['id_obat'])]);
                if ($u->rowCount() === 0) {
                    throw new Exception('Stok obat tidak mencukupi atau obat tidak ditemukan.');
                }
            }
            $db->commit();
        } catch (Exception $e) {
            $db->rollBack();
            throw $e;
        }
    }
}
