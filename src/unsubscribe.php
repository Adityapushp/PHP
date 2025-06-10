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

// Function to remove email from the registered_emails.txt file
function removeEmailFromFile($email) {
    $file = 'registered_emails.txt'; // Path to the file
    $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Read all emails
    $updatedEmails = array();

    // Loop through emails and keep only those that are not unsubscribed
    foreach ($emails as $registeredEmail) {
        if (trim($registeredEmail) !== trim($email)) {
            $updatedEmails[] = $registeredEmail; // Keep the email
        }
    }

    // Write the updated list back to the file
    file_put_contents($file, implode(PHP_EOL, $updatedEmails) . PHP_EOL);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['unsubscribe_email'])) {
        // Step 1: Send verification code for unsubscription
        $email = $_POST['unsubscribe_email'];
        $verificationCode = generateVerificationCode(); // Generate the verification code

        // Store the verification code in the session
        $_SESSION['unsubscribe_verification_code'] = $verificationCode;
        $_SESSION['unsubscribe_email'] = $email; // Store email for unsubscribe

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
            $mail->Subject = 'Unsubscribe Verification Code';
            $mail->Body    = "Your unsubscription verification code is: <strong>$verificationCode</strong>";
            $mail->AltBody = "Your unsubscription verification code is: $verificationCode";

            $mail->send();
            echo 'Unsubscription verification code sent to ' . htmlspecialchars($email);
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } elseif (isset($_POST['unsubscribe_verification_code'])) {
        // Step 2: Verify the unsubscription code
        $enteredCode = $_POST['unsubscribe_verification_code'];
        if ($enteredCode == $_SESSION['unsubscribe_verification_code']) {
            // Remove the email from the mailing list
            removeEmailFromFile($_SESSION['unsubscribe_email']);
            echo "You have successfully unsubscribed from receiving emails at: " . htmlspecialchars($_SESSION['unsubscribe_email']);
            // Clear the session data
            unset($_SESSION['unsubscribe_verification_code']);
            unset($_SESSION['unsubscribe_email']);
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
    <title>Unsubscribe</title>
</head>
<body>
    <form method="POST" action="">
        <label for="unsubscribe_email">Enter your email to unsubscribe:</label>
        <input type="email" name="unsubscribe_email" required>
        <button type="submit">Send Unsubscribe Code</button>
    </form>

    <form method="POST" action="">
        <label for="unsubscribe_verification_code">Enter your unsubscription verification code:</label>
        <input type="text" name="unsubscribe_verification_code" required>
        <button id="submit-verification">Verify Unsubscription</button>
    </form>
</body>
</html>
