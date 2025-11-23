<?php require "../app/views/layout/header.php"; ?>

<h2><?= isset($janji) ? "Edit Janji Temu" : "Buat Janji Baru" ?></h2>

<form method="POST" action="?page=janji&action=<?= isset($janji) ? "update" : "store" ?>">

    <?php if (isset($janji)): ?>
        <input type="hidden" name="id" value="<?= $janji['id'] ?>">
    <?php endif; ?>

    <label>Pasien</label><br>
    <select name="pasien_id">
        <?php foreach ($pasien as $p): ?>
            <option value="<?= $p['id'] ?>"
                <?= isset($janji) && $janji['pasien_id'] == $p['id'] ? 'selected' : '' ?>>
                <?= $p['nama'] ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Dokter</label><br>
    <select name="dokter_id">
        <?php foreach ($dokter as $d): ?>
            <option value="<?= $d['id'] ?>"
                <?= isset($janji) && $janji['dokter_id'] == $d['id'] ? 'selected' : '' ?>>
                <?= $d['nama'] ?> (<?= $d['spesialis'] ?>)
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Tanggal</label><br>
    <input type="date" name="tanggal" value="<?= $janji['tanggal'] ?? '' ?>"><br><br>

    <label>Jam</label><br>
    <input type="time" name="jam" value="<?= $janji['jam'] ?? '' ?>"><br><br>

    <label>Keluhan</label><br>
    <textarea name="keluhan"><?= $janji['keluhan'] ?? '' ?></textarea><br><br>

    <button type="submit">Simpan</button>

</form>

<?php require "../app/views/layout/footer.php"; ?>
