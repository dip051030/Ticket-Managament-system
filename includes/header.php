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
    <a class="nav-brand" href="/dashboard.php">TicketSys</a>
    <button id="navToggle" class="nav-toggle">
        <span></span>
        <span></span>
        <span></span>
    </button>
    <div id="navLinks" class="nav-links">
        <a href="/dashboard.php">Dashboard</a>
        <a href="/tickets/create.php">New Ticket</a>
        <?php if (($_SESSION["role"] ?? "") === "admin"): ?>
            <a href="/admin/dashboard.php">Admin</a>
        <?php endif; ?>
        <a href="/auth/logout.php">Logout</a>
    </div>
</nav>

<?php require_once __DIR__."/flash.php"; get_flash(); ?>

