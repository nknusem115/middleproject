<?php
header('Content-Type: text/html; charset=utf-8');
// 設定錯誤報告等級
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 獲取表單資料
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// 驗證結果
$isEmailValid = true;
$isPasswordValid = true;
$emailError = '';
$passwordError = '';

// Email 驗證函數
function validateEmail($email) {
    // 如果為空，直接返回錯誤
    if (empty($email)) {
        return "請輸入Email地址";
    }

    // 檢查是否只有一個 @ 符號
    $atCount = substr_count($email, '@');
    if ($atCount !== 1) {
        return "Email 必須且只能包含一個 @ 符號";
    }

    // 分割 Email 為使用者名稱和網域名稱
    list($username, $domain) = explode('@', $email);

    // 理論上好像還要<驗證使用者名稱，不然空白感覺怪怪的
    if (empty($username)) {
        return "@ 前的使用者名稱不能為空";
    }

    // 檢查使用者名稱是否以點開頭或結尾
    if ($username[0] === '.' || $username[strlen($username) - 1] === '.') {
        return "使用者名稱不能以點開頭或結尾";
    }

    // 檢查使用者名稱是否有連續兩個點
    if (strpos($username, '..') !== false) {
        return "使用者名稱不能有連續兩個點";
    }

    // 同上，，驗證網域名稱
    if (empty($domain)) {
        return "@ 後的網域名稱不能為空";
    }

    // 網域名稱包含至少一個點
    if (strpos($domain, '.') === false) {
        return "網域名稱包含至少一個點，例如 example.com";
    }

    // 分割網域名稱為不同部分
    $domainParts = explode('.', $domain);
    foreach ($domainParts as $part) {
        // 檢查每個部分是否為空
        if (empty($part)) {
            return "網域名稱的各部分不能為空";
        }

        // 檢查每個部分是否只包含字母和數字
        if (!preg_match('/^[a-zA-Z0-9]+$/', $part)) {
            return "網域名稱的各部分只能包含英文字母和數字";
        }
    }

    return "";  // 驗證通過，返回空字串
}

// 密碼驗證函數
function validatePassword($password) {
    // 檢查密碼長度
    if (strlen($password) < 8) {
        return "密碼長度必須至少8個字符";
    }

    // 檢查密碼是否包含至少一個大寫字母
    if (!preg_match('/[A-Z]/', $password)) {
        return "密碼必須包含至少一個大寫字母";
    }

    return "";  // 驗證通過，返回空字串
}

// 執行驗證
$emailError = validateEmail($email);
$passwordError = validatePassword($password);

$isEmailValid = empty($emailError);
$isPasswordValid = empty($passwordError);

// 如果所有驗證都通過
if ($isEmailValid && $isPasswordValid) {
    // 顯示成功頁面
    ?>
    <!DOCTYPE html>
    <html lang="zh-TW">
    <head>
        <meta charset="UTF-8">
        <title>驗證成功</title>
        <style>
            /* 主題色定義 */
            :root {
                --primary: #3a86ff;
                --secondary: #8338ec;
                --success: #38b000;
                --light: #f8f9fa;
            }

            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Noto Sans TC', sans-serif;
            }

            body {
                background-color: var(--light);
                line-height: 1.6;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
            }

            .success-container {
                max-width: 600px;
                background-color: white;
                border-radius: 12px;
                padding: 2rem;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
                text-align: center;
            }

            .success-icon {
                font-size: 5rem;
                color: var(--success);
                margin-bottom: 1rem;
            }

            h1 {
                color: var(--success);
                margin-bottom: 1rem;
            }

            p {
                margin-bottom: 1.5rem;
            }

            .info {
                background-color: #f8f9fa;
                padding: 1rem;
                border-radius: 8px;
                margin-bottom: 1.5rem;
                text-align: left;
            }

            .info p {
                margin-bottom: 0.5rem;
            }

            .btn {
                display: inline-block;
                padding: 0.75rem 1.5rem;
                border: none;
                border-radius: 6px;
                font-size: 1rem;
                font-weight: 600;
                background-color: var(--primary);
                color: white;
                text-decoration: none;
                transition: all 0.3s ease;
            }

            .btn:hover {
                background-color: #2a75e8;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(58, 134, 255, 0.3);
            }
        </style>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="success-container">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>驗證成功</h1>
            <p>您的 Email 和密碼格式都正確！</p>
            
            <div class="info">
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>密碼:</strong> ********</p>
            </div>
            
            <a href="signup.php" class="btn">返回表單</a>
        </div>
    </body>
    </html>
    <?php
} else {
    // 如果有錯誤，重定向回表單頁面並傳遞錯誤訊息
    $params = [];
    
    if (!$isEmailValid) {
        $params['email_error'] = $emailError;
    }
    
    if (!$isPasswordValid) {
        $params['password_error'] = $passwordError;
    }
    
    // 添加原始的 email，以便在表單中重新顯示
    $params['email'] = $email;
    
    // 自動編碼
    $queryString = http_build_query($params);
    
    // 重定向到表單頁面
    header("Location: signup.php?$queryString");
    exit;
}
?>