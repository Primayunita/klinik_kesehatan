<?php require "../app/views/layout/header.php"; ?>

<h2><?= isset($dokter) ? 'Edit Dokter' : 'Tambah Dokter' ?></h2>

<form method="POST" 
      action="?page=dokter&action=<?= isset($dokter) ? 'update' : 'store' ?>">

    <?php if (isset($dokter)): ?>
        <input type="hidden" name="id" value="<?= $dokter['id'] ?>">
    <?php endif; ?>

    <label>Nama</label><br>
    <input type="text" name="nama" 
           value="<?= $dokter['nama'] ?? '' ?>"><br><br>

    <label>Spesialis</label><br>
    <input type="text" name="spesialis" 
           value="<?= $dokter['spesialis'] ?? '' ?>"><br><br>

    <label>No HP</label><br>
    <input type="text" name="no_hp" 
           value="<?= $dokter['no_hp'] ?? '' ?>"><br><br>

    <button type="submit">Simpan</button>
</form>

<?php require "../app/views/layout/footer.php"; ?>
