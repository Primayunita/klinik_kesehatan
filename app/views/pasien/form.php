<?php require __DIR__ . '/../layout/header.php'; ?>
<?php $isEdit = isset($item) && $item; ?>
<h2><?= $isEdit ? 'Edit Pasien' : 'Tambah Pasien' ?></h2>

<form method="post" action="?page=pasien&action=<?= $isEdit ? 'update' : 'store' ?>">
    <?php if($isEdit): ?>
      <input type="hidden" name="id" value="<?= htmlspecialchars($item['id_pasien']) ?>">
    <?php endif; ?>
    <label>Nama: <input name="nama_pasien" value="<?= htmlspecialchars($item['nama_pasien'] ?? '') ?>"></label><br>
    <label>Tanggal Lahir: <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($item['tanggal_lahir'] ?? '') ?>"></label><br>
    <label>Alergi: <input name="alergi" value="<?= htmlspecialchars($item['alergi'] ?? '') ?>"></label><br>
    <label>Kontak Darurat: <input name="kontak_darurat" value="<?= htmlspecialchars($item['kontak_darurat'] ?? '') ?>"></label><br>
    <label>Alamat: <textarea name="alamat"><?= htmlspecialchars($item['alamat'] ?? '') ?></textarea></label><br>
    <label>No HP: <input name="no_hp" value="<?= htmlspecialchars($item['no_hp'] ?? '') ?>"></label><br>
    <button type="submit">Simpan</button>
</form>

<?php require __DIR__ . '/../layout/footer.php'; ?>
