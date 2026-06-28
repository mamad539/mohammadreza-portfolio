<?php
session_start();
require_once 'config.php';

// امنیت دشبورد: اگر کاربر لاگین نکرده باشد، اجازه ورود ندارد
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$admin_username = $_SESSION['admin_username'] ?? 'مدیر';

try {
    // ۱. دریافت آمار کل پیام‌ها
    $count_stmt = $pdo->query("SELECT COUNT(*) FROM messages");
    $total_messages = $count_stmt->fetchColumn();

    // ۲. دریافت لیست تمام پیام‌ها به ترتیب جدیدترین‌ها
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("خطا در دریافت اطلاعات دشبورد: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت | GamerNext</title>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-dark: #050816;
            --panel-bg: rgba(255, 255, 255, 0.03);
            --border-glow: rgba(255, 255, 255, 0.08);
            --primary-neon: #8B5CF6; /* بنفش نئون */
            --secondary-neon: #06B6D4; /* سایان نئون */
            --text-main: #ffffff;
            --text-muted: #94A3B8;
        }

        * {
            margin: 0; padding: 0; box-sizing: border-box; font-family: 'Vazirmatn', sans-serif;
        }

        body {
            background-color: var(--bg-dark);
            background-image: linear-gradient(180deg, #050816 0%, #0d1327 100%);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* افکت بک‌گراند کهکشانی */
        .space-glow {
            position: absolute; border-radius: 50%; filter: blur(160px); z-index: -1; opacity: 0.15;
        }
        .glow-1 { width: 500px; height: 500px; background: var(--primary-neon); top: -10%; right: -10%; }
        .glow-2 { width: 400px; height: 400px; background: var(--secondary-neon); bottom: -10%; left: -10%; }

        /* سایدبار مدیریت */
        .sidebar {
            width: 260px;
            background: rgba(5, 8, 22, 0.6);
            border-left: 1px solid var(--border-glow);
            backdrop-filter: blur(20px);
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand h1 {
            font-size: 22px; font-weight: 700;
            background: linear-gradient(135deg, var(--secondary-neon), var(--primary-neon));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            margin-bottom: 40px; text-align: center;
        }

        .menu-list { list-style: none; }
        .menu-item { margin-bottom: 12px; }
        .menu-link {
            display: flex; align-items: center; padding: 14px 18px; color: var(--text-muted);
            text-decoration: none; border-radius: 14px; transition: 0.3s; font-weight: 500;
        }
        .menu-link:hover, .menu-link.active {
            color: white; background: rgba(139, 92, 246, 0.15);
            border: 1px solid rgba(139, 92, 246, 0.3);
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.1);
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2);
            color: #f87171; text-align: center; padding: 12px; border-radius: 14px;
            text-decoration: none; font-weight: 700; transition: 0.3s;
        }
        .logout-btn:hover {
            background: #ef4444; color: white; box-shadow: 0 0 15px rgba(239, 68, 68, 0.4);
        }

        /* بخش اصلی محتوا */
        .main-content {
            flex: 1; padding: 40px; overflow-y: auto;
        }

        .header-dash {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px;
        }
        .welcome-text h2 { font-size: 26px; margin-bottom: 5px; }
        .welcome-text p { color: var(--text-muted); font-size: 14px; }

        /* کارت‌های آمار (Stats) */
        .stats-grid {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 40px;
        }
        .stat-card {
            background: var(--panel-bg); border: 1px solid var(--border-glow);
            padding: 25px; border-radius: 20px; backdrop-filter: blur(10px);
            position: relative; overflow: hidden;
        }
        .stat-card::after {
            content: ''; position: absolute; top: 0; left: 0; width: 4px; height: 100%; background: var(--primary-neon);
        }
        .stat-card.cyan::after { background: var(--secondary-neon); }
        .stat-card h3 { font-size: 14px; color: var(--text-muted); margin-bottom: 10px; }
        .stat-card .value { font-size: 32px; font-weight: 700; color: white; }

        /* باکس پیام‌ها */
        .content-panel {
            background: var(--panel-bg); border: 1px solid var(--border-glow);
            border-radius: 24px; backdrop-filter: blur(10px); padding: 30px;
        }
        .panel-title { font-size: 18px; margin-bottom: 25px; font-weight: 700; color: var(--secondary-neon); }

        /* استایل اختصاصی پیام‌ها */
        .messages-container { display: flex; flex-direction: column; gap: 15px; }
        .message-row {
            background: rgba(255, 255, 255, 0.01); border: 1px solid rgba(255, 255, 255, 0.04);
            padding: 20px; border-radius: 16px; transition: 0.3s;
        }
        .message-row:hover {
            border-color: rgba(6, 182, 212, 0.3); background: rgba(6, 182, 212, 0.02);
        }
        .msg-header { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; }
        .msg-sender { font-weight: 700; color: white; }
        .msg-email { color: var(--text-muted); margin-right: 10px; font-size: 13px; }
        .msg-date { color: var(--text-muted); font-size: 12px; }
        .msg-body { color: #cbd5e1; line-height: 1.6; font-size: 14px; white-space: pre-line; }

        .no-data { text-align: center; color: var(--text-muted); padding: 40px 0; }
    </style>
</head>
<body>
    <div class="space-glow glow-1"></div>
    <div class="space-glow glow-2"></div>

    <aside class="sidebar">
        <div>
            <div class="brand">
                <h1>GamerNext Control</h1>
            </div>
            <ul class="menu-list">
                <li class="menu-item">
                    <a href="dashboard.php" class="menu-link active">📥 پیام‌های دریافتی</a>
                </li>
                </ul>
        </div>
        <a href="logout.php" class="logout-btn">خروج از حساب</a>
    </aside>

    <main class="main-content">
        <header class="header-dash">
            <div class="welcome-text">
                <h2>خوش آمدی، <?= htmlspecialchars($admin_username) ?> 🔥</h2>
                <p>اتاق کنترل و مانیتورینگ وب‌سایت پورتفولیو شما</p>
            </div>
        </header>

        <section class="stats-grid">
            <div class="stat-card">
                <h3>کل پیام‌های دریافتی</h3>
                <div class="value"><?= $total_messages ?></div>
            </div>
            <div class="stat-card cyan">
                <h3>وضعیت هسته سرور</h3>
                <div class="value" style="font-size: 18px; color: #10b981;">ONLINE (Laragon)</div>
            </div>
            <div class="stat-card">
                <h3>پایگاه داده MySQL</h3>
                <div class="value" style="font-size: 18px; color: var(--secondary-neon);">Connected</div>
            </div>
        </section>

        <section class="content-panel">
            <div class="panel-title">صندوق ورودی پیام‌های سایت</div>
            
            <div class="messages-container">
                <?php if (count($messages) > 0): ?>
                    <?php foreach ($messages as $msg): ?>
                        <div class="message-row">
                            <div class="msg-header">
                                <div>
                                    <span class="msg-sender"><?= htmlspecialchars($msg['name']) ?></span>
                                    <span class="msg-email">&lt;<?= htmlspecialchars($msg['email']) ?>&gt;</span>
                                </div>
                                <span class="msg-date"><?= $msg['created_at'] ?></span>
                            </div>
                            <div class="msg-body"><?= htmlspecialchars($msg['message']) ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-data">هنوز هیچ پیامی از فرم تماس با ما دریافت نشده است. 📥</div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
