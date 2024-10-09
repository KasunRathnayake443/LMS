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
    $lname = $_POST['lName'];
    $ldescription = $_POST['ldescription'];
    

    $stml = $conn->prepare("INSERT INTO leave_types (leave_name, description) VALUES (?,?)");
    $stml->bind_param("ss", $lname, $ldescription);

    if ($stml->execute()) {
        echo "<script>
          
            window.location.href='leave-types.php?notifications1=1';
        </script>";
    } else {
        echo "<script>
            alert('Error adding Leave Type.');
            window.location.href='leave-types.php';
        </script>";
    }

    $stml->close();
}

$conn->close();
?>