<?php
require "../includes/auth_check.php";
require "../config/db.php";
include "../includes/header.php";

$id = (int)($_GET["id"] ?? 0);
$isAdmin = $_SESSION["role"] === "admin";

if ($id <= 0) {
    die("Invalid ticket");
}

$ticketStmt = $conn->prepare(
    "SELECT ticket_id, user_id, status FROM tickets WHERE ticket_id = ?"
);
$ticketStmt->bind_param("i", $id);
$ticketStmt->execute();
$ticket = $ticketStmt->get_result()->fetch_assoc();

if (!$ticket || (!$isAdmin && (int)$ticket["user_id"] !== (int)$_SESSION["user_id"])) {
    die("Access denied");
}

$isClosed = ($ticket["status"] === "Closed");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["message"])) {
    if ($isClosed) {
        set_flash("You cannot message on a closed ticket", "error");
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO ticket_messages (ticket_id, sender_id, message_text, date_sent)
             VALUES (?, ?, ?, NOW())"
        );
        $stmt->bind_param("iis", $id, $_SESSION["user_id"], $_POST["message"]);
        $stmt->execute();
        header("Location: messages.php?id=$id");
        exit;
    }
}

$messagesStmt = $conn->prepare(
    "SELECT tm.message_text, tm.date_sent, u.name, u.role
     FROM ticket_messages tm
     JOIN users u ON tm.sender_id=u.user_id
     WHERE tm.ticket_id=?
     ORDER BY tm.date_sent"
);
$messagesStmt->bind_param("i", $id);
$messagesStmt->execute();
$messages = $messagesStmt->get_result();
?>

<div class="container">
<div class="card">

<?php if ($isAdmin): ?>
<div class="card" style="margin-bottom: 1.5rem; padding: 1rem;">
    <h3 style="font-size: 0.9rem; margin-bottom: 0.75rem;">Manage Ticket Status</h3>
    <form method="POST" action="/tickets/update_status.php" style="display: flex; gap: 0.5rem;">
        <input type="hidden" name="ticket_id" value="<?= $id ?>">
        <select name="status" style="flex: 1;">
            <option>Open</option>
            <option>In Progress</option>
            <option>Closed</option>
        </select>
        <button>Update</button>
    </form>
</div>
<?php endif; ?>

<div class="chat-container">
<?php while ($m = $messages->fetch_assoc()): ?>
<div class="bubble <?= ($m["role"] === 'admin') ? 'admin' : 'user' ?>">
<div class="bubble-meta"><?= htmlspecialchars($m["name"]) ?> • <?= date("d M, H:i", strtotime($m["date_sent"])) ?></div>
<?= htmlspecialchars($m["message_text"]) ?>
</div>
<?php endwhile; ?>
</div>

<?php if ($isClosed): ?>
    <div style="background: var(--bg-muted); padding: 1.5rem; text-align: center; border-radius: var(--radius); border: 1px dashed var(--border); color: var(--text-muted);">
        <p>This ticket is closed. Messaging is disabled.</p>
    </div>
<?php else: ?>
    <form method="POST" class="form-group" style="margin-top: 1.5rem;">
        <textarea name="message" placeholder="Type your message here..." required style="min-height: 100px;"></textarea>
        <button style="align-self: flex-end;">Send Message</button>
    </form>
<?php endif; ?>

</div>
</div>

<?php include "../includes/footer.php"; ?>
