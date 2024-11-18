<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ร้านของภู</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #6EE7B7, #3B82F6);
            color: #4a5568;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            padding: 40px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        h1 {
            font-size: 2.8rem;
            color: #2b6cb0;
            margin-bottom: 30px;
            font-weight: 700;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }

        .button {
            background-color: #3182ce;
            color: #fff;
            padding: 12px 28px;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
            display: inline-block;
            font-size: 1.1rem;
            margin-top: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .button:hover {
            background-color: #2b6cb0;
            transform: translateY(-4px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .button:active {
            transform: translateY(0);
        }

        .back-button {
            margin-top: 30px;
        }

        .back-button a {
            font-size: 1.1rem;
            color: #000000;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .back-button a:hover {
            color: #000000;
        }

        .footer {
            margin-top: 40px;
            font-size: 1rem;
            color: #000000;
        }

        .footer a {
            color: #000000;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>ยินดีต้อนรับสู่ร้านของภู</h1>
        
        <div class="back-button">
            <a href="{{ route('home') }}" class="button">ไปหน้าสินค้า</a>
        </div>

        @if (Route::has('login'))
            <div class="footer">
                @auth
                    <!-- User is logged in, display nothing or other content -->
                @else
                    <a href="{{ route('login') }}" class="button">เข้าสู่ระบบ</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="button ml-4">สมัครสมาชิก</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</body>

</html>
