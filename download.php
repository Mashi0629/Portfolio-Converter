<?php
session_start();

if (empty($_SESSION['cv_data'])) {
    header('Location: form.php');
    exit;
}

$cv       = $_SESSION['cv_data'];
$template = $cv['template'] ?? 'modern-dark';
$skills   = array_map('trim', explode(',', $cv['skills']));

$name     = htmlspecialchars($cv['name']);
$title    = htmlspecialchars($cv['title']);
$email    = htmlspecialchars($cv['email']);
$phone    = htmlspecialchars($cv['phone'] ?? '');
$location = htmlspecialchars($cv['location'] ?? '');
$linkedin = htmlspecialchars($cv['linkedin'] ?? '');
$github   = htmlspecialchars($cv['github'] ?? '');
$summary  = nl2br(htmlspecialchars($cv['summary']));

// ── Skills HTML ──
$skill_tags = '';
foreach ($skills as $s) {
    if (trim($s)) $skill_tags .= '<span class="skill-tag">' . htmlspecialchars(trim($s)) . '</span>';
}

// ── Entry lines HTML ──
function buildLines($text) {
    $lines = array_filter(array_map('trim', explode("\n", $text)));
    if (empty($lines)) return '';
    $out = '<div class="entry">';
    $first = true;
    foreach ($lines as $line) {
        $cls = $first ? 'entry-line first' : 'entry-line';
        $out .= '<div class="' . $cls . '">' . htmlspecialchars($line) . '</div>';
        $first = false;
    }
    $out .= '</div>';
    return $out;
}

$exp_html  = buildLines($cv['experience'] ?? '');
$edu_html  = buildLines($cv['education'] ?? '');
$proj_html = buildLines($cv['projects'] ?? '');

// ── Contact line ──
$contact = '<span>✉ ' . $email . '</span>';
if ($phone)    $contact .= '<span>📞 ' . $phone . '</span>';
if ($location) $contact .= '<span>📍 ' . $location . '</span>';
if ($linkedin) $contact .= '<a href="https://' . $linkedin . '" target="_blank">🔗 LinkedIn</a>';
if ($github)   $contact .= '<a href="https://' . $github . '" target="_blank">💻 GitHub</a>';

// ── Optional sections ──
$exp_section  = $exp_html  ? '<div class="section"><div class="section-title">Experience</div>' . $exp_html . '</div>' : '';
$edu_section  = $edu_html  ? '<div class="section"><div class="section-title">Education</div>' . $edu_html . '</div>' : '';
$proj_section = $proj_html ? '<div class="section"><div class="section-title">Projects</div>' . $proj_html . '</div>' : '';

// ══════════════════════════
// CSS PER TEMPLATE
// ══════════════════════════
$css = '';

