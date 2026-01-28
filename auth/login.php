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
?>

<form method="POST" class="card">
<input name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button>Login</button>
</form>

