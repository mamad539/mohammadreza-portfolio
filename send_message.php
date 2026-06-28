<?php
// اتصال به دیتابیس
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // دریافت و پاک‌سازی داده‌های ورودی
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (!empty($name) && !empty($email) && !empty($message)) {
        try {
            // آماده‌سازی کوئری برای امنیت در برابر SQL Injection
            $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);

            // اگر با موفقیت ثبت شد، کاربر را با یک پیغام موفقیت برگردان به صفحه اصلی
            echo "<script>
                    alert('پیام شما با موفقیت ارسال شد.');
                    window.location.href = 'index.html'; 
                  </script>";
            exit;
        } catch (PDOException $e) {
            die("خطا در ذخیره پیام: " . $e->getMessage());
        }
    } else {
        echo "<script>
                alert('لطفاً تمام فیلدها را پر کنید.');
                window.location.href = 'index.html';
              </script>";
        exit;
    }
} else {
    // اگر کسی مستقیم خواست این صفحه را باز کند، بفرستش صفحه اصلی
    header('Location: index.html');
    exit;
}
?>