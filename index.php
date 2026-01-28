<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: /dashboard.php");
    exit;
}

include "includes/header.php";
?>

<div class="auth-form">
    <div class="card auth-card">
        <div class="page-header">
            <h1 class="auth-hero-title">SupportPortal</h1>
            <p class="page-sub">Modern ticketing for better support</p>
        </div>

        <div class="auth-hero-actions">
            <a class="btn-primary" href="/auth/login.php">Login to your account</a>
            <a href="/auth/register.php" class="auth-secondary-link">New here? <span>Create an account</span></a>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>

