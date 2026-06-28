<?php
session_start();

// پاک کردن تمام متغیرهای سشن
$_SESSION = array();

// اگر از کوکی برای سشن استفاده شده، آن را هم منقضی کن
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// نابود کردن کامل سشن
session_destroy();

// هدایت کاربر به صفحه لاگین
header("Location: login.php");
exit;
?>