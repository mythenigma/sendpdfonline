<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=utf-8');

$typeA = $_GET['typeA'] ?? '';
$mark = $_GET['time'] ?? time(); // 可留作备用
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$ip = $_SERVER['HTTP_X_REAL_IP'] ?? getUserIP();

if (empty($typeA)) {
    echo json_encode(['url' => null]);
    exit;
}

function convertToKey($str) {
    $key = '';
    $str = strtoupper($str);
    for ($i = 0; $i < strlen($str); $i++) {
        $num = ord($str[$i]) - 64;
        if ($num == 10) {
            $num = 0;
        }
        $key .= $num;
    }
    return $key;
}

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// 可选：解析UA（保留，但你可以不再使用）
function parseUserAgent($ua) {
    // ...（原来的解析函数保持不变）
    return $ua; // 如果不想解析可直接返回原UA
}
$userAgent = parseUserAgent($userAgent);

// 转换 code 为数据库 key
$convertedKey = convertToKey($typeA);

// 数据库查询
include_once('password.php');
$conn = new mysqli($servernameMai, $usernameMai, $passwordMai, $dbnameMai);
$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
    echo json_encode(['url' => null]);
    exit;
}

$sql = "SELECT `mark` AS `id` FROM `grabify` WHERE `auto` = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $convertedKey);
$stmt->execute();
$result = $stmt->get_result();

$url = null;
if ($result->num_rows > 0) {
    $url = $result->fetch_assoc()['id'];
}
$stmt->close();
$conn->close();

echo json_encode(['url' => $url]);
?>
