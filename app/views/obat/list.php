<?php require __DIR__ . '/../layout/header.php'; ?>
<h2>Data Obat</h2>
<a href="?page=obat&action=create">Tambah Obat</a> | <a href="?page=obat&action=export_csv">Export CSV</a>
<form method="get" action="?"><input type="hidden" name="page" value="obat"><input type="hidden" name="action" value="list"><input name="q" oninput="this.form.submit()" value="<?=htmlspecialchars($_GET['q']??'')?>"></form>
<table border="1"><tr><th>ID</th><th>Nama</th><th>Stok</th><th>Harga</th><th>Aksi</th></tr>
<?php foreach($res['data'] as $r): ?>
<tr><td><?=$r['id_obat']?></td><td><?=$r['nama']?></td><td><?=$r['stok']?></td><td><?=$r['harga']?></td>
<td><a href="?page=obat&action=edit&id=<?=$r['id_obat']?>">Edit</a> | <a href="?page=obat&action=delete&id=<?=$r['id_obat']?>" onclick="return confirm('Hapus?')">Hapus</a></td></tr>
<?php endforeach; ?>
</table>
<?php require __DIR__ . '/../layout/footer.php'; ?>
