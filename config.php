<?php
$host     = 'https://jdoftcwahignczzlzzri.supabase.co/rest/v1/'; 
$port     = '6543'; 
$db       = 'mohammadreza-portfolio'; 
$user     = 'mohammadreza-portfolio'; 
$password = '@Cmamad5111'; 

$dsn = "pgsql:host=$host;port=$port;dbname=$db;";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $password, $options);
    
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
