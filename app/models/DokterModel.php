<?php
// app/models/DokterModel.php
require_once __DIR__ . '/../db.php';

class DokterModel {
    public static function paginate($q,$page,$perPage) {
        global $db;
        $offset = ($page-1)*$perPage;
        if ($q) {
            $sql = "SELECT * FROM dokter WHERE (nama ILIKE :q OR spesialisasi ILIKE :q) AND deleted_at IS NULL ORDER BY id_dokter DESC LIMIT :l OFFSET :o";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':q','%'.$q.'%');
        } else {
            $sql = "SELECT * FROM dokter WHERE deleted_at IS NULL ORDER BY id_dokter DESC LIMIT :l OFFSET :o";
            $stmt = $db->prepare($sql);
        }
        $stmt->bindValue(':l',$perPage,PDO::PARAM_INT);
        $stmt->bindValue(':o',$offset,PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cSql = $q ? "SELECT count(*) FROM dokter WHERE (nama ILIKE :q OR spesialisasi ILIKE :q) AND deleted_at IS NULL" : "SELECT count(*) FROM dokter WHERE deleted_at IS NULL";
        $c = $db->prepare($cSql);
        if ($q) $c->bindValue(':q','%'.$q.'%');
        $c->execute();
        $total = (int)$c->fetchColumn();

        return ['data'=>$data,'total'=>$total,'page'=>$page,'perPage'=>$perPage];
    }

    public static function create($d) {
        global $db;
        $stmt = $db->prepare("INSERT INTO dokter (nama, spesialisasi, no_hp, email) VALUES (:nama,:spes,:hp,:email)");
        $stmt->execute([
            ':nama'=>$d['nama'] ?? '',
            ':spes'=>$d['spesialisasi'] ?? '',
            ':hp'=>$d['no_hp'] ?? '',
            ':email'=>$d['email'] ?? ''
        ]);
    }

    public static function find($id) {
        global $db;
        $s = $db->prepare("SELECT * FROM dokter WHERE id_dokter = :id");
        $s->execute([':id'=>$id]);
        return $s->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id,$d) {
        global $db;
        $stmt = $db->prepare("UPDATE dokter SET nama=:nama, spesialisasi=:spes, no_hp=:hp, email=:email WHERE id_dokter = :id");
        $stmt->execute([
            ':nama'=>$d['nama'] ?? '',
            ':spes'=>$d['spesialisasi'] ?? '',
            ':hp'=>$d['no_hp'] ?? '',
            ':email'=>$d['email'] ?? '',
            ':id'=>$id
        ]);
    }

    public static function softDelete($id) {
        global $db;
        $stmt = $db->prepare("UPDATE dokter SET deleted_at = now() WHERE id_dokter = :id");
        $stmt->execute([':id'=>$id]);
    }
}
