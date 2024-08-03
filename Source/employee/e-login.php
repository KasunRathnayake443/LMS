<?php

include '../config.php';








$email = $_POST['email'];
$password = $_POST['password'];

$stml = $conn->prepare("select E_password from employees where E_email = ? ");
    
    $stml->bind_param("s",$email);
    $stml->execute();

    $stml->store_result();
    $stml->bind_result($pass);
    $stml->fetch();

    if($password == $pass)
    { echo "<script> document.location='e-dashboard.php'</script>"; }

    else { echo"<script>
        alert('Wrong Username or Password'); document.location='../../index.php';</script>";}

        session_start();
        $_SESSION['email'] = $email;
        

    
?>
