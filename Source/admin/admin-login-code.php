<?php

include '../config.php';








$email = $_POST['email'];
$password = $_POST['password'];

$stml = $conn->prepare("select A_password from Admin where A_email = ? ");
    
    $stml->bind_param("s",$email);
    $stml->execute();

    $stml->store_result();
    $stml->bind_result($pass);
    $stml->fetch();

    if($password == $pass)
    { echo "<script> document.location='A-dashboard.php'</script>"; }

    else { echo"<script>
        alert('Wrong Username or Password'); document.location='admin-login.php';</script>";}

        session_start();
        $_SESSION['email'] = $email;
        

    
?>