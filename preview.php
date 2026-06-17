<?php
session_start();

// If no CV data in session, redirect back to form
if (empty($_SESSION['cv_data'])) {
    header('Location: form.php');
    exit;
}

$cv = $_SESSION['cv_data'];
$template = $cv['template'] ?? 'modern-dark';

// Parse skills into array
$skills = array_map('trim', explode(',', $cv['skills']));

// Parse experience, education, projects into lines
$experience_lines = array_filter(array_map('trim', explode("\n", $cv['experience'])));
$education_lines  = array_filter(array_map('trim', explode("\n", $cv['education'])));
$project_lines    = array_filter(array_map('trim', explode("\n", $cv['projects'])));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview - <?php echo $cv['name']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        /* ── BASE ── */
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Inter', sans-serif; }

        /* ── PREVIEW TOOLBAR ── */
        .preview-bar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 999;
            background: #1a1d27;
            border-bottom: 1px solid #2d3148;
            padding: 12px 24px;
            display: flex; align-items: center; justify-content: space-between;
            gap: 16px;
        }
        .preview-bar .logo { color: #7c83f5; font-weight: 700; font-size: 16px; font-family: 'Space Grotesk', sans-serif; }
        .preview-bar .actions { display: flex; gap: 12px; }
        .preview-bar a, .preview-bar button {
            padding: 9px 20px; border-radius: 8px; font-size: 13px; font-weight: 600;
            text-decoration: none; cursor: pointer; border: none; font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }
        .btn-back    { background: transparent; border: 1px solid #2d3148; color: #94a3b8; }
        .btn-back:hover { border-color: #7c83f5; color: #7c83f5; }
        .btn-edit    { background: transparent; border: 1px solid #2d3148; color: #94a3b8; }
        .btn-edit:hover { border-color: #7c83f5; color: #7c83f5; }
        .btn-download { background: #7c83f5; color: white; }
        .btn-download:hover { background: #5a63e8; }

        /* ── PORTFOLIO WRAPPER ── */
        .portfolio-wrapper { padding-top: 65px; }

        /* ════════════════════════════════════════
           TEMPLATE 1: MODERN DARK
        ════════════════════════════════════════ */
        .t-modern-dark {
            background: #0f1117;
            color: #e2e8f0;
            min-height: 100vh;
        }
        .t-modern-dark .hero {
            background: linear-gradient(135deg, #0f1117 0%, #1a1d27 100%);
            padding: 80px 40px;
            text-align: center;
            border-bottom: 1px solid #2d3148;
            position: relative;
            overflow: hidden;
        }
        .t-modern-dark .hero::before {
            content: '';
            position: absolute; top: -150px; left: 50%; transform: translateX(-50%);
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(124,131,245,0.15) 0%, transparent 70%);
        }
        .t-modern-dark .hero-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(36px, 5vw, 64px);
            font-weight: 700; color: #fff; margin-bottom: 12px; position: relative;
        }
        .t-modern-dark .hero-title {
            font-size: 18px; color: #7c83f5; font-weight: 600; margin-bottom: 24px;
        }
        .t-modern-dark .hero-contact {
            display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;
            font-size: 14px; color: #94a3b8;
        }
        .t-modern-dark .hero-contact a { color: #94a3b8; text-decoration: none; }
        .t-modern-dark .hero-contact a:hover { color: #7c83f5; }
        .t-modern-dark .content { max-width: 900px; margin: 0 auto; padding: 60px 40px; }
        .t-modern-dark .section { margin-bottom: 56px; }
        .t-modern-dark .section-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 13px; font-weight: 700; letter-spacing: 0.12em;
            text-transform: uppercase; color: #7c83f5;
            margin-bottom: 24px; padding-bottom: 10px;
            border-bottom: 1px solid #2d3148;
        }
        .t-modern-dark .summary-text { color: #94a3b8; line-height: 1.8; font-size: 15px; }
        .t-modern-dark .skills-wrap { display: flex; flex-wrap: wrap; gap: 10px; }
        .t-modern-dark .skill-tag {
            background: #1e2535; border: 1px solid #2d3148;
            color: #c7d2fe; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 500;
        }
        .t-modern-dark .entry { margin-bottom: 16px; color: #cbd5e1; font-size: 14px; line-height: 1.8; }
        .t-modern-dark .entry-line { padding: 6px 0; border-left: 2px solid #2d3148; padding-left: 14px; }
        .t-modern-dark .entry-line:first-child { border-color: #7c83f5; }

        /* ════════════════════════════════════════
           TEMPLATE 2: CLEAN LIGHT
        ════════════════════════════════════════ */
        .t-clean-light {
            background: #f8fafc;
            color: #1e293b;
            min-height: 100vh;
        }
        .t-clean-light .hero {
            background: #fff;
            border-bottom: 3px solid #3b82f6;
            padding: 64px 40px;
            text-align: center;
            box-shadow: 0 1px 20px rgba(0,0,0,0.06);
        }
        .t-clean-light .hero-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(32px, 5vw, 56px);
            font-weight: 700; color: #1e293b; margin-bottom: 10px;
        }
        .t-clean-light .hero-title { font-size: 18px; color: #3b82f6; font-weight: 600; margin-bottom: 20px; }
        .t-clean-light .hero-contact {
            display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;
            font-size: 14px; color: #64748b;
        }
        .t-clean-light .hero-contact a { color: #3b82f6; text-decoration: none; }
        .t-clean-light .content { max-width: 900px; margin: 0 auto; padding: 56px 40px; }
        .t-clean-light .section { margin-bottom: 48px; }
        .t-clean-light .section-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 20px; font-weight: 700; color: #1e293b;
            margin-bottom: 20px; padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
        }
        .t-clean-light .summary-text { color: #475569; line-height: 1.8; font-size: 15px; }
        .t-clean-light .skills-wrap { display: flex; flex-wrap: wrap; gap: 10px; }
        .t-clean-light .skill-tag {
            background: #eff6ff; border: 1px solid #bfdbfe;
            color: #1d4ed8; padding: 6px 14px; border-radius: 6px; font-size: 13px; font-weight: 600;
        }
        .t-clean-light .entry { margin-bottom: 16px; }
        .t-clean-light .entry-line { padding: 6px 0 6px 14px; border-left: 3px solid #e2e8f0; color: #475569; font-size: 14px; line-height: 1.8; }
        .t-clean-light .entry-line:first-child { border-color: #3b82f6; color: #1e293b; font-weight: 600; }

        /* ════════════════════════════════════════
           TEMPLATE 3: CREATIVE
        ════════════════════════════════════════ */
        .t-creative {
            background: #0d0d1a;
            color: #e2e8f0;
            min-height: 100vh;
        }
        .t-creative .hero {
            background: linear-gradient(135deg, #1a0533 0%, #0d1b4b 50%, #0d0d1a 100%);
            padding: 80px 40px;
            text-align: center;
            position: relative; overflow: hidden;
        }
        .t-creative .hero::after {
            content: '';
            position: absolute; bottom: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, #f97316, #ec4899, #8b5cf6, #3b82f6);
        }
        .t-creative .hero-name {
            font-family: 'Space Grotesk', sans-serif;
            font-size: clamp(36px, 5vw, 64px);
            font-weight: 700;
            background: linear-gradient(135deg, #f97316, #ec4899, #8b5cf6);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
        }
        .t-creative .hero-title { font-size: 18px; color: #fb923c; font-weight: 600; margin-bottom: 24px; }
        .t-creative .hero-contact {
            display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;
            font-size: 14px; color: #94a3b8;
        }
        .t-creative .hero-contact a { color: #fb923c; text-decoration: none; }
        .t-creative .content { max-width: 900px; margin: 0 auto; padding: 60px 40px; }
        .t-creative .section { margin-bottom: 56px; }
        .t-creative .section-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 13px; font-weight: 700; letter-spacing: 0.12em;
            text-transform: uppercase;
            background: linear-gradient(90deg, #f97316, #ec4899);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 24px; padding-bottom: 10px;
            border-bottom: 1px solid #1e1e3a;
        }
        .t-creative .summary-text { color: #94a3b8; line-height: 1.8; font-size: 15px; }
        .t-creative .skills-wrap { display: flex; flex-wrap: wrap; gap: 10px; }
        .t-creative .skill-tag {
            background: linear-gradient(135deg, rgba(249,115,22,0.15), rgba(236,72,153,0.15));
            border: 1px solid rgba(249,115,22,0.3);
            color: #fdba74; padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 500;
        }
        .t-creative .entry { margin-bottom: 16px; }
        .t-creative .entry-line { padding: 6px 0 6px 14px; border-left: 2px solid #1e1e3a; color: #94a3b8; font-size: 14px; line-height: 1.8; }
        .t-creative .entry-line:first-child { border-image: linear-gradient(180deg, #f97316, #ec4899) 1; color: #e2e8f0; }
    </style>
</head>
<body>

<!-- PREVIEW TOOLBAR -->
<div class="preview-bar">
    <div class="logo">PortfolioGen — Preview</div>
    <div class="actions">
        <a href="form.php" class="btn-edit">← Edit</a>
        <a href="download.php" class="btn-download">⬇ Download HTML</a>
    </div>
</div>

<!-- PORTFOLIO -->
<div class="portfolio-wrapper">
<div class="t-<?php echo $template; ?>">

    <!-- HERO -->
    <div class="hero">
        <div class="hero-name"><?php echo $cv['name']; ?></div>
        <div class="hero-title"><?php echo $cv['title']; ?></div>
        <div class="hero-contact">
            <?php if ($cv['email'])    echo '<span>✉ ' . $cv['email'] . '</span>'; ?>
            <?php if ($cv['phone'])    echo '<span>📞 ' . $cv['phone'] . '</span>'; ?>
            <?php if ($cv['location']) echo '<span>📍 ' . $cv['location'] . '</span>'; ?>
            <?php if ($cv['linkedin']) echo '<a href="https://' . $cv['linkedin'] . '" target="_blank">🔗 LinkedIn</a>'; ?>
            <?php if ($cv['github'])   echo '<a href="https://' . $cv['github'] . '" target="_blank">💻 GitHub</a>'; ?>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <!-- ABOUT -->
        <?php if ($cv['summary']): ?>
        <div class="section">
            <div class="section-title">About Me</div>
            <p class="summary-text"><?php echo nl2br($cv['summary']); ?></p>
        </div>
        <?php endif; ?>

        <!-- SKILLS -->
        <?php if (!empty($skills)): ?>
        <div class="section">
            <div class="section-title">Skills</div>
            <div class="skills-wrap">
                <?php foreach ($skills as $skill): ?>
                    <span class="skill-tag"><?php echo $skill; ?></span>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- EXPERIENCE -->
        <?php if (!empty($experience_lines)): ?>
        <div class="section">
            <div class="section-title">Experience</div>
            <div class="entry">
                <?php foreach ($experience_lines as $line): ?>
                    <div class="entry-line"><?php echo htmlspecialchars($line); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- EDUCATION -->
        <?php if (!empty($education_lines)): ?>
        <div class="section">
            <div class="section-title">Education</div>
            <div class="entry">
                <?php foreach ($education_lines as $line): ?>
                    <div class="entry-line"><?php echo htmlspecialchars($line); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- PROJECTS -->
        <?php if (!empty($project_lines)): ?>
        <div class="section">
            <div class="section-title">Projects</div>
            <div class="entry">
                <?php foreach ($project_lines as $line): ?>
                    <div class="entry-line"><?php echo htmlspecialchars($line); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div><!-- end content -->
</div><!-- end template -->
</div><!-- end portfolio-wrapper -->

</body>
</html>