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

$E_id = $_SESSION['E_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$department = $_POST['department'];
$password = $_POST['password'];

if ($password) {
    $stml = $conn->prepare("UPDATE employees SET E_name = ?, E_email = ?, E_department = ?, E_password = ? WHERE E_id = ?");
    $stml->bind_param("sssss", $name, $email, $department, $password, $E_id);
} else {
    $stml = $conn->prepare("UPDATE employees SET E_name = ?, E_email = ?, E_department = ? WHERE E_id = ?");
    $stml->bind_param("ssss", $name, $email, $department, $E_id);
}

$stml->execute();

if ($stml->affected_rows > 0) {
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    echo "<script>
      
        window.location.href='employees.php?notifications2=1';
    </script>";
} else {
    echo "<script>
        
        window.location.href='employees.php?notifications3=1';
    </script>";
}

$stml->close();
$conn->close();
?>