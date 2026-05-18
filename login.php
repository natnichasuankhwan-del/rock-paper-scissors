<?php
session_start();

$salt = 'Xyzzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

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
        $error = 'ต้องใช้ชื่อผู้ใช้และรหัสผ่าน';
    } else {
        $input_hash = hash('md5', $salt . $pass);
        if ($input_hash !== $stored_hash) {
            $error = 'รหัสผ่านไม่ถูกต้อง';
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
    <title>Rock Paper Scissors - Login</title>
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
    <h2>Please Log In</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label>Name: <input type="text"     name="who"  
               value="<?= htmlspecialchars($_POST['who'] ?? '') ?>"></label>
        <label>Password: <input type="password" name="pass"></label>
        <button type="submit">เข้าสู่ระบบ</button>
    </form>
</body>
</html>
