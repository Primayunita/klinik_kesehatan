<?php require __DIR__ . '/../layout/header.php'; ?>
<h2>Tambah Rekam Medis</h2>
<?php if(!empty($_SESSION['flash_error'])): ?><div style="color:red"><?=htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']);?></div><?php endif; ?>
<form method="post" action="?page=rekam&action=store">
<label>Pasien:
  <select name="id_pasien" required>
    <?php foreach($pasiens as $p): ?><option value="<?=$p['id_pasien']?>"><?=$p['nama_pasien']?></option><?php endforeach; ?>
  </select>
</label><br>
<label>Dokter:
  <select name="id_dokter" required>
    <?php foreach($dokters as $d): ?><option value="<?=$d['id_dokter']?>"><?=$d['nama']?></option><?php endforeach; ?>
  </select>
</label><br>
<label>Tanggal: <input type="date" name="tanggal" required></label><br>
<label>Diagnosis: <input name="diagnosis" required></label><br>
<label>Tindakan: <input name="tindakan"></label><br>
<label>Resep: <textarea name="resep"></textarea></label><br>
<label>Obat (opsional):
  <select name="id_obat"><option value="">-- none --</option><?php foreach($obats as $o): ?><option value="<?=$o['id_obat']?>"><?=$o['nama']?> (stok <?=$o['stok']?>)</option><?php endforeach; ?></select>
</label><br>
<label>Qty: <input type="number" name="qty" value="1" min="1"></label><br>
<button type="submit">Simpan</button>
</form>
<?php require __DIR__ . '/../layout/footer.php'; ?>
