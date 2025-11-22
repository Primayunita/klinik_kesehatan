<?php
// app/models/ObatModel.php
require_once __DIR__ . '/../db.php';

class ObatModel {
    public static function paginate($q,$page,$perPage) {
        global $db;
        $offset = ($page-1)*$perPage;
        if ($q) {
            $sql = "SELECT * FROM obat WHERE nama ILIKE :q AND deleted_at IS NULL ORDER BY id_obat DESC LIMIT :l OFFSET :o";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':q','%'.$q.'%');
        } else {
            $sql = "SELECT * FROM obat WHERE deleted_at IS NULL ORDER BY id_obat DESC LIMIT :l OFFSET :o";
            $stmt = $db->prepare($sql);
        }
        $stmt->bindValue(':l',$perPage,PDO::PARAM_INT);
        $stmt->bindValue(':o',$offset,PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $cSql = $q ? "SELECT count(*) FROM obat WHERE nama ILIKE :q AND deleted_at IS NULL" : "SELECT count(*) FROM obat WHERE deleted_at IS NULL";
        $c = $db->prepare($cSql);
        if ($q) $c->bindValue(':q','%'.$q.'%');
        $c->execute();
        $total = (int)$c->fetchColumn();

        return ['data'=>$data,'total'=>$total,'page'=>$page,'perPage'=>$perPage];
    }

    public static function create($d) {
        global $db;
        $stmt = $db->prepare("INSERT INTO obat (nama, stok, harga) VALUES (:nama,:stok,:harga)");
        $stmt->execute([
            ':nama'=>$d['nama'] ?? '',
            ':stok'=>intval($d['stok'] ?? 0),
            ':harga'=>floatval($d['harga'] ?? 0)
        ]);
    }

    public static function find($id) {
        global $db;
        $s = $db->prepare("SELECT * FROM obat WHERE id_obat = :id");
        $s->execute([':id'=>$id]);
        return $s->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id,$d) {
        global $db;
        $stmt = $db->prepare("UPDATE obat SET nama=:nama, stok=:stok, harga=:harga WHERE id_obat = :id");
        $stmt->execute([
            ':nama'=>$d['nama'] ?? '',
            ':stok'=>intval($d['stok'] ?? 0),
            ':harga'=>floatval($d['harga'] ?? 0),
            ':id'=>$id
        ]);
    }

    public static function softDelete($id) {
        global $db;
        $stmt = $db->prepare("UPDATE obat SET deleted_at = now() WHERE id_obat = :id");
        $stmt->execute([':id'=>$id]);
    }

    public static function all() {
        global $db;
        $s = $db->query("SELECT id_obat, nama, stok, harga FROM obat WHERE deleted_at IS NULL ORDER BY id_obat");
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }
}
