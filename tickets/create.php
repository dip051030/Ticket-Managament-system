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

<div class="container" style="max-width: 600px;">
    <div class="card">
        <div class="page-header">
            <h2>Create New Ticket</h2>
            <p class="page-sub">Fill out the form below to open a new support request</p>
        </div>

        <form method="POST" class="form-group">
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-main);">Subject</label>
                <input name="subject" placeholder="What is the issue about?" required>
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-main);">Description</label>
                <textarea name="description" placeholder="Please provide as much detail as possible..." required style="min-height: 150px;"></textarea>
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button style="flex: 1;">Create Ticket</button>
                <a href="/dashboard.php" class="btn-primary" style="background: var(--bg-muted); color: var(--text-main); flex: 1;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include "../includes/footer.php"; ?>

