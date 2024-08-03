<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333;">

<table style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #fff; border-radius: 8px;">
    <tr>
        <td>
            <h2 style="text-align: center; margin-bottom: 30px;">Password Reset</h2>
            <p>Hello, {{ $userName }},</p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <p>Please use the following 6-digit code to reset your password:</p>
            <h3 style="text-align: center; font-size: 24px; margin-top: 20px; margin-bottom: 20px;">{{ $code }}</h3>
            <p>If you did not request a password reset, no further action is required.</p>
            <p>Regards,<br>Bubble nerd</p>
        </td>
    </tr>
</table>

</body>
</html>
