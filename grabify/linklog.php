<?php
// 设置响应头
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf-8");

// 获取 JSON POST 数据
$data = json_decode(file_get_contents('php://input'), true);
$typeA = $data['typeA'] ?? '';
$browserTime = $data['time'] ?? date('c'); // ISO 格式时间
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';

// 获取真实 IP（Cloudflare）
$ip = $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['REMOTE_ADDR'];

// 校验必须参数
if (empty($typeA)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing typeA']);
    exit;
}

// 转换 typeA 为数据库 key
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
$convertedKey = convertToKey($typeA);
function parseUserAgent($ua) {
    $ua = strtolower($ua);
    $context = '';
    $osName = '';
    $osVersion = '';
    $browserVersion = '';

    // In-App Browsers
    if (strpos($ua, 'micromessenger') !== false) {
        $context = 'WeChat In-App Browser';
    } elseif (strpos($ua, 'fb_iab') !== false || strpos($ua, 'fbav') !== false || strpos($ua, 'fban') !== false || strpos($ua, 'fbios') !== false) {
        $context = 'Facebook In-App Browser';
    } elseif (strpos($ua, 'instagram') !== false) {
        $context = 'Instagram In-App Browser';
    } elseif (strpos($ua, 'twitter') !== false || strpos($ua, 'twitterandroid') !== false) {
        $context = 'Twitter In-App Browser';
    } elseif (strpos($ua, 'musical_ly') !== false || strpos($ua, 'tiktok') !== false || strpos($ua, 'bytelocale') !== false) {
        $context = 'TikTok In-App Browser';
    } elseif (strpos($ua, 'wv') !== false) {
        $context = 'Generic In-App WebView';
    }

    // OS Detection
    if (strpos($ua, 'android') !== false) {
        $osName = 'Android';
        preg_match('/android\s+([0-9]+(?:\.[0-9]+)?)/', $ua, $match);
        if ($match) {
            $osVersion = $match[1];
        }
    } elseif (strpos($ua, 'iphone os') !== false || strpos($ua, 'cpu os') !== false) {
        $osName = 'iOS';
        preg_match('/(?:iphone os|cpu os)\s+([0-9_]+)/', $ua, $match);
        if ($match) {
            $osVersion = str_replace('_', '.', $match[1]);
            $osVersion = explode('.', $osVersion)[0];
        }
    } elseif (strpos($ua, 'windows nt') !== false) {
        $osName = 'Windows';
        preg_match('/windows nt\s*([0-9\.]+)/', $ua, $match);
        if ($match) {
            $ntVer = $match[1];
            if (strpos($ntVer, '10.0') === 0) {
                $osVersion = '10';
            } elseif (strpos($ntVer, '6.3') === 0) {
                $osVersion = '8.1';
            } elseif (strpos($ntVer, '6.2') === 0) {
                $osVersion = '8';
            } elseif (strpos($ntVer, '6.1') === 0) {
                $osVersion = '7';
            } else {
                $osVersion = $ntVer;
            }
        }
    } elseif (strpos($ua, 'mac os x') !== false) {
        $osName = 'macOS';
        preg_match('/mac os x\s*([0-9_]+)/', $ua, $match);
        if ($match) {
            $osVersion = str_replace('_', '.', $match[1]);
            $osParts = explode('.', $osVersion);
            $osVersion = $osParts[0] . '.' . ($osParts[1] ?? '0');
        }
    } elseif (strpos($ua, 'linux') !== false) {
        $osName = 'Linux';
    }

    // Standalone browsers
    if ($context === '') {
        if (strpos($ua, 'edg/') !== false) {
            $context = 'Edge';
            preg_match('/edg\/([\d\.]+)/', $ua, $match);
            $browserVersion = $match[1] ?? '';
        } elseif (strpos($ua, 'chrome/') !== false || strpos($ua, 'crios/') !== false) {
            $context = 'Chrome';
            preg_match('/(?:chrome|crios)\/([\d\.]+)/', $ua, $match);
            $browserVersion = $match[1] ?? '';
        } elseif (strpos($ua, 'firefox/') !== false || strpos($ua, 'fxios/') !== false) {
            $context = 'Firefox';
            preg_match('/(?:firefox|fxios)\/([\d\.]+)/', $ua, $match);
            $browserVersion = $match[1] ?? '';
        } elseif (strpos($ua, 'safari/') !== false && strpos($ua, 'chrome') === false && strpos($ua, 'crios') === false) {
            $context = 'Safari';
            preg_match('/version\/([\d\.]+)/', $ua, $match);
            $browserVersion = $match[1] ?? '';
        } else {
            $context = 'Browser';
        }
    }

    // Output
    $result = $context;
    if ($browserVersion) {
        $result .= ' ' . explode('.', $browserVersion)[0];
    }
    if ($osName) {
        $result .= ' (' . $osName;
        if ($osVersion) $result .= ' ' . $osVersion;
        $result .= ')';
    }

    return $result;
}
$userAgent = parseUserAgent($userAgent);
// 引入数据库配置
include_once('password.php');
$conn = new mysqli($servernameMai, $usernameMai, $passwordMai, $dbnameMai);
$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'DB connection failed']);
    exit;
}

// 插入访问记录
$insertSQL = "INSERT INTO `recordip`(`email`, `subject`, `mark`, `markopen`, `passcode`, `ip`)
              VALUES (?, ?, ?, ?, ?, ?)";
$insertStmt = $conn->prepare($insertSQL);
$email = 'g'; // 固定值（可根据你需求改）
$passcode = 7; // 固定值
$insertStmt->bind_param("sissis", $email, $convertedKey, $browserTime, $userAgent, $passcode, $ip);
$insertStmt->execute();
$insertStmt->close();

echo json_encode(['status' => 'ok']);
$conn->close();
