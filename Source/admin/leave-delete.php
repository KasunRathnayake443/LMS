<?php
include '../config.php';
session_start();

if (!isset($_SESSION['email'])|| !isset($_GET['id'])) {
    echo "<script>
        alert('Please login as admin.');
        window.location.href='admin-login.php';
    </script>";
    exit;
}

$id = $_GET['id'];

$stml = $conn->prepare("DELETE FROM leave_types WHERE id = ?");
$stml->bind_param("s", $id);
$stml->execute();

if ($stml->affected_rows > 0) {
    echo "<script>
       
        window.location.href='Leave-types.php?notifications2=1';
    </script>";
} else {
    echo "<script>
        alert('Error deleting Leave Type.');
        window.location.href='Leave-types.php';
    </script>";
}

?>