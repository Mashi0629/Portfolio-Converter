<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortfolioGen - Turn Your CV Into a Portfolio</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-container">
        <div class="logo">Portfolio<span class="logo-accent">Gen</span></div>
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="form.php" class="btn-nav">Create Portfolio</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-container">
        <div class="hero-badge">✦ Free &amp; No Sign-up Required</div>
        <h1 class="hero-title">
            Your CV deserves to<br>
            <span class="hero-highlight">look like a portfolio.</span>
        </h1>
        <p class="hero-sub">
            Fill in your details, pick a template, and download a beautiful portfolio website — in minutes.
        </p>
        <div class="hero-actions">
            <a href="form.php" class="btn-primary">Build My Portfolio →</a>
            <a href="dashboard.php" class="btn-ghost">View Dashboard</a>
        </div>
    </div>

    <!-- Floating cards decoration -->
    <div class="hero-visual">
        <div class="card-float card-1">
            <div class="card-dot"></div>
            <span>Skills Added</span>
            <strong>React, PHP, MySQL</strong>
        </div>
        <div class="card-float card-2">
            <div class="card-dot green"></div>
            <span>Portfolio Ready</span>
            <strong>Download Now ↓</strong>
        </div>
        <div class="card-float card-3">
            <div class="card-dot purple"></div>
            <span>Template</span>
            <strong>Modern Dark</strong>
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="steps">
    <div class="steps-container">
        <h2 class="section-title">How it works</h2>
        <div class="steps-grid">
            <div class="step-card">
                <div class="step-icon">📝</div>
                <h3>Fill Your Details</h3>
                <p>Enter your name, skills, experience, and education into a simple form.</p>
            </div>
            <div class="step-card">
                <div class="step-icon">👁️</div>
                <h3>Preview Live</h3>
                <p>See your portfolio rendered instantly before you download it.</p>
            </div>
            <div class="step-card">
                <div class="step-icon">⬇️</div>
                <h3>Download &amp; Share</h3>
                <p>Download your portfolio as a ready-to-host HTML file.</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer">
    <p>Built with ☕ for interns who deserve better than a plain CV.</p>
</footer>

</body>
</html>