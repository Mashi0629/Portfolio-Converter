<?php
session_start();

// If already logged in, go to dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

require_once 'includes/db.php';

$error   = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm_password'] ?? '';

    // Validation
    if (!$name || !$email || !$password || !$confirm) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'An account with this email already exists.';
        } else {
            // Hash password and insert user
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->execute([$email, $hashed]);

            $user_id = $pdo->lastInsertId();

            // Auto login after register
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;

            header('Location: form.php');
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PortfolioGen</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 24px;
            position: relative;
            overflow: hidden;
        }

        .auth-page::before {
            content: '';
            position: absolute;
            top: -200px; left: 50%;
            transform: translateX(-50%);
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(124,131,245,0.1) 0%, transparent 65%);
            pointer-events: none;
        }

        .auth-card {
            position: relative; z-index: 2;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 48px 44px;
            width: 100%; max-width: 460px;
            box-shadow: 0 24px 64px rgba(0,0,0,0.4);
        }

        .auth-logo {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 24px; font-weight: 700;
            color: var(--text); margin-bottom: 8px;
            text-align: center;
        }
        .auth-logo span { color: var(--accent); }

        .auth-subtitle {
            text-align: center;
            color: var(--text-muted);
            font-size: 14px; margin-bottom: 36px;
        }

        .auth-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 22px; font-weight: 700;
            color: var(--text); margin-bottom: 24px;
            text-align: center;
        }

        .form-group {
            display: flex; flex-direction: column;
            gap: 6px; margin-bottom: 18px;
        }

        label {
            font-size: 13px; font-weight: 600;
            color: var(--text-muted);
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            background: var(--bg-card2);
            border: 1px solid var(--border);
            border-radius: 8px;
            color: var(--text);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            padding: 12px 14px;
            transition: border-color 0.2s;
            width: 100%;
            outline: none;
            box-sizing: border-box;
        }

        input:focus { border-color: var(--accent); }

        .error-msg {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            color: #f87171;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .success-msg {
            background: rgba(34,197,94,0.1);
            border: 1px solid rgba(34,197,94,0.3);
            color: #4ade80;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .auth-btn {
            width: 100%;
            background: var(--accent);
            color: white; border: none;
            padding: 14px; border-radius: 10px;
            font-size: 15px; font-weight: 700;
            cursor: pointer; font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            box-shadow: 0 0 24px rgba(124,131,245,0.3);
            margin-top: 8px;
        }
        .auth-btn:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
            box-shadow: 0 0 40px rgba(124,131,245,0.5);
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: var(--text-muted);
        }
        .auth-footer a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
        }
        .auth-footer a:hover { text-decoration: underline; }

        .divider {
            height: 1px; background: var(--border);
            margin: 28px 0;
        }

        .password-hint {
            font-size: 11px; color: #64748b; margin-top: 2px;
        }
    </style>
</head>
<body>

<div class="auth-page">
    <div class="auth-card">

        <div class="auth-logo">Portfolio<span>Gen</span></div>
        <p class="auth-subtitle">Create your account to get started</p>

        <?php if ($error): ?>
            <div class="error-msg">⚠ <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="success-msg">✓ <?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Your full name"
                    value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="you@email.com"
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Min. 6 characters" required>
                <span class="password-hint">At least 6 characters</span>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="Repeat your password" required>
            </div>

            <button type="submit" class="auth-btn">Create Account →</button>

        </form>

        <div class="divider"></div>

        <div class="auth-footer">
            Already have an account? <a href="login.php">Sign in</a>
        </div>

    </div>
</div>

</body>
</html>