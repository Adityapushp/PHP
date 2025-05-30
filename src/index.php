<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Verification</title>
</head>
<body>
&nbsp;
&nbsp;

<h1>Email Verification</h1>
&nbsp;
&nbsp;

<form method="POST" action="index.php">
    <input type="email" name="email" required>
    <button id="submit-email">Submit</button>
</form>
&nbsp;
&nbsp;

<form method="POST" action="index.php">
    <input type="text" name="verification_code" maxlength="6" required>
    <button id="submit-verification">Verify</button>
</form>
&nbsp;
&nbsp;

</body>
</html>
