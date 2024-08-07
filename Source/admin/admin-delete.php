<?php
include '../config.php';
session_start();

if (!isset($_SESSION['email'])|| !isset($_GET['A_id'])) {
    echo "<script>
        alert('Please login as admin.');
        window.location.href='admin-login.php';
    </script>";
    exit;
}

$A_id = $_GET['A_id'];

$stml = $conn->prepare("DELETE FROM admin WHERE A_id = ?");
$stml->bind_param("s", $A_id);
$stml->execute();

if ($stml->affected_rows > 0) {
    echo "<script>
        alert('Admin deleted successfully.');
        window.location.href='admins.php';
    </script>";
} else {
    echo "<script>
        alert('Error deleting Admin.');
        window.location.href='admins.php';
    </script>";
}

?>