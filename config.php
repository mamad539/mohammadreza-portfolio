<?php
// اطلاعات دیتابیس آنلاین Supabase شما
$host     = 'aws-0-eu-central-1.pooler.supabase.com'; // همان آدرسی که در پنل داری
$port     = '5432'; // تغییر پورت به 5432 برای اتصال مستقیم و پایداری بیشتر
$db       = 'postgres'; 
$user     = 'postgres'; 
$password = '@Cmamad5111'; 

// اضافه کردن پارامترهای SSL به رشته اتصال برای جلوگیری از خطای سرور
$dsn = "pgsql:host=$host;port=$port;dbname=$db;sslmode=require;";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $password, $options);
     // اتصال با موفقیت برقرار شد!
} catch (\PDOException $e) {
     die("خطا در اتصال به دیتابیس ابری: " . $e->getMessage());
}
?>
