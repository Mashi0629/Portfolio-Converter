<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PortfolioGen</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        .dash-page { max-width: 1000px; margin: 60px auto; padding: 0 24px 80px; }

        .dash-header {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 48px; flex-wrap: wrap; gap: 16px;
        }
        .dash-header h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 28px; font-weight: 700;
        }

        /* ── STATS ROW ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px; margin-bottom: 48px;
        }
        .stat-card {
            background: #1a1d27; border: 1px solid #2d3148;
            border-radius: 12px; padding: 24px;
        }
        .stat-card .stat-label { font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 8px; }
        .stat-card .stat-value { font-family: 'Space Grotesk', sans-serif; font-size: 32px; font-weight: 700; color: #7c83f5; }
        .stat-card .stat-sub   { font-size: 12px; color: #64748b; margin-top: 4px; }

        /* ── CURRENT SESSION CARD ── */
        .section-label {
            font-size: 13px; font-weight: 700; color: #64748b;
            text-transform: uppercase; letter-spacing: 0.08em;
            margin-bottom: 20px;
        }

        .portfolio-card {
            background: #1a1d27; border: 1px solid #2d3148;
            border-radius: 14px; padding: 28px;
            display: flex; align-items: flex-start;
            justify-content: space-between; gap: 24px;
            flex-wrap: wrap; margin-bottom: 16px;
            transition: border-color 0.2s;
        }
        .portfolio-card:hover { border-color: #7c83f5; }

        .card-left { flex: 1; min-width: 200px; }
        .card-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px; font-weight: 700; color: #e2e8f0;
            margin-bottom: 4px;
        }
        .card-title { font-size: 14px; color: #7c83f5; margin-bottom: 12px; }
        .card-meta  { font-size: 13px; color: #64748b; display: flex; gap: 20px; flex-wrap: wrap; }

        .card-badge {
            display: inline-block;
            padding: 4px 12px; border-radius: 20px;
            font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em;
        }
        .badge-dark     { background: #1e2535; color: #c7d2fe; border: 1px solid #2d3148; }
        .badge-light    { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-creative { background: rgba(249,115,22,.15); color: #fdba74; border: 1px solid rgba(249,115,22,.3); }

        .card-actions { display: flex; gap: 10px; flex-wrap: wrap; align-items: center; }
        .card-actions a, .card-actions button {
            padding: 9px 18px; border-radius: 8px; font-size: 13px;
            font-weight: 600; text-decoration: none; cursor: pointer;
            border: none; font-family: 'Inter', sans-serif; transition: all 0.2s;
        }
        .btn-preview  { background: transparent; border: 1px solid #2d3148; color: #94a3b8; }
        .btn-preview:hover  { border-color: #7c83f5; color: #7c83f5; }
        .btn-dl       { background: #7c83f5; color: white; }
        .btn-dl:hover { background: #5a63e8; }
        .btn-new      { background: #22c55e; color: white; }
        .btn-new:hover{ background: #16a34a; }

        /* ── EMPTY STATE ── */
        .empty-state {
            background: #1a1d27; border: 1px dashed #2d3148;
            border-radius: 14px; padding: 64px 40px;
            text-align: center;
        }
        .empty-icon  { font-size: 48px; margin-bottom: 16px; }
        .empty-state h2 { font-family: 'Space Grotesk', sans-serif; font-size: 22px; font-weight: 700; margin-bottom: 10px; }
        .empty-state p  { color: #64748b; font-size: 14px; margin-bottom: 28px; }

        /* ── HOW TO USE ── */
        .how-section { margin-top: 56px; }
        .how-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px; margin-top: 20px;
        }
        .how-card {
            background: #1a1d27; border: 1px solid #2d3148;
            border-radius: 12px; padding: 24px;
        }
        .how-step { font-size: 11px; font-weight: 700; color: #7c83f5; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 8px; }
        .how-card h3 { font-size: 15px; font-weight: 700; margin-bottom: 6px; }
        .how-card p  { font-size: 13px; color: #64748b; line-height: 1.6; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-container">
        <div class="logo">
            <a href="index.php" style="text-decoration:none;color:inherit;">Portfolio<span class="logo-accent">Gen</span></a>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="form.php" class="btn-nav">Create Portfolio</a>
        </div>
    </div>
</nav>

<div class="dash-page">

    <!-- HEADER -->
    <div class="dash-header">
        <h1>Dashboard ✦</h1>
        <a href="form.php" class="btn btn-blue">+ Create New Portfolio</a>
    </div>

    <!-- STATS -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">Session Portfolio</div>
            <div class="stat-value"><?php echo isset($_SESSION['cv_data']) ? '1' : '0'; ?></div>
            <div class="stat-sub">Currently loaded</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Templates</div>
            <div class="stat-value">3</div>
            <div class="stat-sub">Available designs</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Status</div>
            <div class="stat-value" style="font-size:20px;padding-top:6px;">
                <?php echo isset($_SESSION['cv_data']) ? '✅ Ready' : '⏳ Empty'; ?>
            </div>
            <div class="stat-sub">Download available</div>
        </div>
    </div>

    <!-- PORTFOLIO CARD OR EMPTY STATE -->
    <div class="section-label">Current Portfolio</div>

    <?php if (isset($_SESSION['cv_data'])): ?>
        <?php
            $cv = $_SESSION['cv_data'];
            $template = $cv['template'] ?? 'modern-dark';
            $badge_class = [
                'modern-dark' => 'badge-dark',
                'clean-light' => 'badge-light',
                'creative'    => 'badge-creative',
            ][$template] ?? 'badge-dark';
            $badge_label = [
                'modern-dark' => 'Modern Dark',
                'clean-light' => 'Clean Light',
                'creative'    => 'Creative',
            ][$template] ?? 'Modern Dark';
            $skills_preview = implode(', ', array_slice(array_map('trim', explode(',', $cv['skills'])), 0, 4));
        ?>
        <div class="portfolio-card">
            <div class="card-left">
                <div class="card-name"><?php echo htmlspecialchars($cv['name']); ?></div>
                <div class="card-title"><?php echo htmlspecialchars($cv['title']); ?></div>
                <div class="card-meta">
                    <span>✉ <?php echo htmlspecialchars($cv['email']); ?></span>
                    <?php if ($cv['location']): ?>
                        <span>📍 <?php echo htmlspecialchars($cv['location']); ?></span>
                    <?php endif; ?>
                    <span>🎨 <span class="card-badge <?php echo $badge_class; ?>"><?php echo $badge_label; ?></span></span>
                </div>
                <?php if ($skills_preview): ?>
                    <div style="margin-top:12px;font-size:12px;color:#64748b;">
                        Skills: <?php echo htmlspecialchars($skills_preview); ?><?php echo (count(explode(',', $cv['skills'])) > 4) ? '...' : ''; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-actions">
                <a href="preview.php" class="btn-preview">👁 Preview</a>
                <a href="download.php" class="btn-dl">⬇ Download</a>
            </div>
        </div>

        <div style="margin-top:16px;">
            <a href="form.php" class="btn btn-outline" style="font-size:13px;">✏️ Edit this portfolio</a>
        </div>

    <?php else: ?>
        <div class="empty-state">
            <div class="empty-icon">📭</div>
            <h2>No portfolio yet</h2>
            <p>Fill in your CV details to generate your first portfolio.</p>
            <a href="form.php" class="btn btn-blue">Create My Portfolio →</a>
        </div>
    <?php endif; ?>

    <!-- HOW TO USE -->
    <div class="how-section">
        <div class="section-label">How to use PortfolioGen</div>
        <div class="how-grid">
            <div class="how-card">
                <div class="how-step">Step 1</div>
                <h3>📝 Fill the Form</h3>
                <p>Enter your name, skills, experience, education and projects.</p>
            </div>
            <div class="how-card">
                <div class="how-step">Step 2</div>
                <h3>🎨 Pick a Template</h3>
                <p>Choose from Modern Dark, Clean Light, or Creative gradient styles.</p>
            </div>
            <div class="how-card">
                <div class="how-step">Step 3</div>
                <h3>👁 Preview Live</h3>
                <p>See your portfolio rendered instantly before downloading.</p>
            </div>
            <div class="how-card">
                <div class="how-step">Step 4</div>
                <h3>⬇ Download & Share</h3>
                <p>Download a ready-to-host HTML file and share it anywhere.</p>
            </div>
        </div>
    </div>

</div><!-- end dash-page -->
</body>
</html>