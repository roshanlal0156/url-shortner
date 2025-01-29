<!DOCTYPE html>
<html>
<head>
    <title>Login Invite</title>
</head>
<body>
    <h1>Hello {{ $userName }},</h1>
    <p>You have been invited to log in to our platform. Please use the link below to access your account:</p>
    <a href="{{ $loginUrl }}">Login Now</a>
    <p>password: {{ $password }}</p>
    <p>If you did not request this invite, please ignore this email.</p>
    <p>Thank you,<br> The {{ config('app.name') }} Team</p>
</body>
</html>
