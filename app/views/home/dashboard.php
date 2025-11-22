<?php require "../app/views/layout/header.php"; ?>

<h2>Dashboard Klinik</h2>

<p>Selamat datang, <?= $_SESSION["user"]["username"] ?>!</p>

<ul>
    <li>Total Pasien</li>
    <li>Total Dokter</li>
    <li>Janji Temu Hari Ini</li>
</ul>

<?php require "../app/views/layout/footer.php"; ?>
