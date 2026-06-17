<?php
session_start();

// If form is submitted, save to session and redirect to preview
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['cv_data'] = [
        'name'       => htmlspecialchars(trim($_POST['name'])),
        'title'      => htmlspecialchars(trim($_POST['title'])),
        'email'      => htmlspecialchars(trim($_POST['email'])),
        'phone'      => htmlspecialchars(trim($_POST['phone'])),
        'location'   => htmlspecialchars(trim($_POST['location'])),
        'linkedin'   => htmlspecialchars(trim($_POST['linkedin'])),
        'github'     => htmlspecialchars(trim($_POST['github'])),
        'summary'    => htmlspecialchars(trim($_POST['summary'])),
        'skills'     => htmlspecialchars(trim($_POST['skills'])),
        'experience' => htmlspecialchars(trim($_POST['experience'])),
        'education'  => htmlspecialchars(trim($_POST['education'])),
        'projects'   => htmlspecialchars(trim($_POST['projects'])),
        'template'   => htmlspecialchars(trim($_POST['template'] ?? 'modern-dark')),
    ];
    header('Location: preview.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Build Your Portfolio - PortfolioGen</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        .form-page { max-width: 780px; margin: 60px auto; padding: 0 24px 80px; }
        .form-page h1 { font-family: 'Space Grotesk', sans-serif; font-size: 32px; font-weight: 700; margin-bottom: 8px; }
        .form-page .subtitle { color: #94a3b8; margin-bottom: 48px; font-size: 15px; }

        .form-section { margin-bottom: 40px; }
        .form-section h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 16px; font-weight: 700;
            color: #7c83f5;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #2d3148;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group.full { grid-column: 1 / -1; }

        label { font-size: 13px; font-weight: 600; color: #94a3b8; }

        input[type="text"],
        input[type="email"],
        input[type="url"],
        textarea {
            background: #1a1d27;
            border: 1px solid #2d3148;
            border-radius: 8px;
            color: #e2e8f0;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            padding: 12px 14px;
            transition: border-color 0.2s;
            width: 100%;
            outline: none;
        }

        input:focus, textarea:focus { border-color: #7c83f5; }
        textarea { resize: vertical; min-height: 110px; line-height: 1.6; }

        .hint { font-size: 12px; color: #64748b; margin-top: 2px; }

        .submit-row { margin-top: 40px; display: flex; gap: 16px; }
        .submit-btn {
            background: #7c83f5;
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            font-family: 'Inter', sans-serif;
        }
        .submit-btn:hover { background: #5a63e8; transform: translateY(-2px); }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-container">
        <div class="logo"><a href="index.php" style="text-decoration:none;color:inherit;">Portfolio<span class="logo-accent">Gen</span></a></div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
        </div>
    </div>
</nav>

<div class="form-page">
    <h1>Build Your Portfolio ✦</h1>
    <p class="subtitle">Fill in your details below — we'll turn it into a beautiful portfolio page.</p>

    <form method="POST" action="form.php">

        <!-- PERSONAL INFO -->
        <div class="form-section">
            <h2>Personal Info</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" placeholder="e.g. Mashi Loopz" required>
                </div>
                <div class="form-group">
                    <label>Professional Title *</label>
                    <input type="text" name="title" placeholder="e.g. Software Engineering Intern" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" placeholder="you@email.com" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" placeholder="+94 77 000 0000">
                </div>
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" placeholder="Colombo, Sri Lanka">
                </div>
                <div class="form-group">
                    <label>LinkedIn URL</label>
                    <input type="text" name="linkedin" placeholder="linkedin.com/in/yourname">
                </div>
                <div class="form-group full">
                    <label>GitHub URL</label>
                    <input type="text" name="github" placeholder="github.com/yourname">
                </div>
            </div>
        </div>

        <!-- SUMMARY -->
        <div class="form-section">
            <h2>About Me</h2>
            <div class="form-group">
                <label>Professional Summary *</label>
                <textarea name="summary" placeholder="Write 2-3 sentences about yourself, your passion and what you do..." required></textarea>
            </div>
        </div>

        <!-- SKILLS -->
        <div class="form-section">
            <h2>Skills</h2>
            <div class="form-group">
                <label>Skills (comma separated) *</label>
                <input type="text" name="skills" placeholder="PHP, MySQL, React, JavaScript, CSS, Git..." required>
                <span class="hint">Separate each skill with a comma</span>
            </div>
        </div>

        <!-- EXPERIENCE -->
        <div class="form-section">
            <h2>Experience</h2>
            <div class="form-group">
                <label>Work Experience</label>
                <textarea name="experience" placeholder="Job Title at Company Name (Year - Year)
- What you did
- What you achieved

Job Title at Company Name (Year - Year)
- What you did"></textarea>
                <span class="hint">Use new lines to separate roles</span>
            </div>
        </div>

        <!-- EDUCATION -->
        <div class="form-section">
            <h2>Education</h2>
            <div class="form-group">
                <label>Education</label>
                <textarea name="education" placeholder="BSc Hons Software Engineering
NSBM Green University (2023 - 2027)

A/Levels - School Name (Year)"></textarea>
            </div>
        </div>

        <!-- PROJECTS -->
        <div class="form-section">
            <h2>Projects</h2>
            <div class="form-group">
                <label>Projects</label>
                <textarea name="projects" placeholder="Project Name - Short description of what it does and tech used

Project Name - Short description of what it does and tech used"></textarea>
                <span class="hint">One project per line works great</span>
            </div>
        </div>

        <!-- SUBMIT -->
                <!-- TEMPLATE CHOOSER -->
        <div class="form-section">
            <h2>Choose a Template</h2>
            <div class="template-grid">

                <label class="template-card">
                    <input type="radio" name="template" value="modern-dark" checked>
                    <div class="template-preview dark-preview">
                        <div class="tp-bar"></div>
                        <div class="tp-line"></div>
                        <div class="tp-line short"></div>
                        <div class="tp-dots">
                            <span></span><span></span><span></span>
                        </div>
                    </div>
                    <div class="template-info">
                        <strong>Modern Dark</strong>
                        <span>Dark theme, purple accents</span>
                    </div>
                    <div class="template-check">✓</div>
                </label>

                <label class="template-card">
                    <input type="radio" name="template" value="clean-light">
                    <div class="template-preview light-preview">
                        <div class="tp-bar light"></div>
                        <div class="tp-line dark"></div>
                        <div class="tp-line short dark"></div>
                        <div class="tp-dots">
                            <span class="dark"></span><span class="dark"></span><span class="dark"></span>
                        </div>
                    </div>
                    <div class="template-info">
                        <strong>Clean Light</strong>
                        <span>Minimal, white &amp; blue</span>
                    </div>
                    <div class="template-check">✓</div>
                </label>

                <label class="template-card">
                    <input type="radio" name="template" value="creative">
                    <div class="template-preview creative-preview">
                        <div class="tp-bar creative"></div>
                        <div class="tp-line"></div>
                        <div class="tp-line short"></div>
                        <div class="tp-dots">
                            <span class="orange"></span><span class="orange"></span><span class="orange"></span>
                        </div>
                    </div>
                    <div class="template-info">
                        <strong>Creative</strong>
                        <span>Bold, colorful gradients</span>
                    </div>
                    <div class="template-check">✓</div>
                </label>

            </div>
        </div>

        <!-- SUBMIT -->
        <div class="submit-row">
            <button type="submit" class="submit-btn">Preview My Portfolio →</button>
            <a href="index.php" class="btn btn-outline">Cancel</a>
        </div>

    </form>
</div>

<!-- Template card styles -->
<style>
.template-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}
.template-card {
    position: relative;
    cursor: pointer;
    border: 2px solid #2d3148;
    border-radius: 12px;
    overflow: hidden;
    transition: border-color 0.2s, transform 0.15s;
    background: #1a1d27;
}
.template-card:hover { border-color: #7c83f5; transform: translateY(-2px); }
.template-card input[type="radio"] { display: none; }
.template-card input[type="radio"]:checked ~ .template-check { opacity: 1; }
.template-card input[type="radio"]:checked ~ .template-info strong { color: #7c83f5; }
.template-card:has(input:checked) { border-color: #7c83f5; }

.template-preview {
    height: 120px;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.dark-preview    { background: #0f1117; }
.light-preview   { background: #f8fafc; }
.creative-preview{ background: linear-gradient(135deg, #1a0533, #0d1b4b); }

.tp-bar  { height: 10px; width: 60%; border-radius: 4px; background: #7c83f5; }
.tp-bar.light    { background: #3b82f6; }
.tp-bar.creative { background: linear-gradient(90deg, #f97316, #ec4899); }
.tp-line { height: 6px; width: 90%; border-radius: 3px; background: #2d3148; }
.tp-line.short   { width: 60%; }
.tp-line.dark    { background: #cbd5e1; }
.tp-dots { display: flex; gap: 6px; margin-top: 4px; }
.tp-dots span { width: 28px; height: 6px; border-radius: 3px; background: #7c83f5; display: block; }
.tp-dots span.dark   { background: #3b82f6; }
.tp-dots span.orange { background: #f97316; }

.template-info {
    padding: 12px 14px;
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.template-info strong { font-size: 14px; color: #e2e8f0; }
.template-info span   { font-size: 12px; color: #64748b; }

.template-check {
    position: absolute;
    top: 10px; right: 10px;
    background: #7c83f5;
    color: white;
    width: 22px; height: 22px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 700;
    opacity: 0;
    transition: opacity 0.2s;
}
</style>

</body>
</html>

    </form>
</div>

</body>
</html>