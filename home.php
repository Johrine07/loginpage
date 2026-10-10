<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$name = htmlspecialchars($_SESSION['full_name'] ?? 'User', ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_SESSION['email'] ?? '', ENT_QUOTES, 'UTF-8');
$firstName = explode(' ', trim($_SESSION['full_name'] ?? 'there'))[0];
$firstName = htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | BrightSpace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="dashboard-page">
    <header class="topbar">
        <a class="brand dark-brand" href="home.php"><span class="brand-mark">B</span> BrightSpace</a>
        <div class="topbar-right">
            <span class="user-chip"><span class="avatar"><?= strtoupper(substr($firstName, 0, 1)) ?></span><span><?= $name ?></span></span>
            <a class="logout-link" href="logout.php">Log out ↗</a>
        </div>
    </header>

    <main class="dashboard-main">
        <section class="hero-card">
            <div class="hero-content">
                <p class="eyebrow">YOUR PERSONAL SPACE</p>
                <h1>Hello, <?= $firstName ?>! <span class="wave">✦</span></h1>
                <p>You're signed in and ready to go. This is your home page, where you can start organizing your day.</p>
                <span class="status-pill"><span class="status-dot"></span> Account active</span>
            </div>
            <div class="hero-art" aria-hidden="true">
                <div class="art-card card-back"></div>
                <div class="art-card card-front"><span class="art-star">✦</span><span class="art-line long"></span><span class="art-line"></span><span class="art-line short"></span><div class="art-check">✓</div></div>
                <div class="art-orb"></div>
            </div>
        </section>

        <section class="section-heading">
            <div><p class="eyebrow accent">OVERVIEW</p><h2>Your dashboard</h2></div>
            <span class="date-label"><?= date('F j, Y') ?></span>
        </section>

        <section class="dashboard-grid">
            <article class="info-card">
                <div class="card-icon lavender">♙</div>
                <p class="card-label">PROFILE</p>
                <h3><?= $name ?></h3>
                <p class="card-description">Your registered account name.</p>
            </article>
            <article class="info-card">
                <div class="card-icon mint">✉</div>
                <p class="card-label">EMAIL ADDRESS</p>
                <h3 class="email-value"><?= $email ?></h3>
                <p class="card-description">The email connected to your account.</p>
            </article>
            <article class="info-card">
                <div class="card-icon peach">✓</div>
                <p class="card-label">SIGN-IN STATUS</p>
                <h3>Successfully signed in</h3>
                <p class="card-description">Your session is protected until you log out.</p>
            </article>
        </section>

        <section class="getting-started">
            <div class="getting-icon">✦</div>
            <div><h3>You're all set!</h3><p>This sample home page demonstrates a protected page that is only available after login. You can customize this section for your own project.</p></div>
        </section>
        <footer class="dashboard-footer">BrightSpace <span>•</span> Simple login system project</footer>
    </main>
</body>
</html>
