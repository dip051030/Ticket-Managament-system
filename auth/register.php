
<?php
require "../config/db.php";
include "../includes/header.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $stmt = $conn->prepare(
        "INSERT INTO users (name,email,password,role) VALUES (?,?,?,'user')"
    );
    $stmt->bind_param("sss", $_POST["name"], $_POST["email"], $hash);
    $stmt->execute();
    header("Location: login.php");
}
?>

<div class="card">
<form method="POST">
    <label>Name</label>
    <input name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button class="btn-primary">Register</button>
</form>
</div>

<?php include "../includes/footer.php"; ?>

