<?php
session_start();

if (!isset($_SESSION['who'])) {
    die('Missing name parameter');
}

$who = htmlentities($_SESSION['who']);
$names = array("Rock", "Paper", "Scissors");

function check($computer, $human) {
    if ($computer == $human) return "Tie";
    if (($human == 0 && $computer == 2) ||
        ($human == 1 && $computer == 0) ||
        ($human == 2 && $computer == 1)) {
        return "Win";
    }
    return "Lose";
}

$output = "";
$action = $_GET['action'] ?? "";

if ($action === "Logout") {
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
    exit();
}

if ($action === "Play") {
    $human = (int)$_GET['choice'];
    $computer = rand(0, 2);
    $result = check($computer, $human);
    $output = "Human = {$names[$human]} Computer = {$names[$computer]} Result = $result";
}

if ($action === "Test") {
    for ($h = 0; $h < 3; $h++) {
        for ($c = 0; $c < 3; $c++) {
            $r = check($c, $h);
            $output .= "Human = {$names[$h]} Computer = {$names[$c]} Result = $r\n";
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
    <h1>Rock Paper Scissors bde4e71c</h1>
    <p>Welcome, <?= $who ?></p>
    <form method="GET" action="game.php">
        <input type="hidden" name="who" value="<?= $who ?>">
        <select name="choice">
            <option value="0">Rock</option>
            <option value="1">Paper</option>
            <option value="2">Scissors</option>
        </select>
        <input type="submit" name="action" value="Play">
        <input type="submit" name="action" value="Test">
        <input type="submit" name="action" value="Logout">
    </form>
    <?php if ($output !== "") : ?>
        <pre><?= htmlentities($output) ?></pre>
    <?php endif; ?>
</div>
</body>
</html>