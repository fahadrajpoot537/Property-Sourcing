<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
            border-radius: 10px;
        }

        .header {
            background-color: #1E4072;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .content {
            padding: 20px;
        }

        .credentials {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #F95CA8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Welcome to Property Sourcing Group</h2>
        </div>
        <div class="content">
            <p>Hi {{ $user->name }},</p>
            <p>Your account has been successfully created as an Investor. You can now log in to our platform to explore
                available properties and manage your interests.</p>

            <div class="credentials">
                <p><strong>Login URL:</strong> <a href="{{ url('/login') }}">{{ url('/login') }}</a></p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Temporary Password:</strong> {{ $password }}</p>
            </div>

            <p>We recommend changing your password after your first login.</p>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/login') }}" class="btn">Login to Your Account</a>
            </div>

            <p style="margin-top: 30px;">
                Best Regards,<br>
                Property Sourcing Group Team
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Property Sourcing Group. All rights reserved.
        </div>
    </div>
</body>

</html>