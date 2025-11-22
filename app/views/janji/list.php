<?php require __DIR__ . '/../layout/header.php'; ?>
<h2>Janji Temu</h2>
<a href="?page=janji&action=create">Buat Janji</a>
<form method="get" action="?"><input type="hidden" name="page" value="janji"><input type="hidden" name="action" value="list"><input name="q" oninput="this.form.submit()" value="<?=htmlspecialchars($_GET['q']??'')?>"></form>
<table border="1"><tr><th>ID</th><th>Pasien</th><th>Dokter</th><th>Tanggal</th><th>Waktu</th><th>Status</th><th>Aksi</th></tr>
<?php foreach($res['data'] as $r): ?>
<tr><td><?=$r['id_janji']?></td><td><?=$r['nama_pasien']?></td><td><?=$r['nama_dokter']?></td><td><?=$r['tanggal']?></td><td><?=$r['waktu']?></td><td><?=$r['status']?></td>
<td><?php if($r['status']!='confirmed'): ?><a href="?page=janji&action=confirm&id=<?=$r['id_janji']?>">Konfirmasi</a> | <?php endif; ?><a href="?page=janji&action=delete&id=<?=$r['id_janji']?>" onclick="return confirm('Hapus?')">Hapus</a></td></tr>
<?php endforeach; ?>
</table>
<?php require __DIR__ . '/../layout/footer.php'; ?>
