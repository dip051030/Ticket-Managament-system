<?php
require "includes/auth_check.php";
require "config/db.php";
include "includes/header.php";

$isAdmin = $_SESSION["role"] === "admin";
$userId = $_SESSION["user_id"];

if ($isAdmin) {
    $stats = $conn->query(
        "SELECT
            COUNT(*) total,
            SUM(status='Open') open,
            SUM(status='In Progress') progress,
            SUM(status='Closed') closed,
            SUM(DATE(date_created)=CURDATE()) today,
            SUM(date_created >= NOW() - INTERVAL 7 DAY) week
         FROM tickets"
    )->fetch_assoc();

    $tickets = $conn->query(
        "SELECT * FROM tickets ORDER BY date_created DESC"
    );
} else {
    $stats = $conn->query(
        "SELECT
            COUNT(*) total,
            SUM(status='Open') open,
            SUM(status='Closed') closed,
            SUM(DATE(date_created)=CURDATE()) today,
            SUM(date_created >= NOW() - INTERVAL 7 DAY) week
         FROM tickets WHERE user_id=$userId"
    )->fetch_assoc();

    $tickets = $conn->query(
        "SELECT * FROM tickets WHERE user_id=$userId ORDER BY date_created DESC"
    );
}
?>

<div class="container">

<div class="page-header">
    <h2><?= $isAdmin ? "Admin Dashboard" : "My Dashboard" ?></h2>
    <p class="page-sub"><?= $isAdmin ? "System overview and ticket management" : "Your ticket activity overview" ?></p>
</div>

<section class="stats-grid">
    <div class="stat-card">
        <span>Total Tickets</span>
        <strong><?= $stats["total"] ?></strong>
    </div>

    <div class="stat-card blue">
        <span>Open</span>
        <strong><?= $stats["open"] ?></strong>
    </div>

    <?php if ($isAdmin): ?>
    <div class="stat-card amber">
        <span>In Progress</span>
        <strong><?= $stats["progress"] ?></strong>
    </div>
    <?php endif; ?>

    <div class="stat-card green">
        <span>Closed</span>
        <strong><?= $stats["closed"] ?></strong>
    </div>

    <div class="stat-card">
        <span>Today</span>
        <strong><?= $stats["today"] ?></strong>
    </div>

    <div class="stat-card">
        <span>Last 7 Days</span>
        <strong><?= $stats["week"] ?></strong>
    </div>
</section>

<a href="/tickets/create.php" class="btn-primary">+ New Ticket</a>

<div class="ticket-list" style="margin-top:1.5rem;">
<?php while ($t = $tickets->fetch_assoc()): ?>
<div class="ticket-item">
    <div class="ticket-content">
        <h3>
            <a href="/tickets/messages.php?id=<?= $t["ticket_id"] ?>">
                <?= htmlspecialchars($t["subject"]) ?>
            </a>
        </h3>
        <small><?= date("d M Y, H:i", strtotime($t["date_created"])) ?></small>
    </div>

    <div style="display:flex; gap:.5rem; align-items:center;">
        <span class="badge status-<?= strtolower(str_replace(' ','-',$t["status"])) ?>">
            <?= htmlspecialchars($t["status"]) ?>
        </span>

        <div style="display:flex; gap:.5rem;">
            <a href="/tickets/messages.php?id=<?= $t["ticket_id"] ?>" class="btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.75rem;">View</a>
            <?php if ($t["status"] === 'Open' && !$isAdmin): ?>
            <a href="/tickets/edit.php?id=<?= $t["ticket_id"] ?>" class="btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.75rem; background: var(--bg-muted); color: var(--text-main);">Edit</a>
            <?php endif; ?>
            <?php if ($isAdmin): ?>
            <form method="POST" action="/tickets/delete.php" onsubmit="return confirm('Are you sure?')">
                <input type="hidden" name="ticket_id" value="<?= $t["ticket_id"] ?>">
                <button class="btn-danger" style="padding: 0.4rem 0.8rem; font-size: 0.75rem;">Delete</button>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php endwhile; ?>
</div>

</div>

<?php include "includes/footer.php"; ?>

