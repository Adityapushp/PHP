<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Ensure PHPMailer is included

function generateVerificationCode() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT); // Generate a 6-digit code
}

function registerEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    file_put_contents($file, $email . PHP_EOL, FILE_APPEND); // Save verified email
}

function unsubscribeEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file($file, FILE_IGNORE_NEW_LINES);
    $emails = array_filter($emails, function($e) use ($email) {
        return trim($e) !== $email; // Remove email from the list
    });
    file_put_contents($file, implode(PHP_EOL, $emails) . PHP_EOL); // Update the file
}

function sendVerificationEmail($email, $code) {
    $subject = "Your Verification Code";
    $message = "<p>Your verification code is: <strong>$code</strong></p>";
    $headers = "From: no-reply@example.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    mail($email, $subject, $message, $headers); // Send verification email
}

function sendUnsubscribeConfirmationEmail($email, $code) {
    $subject = "Confirm Un-subscription";
    $message = "<p>To confirm un-subscription, use this code: <strong>$code</strong></p>";
    $headers = "From: no-reply@example.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    mail($email, $subject, $message, $headers); // Send unsubscribe confirmation email
}

function verifyCode($email, $code) {
    // Store the code temporarily for verification
    // This could be improved with a more secure method
    return true; // Placeholder for actual verification logic
}

function fetchAndFormatXKCDData() {
    $randomComicID = rand(1, 2500); // Generate a random comic ID
    $url = "https://xkcd.com/$randomComicID/info.0.json";
    $data = file_get_contents($url);
    
    if ($data === false) {
        return "<p>Could not fetch XKCD comic data.</p>"; // Handle fetch error
    }

    $comic = json_decode($data, true);
    return "<h2>XKCD Comic</h2><img src='{$comic['img']}' alt='XKCD Comic'><p><a href='unsubscribe.php' id='unsubscribe-button'>Unsubscribe</a></p>"; // Format as HTML
}

function sendXKCDUpdatesToSubscribers() {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file($file, FILE_IGNORE_NEW_LINES);
    $comicHTML = fetchAndFormatXKCDData();
    $subject = "Your XKCD Comic";

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'jasonroy03271@gmail.com'; // Your Gmail address
        $mail->Password = 'lhcl tomh jaar sssm'; // Your Gmail password or app password
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        // Content
        $mail->setFrom('jasonroy03271@gmail.com', 'XKCD Comic');
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $comicHTML;

        foreach ($emails as $email) {
            $email = trim($email); // Trim whitespace
            if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mail->addAddress($email); // Add a valid recipient
            } else {
                echo "Invalid email address: $email\n"; // Debugging output
            }
        }

        // Send the email only if there are valid recipients
        if (count($mail->getToAddresses()) > 0) {
            $mail->send();
            echo 'Message has been sent';
        } else {
            echo 'No valid email addresses to send to.';
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
