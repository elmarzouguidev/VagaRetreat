<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message - VagaRetreat</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f9fafb;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f9fafb;
            padding-bottom: 40px;
            padding-top: 20px;
        }

        .main {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            color: #111827;
        }

        .header {
            padding: 40px 0;
            text-align: center;
        }

        .logo {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: -0.05em;
            text-transform: uppercase;
            color: #111827;
        }

        .logo-dot {
            color: #e11d48;
        }

        .content {
            padding: 40px;
        }

        .heading {
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: -0.025em;
            margin-bottom: 24px;
            color: #111827;
        }

        .info-label {
            font-size: 10px;
            font-weight: 900;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.2em;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 24px;
        }

        .message-box {
            background-color: #f3f4f6;
            padding: 24px;
            border-radius: 16px;
            font-size: 16px;
            line-height: 1.6;
            color: #374151;
            margin-top: 8px;
        }

        .footer {
            padding: 40px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <table class="main" align="center">
            <tr>
                <td class="header">
                    <div class="logo">VagaRetreat<span class="logo-dot">.</span></div>
                </td>
            </tr>
            <tr>
                <td class="content">
                    <h1 class="heading">New Contact Message</h1>

                    <div class="info-label">Name</div>
                    <div class="info-value">{{ $data['name'] }}</div>

                    <div class="info-label">Contact Email</div>
                    <div class="info-value">{{ $data['email'] }}</div>

                    <div class="info-label">Message Content</div>
                    <div class="message-box">
                        {{ $data['message'] }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="footer">
                    &copy; {{ date('Y') }} VagaRetreat Agency. All rights reserved.<br>
                    Intended for institutional use only.
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
