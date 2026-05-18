<?php
ob_start();
session_start();

$salt = 'Xyzzy12*_';
$stored_hash = md5($salt . 'php123');


$error = '';

// ถ้า login แล้ว ไป game.php เลย
if (isset($_SESSION['who'])) {
    header('Location: game.php?who=' . urlencode($_SESSION['who']));
    exit();
}

// รับข้อมูลจากฟอร์ม POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $who  = $_POST['who']  ?? '';
    $pass = $_POST['pass'] ?? '';

    if (empty($who) || empty($pass)) {
        $error = 'Must provide username and password';
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
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; }
        h1   { font-size: 2em; }
        input { display: block; margin: 8px 0; padding: 6px; font-size: 1em; }
        button { padding: 8px 20px; font-size: 1em; }
        .error { color: red; }
    </style>
</head>
<body>
    <h1>Rock Paper Scissors</h1>
    <h2><a href="login.php">Please Log In</a></h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlentities($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label>Name: <input type="text"     name="who"  
               value="<?= htmlentities($_POST['who'] ?? '') ?>"
        <label>Password: <input type="password" name="pass"></label>
        <button type="submit">Log In</button>
    </form>
</body>
</html>
