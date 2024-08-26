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

$_SESSION['A_name'] = $admin_name;
$_SESSION['A_id'] = $admin_id;

$pending_query = "SELECT COUNT(*) as count FROM leave_list WHERE Status = 'Pending'";
$pending_result = $conn->query($pending_query);
$pending_count = $pending_result->fetch_assoc()['count'];

$Declined_query = "SELECT COUNT(*) as count FROM leave_list WHERE Status = 'Declined'";
$Declined_result = $conn->query($Declined_query);
$Declined_count = $Declined_result->fetch_assoc()['count'];

$Approved_query = "SELECT COUNT(*) as count FROM leave_list WHERE Status = 'Approved'";
$Approved_result = $conn->query($Approved_query);
$Approved_count = $Approved_result->fetch_assoc()['count'];


$pendig_query = "SELECT * FROM leave_list where Status = 'Pending' ORDER BY submission_date DESC";
$pending_result = $conn->query($pendig_query);

$approved_query = "SELECT * FROM leave_list where Status = 'Approved' ORDER BY submission_date DESC";
$approved_result = $conn->query($approved_query);

$declined_query = "SELECT * FROM leave_list where Status = 'Declined' ORDER BY submission_date DESC";
$declined_result = $conn->query($declined_query);
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
    <link rel="stylesheet" href="../css/main.css">
    <link rel="icon" type="image/x-icon" href="../img/icon.png">
    <link rel="stylesheet" href="../css/spinner.css">
</head>

<body>


<div id="spinner" class="show">
<div class="spinner-border text-warning" role="status">
  <span class="sr-only">Loading...</span>
</div>
</div>
<script src="../js/spinner.js"></script>

<div class="d-flex">
    <nav class="nav flex-column bg-light p-3" style="width: 300px; min-height: 100vh; ">
        <a class="navbar-brand" href="a-dashboard.php">Leave Management System</a>
        <a class="nav-link" href="a-dashboard.php"> Dashboard</a>
        <a class="nav-link" href="employees.php"> Employees</a>
        <a class="nav-link d-flex justify-content-between align-items-center" href="leave-requests.php">
    Leave Requests
    <?php if ($pending_count > 0): ?>
        <span class="badge bg-warning"><?php echo $pending_count; ?></span>
    <?php endif; ?>
</a>
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
                    <a class="nav-link" href="leave-requests.php">
                        Pending Requests 
                        <?php if ($pending_count > 0): ?>
                            <span class="badge bg-warning"><?php echo $pending_count; ?></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php" onclick="return confirmLogout();">Logout</a>
                </li>
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

    <div class="container mt-4">
            
        <h2 class="text-secondary">Pending Leave Requests</h2>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Submitted Date</th>
                        <th>Employee Name</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $pending_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['submission_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['E_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Leave_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['Start']); ?></td>
                        <td><?php echo htmlspecialchars($row['End']); ?></td>
                        <td>
                            <?php 
                                echo htmlspecialchars($row['Status']); 
                                if ($row['Status'] == 'Pending') {
                                    echo '<i style="color: orange; margin-left: 24px;" class="fas fa-hourglass-start status-icon status-pending"></i>';
                                } elseif ($row['Status'] == 'Approved') {
                                    echo '<i style="color: green; margin-left: 10px;" class="fas fa-check-circle status-icon status-approved"></i>';
                                } elseif ($row['Status'] == 'Declined') {
                                    echo '<i style="color: red; margin-left: 18px;" class="fas fa-times-circle status-icon status-declined"></i>';
                                }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['Comment']); ?></td>
                        
                        <td>
                        <a href="leave-action.php?leave_id=<?php echo htmlspecialchars($row['leave_id']); ?>" > <i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h2 class="text-secondary">Approved Leave Requests</h2>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Submitted Date</th>
                        <th>Employee Name</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th>Admin Id</th>
                        <th>Admin Remark</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $approved_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['submission_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['E_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Leave_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['Start']); ?></td>
                        <td><?php echo htmlspecialchars($row['End']); ?></td>
                        <td>
                            <?php 
                                echo htmlspecialchars($row['Status']); 
                                if ($row['Status'] == 'Pending') {
                                    echo '<i style="color: orange; margin-left: 24px;" class="fas fa-hourglass-start status-icon status-pending"></i>';
                                } elseif ($row['Status'] == 'Approved') {
                                    echo '<i style="color: green; margin-left: 10px;" class="fas fa-check-circle status-icon status-approved"></i>';
                                } elseif ($row['Status'] == 'Declined') {
                                    echo '<i style="color: red; margin-left: 18px;" class="fas fa-times-circle status-icon status-declined"></i>';
                                }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['Comment']); ?></td>
                        <td><?php echo htmlspecialchars($row['A_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['a_remark']); ?></td>
                        <td>
                        <a href="leave-action.php?leave_id=<?php echo htmlspecialchars($row['leave_id']); ?>" > <i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <h2 class="text-secondary">Declined Leave Requests</h2>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Submitted Date</th>
                        <th>Employee Name</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Reason</th>
                        <th>Admin Id</th>
                        <th>Admin Remark</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $declined_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['submission_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['E_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Leave_type']); ?></td>
                        <td><?php echo htmlspecialchars($row['Start']); ?></td>
                        <td><?php echo htmlspecialchars($row['End']); ?></td>
                        <td>
                            <?php 
                                echo htmlspecialchars($row['Status']); 
                                if ($row['Status'] == 'Pending') {
                                    echo '<i style="color: orange; margin-left: 24px;" class="fas fa-hourglass-start status-icon status-pending"></i>';
                                } elseif ($row['Status'] == 'Approved') {
                                    echo '<i style="color: green; margin-left: 10px;" class="fas fa-check-circle status-icon status-approved"></i>';
                                } elseif ($row['Status'] == 'Declined') {
                                    echo '<i style="color: red; margin-left: 18px;" class="fas fa-times-circle status-icon status-declined"></i>';
                                }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['Comment']); ?></td>
                        <td><?php echo htmlspecialchars($row['A_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['a_remark']); ?></td>
                        <td>
                        <a href="leave-action.php?leave_id=<?php echo htmlspecialchars($row['leave_id']); ?>" > <i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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