<?php require __DIR__ . '/../layout/header.php'; ?>
<div class="container">
<h2>Data Pasien</h2>
<a href="?page=pasien&action=create">Tambah Pasien</a>
<form method="get" action="?">
    <input type="hidden" name="page" value="pasien">
    <input type="hidden" name="action" value="list">
    <input type="text" name="q" placeholder="Cari nama/alamat" value="<?= htmlspecialchars($_GET['q']??'') ?>" oninput="this.form.submit()">
</form>
<table border="1" cellpadding="5">
<tr><th>ID</th><th>Nama</th><th>Tgl Lahir</th><th>Alergi</th><th>Kontak</th><th>Aksi</th></tr>
<?php foreach($result['data'] as $r): ?>
<tr>
  <td><?= htmlspecialchars($r['id_pasien']) ?></td>
  <td><?= htmlspecialchars($r['nama_pasien']) ?></td>
  <td><?= htmlspecialchars($r['tanggal_lahir']) ?></td>
  <td><?= htmlspecialchars($r['alergi']) ?></td>
  <td><?= htmlspecialchars($r['kontak_darurat']) ?></td>
  <td>
    <a href="?page=pasien&action=edit&id=<?= $r['id_pasien'] ?>">Edit</a> |
    <a href="#" onclick="if(confirm('Hapus?'))location='?page=pasien&action=delete&id=<?= $r['id_pasien'] ?>'">Hapus</a>
  </td>
</tr>
<?php endforeach; ?>
</table>

<?php
$totalPages = ceil($result['total']/$result['perPage']);
for($p=1;$p<=$totalPages;$p++){
    echo "<a href='?page=pasien&action=list&page=$p'>".$p."</a> ";
}
?>
</div>
<?php require __DIR__ . '/../layout/footer.php'; ?>
