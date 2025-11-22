<?php require __DIR__ . '/../layout/header.php'; ?>
<h2>Laporan Klinik</h2>
<?php
require_once __DIR__ . '/../../models/ReportModel.php';
$rm = new ReportModel();
$lap = $rm->getLaporanKunjunganPerDokter();
?>
<table border="1">
<tr><th>Dokter</th><th>Jumlah Kunjungan</th><th>Jumlah Pasien</th><th>Diagnosa</th></tr>
<?php foreach($lap as $r): ?>
<tr>
<td><?=htmlspecialchars($r['nama_dokter'])?></td>
<td><?=htmlspecialchars($r['jumlah_kunjungan'])?></td>
<td><?=htmlspecialchars($r['jumlah_pasien'])?></td>
<td><?=htmlspecialchars($r['daftar_diagnosis'])?></td>
</tr>
<?php endforeach; ?>
</table>

<h3>Top Diseases (Materialized View)</h3>
<?php $mv = $rm->getMaterializedTopDiseases(10); ?>
<table border="1"><tr><th>Diagnosis</th><th>Count</th></tr>
<?php foreach($mv as $m): ?>
<tr><td><?=htmlspecialchars($m['diagnosis'])?></td><td><?=htmlspecialchars($m['cnt'])?></td></tr>
<?php endforeach; ?>
</table>

<form method="post" action="?page=dbadmin&action=refresh_matview"><button type="submit">Refresh Materialized View</button></form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
