<?php
// app/models/JanjiModel.php
require_once __DIR__ . '/../db.php';

class JanjiModel {
    public static function paginate($q,$page,$perPage) {
        global $db;
        $offset = ($page-1)*$perPage;
        if ($q) {
            $sql = "SELECT j.*, p.nama_pasien, d.nama as nama_dokter
                    FROM janji_temu j
                    JOIN pasien p ON j.id_pasien = p.id_pasien
                    JOIN dokter d ON j.id_dokter = d.id_dokter
                    WHERE (p.nama_pasien ILIKE :q OR d.nama ILIKE :q) ORDER BY j.tanggal DESC LIMIT :l OFFSET :o";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':q','%'.$q.'%');
        } else {
            $sql = "SELECT j.*, p.nama_pasien, d.nama as nama_dokter
                    FROM janji_temu j
                    JOIN pasien p ON j.id_pasien = p.id_pasien
                    JOIN dokter d ON j.id_dokter = d.id_dokter
                    ORDER BY j.tanggal DESC LIMIT :l OFFSET :o";
            $stmt = $db->prepare($sql);
        }
        $stmt->bindValue(':l',$perPage,PDO::PARAM_INT);
        $stmt->bindValue(':o',$offset,PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countSql = $q ? "SELECT count(*) FROM janji_temu j JOIN pasien p ON j.id_pasien=p.id_pasien JOIN dokter d ON j.id_dokter=d.id_dokter WHERE (p.nama_pasien ILIKE :q OR d.nama ILIKE :q)" : "SELECT count(*) FROM janji_temu";
        $c = $db->prepare($countSql);
        if ($q) $c->bindValue(':q','%'.$q.'%');
        $c->execute();
        $total = (int)$c->fetchColumn();

        return ['data'=>$data,'total'=>$total,'page'=>$page,'perPage'=>$perPage];
    }

    public static function create($d) {
        global $db;
        // business rule: no overlapping booking for same dokter at same datetime
        $chk = $db->prepare("SELECT count(*) FROM janji_temu WHERE id_dokter = :dok AND tanggal = :tgl AND waktu = :waktu AND status <> 'cancelled'");
        $chk->execute([':dok'=>intval($d['id_dokter']), ':tgl'=>$d['tanggal'], ':waktu'=>$d['waktu']]);
        if ((int)$chk->fetchColumn() > 0) {
            throw new Exception('Dokter sudah memiliki janji pada waktu tersebut.');
        }
        $stmt = $db->prepare("INSERT INTO janji_temu (id_pasien, id_dokter, tanggal, waktu, status, catatan) VALUES (:pas, :dok, :tgl, :wkt, 'booked', :cat)");
        $stmt->execute([
            ':pas'=>intval($d['id_pasien']),
            ':dok'=>intval($d['id_dokter']),
            ':tgl'=>$d['tanggal'],
            ':wkt'=>$d['waktu'],
            ':cat'=>($d['catatan'] ?? '')
        ]);
    }

    public static function confirm($id) {
        global $db;
        $s = $db->prepare("UPDATE janji_temu SET status='confirmed' WHERE id_janji = :id");
        $s->execute([':id'=>$id]);
    }

    public static function delete($id) {
        global $db;
        $s = $db->prepare("DELETE FROM janji_temu WHERE id_janji = :id");
        $s->execute([':id'=>$id]);
    }
}
