<?php
include '../config.php';
session_start();

if (!isset($_SESSION['email'])|| !isset($_GET['D_id'])) {
    echo "<script>
        alert('Please login as admin.');
        window.location.href='admin-login.php';
    </script>";
    exit;
}

$D_id = $_GET['D_id'];

$stml = $conn->prepare("DELETE FROM departments WHERE D_id = ?");
$stml->bind_param("s", $D_id);
$stml->execute();

if ($stml->affected_rows > 0) {
    echo "<script>
  
        window.location.href='departments.php?notifications2=1';
    </script>";
} else {
    echo "<script>
        alert('Error deleting Department.');
        window.location.href='departments.php';
    </script>";
}

?>