if ($template === 'modern-dark') {
    $css = '
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Inter,sans-serif;background:#0f1117;color:#e2e8f0}
        .hero{background:linear-gradient(135deg,#0f1117,#1a1d27);padding:80px 40px;text-align:center;border-bottom:1px solid #2d3148}
        .hero-name{font-family:"Space Grotesk",sans-serif;font-size:clamp(36px,5vw,64px);font-weight:700;color:#fff;margin-bottom:12px}
        .hero-title{font-size:18px;color:#7c83f5;font-weight:600;margin-bottom:24px}
        .hero-contact{display:flex;flex-wrap:wrap;justify-content:center;gap:20px;font-size:14px;color:#94a3b8}
        .hero-contact a{color:#94a3b8;text-decoration:none}
        .content{max-width:900px;margin:0 auto;padding:60px 40px}
        .section{margin-bottom:56px}
        .section-title{font-family:"Space Grotesk",sans-serif;font-size:13px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:#7c83f5;margin-bottom:24px;padding-bottom:10px;border-bottom:1px solid #2d3148}
        .summary-text{color:#94a3b8;line-height:1.8;font-size:15px}
        .skills-wrap{display:flex;flex-wrap:wrap;gap:10px}
        .skill-tag{background:#1e2535;border:1px solid #2d3148;color:#c7d2fe;padding:6px 14px;border-radius:20px;font-size:13px}
        .entry{margin-bottom:16px}
        .entry-line{padding:6px 0 6px 14px;border-left:2px solid #2d3148;color:#cbd5e1;font-size:14px;line-height:1.8;margin-bottom:4px}
        .entry-line.first{border-color:#7c83f5}
        .footer{text-align:center;padding:32px;border-top:1px solid #2d3148;color:#475569;font-size:13px}
        .footer a{color:#475569}
    ';
} elseif ($template === 'clean-light') {
    $css = '
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Inter,sans-serif;background:#f8fafc;color:#1e293b}
        .hero{background:#fff;border-bottom:3px solid #3b82f6;padding:64px 40px;text-align:center;box-shadow:0 1px 20px rgba(0,0,0,.06)}
        .hero-name{font-family:"Space Grotesk",sans-serif;font-size:clamp(32px,5vw,56px);font-weight:700;color:#1e293b;margin-bottom:10px}
        .hero-title{font-size:18px;color:#3b82f6;font-weight:600;margin-bottom:20px}
        .hero-contact{display:flex;flex-wrap:wrap;justify-content:center;gap:20px;font-size:14px;color:#64748b}
        .hero-contact a{color:#3b82f6;text-decoration:none}
        .content{max-width:900px;margin:0 auto;padding:56px 40px}
        .section{margin-bottom:48px}
        .section-title{font-family:"Space Grotesk",sans-serif;font-size:20px;font-weight:700;color:#1e293b;margin-bottom:20px;padding-bottom:10px;border-bottom:2px solid #e2e8f0}
        .summary-text{color:#475569;line-height:1.8;font-size:15px}
        .skills-wrap{display:flex;flex-wrap:wrap;gap:10px}
        .skill-tag{background:#eff6ff;border:1px solid #bfdbfe;color:#1d4ed8;padding:6px 14px;border-radius:6px;font-size:13px;font-weight:600}
        .entry{margin-bottom:16px}
        .entry-line{padding:6px 0 6px 14px;border-left:3px solid #e2e8f0;color:#475569;font-size:14px;line-height:1.8;margin-bottom:4px}
        .entry-line.first{border-color:#3b82f6;color:#1e293b;font-weight:600}
        .footer{text-align:center;padding:32px;border-top:1px solid #e2e8f0;color:#94a3b8;font-size:13px}
        .footer a{color:#94a3b8}
    ';
} else {
    $css = '
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:Inter,sans-serif;background:#0d0d1a;color:#e2e8f0}
        .hero{background:linear-gradient(135deg,#1a0533,#0d1b4b,#0d0d1a);padding:80px 40px;text-align:center;position:relative;overflow:hidden}
        .hero::after{content:"";position:absolute;bottom:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#f97316,#ec4899,#8b5cf6,#3b82f6)}
        .hero-name{font-family:"Space Grotesk",sans-serif;font-size:clamp(36px,5vw,64px);font-weight:700;background:linear-gradient(135deg,#f97316,#ec4899,#8b5cf6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:12px}
        .hero-title{font-size:18px;color:#fb923c;font-weight:600;margin-bottom:24px}
        .hero-contact{display:flex;flex-wrap:wrap;justify-content:center;gap:20px;font-size:14px;color:#94a3b8}
        .hero-contact a{color:#fb923c;text-decoration:none}
        .content{max-width:900px;margin:0 auto;padding:60px 40px}
        .section{margin-bottom:56px}
        .section-title{font-family:"Space Grotesk",sans-serif;font-size:13px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;background:linear-gradient(90deg,#f97316,#ec4899);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin-bottom:24px;padding-bottom:10px;border-bottom:1px solid #1e1e3a}
        .summary-text{color:#94a3b8;line-height:1.8;font-size:15px}
        .skills-wrap{display:flex;flex-wrap:wrap;gap:10px}
        .skill-tag{background:rgba(249,115,22,.1);border:1px solid rgba(249,115,22,.3);color:#fdba74;padding:6px 14px;border-radius:20px;font-size:13px}
        .entry{margin-bottom:16px}
        .entry-line{padding:6px 0 6px 14px;border-left:2px solid #1e1e3a;color:#94a3b8;font-size:14px;line-height:1.8;margin-bottom:4px}
        .entry-line.first{border-color:#f97316;color:#e2e8f0}
        .footer{text-align:center;padding:32px;border-top:1px solid #1e1e3a;color:#475569;font-size:13px}
        .footer a{color:#475569}
    ';
}

// ══════════════════════════
// BUILD HTML STRING
// ══════════════════════════
$html  = '<!DOCTYPE html><html lang="en"><head>';
$html .= '<meta charset="UTF-8">';
$html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
$html .= '<title>' . $name . ' — Portfolio</title>';
$html .= '<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">';
$html .= '<style>' . $css . '</style>';
$html .= '</head><body>';

$html .= '<div class="hero">';
$html .= '<div class="hero-name">' . $name . '</div>';
$html .= '<div class="hero-title">' . $title . '</div>';
$html .= '<div class="hero-contact">' . $contact . '</div>';
$html .= '</div>';

$html .= '<div class="content">';
$html .= '<div class="section"><div class="section-title">About Me</div><p class="summary-text">' . $summary . '</p></div>';
$html .= '<div class="section"><div class="section-title">Skills</div><div class="skills-wrap">' . $skill_tags . '</div></div>';
$html .= $exp_section . $edu_section . $proj_section;
$html .= '</div>';

$html .= '<div class="footer">Built with PortfolioGen &#10022; <a href="https://omashi.loopzglobal.com/portfolio-converter/">Create yours free</a></div>';
$html .= '</body></html>';

// ══════════════════════════
// SEND AS DOWNLOAD
// ══════════════════════════
$filename = strtolower(str_replace(' ', '-', $cv['name'])) . '-portfolio.html';

header('Content-Type: text/html; charset=utf-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . strlen($html));
header('Cache-Control: no-cache, no-store');
header('Pragma: no-cache');

echo $html;
exit;