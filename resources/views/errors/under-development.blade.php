<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $config['page_title'] ?? 'Under Development - Arsh Optical' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            margin: 20px;
            position: relative;
            overflow: hidden;
        }
        
        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2, #f093fb);
        }
        
        .icon {
            font-size: 80px;
            margin-bottom: 30px;
            color: #667eea;
        }
        
        .title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #2d3748;
        }
        
        .subtitle {
            font-size: 18px;
            color: #718096;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .message {
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            margin: 30px 0;
            text-align: left;
        }
        
        .message h3 {
            color: #2d3748;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .message p {
            color: #4a5568;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .actions {
            margin-top: 40px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 0 10px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }
        
        .btn-secondary:hover {
            background: #cbd5e0;
            transform: translateY(-2px);
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #718096;
            font-size: 14px;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 40px 20px;
                margin: 10px;
            }
            
            .title {
                font-size: 24px;
            }
            
            .subtitle {
                font-size: 16px;
            }
            
            .btn {
                display: block;
                margin: 10px auto;
                max-width: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🕶️ Arsh Optical</div>
        
        <div class="icon">{{ $config['page_icon'] ?? '🚧' }}</div>
        
        <h1 class="title">Under Development</h1>
        
        <p class="subtitle">
            {{ $config['page_message'] ?? 'We\'re currently working on improving this page. Please check back later or contact our support team if you need immediate assistance.' }}
        </p>
        
        <div class="message">
            <h3>What happened?</h3>
            <p>This page encountered an unexpected error and is temporarily unavailable while we fix the issue.</p>
        </div>
        
        <div class="message">
            <h3>What can you do?</h3>
            <p>• Try refreshing the page in a few minutes<br>
               • Navigate to our homepage<br>
               • Contact our support team</p>
        </div>
        
        <div class="actions">
            <a href="{{ route('home') }}" class="btn btn-primary">Go to Homepage</a>
            <a href="{{ route('contact') }}" class="btn btn-secondary">Contact Support</a>
        </div>
        
        <div class="footer">
            <p>Error ID: {{ $errorId ?? 'N/A' }} | {{ now()->format('M d, Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
