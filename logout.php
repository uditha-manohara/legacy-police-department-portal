<?php
session_start();
include 'db.php';
if (isset($_SESSION['user'])) {
    session_unset();
    session_destroy();
}
header("Location: index.php");

?>