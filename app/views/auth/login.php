<?php require "../app/views/layout/header.php"; ?>

<h2>Login</h2>

<form action="?page=auth&action=login" method="POST">
    <label>Username</label><br>
    <input type="text" name="username"><br><br>

    <label>Password</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Login</button>
</form>

<?php require "../app/views/layout/footer.php"; ?>
