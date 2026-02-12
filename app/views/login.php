<?php
// Login View
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.min.css">
    <script defer src="<?= BASE_URL ?>/js/validation-ajax.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ffc800;
        }
        .btn-primary {
            background-color: #ffc800;
            border-color: #ffc800;
            color: #000;
        }
        .btn-primary:hover {
            background-color: #e6b800;
            border-color: #e6b800;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <form action="<?= BASE_URL ?>/login" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group" id="passwordGroup">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group form-check" id="adminCheck">
                <input type="checkbox" class="form-check-input" id="isAdmin" name="isAdmin">
                <label class="form-check-label" for="isAdmin">Login as Admin</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <p class="text-center mt-3"><a id="inscription">S'inscrire</a></p>
        </form>
    </div>

    <script>
        var isadmin = document.getElementById('isAdmin');
        var inscription = document.getElementById('inscription');
        var adminCheck = document.getElementById('adminCheck');
        
        inscription.addEventListener('click', function() {
            adminCheck
        });

        
    </script>

</body>
</html>