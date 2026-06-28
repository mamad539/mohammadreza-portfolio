<?php
// send.php

// ۱. فراخوانی فایل تنظیمات دیتابیس
require_once 'config.php';

// ۲. تنظیم هدر برای ارسال پاسخ به صورت JSON
header('Content-Type: application/json');

// ۳. بررسی اینکه درخواست حتماً POST باشد
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // دریافت و پاک‌سازی داده‌های ورودی
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // اعتبار سنجی خالی نبودن فیلدها
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'لطفاً تمامی فیلدها را پر کنید.']);
        exit;
    }

    // اعتبار سنجی فرمت ایمیل
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'آدرس ایمیل وارد شده معتبر نیست.']);
        exit;
    }

    // تلاش برای ذخیره در دیتابیس
    try {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
        
        // پاسخ موفقیت‌آمیز
        echo json_encode(['status' => 'success', 'message' => 'پیام شما با موفقیت ارسال شد.']);
        exit;
    } catch (PDOException $e) {
        // گزارش خطای دیتابیس در صورت بروز مشکل
        echo json_encode(['status' => 'error', 'message' => 'خطای دیتابیس: ' . $e->getMessage()]);
        exit;
    }

} else {
    // پاسخ در صورتی که کسی بخواهد مستقیم فایل را باز کند (غیر از POST)
    echo json_encode(['status' => 'error', 'message' => 'دسترسی غیرمجاز است.']);
    exit;
}
?>