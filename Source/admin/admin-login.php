<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - LMS</title>
    <link rel="stylesheet" href="../css/a-login.css">
    <link href="../bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       
    </style>
</head>
<body>
    <a href="../../index.php" class="admin-panel-link">Go to Employee Login</a>
    <div class="login-wrapper">
        <div class="login-sidebar">
            <div>
                <h1>Welcome Admin!</h1>
                <p>Manage the leave system efficiently and oversee all activities from this panel.</p>
            </div>
        </div>
        <div class="login-form-container">
            <div class="login-form">
                <h2 class="text-center">Admin Login</h2>
                <form action="admin-login-code.php" method="post">
                    <div class="form-group">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" style="width:340px">Login</button>
                    <div class="form-footer">
                        <p><a href="forgot-password.php">Forgot Password?</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>