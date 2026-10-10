<?php
session_start();
require_once __DIR__ . '/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}

$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($fullName === '' || $email === '' || $password === '' || $confirmPassword === '') {
        $error = 'Please complete all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } elseif ($password !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        $check = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $check->execute([$email]);
        if ($check->fetch()) {
            $error = 'That email is already registered. Please sign in instead.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)');
            $insert->execute([$fullName, $email, $hash]);
            $success = 'Account created successfully. You can now sign in.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account | BrightSpace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <main class="auth-layout">
        <section class="welcome-panel">
            <div class="brand"><span class="brand-mark">B</span> BrightSpace</div>
            <div class="welcome-copy">
                <p class="eyebrow">MAKE IT YOURS</p>
                <h1>Your next chapter starts here.</h1>
                <p>Create an account to access your own private dashboard.</p>
            </div>
            <div class="decor-circle circle-one"></div>
            <div class="decor-circle circle-two"></div>
            <p class="panel-footer">Simple. Secure. Organized.</p>
        </section>

        <section class="form-panel">
            <div class="mobile-brand"><span class="brand-mark">B</span> BrightSpace</div>
            <div class="form-wrap">
                <p class="eyebrow accent">GET STARTED</p>
                <h2>Create your account</h2>
                <p class="muted">Fill in the details to get started.</p>

                <?php if ($error): ?><div class="alert" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
                <?php if ($success): ?><div class="success" role="status"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?> <a href="index.php">Sign in</a></div><?php endif; ?>

                <form method="POST" action="register.php">
                    <label for="full_name">Full name</label>
                    <input id="full_name" name="full_name" type="text" placeholder="Your full name" autocomplete="name" required value="<?= htmlspecialchars($_POST['full_name'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" placeholder="you@example.com" autocomplete="email" required value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                    <label for="password">Password <span class="label-hint">(8 characters minimum)</span></label>
                    <input id="password" name="password" type="password" placeholder="Create a password" autocomplete="new-password" required minlength="8">

                    <label for="confirm_password">Confirm password</label>
                    <input id="confirm_password" name="confirm_password" type="password" placeholder="Enter it again" autocomplete="new-password" required minlength="8">

                    <button class="primary-button" type="submit">Create account <span aria-hidden="true">→</span></button>
                </form>
                <p class="form-bottom">Already have an account? <a href="index.php">Sign in</a></p>
            </div>
            <p class="copyright">© <?= date('Y') ?> BrightSpace. Student project demo.</p>
        </section>
    </main>
</body>
</html>
