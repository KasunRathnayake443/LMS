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
    $name = $_POST['employeeName'];
    $email = $_POST['employeeEmail'];
    $department = $_POST['employeeDepartment'];
    $password = $_POST['employeePassword'];

    $stml = $conn->prepare("INSERT INTO employees (E_name, E_email, E_department, E_password) VALUES (?, ?, ?, ?)");
    $stml->bind_param("ssss", $name, $email, $department, $password);

    if ($stml->execute()) {
        echo "<script>
           
            window.location.href='employees.php?notifications1=1';
        </script>";
    } else {
        echo "<script>
            alert('Error adding employee.');
            window.location.href='employees.php';
        </script>";
    }

    $stml->close();
}

$conn->close();
?>