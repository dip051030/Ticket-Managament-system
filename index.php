<?php
session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: /dashboard.php");
    exit;
}

include "includes/header.php";
?>

<div class="card">
    <div class="page-header">
        <h2>Welcome to SupportPortal</h2>
        <p class="page-sub">Login or register to continue</p>
    </div>

    <a class="btn-primary" href="/auth/login.php">Login</a>
    <br><br>
    <a href="/auth/register.php">Create an account</a>
</div>

<?php include "includes/footer.php"; ?>

