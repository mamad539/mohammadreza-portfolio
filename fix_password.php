<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ۱. اتصال به دیتابیس
require_once 'config.php';

// ۲. رمزی که می‌خواهید با آن وارد شوید
$username = 'mohammad'; 
$plain_password = '654321'; 

// ۳. تبدیل رمز ساده به رمز امن هش‌شده PHP
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

try {
    // ۴. آپدیت کردن رمز در دیتابیس
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
    $stmt->execute([$hashed_password, $username]);
    
    echo "<div style='background:#10b981; color:white; padding:20px; text-align:center; font-family:sans-serif; direction:rtl; border-radius:10px;'>";
    echo "<h3>موفقیت‌آمیز بود! 🎉</h3>";
    echo "<p>رمز عبور کاربر <strong>$username</strong> در دیتابیس به صورت امن تغییر کرد.</p>";
    echo "<p>حالا به صفحه <a href='login.php' style='color:black; font-weight:bold;'>login.php</a> بروید و با رمز <strong>$plain_password</strong> وارد شوید.</p>";
    echo "</div>";
} catch (PDOException $e) {
    echo "خطا در آپدیت دیتابیس: " . $e->getMessage();
}
?>