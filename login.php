<?php
// Spustenie session, aby si systém pamätal prihláseného používateľa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'app/Database.php';
require_once 'app/Auth.php';

$message = "";
$messageClass = "";

// Spracovanie odoslaného formulára
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);

    if (!empty($user) && !empty($pass)) {
        $auth = new Auth();

        if ($auth->login($user, $pass)) {
            // Po úspešnom prihlásení presmerujeme na index.php
            header("Location: admin.php");
            exit();
        } else {
            $message = "Nesprávne používateľské meno alebo heslo!";
            $messageClass = "alert danger"; // Červený štýl chybovej hlášky
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prihlásenie | Inventory Manager</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="container">
        <div class="logo">InvManager</div>
        <nav>
            <ul>
                <li><a href="index.php">Domov</a></li>
                <li><a href="login.php">Prihlásenie</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container">
    <div class="login-wrapper">
        <div class="login-card">
            <h2>Prihlásenie</h2>

            <?php if ($message != ""): ?>
                <div class="<?php echo $messageClass; ?>" style="padding: 10px; margin-bottom: 20px; border-radius: 8px; text-align: center; font-weight: 600;">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="input-group">
                    <label for="username">Používateľské meno</label>
                    <input type="text" id="username" name="username" placeholder="Zadajte meno" required>
                </div>

                <div class="input-group">
                    <label for="password">Heslo</label>
                    <input type="password" id="password" name="password" placeholder="Zadajte heslo" required>
                </div>

                <button type="submit" class="login-btn">Vstúpiť do systému</button>
            </form>

            <div class="login-footer">
                <p>Nemáte účet? <a href="#">Kontaktujte správcu</a></p>
            </div>
        </div>
    </div>
</main>

<footer>
    <div class="container">
        <p>&copy; 2026 Inventory Management System | UKF Projekt</p>
    </div>
</footer>

</body>
</html>