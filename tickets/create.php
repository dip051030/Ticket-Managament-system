<?php
require "../includes/auth_check.php";
require "../config/db.php";
include "../includes/header.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare(
        "INSERT INTO tickets (subject, description, user_id, status, date_created)
         VALUES (?, ?, ?, 'Open', NOW())"
    );
    $stmt->bind_param("ssi", $_POST["subject"], $_POST["description"], $_SESSION["user_id"]);
    $stmt->execute();
    header("Location: /dashboard.php");
    exit;
}
?>

<div class="container">
<div class="card">
<h2>Create Ticket</h2>

<form method="POST" class="form-group">
<input name="subject" placeholder="Subject" required>
<textarea name="description" placeholder="Describe your issue" required></textarea>
<button>Create</button>
</form>
</div>
</div>

<?php include "../includes/footer.php"; ?>

