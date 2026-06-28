<?php
// ۱. شروع سشن در اولین خط (حیاتی برای اینکه دشبورد شما را بشناسد)
session_start();
ob_start();

// اتصال به دیتابیس
require_once 'config.php';

// اگر کاربر از قبل لاگین کرده، مستقیم هدایت شود به داشبورد
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        // جستجوی نام کاربری در جدول users
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // بررسی صحت‌سنجی رمز عبور هش‌شده
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $user['username'];
            
            // ورود موفقیت‌آمیز و هدایت به داشبورد
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'نام کاربری یا رمز عبور اشتباه است.';
        }
    } else {
        $error = 'لطفاً تمامی فیلدها را پر کنید.';
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به مدیریت</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --bg: #050816; 
            --primary: #8B5CF6; 
            --secondary: #06B6D4; 
            --text: #ffffff; 
        }
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Vazirmatn', sans-serif; 
        }
        body { 
            background: linear-gradient(180deg, #050816, #0d1327); 
            min-height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            color: var(--text); 
            overflow: hidden; 
            position: relative; 
        }
        .blur { 
            position: absolute; 
            border-radius: 50%; 
            filter: blur(150px); 
            z-index: -1; 
        }
        .blur1 { width: 400px; height: 400px; background: #7c3aed; top: -100px; left: -100px; opacity: 0.25; }
        .blur2 { width: 350px; height: 350px; background: #00c8ff; bottom: -50px; right: -50px; opacity: 0.2; }
        
        .login-container { 
            width: 100%; 
            max-width: 400px; 
            padding: 45px 35px; 
            background: rgba(255, 255, 255, 0.04); 
            border: 1px solid rgba(255, 255, 255, 0.08); 
            backdrop-filter: blur(25px); 
            border-radius: 28px; 
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5); 
        }
        .login-header { text-align: center; margin-bottom: 35px; }
        .login-header h2 { font-size: 28px; margin-bottom: 8px; font-weight: 700; }
        .login-header p { color: #94A3B8; font-size: 14px; }
        
        .error-msg { 
            background: rgba(239, 68, 68, 0.15); 
            border: 1px solid #ef4444; 
            color: #f87171; 
            padding: 12px; 
            border-radius: 12px; 
            margin-bottom: 20px; 
            font-size: 14px; 
            text-align: center; 
        }
        
        .input-group { margin-bottom: 22px; display: flex; flex-direction: column; }
        .input-group label { margin-bottom: 8px; font-size: 14px; color: #b7c2d4; }
        .input-group input { 
            background: rgba(255, 255, 255, 0.03); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            padding: 15px 18px; 
            border-radius: 16px; 
            color: white; 
            font-size: 15px; 
            outline: none; 
            transition: 0.3s; 
        }
        .input-group input:focus { 
            border-color: var(--primary); 
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.25); 
        }
        
        .submit-btn { 
            width: 100%; 
            padding: 15px; 
            border: none; 
            cursor: pointer; 
            border-radius: 16px; 
            font-size: 17px; 
            font-weight: 700; 
            background: linear-gradient(135deg, var(--primary), var(--secondary)); 
            color: white; 
            transition: 0.3s; 
        }
        .submit-btn:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4); 
        }
        .back-link { display: block; text-align: center; margin-top: 20px; color: #94A3B8; text-decoration: none; font-size: 14px; }
        .back-link:hover { color: var(--secondary); }
    </style>
</head>
<body>
    <div class="blur blur1"></div>
    <div class="blur blur2"></div>

    <div class="login-container">
        <div class="login-header">
            <h2>پنل مدیریت پورتفولیو</h2>
            <p>مشاهده پیام‌های دریافتی</p>
        </div>

        <?php if(!empty($error)): ?>
            <div class="error-msg"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST" autocomplete="off">
            <div class="input-group">
                <label>نام کاربری</label>
                <input type="text" name="username" placeholder="نام کاربری خود را بنویسید" required autocomplete="off">
            </div>
            <div class="input-group">
                <label>رمز عبور</label>
                <input type="password" name="password" placeholder="••••••••" required autocomplete="new-password">
            </div>
            <button type="submit" class="submit-btn">ورود به پنل</button>
        </form>
        <a href="index.html" class="back-link">بازگشت به سایت اصلی</a>
    </div>
</body>
</html>