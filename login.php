<?php
ob_start();
session_start();

if (isset($_SESSION['who'])) {
    header('Location: game.php?who=' . urlencode($_SESSION['who']));
    exit();
}

$salt = 'Xyzzy12*_';
$stored_hash = md5($salt . 'php123');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $who  = $_POST['who']  ?? '';
    $pass = $_POST['pass'] ?? '';

    if (strlen($who) < 1 || strlen($pass) < 1) {
        $error = 'User name and password are required';
    } else {
        $input_hash = md5($salt . $pass);
        if ($input_hash !== $stored_hash) {
            $error = 'Incorrect password';
        } else {
            $_SESSION['who'] = $who;
            header('Location: game.php?who=' . urlencode($who));
            exit();
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
    <h1>Rock Paper Scissors</h1>
    <h2>Please Log In</h2>

    <?php if ($error != ''): ?>
        <p style="color: red;"><?= htmlentities($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label>Name: <input type="text" name="who" value="<?= htmlentities($_POST['who'] ?? '') ?>"></label>
        <label>Password: <input type="password" name="pass"></label>
        <button type="submit">Log In</button>
    </form>
</div>
</body>
</html>
