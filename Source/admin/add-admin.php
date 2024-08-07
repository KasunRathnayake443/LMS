<?php
include '../config.php';
session_start();

if (!isset($_SESSION['email'])) {
    echo "<script>
        alert('Please login as admin.');
        window.location.href='admin-login.php';
    </script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['adminName'];
    $email = $_POST['adminEmail'];
    $password = $_POST['adminPassword'];

    $stml = $conn->prepare("INSERT INTO admin (A_name, A_email, A_password) VALUES (?, ?, ?)");
    $stml->bind_param("sss", $name, $email, $password);

    if ($stml->execute()) {
        echo "<script>
            alert('Admin added successfully.');
            window.location.href='admins.php';
        </script>";
    } else {
        echo "<script>
            alert('Error adding eadmin.');
            window.location.href='admins.php';
        </script>";
    }

    $stml->close();
}

$conn->close();
?>