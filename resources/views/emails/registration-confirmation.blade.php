<!DOCTYPE html>
<html>

<head>
    <title>Registration Confirmation</title>
</head>

<body>
    <h1>Thank you for your registration!</h1>

    <p>Hello {{ $registrationData['name'] }},</p>

    <p>We have received your registration with the following details:</p>

    <ul>
        <li>Email: {{ $registrationData['email'] }}</li>
        <li>Phone: {{ $registrationData['phone'] }}</li>
    </ul>

    <p>We'll contact you soon with more information about the event.</p>

    <p>Best regards,<br>
        The Event Team</p>
</body>

</html>
