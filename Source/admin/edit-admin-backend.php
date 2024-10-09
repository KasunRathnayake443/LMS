<?php
include '../config.php';
session_start();

if (!isset($_SESSION['email'])) {
    echo "<script>
        alert('Please login first.');
        window.location.href='admin-login.php';
    </script>";
    exit;
}

$A_id = $_SESSION['A_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

if ($password) {
    $stml = $conn->prepare("UPDATE admin SET A_name = ?, A_email = ?,  A_password = ? WHERE A_id = ?");
    $stml->bind_param("ssss", $name, $email,  $password, $A_id);
} else {
    $stml = $conn->prepare("UPDATE admin SET A_name = ?, A_email = ? WHERE A_id = ?");
    $stml->bind_param("sss", $name, $email, $A_id);
}

$stml->execute();

if ($stml->affected_rows > 0) {
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    echo "<script>
        
        window.location.href='admins.php?notifications3=1';
    </script>";
} else {
    echo "<script>
        
        window.location.href='admins.php?notifications4=1';
    </script>";
}

$stml->close();
$conn->close();
?>