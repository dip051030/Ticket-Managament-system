<?php
require "../config/db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($_POST["password"], $user["password"])) {
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["role"] = $user["role"];
        header("Location: /dashboard.php");
        exit;
    }
}

include "../includes/header.php";
?>

<div class="card">
<form method="POST" class="form-group">
    <label>Email</label>
    <input type="email" name="email" required autofocus>

    <label>Password</label>
    <input type="password" name="password" required>

    <button class="btn-primary">Login</button>
</form>
</div>

<?php include "../includes/footer.php"; ?>

