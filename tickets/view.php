<?php
require "../includes/auth_check.php";
require "../config/db.php";
include "../includes/header.php";

$isAdmin = $_SESSION["role"] === "admin";
$userId = $_SESSION["user_id"];

$sql = $isAdmin
    ? "SELECT * FROM tickets ORDER BY date_created DESC"
    : "SELECT * FROM tickets WHERE user_id = $userId ORDER BY date_created DESC";

$result = $conn->query($sql);
?>

<div class="container">
<div class="page-header">
<h2><?= $isAdmin ? "All Tickets" : "My Tickets" ?></h2>
</div>

<div class="ticket-list">
<?php while ($t = $result->fetch_assoc()): ?>
<div class="ticket-item">
    <div class="ticket-content">
        <h3>
            <a href="/tickets/messages.php?id=<?= $t["ticket_id"] ?>">
                <?= htmlspecialchars($t["subject"]) ?>
            </a>
        </h3>
        <small><?= date("d M Y, H:i", strtotime($t["date_created"])) ?></small>
    </div>

    <span class="badge status-<?= strtolower(str_replace(' ','-',$t["status"])) ?>">
        <?= $t["status"] ?>
    </span>
</div>
<?php endwhile; ?>
</div>
</div>

<?php include "../includes/footer.php"; ?>

