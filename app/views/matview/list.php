<?php require __DIR__ . '/../layout/header.php'; ?>
<h2>Materialized View - Top Diseases</h2>
<?php
$rm = new ReportModel();
$rows = $rm->getMaterializedTopDiseases(50);
?>
<table border="1"><tr><th>Diagnosis</th><th>Count</th></tr>
<?php foreach($rows as $r): ?>
<tr><td><?=htmlspecialchars($r['diagnosis'])?></td><td><?=htmlspecialchars($r['cnt'])?></td></tr>
<?php endforeach; ?>
</table>
<?php require __DIR__ . '/../layout/footer.php'; ?>
