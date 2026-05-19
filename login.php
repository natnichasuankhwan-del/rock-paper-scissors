<?php
if (isset($_GET['cancel'])) {
    header("Location: index.php");
    exit();
}

if (isset($_GET['who'])) {
    if (strlen($_GET['who']) < 1) {
        $error = "Name parameter missing";
    } else {
        header("Location: game.php?who=" . urlencode($_GET['who']));
        exit();
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
    <?php if (isset($error)) : ?>
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