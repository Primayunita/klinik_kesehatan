<?php require __DIR__ . '/../layout/header.php'; ?>
<h2>Rekam Medis</h2>
<a href="?page=rekam&action=create">Tambah Rekam</a>
<form method="get"><input type="hidden" name="page" value="rekam"><input type="hidden" name="action" value="list"><input name="q" oninput="this.form.submit()" value="<?=htmlspecialchars($_GET['q']??'')?>"></form>
<table border="1"><tr><th>ID</th><th>Pasien</th><th>Dokter</th><th>Tanggal</th><th>Diagnosis</th><th>Tindakan</th><th>Resep</th></tr>
<?php foreach($res['data'] as $r): ?>
<tr><td><?=$r['id_rekam']?></td><td><?=$r['nama_pasien']?></td><td><?=$r['nama_dokter']?></td><td><?=$r['tanggal']?></td><td><?=$r['diagnosis']?></td><td><?=$r['tindakan']?></td><td><?=$r['resep']?></td></tr>
<?php endforeach; ?>
</table>
<?php require __DIR__ . '/../layout/footer.php'; ?>
