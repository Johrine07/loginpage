<?php
session_start();
require_once __DIR__ . '/db.php';

if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $error = 'Please enter both your email and password.';
    } else {
        $stmt = $pdo->prepare('SELECT id, full_name, email, password_hash FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            header('Location: home.php');
            exit;
        }
        $error = 'Incorrect email or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in | BrightSpace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-page">
    <main class="auth-layout">
        <section class="welcome-panel">
            <div class="brand"><span class="brand-mark">B</span> BrightSpace</div>
            <div class="welcome-copy">
                <p class="eyebrow">YOUR SPACE TO GET THINGS DONE</p>
                <h1>Welcome back.</h1>
                <p>Sign in to continue to your personal dashboard and keep everything in one place.</p>
            </div>
            <div class="decor-circle circle-one"></div>
            <div class="decor-circle circle-two"></div>
            <p class="panel-footer">Simple. Secure. Organized.</p>
        </section>

        <section class="form-panel">
            <div class="mobile-brand"><span class="brand-mark">B</span> BrightSpace</div>
            <div class="form-wrap">
                <p class="eyebrow accent">ACCOUNT ACCESS</p>
                <h2>Sign in to your account</h2>
                <p class="muted">Enter your details below to get started.</p>

                <?php if ($error): ?>
                    <div class="alert" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endif; ?>

                <form method="POST" action="index.php">
                    <label for="email">Email address</label>
                    <input id="email" name="email" type="email" placeholder="you@example.com" autocomplete="email" required value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" placeholder="Enter your password" autocomplete="current-password" required>

                    <button class="primary-button" type="submit">Sign in <span aria-hidden="true">→</span></button>
                </form>

                <p class="form-bottom">New to BrightSpace? <a href="register.php">Create an account</a></p>
                <p class="demo-note">For your class project: create an account first, then sign in.</p>
            </div>
            <p class="copyright">© <?= date('Y') ?> BrightSpace. Student project demo.</p>
        </section>
    </main>
</body>
</html>
