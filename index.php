<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: /dashboard.php");
    exit;
}

include "includes/header.php";
?>

<div class="auth-form">
    <div class="card" style="text-align: center;">
        <div class="page-header">
            <h1 style="font-size: 1.75rem; margin-bottom: 0.5rem;">SupportPortal</h1>
            <p class="page-sub">Modern ticketing for better support</p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 2rem;">
            <a class="btn-primary" href="/auth/login.php">Login to your account</a>
            <a href="/auth/register.php" style="font-size: 0.85rem; color: var(--text-muted); text-decoration: none;">New here? <span style="color: var(--accent); font-weight: 600;">Create an account</span></a>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>

