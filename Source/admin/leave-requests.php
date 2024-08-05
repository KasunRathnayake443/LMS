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

$admin_email = $_SESSION['email'];

$stml = $conn->prepare("SELECT A_id, A_name FROM admin WHERE A_email = ?");
$stml->bind_param("s", $admin_email);
$stml->execute();
$stml->store_result();
$stml->bind_result($admin_id, $admin_name);
$stml->fetch();
$stml->close();



$pending_query = "SELECT COUNT(*) as count FROM leave_list WHERE Status = 'Pending'";
$pending_result = $conn->query($pending_query);
$pending_count = $pending_result->fetch_assoc()['count'];

$Declined_query = "SELECT COUNT(*) as count FROM leave_list WHERE Status = 'Declined'";
$Declined_result = $conn->query($Declined_query);
$Declined_count = $Declined_result->fetch_assoc()['count'];

$Approved_query = "SELECT COUNT(*) as count FROM leave_list WHERE Status = 'Approved'";
$Approved_result = $conn->query($Approved_query);
$Approved_count = $Approved_result->fetch_assoc()['count'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Leave Management System</title>
    <link rel="stylesheet" href="../bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       
    </style>
</head>
<body>
<div class="d-flex">
    <nav class="nav flex-column bg-light p-3" style="width: 300px; height: 100vh;">
        <a class="navbar-brand" href="a-dashboard.php">Leave Management System</a>
        <a class="nav-link" href="a-dashboard.php"> DashBoard</a>
        <a class="nav-link" href="employees.php"> Employees</a>
        <a class="nav-link" href="leave-requests.php"> Leave Requests</a>
        <a class="nav-link" href="leave-types.php"> Leave Types</a>
        <a class="nav-link" href="departments.php"> Departments</a>
        <a class="nav-link" href="admins.php">Admins</a>
        <a class="nav-link" href="logout.php" onclick="return confirmLogout();">Logout</a>
    </nav>
    
    <div class="flex-grow-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <span class="navbar-text">
                    Welcome, <?php echo $admin_name; ?>
                </span>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                        <a class="nav-link" href="logout.php" onclick="return confirmLogout();">Logout</a>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-4">
            <div class="d-flex justify-content-around">
                <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                    <div class="card-header">Pending Leave Requests</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $pending_count; ?></h5>
                        <p class="card-text">Pending Leave Requests</p>
                    </div>
                </div>
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">Approved Leave Requests</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $Approved_count ; ?></h5>
                        <p class="card-text">Approved Leave Requests</p>
                    </div>
                </div>
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">Declined Leave Requests</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $Declined_count; ?></h5>
                        <p class="card-text">Declined Leave Requests</p>
                    </div>
                </div>
            </div>

           
            
        </div>
    </div>
</div>

<script src="../bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
<script src="logout.js"></script>

</body>
</html>

<?php
$conn->close();
?>