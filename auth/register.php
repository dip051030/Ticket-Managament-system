<?php
require "../config/db.php";
require "../includes/flash.php";

if ($_SERVER["REQUEST_METHOD"]==="POST") {
    if ($_POST["password"] !== $_POST["confirm"]) {
        set_flash("Passwords do not match","error");
    } elseif (strlen($_POST["password"]) < 8) {
        set_flash("Password must be at least 8 characters","error");
    } else {
        $hash=password_hash($_POST["password"],PASSWORD_DEFAULT);
        $stmt=$conn->prepare(
            "INSERT INTO users(name,email,password) VALUES(?,?,?)"
        );
        $stmt->bind_param("sss",$_POST["name"],$_POST["email"],$hash);

        if($stmt->execute()){
            set_flash("Account created. Please login.");
            header("Location:/auth/login.php"); exit;
        } else {
            set_flash("Email already exists","error");
        }
    }
}
include "../includes/header.php";
?>

<div class="auth-form">
    <form method="POST" class="card">
        <div class="page-header">
            <h2>Register</h2>
            <p class="page-sub">Create your SupportPortal account</p>
        </div>
        <div class="form-group">
            <input name="name" placeholder="Name" required>
            <input name="email" type="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password (min 8 chars)" required>
            <input type="password" name="confirm" placeholder="Confirm Password" required>
            <button>Register</button>
        </div>
        <p style="margin-top: 1.5rem; font-size: 0.85rem; text-align: center; color: var(--text-muted);">
            Already have an account? <a href="/auth/login.php" style="color: var(--accent); font-weight: 600;">Login</a>
        </p>
    </form>
</div>

<?php include "../includes/footer.php"; ?>

