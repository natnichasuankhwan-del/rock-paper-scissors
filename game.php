<?php
session_start();

// ตรวจสอบ session
if (!isset($_SESSION['who'])) {
    die('พารามิเตอร์ชื่อหายไป');
}

$who = $_SESSION['who'];
$names = ['Rock', 'Paper', 'Scissors'];

// ฟังก์ชัน check - คำนวณผลการเล่น
function check($computer, $human) {
    if ($computer === $human) return 'เน็คไท';
    if (($human === 0 && $computer === 2) ||
        ($human === 1 && $computer === 0) ||
        ($human === 2 && $computer === 1)) {
        return 'คุณชนะ';
    }
    return 'คุณแพ้';
}

$output = '';
$action = $_GET['action'] ?? '';

if ($action === 'logout') {
    session_destroy();
    header('Location: index.php');
    exit();
}

if ($action === 'play') {
    $human    = (int)($_GET['choice'] ?? 0);
    $computer = rand(0, 2);
    $result   = check($computer, $human);
    $output   = "การเล่นของคุณ = {$names[$human]} "
              . "คอมพิวเตอร์ = {$names[$computer]} "
              . "ผลลัพธ์ = $result";
}

if ($action === 'test') {
    for ($c = 0; $c < 3; $c++) {
        for ($h = 0; $h < 3; $h++) {
            $r = check($c, $h);
            $output .= "Human={$names[$h]} "
                    .  "Computer={$names[$c]} "
                    .  "Result=$r\n";
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
        pre  { background: #f0f0f0; padding: 16px; 
               border: 1px solid #ccc; }
        select, button { 
            padding: 6px 14px; 
            font-size: 1em; 
            margin-right: 6px; 
        }
    </style>
</head>
<body>
    <h1>Rock Paper Scissors</h1>
    <p>Welcome: <?= htmlspecialchars($who) ?></p>

    <form method="GET" action="game.php">
        <select name="choice">
            <option value="0">Rock</option>
            <option value="1">Paper</option>
            <option value="2">Scissors</option>
        </select>
        <button type="submit" name="action" value="play">Play</button>
        <button type="submit" name="action" value="test">Test</button>
        <button type="submit" name="action" value="logout">Logout</button>
    </form>

    <?php if ($output): ?>
        <pre><?= htmlspecialchars($output) ?></pre>
    <?php endif; ?>
</body>
</html>
