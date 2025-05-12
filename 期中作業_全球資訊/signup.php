<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>表單驗證 - Lab 4</title>
    <style>
        /* 主題色定義，方便整站統一風格與日後修改 */
        :root {
            --primary: #3a86ff;
            --secondary: #8338ec;
            --accent: #ff006e;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #38b000;
            --danger: #d90429;
            --warning: #ffbe0b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Noto Sans TC', sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem 0;
            text-align: center;
            margin-bottom: 2rem;
            border-radius: 8px;
        }

        .form-container {
            background-color: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .email-rules, .password-rules {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid var(--primary);
        }

        .email-rules h3, .password-rules h3 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        ul {
            list-style-position: inside;
            margin-bottom: 1rem;
        }

        li {
            margin-bottom: 0.5rem;
        }

        .sub-list {
            padding-left: 2rem;
            list-style-type: circle;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .form-group input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(58, 134, 255, 0.2);
        }

        .error {
            color: var(--danger);
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: var(--primary);
            color: white;
        }

        .btn:hover {
            background-color: #2a75e8;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(58, 134, 255, 0.3);
        }

        footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Lab 4 - 表單驗證練習</h1>
        </header>

        <div class="form-container">
            <div class="email-rules">
                <h3>Email 格式要求</h3>
                <ul>
                    <li>帳號名稱（@ 前）：
                        <ul class="sub-list">
                            <li>不能以點開頭或結尾</li>
                            <li>不能連續兩個點</li>
                        </ul>
                    </li>
                    <li>@ 符號：Email 中必須且只能有一個 @</li>
                    <li>網域名稱（@ 後）：
                        <ul class="sub-list">
                            <li>應包含至少一個點，例如 example.com</li>
                            <li>每個區段只能包含英文字母與數字，且不能以連字符號開頭或結尾</li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="password-rules">
                <h3>密碼要求</h3>
                <ul>
                    <li>至少8個字符</li>
                    <li>至少包含一個大寫字母</li>
                    <li>至少包含一個小寫字母</li>
                    <li>至少包含一個數字</li>
                    <li>至少包含一個特殊字符（如 !@#$%^&*()）</li>
                </ul>
            </div>

            <?php
            // 檢查是否有錯誤訊息需要顯示
            $error = isset($_GET['error']) ? $_GET['error'] : '';
            $emailError = isset($_GET['email_error']) ? $_GET['email_error'] : '';
            $passwordError = isset($_GET['password_error']) ? $_GET['password_error'] : '';
            $email = isset($_GET['email']) ? $_GET['email'] : '';
            ?>

            <?php if ($error): ?>
                <div class="error">
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>

            <form action="form-handler.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="請輸入您的 Email" value="<?php echo htmlspecialchars($email); ?>" required>
                    <?php if ($emailError): ?>
                        <div class="error">
                            <p><?php echo htmlspecialchars($emailError); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="password">密碼</label>
                    <input type="password" id="password" name="password" placeholder="請設定您的密碼" required>
                    <?php if ($passwordError): ?>
                        <div class="error">
                            <p><?php echo htmlspecialchars($passwordError); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn">提交</button>
            </form>
        </div>

        <footer>
            <p>畢業專題 © 2025</p>
        </footer>
    </div>
</body>
</html>