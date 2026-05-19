<?php
// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1 ) {
    die('Name parameter missing');
}

// If the user requests logout go back to index.php
if ( isset($_GET['action']) && $_GET['action'] == 'Logout' ) {
    header('Location: index.php');
    return;
}

// Set up the values for the game
$names = array('Rock', 'Paper', 'Scissors');

// เปลี่ยนกลับมาใช้พารามิเตอร์ choice ตามโครงสร้างระบบของคุณ
$human = isset($_GET['choice']) ? $_GET['choice']+0 : -1;

// Function to check who wins
function check($computer, $human) {
    if ( $human == $computer ) {
        return "Tie";
    } else if ( $human == 1 && $computer == 0 ) {
        return "Win";
    } else if ( $human == 2 && $computer == 1 ) {
        return "Win";
    } else if ( $human == 0 && $computer == 2 ) {
        return "Win";
    } else if ( $human == 0 && $computer == 1 ) {
        return "Lose";
    } else if ( $human == 1 && $computer == 2 ) {
        return "Lose";
    } else if ( $human == 2 && $computer == 0 ) {
        return "Lose";
    }
    return false;
}

$output = false;
if ( isset($_GET['action']) && $_GET['action'] == 'Play' ) {
    if ( $human == -1 ) {
        $output = "Please select a strategy and press Play";
    } else {
        $computer = rand(0,2);
        $result = check($computer, $human);
        $output = "Your Play=" . $names[$human] . " Computer=" . $names[$computer] . " Result=" . $result;
    }
} else if ( isset($_GET['action']) && $_GET['action'] == 'Test' ) {
    $output = "";
    for($h=0; $h<3; $h++) {
        for($c=0; $c<3; $c++) {
            $r = check($c, $h);
            $output .= "Human=" . $names[$h] . " Computer=" . $names[$c] . " Result=" . $r . "\n";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Rock Paper Scissors bde4e71c</title>
<?php require_once "bootstrap.php"; ?>
</head>
<body>
<div class="container">
<h1>Rock Paper Scissors bde4e71c</h1>
<?php
if ( isset($_GET['name']) ) {
    echo "<p>Welcome, " . htmlentities($_GET['name']) . "</p>\n";
}
?>
<form method="GET">
<select name="choice">
<option value="-1">Select</option>
<option value="0">Rock</option>
<option value="1">Paper</option>
<option value="2">Scissors</option>
<option value="3">Test</option>
</select>
<input type="hidden" name="name" value="<?= htmlentities($_GET['name']) ?>">
<input type="submit" name="action" value="Play">
<input type="submit" name="action" value="Test">
<input type="submit" name="action" value="Logout">
</form>

<pre>
<?php
if ( $output !== false ) {
    echo htmlentities($output);
}
?>
</pre>
</div>
</body>
</html>