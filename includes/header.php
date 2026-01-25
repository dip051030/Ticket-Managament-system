<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TicketSys</title>
    <link rel="stylesheet" href="/assets/style.css">
</head>
<body>

<nav>
    <a href="/dashboard.php" class="nav-brand">TicketSys</a>

    <button id="navToggle" class="nav-toggle" aria-label="Toggle navigation">
        ☰
    </button>

    <div id="navLinks" class="nav-links">
        <a href="../dashboard.php">Dashboard</a>
        <a href="../tickets/create.php">New Ticket</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</nav>

