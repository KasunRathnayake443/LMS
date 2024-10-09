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
    $name = $_POST['dName'];
    

    $stml = $conn->prepare("INSERT INTO departments (d_name) VALUES (?)");
    $stml->bind_param("s", $name);

    if ($stml->execute()) {
        echo "<script>
     
            window.location.href='Departments.php?notifications1=1';
        </script>";
    } else {
        echo "<script>
            alert('Error adding Department.');
            window.location.href='Departments.php';
        </script>";
    }

    $stml->close();
}

$conn->close();
?>