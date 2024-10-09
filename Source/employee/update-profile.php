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
   
    $stml = $conn->prepare("UPDATE employees SET E_name = ?, E_email = ?, E_department = ?, E_password = ? WHERE E_id = ?");
    $stml->bind_param("sssss", $name, $email, $department, $password, $id);
} else {
    $stml = $conn->prepare("UPDATE employees SET E_name = ?, E_email = ?, E_department = ? WHERE E_id = ?");
    $stml->bind_param("ssss", $name, $email, $department, $id);
}

$stml->execute();

if ($stml->affected_rows > 0) {
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    echo "<script>
        
        window.location.href='edit-profile.php?notifications1=1';
    </script>";
} else {
    echo "<script>
        window.location.href='edit-profile.php?notifications2=1';
    </script>";
}

$stml->close();
$conn->close();
?>