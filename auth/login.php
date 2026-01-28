<?php
require "../config/db.php";
require "../includes/flash.php";
session_start();

if ($_SERVER["REQUEST_METHOD"]==="POST") {
    $stmt=$conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$_POST["email"]);
    $stmt->execute();
    $u=$stmt->get_result()->fetch_assoc();

    if($u && password_verify($_POST["password"],$u["password"])) {
        $_SESSION["user_id"]=$u["user_id"];
        $_SESSION["role"]=$u["role"];
        set_flash("Welcome back");
        header("Location:/dashboard.php"); exit;
    }

    set_flash("Invalid email or password","error");
}
include "../includes/header.php";
?>

<div class="auth-form">
    <form method="POST" class="card">
        <div class="page-header">
            <h2>Login</h2>
            <p class="page-sub">Welcome back to SupportPortal</p>
        </div>
        <div class="form-group">
            <input name="email" type="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button>Login</button>
        </div>
        <p style="margin-top: 1.5rem; font-size: 0.85rem; text-align: center; color: var(--text-muted);">
            Don't have an account? <a href="/auth/register.php" style="color: var(--accent); font-weight: 600;">Register</a>
        </p>
    </form>
</div>

<?php include "../includes/footer.php"; ?>

