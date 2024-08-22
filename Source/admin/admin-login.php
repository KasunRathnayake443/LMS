<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - LMS</title>
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-color: #f0f2f5;
            position: relative;
        }
        .login-wrapper {
            display: flex;
            height: 100%;
            flex-direction: row;
        }
        .login-sidebar {
            flex: 1;
            background: #343a40;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 20px;
        }
        .login-sidebar h1 {
            margin: 0;
            font-size: 2.5rem;
        }
        .login-sidebar p {
            font-size: 1.2rem;
        }
        .login-form-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .login-form h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-footer {
            margin-top: 20px;
            text-align: center;
        }
        .form-footer a {
            color: #007bff;
            text-decoration: none;
        }
        .admin-panel-link {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 0.9rem;
            color: #007bff;
            text-decoration: none;
        }
        .admin-panel-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }
            .login-sidebar {
                width: 100%;
                height: auto;
                padding: 20px;
            }
            .login-form-container {
                width: 100%;
                padding: 20px;
            }
        }
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
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                    <div class="form-footer">
                        <p><a href="forgot-password.php">Forgot Password?</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="source/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>
</html>