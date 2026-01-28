<?php
require "../includes/auth_check.php";
require "../config/db.php";

$id  = (int)($_GET["id"] ?? 0);
$uid = $_SESSION["user_id"];

if ($id <= 0) {
    die("Invalid ticket");
}

$stmt = $conn->prepare(
    "SELECT * FROM tickets
     WHERE ticket_id = ? AND user_id = ? AND status = 'Open'"
);
$stmt->bind_param("ii", $id, $uid);
$stmt->execute();
$ticket = $stmt->get_result()->fetch_assoc();

if (!$ticket) {
    die("Access denied");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $conn->prepare(
        "UPDATE tickets SET subject = ?, description = ? WHERE ticket_id = ?"
    );
    $stmt->bind_param(
        "ssi",
        $_POST["subject"],
        $_POST["description"],
        $id
    );
    $stmt->execute();
    header("Location: messages.php?id=$id");
    exit;
}
include "../includes/header.php";
?>

<div class="container" style="max-width: 600px;">
    <div class="card">
        <div class="page-header">
            <h2>Edit Ticket</h2>
            <p class="page-sub">Update your ticket details</p>
        </div>

        <form method="POST" class="form-group">
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-main);">Subject</label>
                <input name="subject" value="<?= htmlspecialchars($ticket["subject"]) ?>" required>
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--text-main);">Description</label>
                <textarea name="description" required style="min-height: 150px;"><?= htmlspecialchars($ticket["description"]) ?></textarea>
            </div>
            <div style="display: flex; gap: 1rem; margin-top: 1rem;">
                <button style="flex: 1;">Update Ticket</button>
                <a href="/dashboard.php" class="btn-primary" style="background: var(--bg-muted); color: var(--text-main); flex: 1;">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include "../includes/footer.php"; ?>
