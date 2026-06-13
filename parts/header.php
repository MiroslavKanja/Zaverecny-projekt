<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Manager | Správa výpožičiek</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <div class="container">
        <div class="logo">InvManager</div>
        <nav>
            <a href="index.php">Domov</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="header-btn-logout">
                    Odhlásiť sa (<?php echo htmlspecialchars($_SESSION['username']); ?>)
                </a>
            <?php else: ?>
                <a href="login.php" class="header-btn-login">Prihlásenie</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

    <main class="container">
