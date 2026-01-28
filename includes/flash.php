<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function set_flash($msg, $type = "success") {
    $_SESSION["flash"] = ["msg" => $msg, "type" => $type];
}

function get_flash() {
    if (!isset($_SESSION["flash"])) return;
    $f = $_SESSION["flash"];
    unset($_SESSION["flash"]);
    echo "<div class='flash {$f["type"]}'>{$f["msg"]}</div>";
}

