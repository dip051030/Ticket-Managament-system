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
?>

<form method="POST" class="card">
<input name="name" placeholder="Name" required>
<input name="email" type="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<input type="password" name="confirm" placeholder="Confirm Password" required>
<button>Register</button>
</form>

