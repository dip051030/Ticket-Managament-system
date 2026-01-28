<?php
if (session_status() === PHP_SESSION_NONE) session_start();

include "includes/header.php";
?>

<div class="auth-form">
    <div class="card auth-card">
        <div class="page-header">
            <h1 class="auth-hero-title">SupportPortal</h1>
            <p class="page-sub">Modern ticketing for better support</p>
        </div>

        <div class="auth-hero-actions">
            <?php if (!isset($_SESSION["user_id"])): ?>
                <a class="btn-primary" href="/auth/login.php">Login to your account</a>
                <a href="/auth/register.php" class="auth-secondary-link">New here? <span>Create an account</span></a>
            <?php else: ?>
                <a class="btn-primary" href="/dashboard.php">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>

