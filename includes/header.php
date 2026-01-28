<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/assets/style.css">
<title>Ticket System</title>
</head>
<body>

<nav>
    <a class="nav-brand" href="/">SupportPortal</a>
    <button id="navToggle" class="nav-toggle">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div id="navLinks" class="nav-links">
        <?php $curr = $_SERVER["SCRIPT_NAME"]; ?>
        <?php if (isset($_SESSION["user_id"])): ?>
            <a href="/dashboard.php" class="<?= $curr == '/dashboard.php' ? 'active' : '' ?>">Dashboard</a>
            <a href="/tickets/create.php" class="<?= $curr == '/tickets/create.php' ? 'active' : '' ?>">New Ticket</a>
            <?php if (($_SESSION["role"] ?? "") === "admin"): ?>
                <a href="/admin/dashboard.php" class="<?= strpos($curr, '/admin/') === 0 ? 'active' : '' ?>">Analytics</a>
            <?php endif; ?>
            <a href="/auth/logout.php">Logout</a>
        <?php else: ?>
            <a href="/auth/login.php" class="<?= $curr == '/auth/login.php' ? 'active' : '' ?>">Login</a>
            <a href="/auth/register.php" class="<?= $curr == '/auth/register.php' ? 'active' : '' ?>">Register</a>
        <?php endif; ?>
    </div>
</nav>

<?php require_once __DIR__."/flash.php"; get_flash(); ?>

