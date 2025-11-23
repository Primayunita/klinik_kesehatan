<?php require "../app/views/layout/header.php"; ?>

<h2><?= isset($obat) ? 'Edit Obat' : 'Tambah Obat' ?></h2>

<form method="POST"
      action="?page=obat&action=<?= isset($obat) ? 'update' : 'store' ?>">

    <?php if (isset($obat)): ?>
        <input type="hidden" name="id" value="<?= $obat['id'] ?>">
    <?php endif; ?>

    <label>Nama Obat</label><br>
    <input type="text" name="nama" 
           value="<?= $obat['nama'] ?? '' ?>"><br><br>

    <label>Stok</label><br>
    <input type="number" name="stok" 
           value="<?= $obat['stok'] ?? '' ?>"><br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" 
           value="<?= $obat['harga'] ?? '' ?>"><br><br>

    <button type="submit">Simpan</button>
</form>

<?php require "../app/views/layout/footer.php"; ?>
