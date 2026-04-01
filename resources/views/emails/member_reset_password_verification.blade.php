<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAMIGOGO 重設密碼驗證碼</title>

    <!--Google Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Noto Sans TC', '微軟正黑體', sans-serif;
            font-size: 0.9rem;
            color: #5a5a5a;
            letter-spacing: 0.1rem;
            font-weight: 500;
            line-height: 1.5;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            margin: 0;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(88, 122, 224, 0.15);
        }

        .header {
            background: linear-gradient(135deg, #587AE0 0%, #57a2ff 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
            position: relative;
        }

        .header::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 30px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"><path d="M0,0V60.29c0,0,128.32,59.52,600,0s600,0,600,0V0Z" fill="%23ffffff"></path></svg>') center/cover no-repeat;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo-svg {
            height: 45px;
            width: auto;
            max-width: 280px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }

        .header-title {
            font-size: 18px;
            font-weight: 400;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .content {
            padding: 50px 40px;
        }

        .greeting {
            color: #587AE0;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .message {
            color: #666666;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .verification-section {
            text-align: center;
            margin: 50px 0;
        }

        .verification-label {
            color: #587AE0;
            font-weight: 600;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .code-container {
            display: inline-block;
            background: linear-gradient(135deg, #587AE0 0%, #57a2ff 100%);
            border-radius: 12px;
            padding: 25px 40px;
            margin: 20px 0;
            box-shadow: 0 8px 25px rgba(88, 122, 224, 0.3);
        }

        .verification-code {
            color: white;
            font-family: 'Rubik', monospace;
            font-size: 36px;
            font-weight: 700;
            letter-spacing: 8px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .code-hint {
            color: #999999;
            font-size: 12px;
            margin-top: 10px;
        }

        .instructions {
            background: rgba(237,237,237,0.8);
            border-radius: 10px;
            padding: 25px;
            margin: 30px 0;
            border-left: 4px solid #587AE0;
        }

        .instructions h3 {
            color: #587AE0;
            font-family: 'Rubik', sans-serif;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .instructions ul {
            padding-left: 20px;
            color: #666666;
        }

        .instructions li {
            margin-bottom: 8px;
            line-height: 1.4;
        }

        .instructions strong {
            color: #587AE0;
        }

        .warning {
            background: rgba(255, 241, 157, 0.3);
            border: 1px solid #FFE158;
            border-radius: 8px;
            padding: 20px;
            margin: 30px 0;
            color: #704B3F;
        }

        .warning strong {
            color: #587AE0;
        }

        .footer {
            background: #f8f9fa;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .contact-info {
            color: #999999;
            font-size: 12px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .contact-info a {
            color: #587AE0;
            text-decoration: none;
        }

        .copyright {
            color: #b0b0b0;
            font-size: 11px;
            font-weight: 400;
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            .content {
                padding: 30px 20px;
            }

            .logo-svg {
                height: 35px;
                max-width: 220px;
            }

            .verification-code {
                font-size: 28px;
                letter-spacing: 6px;
            }

            .code-container {
                padding: 20px 30px;
            }

            .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo-container">
                <img
                    class="logo-svg"
                    src="https://storage.googleapis.com/new_mamigogo_backend_bucket/logo.png"
                    alt="MAMIGOGO Logo"
                />
            </div>
            <p class="header-title">會員重設密碼驗證信件</p>
        </div>

        <div class="content">
            <div class="greeting">親愛的會員，您好！</div>

            <div class="message">
                我們收到了您的密碼重設請求。請使用以下驗證碼來完成密碼重設流程。
            </div>

            <div class="verification-section">
                <div class="verification-label">您的驗證碼</div>
                <div class="code-container">
                    <div class="verification-code">{{ $verificationCode }}</div>
                </div>
                <div class="code-hint">請輸入上方6位數驗證碼</div>
            </div>

            <div class="instructions">
                <h3>📋 使用說明</h3>
                <ul>
                    <li>此驗證碼將在 <strong>5分鐘後</strong> 過期</li>
                    <li>驗證碼僅能使用一次</li>
                    <li>請勿將驗證碼分享給任何人</li>
                    <li>如有問題請聯繫客服中心</li>
                </ul>
            </div>

            <div class="warning">
                <strong>🔒 安全提醒：</strong>
                如果您未申請重設密碼，請忽略此信件，您的帳戶密碼不會被變更。MAMIGOGO 絕不會透過電話或其他方式索取您的驗證碼。
            </div>
        </div>

        <div class="footer">
            <div class="contact-info">
                📧 <a href="mailto:mamigogo.service@gmail.com">mamigogo.service@gmail.com</a><br>
                📞 0986-687852 | Line@ @tfb7659p<br>
                📍 220 新北市板橋區三民路二段146號<br>
                ⏰ 服務時間：週一至週五 早上9:00~晚上6:00
            </div>

            <div class="copyright">
                Copyright © {{ date('Y') }} MAMIGOGO All Rights Reserved.<br>
                此信件由系統自動發送，請勿直接回覆。
            </div>
        </div>
    </div>
</body>
</html>
