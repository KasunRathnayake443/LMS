<?php
include '../config.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo "<script>
        alert('Please login first.');
        window.location.href='../../index.php';
    </script>";
    exit;
}

$id = $_SESSION['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$department = $_POST['department'];
$password = $_POST['password'];

if ($password) {
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $stml = $conn->prepare("UPDATE employees SET E_name = ?, E_email = ?, E_department = ?, E_password = ? WHERE E_id = ?");
    $stml->bind_param("sssss", $name, $email, $department, $password_hash, $id);
} else {
    $stml = $conn->prepare("UPDATE employees SET E_name = ?, E_email = ?, E_department = ? WHERE E_id = ?");
    $stml->bind_param("ssss", $name, $email, $department, $id);
}

$stml->execute();

if ($stml->affected_rows > 0) {
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    echo "<script>
        alert('Profile updated successfully.');
        window.location.href='e-dashboard.php';
    </script>";
} else {
    echo "<script>
        alert('No changes made to the profile.');
        window.location.href='e-dashboard.php';
    </script>";
}

$stml->close();
$conn->close();
?>