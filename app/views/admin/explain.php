<?php require __DIR__ . '/../layout/header.php'; ?>
<h2>EXPLAIN ANALYZE Demo</h2>
<h3>Without Index</h3><pre><?=htmlspecialchars($before)?></pre>
<h3>With Index</h3><pre><?=htmlspecialchars($after)?></pre>
<?php require __DIR__ . '/../layout/footer.php'; ?>
