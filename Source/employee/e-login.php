<?php
session_start(); 

include '../config.php'; 

$email = $_POST['email'];
$password = $_POST['password'];


$stml = $conn->prepare("SELECT E_password FROM employees WHERE E_email = ?");
$stml->bind_param("s", $email);
$stml->execute();
$stml->store_result();
$stml->bind_result($pass);
$stml->fetch();


if ($stml->num_rows > 0) {
    
    if ($password === $pass) {
        
        $_SESSION['email'] = $email;
        echo "<script> document.location='e-dashboard.php'; </script>";
    } else {
        
        echo "<script>
            document.location='../../index.php?login_error=1'; 
        </script>";
    }
} else {
   
    echo "<script>
        document.location='../../index.php?login_error=1'; 
    </script>";
}

$stml->close(); 
$conn->close();
?>
