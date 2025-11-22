<?php require __DIR__ . '/../layout/header.php'; ?>
<h2>Data Dokter</h2>
<a href="?page=dokter&action=create">Tambah Dokter</a>
<form method="get" action="?">
<input type="hidden" name="page" value="dokter"><input type="hidden" name="action" value="list">
<input name="q" value="<?=htmlspecialchars($_GET['q']??'')?>" placeholder="Cari dokter" oninput="this.form.submit()">
</form>
<table border="1">
<tr><th>ID</th><th>Nama</th><th>Spesialis</th><th>Aksi</th></tr>
<?php foreach($res['data'] as $r): ?>
<tr>
<td><?=$r['id_dokter']?></td>
<td><?=$r['nama']?></td>
<td><?=$r['spesialisasi']?></td>
<td><a href="?page=dokter&action=edit&id=<?=$r['id_dokter']?>">Edit</a> | <a href="?page=dokter&action=delete&id=<?=$r['id_dokter']?>" onclick="return confirm('Hapus?')">Hapus</a></td>
</tr>
<?php endforeach; ?>
</table>
<?php require __DIR__ . '/../layout/footer.php'; ?>
