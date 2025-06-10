<?php
session_start(); // Start a session to store the verification code

// Include error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include PHPMailer if you're using it
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Adjusted path

// Function to generate a verification code
function generateVerificationCode() {
    return rand(100000, 999999); // Generates a random 6-digit code
}

// Function to save the verified email to a text file
function saveEmailToFile($email) {
    $file = 'registered_emails.txt'; // Path to the file
    // Check if the email is already registered
    if (!in_array(trim($email), file($file, FILE_IGNORE_NEW_LINES))) {
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND); // Save verified email
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        // Step 1: Send verification code
        $email = $_POST['email'];
        $_SESSION['email_to_verify'] = $email; // Store the email in the session
        $verificationCode = generateVerificationCode(); // Generate the verification code

        // Store the verification code in the session
        $_SESSION['verification_code'] = $verificationCode;

        // Generate a unique unsubscribe token (for simplicity, using the email here)
        $unsubscribeToken = base64_encode($email); // Encode the email for the link
        $unsubscribeLink = "http://localhost:8000/unsubscribe.php?token=$unsubscribeToken"; // Adjust the URL as needed

        // Using PHPMailer to send the email
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'jasonroy03271@gmail.com'; // Your email
            $mail->Password = 'lhcl tomh jaar sssm'; // Your App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('jasonroy03271@gmail.com', 'no-reply@example.com');
            $mail->addAddress($email); // Add a recipient

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Verification Code';
            $mail->Body    = "Your verification code is: <strong>$verificationCode</strong><br>";
            $mail->Body   .= "If you wish to unsubscribe, click <a href='$unsubscribeLink'>here</a>.";
            $mail->AltBody = "Your verification code is: $verificationCode\nIf you wish to unsubscribe, please contact us.";

            $mail->send();
            echo 'Verification code sent to ' . $email;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } elseif (isset($_POST['verification_code'])) {
        // Step 2: Verify the code
        $enteredCode = $_POST['verification_code'];
        if ($enteredCode == $_SESSION['verification_code']) {
            echo "Verification successful!";
            // Save the verified email to the file
            saveEmailToFile($_SESSION['email_to_verify']);
            echo "Email registered successfully!";
        } else {
            echo "Invalid verification code. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <form method="POST" action="">
        <label for="email">Enter your email:</label>
        <input type="email" name="email" required>
        <button type="submit">Send Verification Code</button>
    </form>

    <form method="POST" action="">
        <label for="verification_code">Enter your verification code:</label>
        <input type="text" name="verification_code" required>
        <button type="submit">Verify Code</button>
    </form>
</body>
</html>
