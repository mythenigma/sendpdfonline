<?php
// 返回空透明图片类型
header("Content-Type: image/png");

// 获取参数
$typeA = $_GET['typeA'] ?? '';
$ip = $_SERVER['HTTP_X_REAL_IP'] ?? $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

// 转换规则：AJJIIJA → 数字
function convertToKey($str) {
    $key = '';
    $str = strtoupper($str);
    for ($i = 0; $i < strlen($str); $i++) {
        $num = ord($str[$i]) - 64;
        if ($num == 10) $num = 0;
        $key .= $num;
    }
    return $key;
}

$convertedKey = convertToKey($typeA);

// 当前时间作为 mark
$mark = date('r'); // e.g., "Sat, 13 Apr 2025 10:22:45 +0800"

// 插入到 recordip 表
include_once('password.php');
$conn = new mysqli($servernameMai, $usernameMai, $passwordMai, $dbnameMai);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    http_response_code(500);
    exit;
}

$insertSQL = "INSERT INTO `recordip`(`email`, `subject`, `mark`, `markopen`, `passcode`, `ip`)
              VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insertSQL);
$email = 'g';
$passcode = 7;
$stmt->bind_param("sissis", $email, $convertedKey, $mark, $userAgent, $passcode, $ip);
$stmt->execute();
$stmt->close();
$conn->close();
?>