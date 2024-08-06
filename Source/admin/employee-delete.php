<?php
include '../config.php';
session_start();

if (!isset($_SESSION['email'])|| !isset($_GET['E_id'])) {
    echo "<script>
        alert('Please login as admin.');
        window.location.href='admin-login.php';
    </script>";
    exit;
}

$E_id = $_GET['E_id'];

$stml = $conn->prepare("DELETE FROM employees WHERE E_id = ?");
$stml->bind_param("s", $E_id);
$stml->execute();

if ($stml->affected_rows > 0) {
    echo "<script>
        alert('Employee deleted successfully.');
        window.location.href='employees.php';
    </script>";
} else {
    echo "<script>
        alert('Error deleting employee.');
        window.location.href='employees.php';
    </script>";
}

?>