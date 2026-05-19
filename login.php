<?php
session_start();

$salt = 'Xyzzy12';
$stored_hash = '1a52e17fa899cf40fb04cf42e6352f1'; // md5 of Xyzzy12php123

if (isset($_POST['cancel'])) {
    header("Location: index.php");
    exit();
}

$error = false;

if (isset($_POST['who']) && isset($_POST['pass'])) {
    if (strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1) {
        $error = "User name and password are required";
    } else {
        $check = hash('md5', $salt . $_POST['pass']);
        if ($check === $stored_hash) {
            session_regenerate_id(true);
            $_SESSION['who'] = $_POST['who'];
            header("Location: game.php?who=" . urlencode($_POST['who']));
            exit();
        } else {
            $error = "Incorrect password";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rock Paper Scissors bde4e71c</title>
</head>
<body>
<div class="container">
    <h1>Please Log In</h1>
    <?php if ($error !== false) : ?>
        <p style="color:red;"><?= htmlentities($error) ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <label for="who">Name:</label>
        <input type="text" name="who" id="who">
        <label for="pass">Password:</label>
        <input type="password" name="pass" id="pass">
        <input type="submit" value="Log In">
        <input type="submit" name="cancel" value="Cancel">
    </form>
</div>
</body>
</html>