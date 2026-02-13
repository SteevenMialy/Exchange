<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get login errors from session and clear them
$errors = $_SESSION['signin_errors'] ?? [];
unset($_SESSION['signin_errors']);

function e($v)
{
    return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
}
function cls_invalid($errors, $field)
{
    return ($errors[$field] ?? '') !== '' ? 'is-invalid' : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.min.css">
    <script defer src="<?= BASE_URL ?>/js/validation-login.js"></script>
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
        <?php if (!empty($errors['_global'])): ?>
            <div class="alert alert-danger" role="alert">
                <?= e($errors['_global']) ?>
            </div>
        <?php endif; ?>
        <div id="formStatus"></div>
        <form action="<?= BASE_URL ?>/login" method="POST" id="registerForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control <?= cls_invalid($errors, 'username') ?>" id="username" name="username" placeholder="Enter your username" value="Test User" required>
                <div class="invalid-feedback" id="usernameError">
                    <?= e($errors['username'] ?? '') ?>
                </div>
            </div>
            <div class="form-group" id="passwordGroup">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control <?= cls_invalid($errors, 'password') ?>" id="password" name="password" placeholder="Enter your password" value="Abcd123!" required>
                    <button type="button" id="togglePassword" class="btn btn-outline-secondary">Show</button>
                    <div class="invalid-feedback" id="passwordError">
                        <?= e($errors['password'] ?? '') ?>
                    </div>
                </div>
            </div>
            <div class="form-group form-check" id="adminCheck">
                <input type="checkbox" class="form-check-input" id="isAdmin" name="isAdmin">
                <label class="form-check-label" for="isAdmin">Login as Admin</label>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <p class="text-center mt-3"><a href="<?= BASE_URL ?>/signin" id="inscription">S'inscrire</a></p>
        </form>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const passwordFieldType = passwordField.getAttribute('type');
            passwordField.setAttribute('type', passwordFieldType === 'password' ? 'text' : 'password');
            this.textContent = passwordFieldType === 'password' ? 'Hide' : 'Show';
        });

        
    </script>

</body>
</html>