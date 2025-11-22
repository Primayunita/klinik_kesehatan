<?php
// app/models/PasienModel.php
require_once __DIR__ . '/../db.php';

class PasienModel {
    public static function paginate($q, $page, $perPage) {
        global $db;
        $offset = ($page-1)*$perPage;
        if ($q) {
            $sql = "SELECT * FROM pasien WHERE (nama_pasien ILIKE :q OR alamat ILIKE :q) AND deleted_at IS NULL ORDER BY id_pasien DESC LIMIT :l OFFSET :o";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':q', '%'.$q.'%');
        } else {
            $sql = "SELECT * FROM pasien WHERE deleted_at IS NULL ORDER BY id_pasien DESC LIMIT :l OFFSET :o";
            $stmt = $db->prepare($sql);
        }
        $stmt->bindValue(':l', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':o', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $countSql = $q ? "SELECT count(*) FROM pasien WHERE (nama_pasien ILIKE :q OR alamat ILIKE :q) AND deleted_at IS NULL" : "SELECT count(*) FROM pasien WHERE deleted_at IS NULL";
        $cstmt = $db->prepare($countSql);
        if ($q) $cstmt->bindValue(':q', '%'.$q.'%');
        $cstmt->execute();
        $total = (int)$cstmt->fetchColumn();

        return ['data'=>$data,'total'=>$total,'page'=>$page,'perPage'=>$perPage];
    }

    public static function create($d) {
        global $db;
        $sql = "INSERT INTO pasien (nama_pasien, tanggal_lahir, alergi, kontak_darurat, alamat, no_hp) VALUES (:nama, :tgl, :alergi, :kontak, :alamat, :hp)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':nama'=>$d['nama_pasien'] ?? $d['nama'] ?? '',
            ':tgl'=>$d['tanggal_lahir'] ?? null,
            ':alergi'=>$d['alergi'] ?? null,
            ':kontak'=>$d['kontak_darurat'] ?? null,
            ':alamat'=>$d['alamat'] ?? null,
            ':hp'=>$d['no_hp'] ?? null
        ]);
    }

    public static function find($id) {
        global $db;
        $stmt = $db->prepare("SELECT * FROM pasien WHERE id_pasien = :id");
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($id, $d) {
        global $db;
        $sql = "UPDATE pasien SET nama_pasien=:nama, tanggal_lahir=:tgl, alergi=:alergi, kontak_darurat=:kontak, alamat=:alamat, no_hp=:hp WHERE id_pasien = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':nama'=>$d['nama_pasien'] ?? $d['nama'] ?? '',
            ':tgl'=>$d['tanggal_lahir'] ?? null,
            ':alergi'=>$d['alergi'] ?? null,
            ':kontak'=>$d['kontak_darurat'] ?? null,
            ':alamat'=>$d['alamat'] ?? null,
            ':hp'=>$d['no_hp'] ?? null,
            ':id'=>$id
        ]);
    }

    public static function softDelete($id) {
        global $db;
        $stmt = $db->prepare("UPDATE pasien SET deleted_at = now() WHERE id_pasien = :id");
        $stmt->execute([':id'=>$id]);
    }
}
