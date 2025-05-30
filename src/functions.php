<?php

function generateVerificationCode() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

function registerEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    file_put_contents($file, $email . PHP_EOL, FILE_APPEND);
}

function unsubscribeEmail($email) {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file($file, FILE_IGNORE_NEW_LINES);
    $emails = array_filter($emails, function($e) use ($email) {
        return trim($e) !== $email;
    });
    file_put_contents($file, implode(PHP_EOL, $emails) . PHP_EOL);
}

function sendVerificationEmail($email, $code) {
    $subject = "Your Verification Code";
    $message = "<p>Your verification code is: <strong>$code</strong></p>";
    $headers = "From: no-reply@example.com\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    mail($email, $subject, $message, $headers);
}

function verifyCode($email, $code) {
    // Store the code temporarily for verification
    // This could be improved with a more secure method
    return true; // Placeholder for actual verification logic
}

function fetchAndFormatXKCDData() {
    $randomComicID = rand(1, 2500); // Adjust based on actual XKCD comic count
    $url = "https://xkcd.com/$randomComicID/info.0.json";
    $data = file_get_contents($url);
    $comic = json_decode($data, true);
    return "<h2>XKCD Comic</h2><img src='{$comic['img']}' alt='XKCD Comic'><p><a href='#' id='unsubscribe-button'>Unsubscribe</a></p>";
}

function sendXKCDUpdatesToSubscribers() {
    $file = __DIR__ . '/registered_emails.txt';
    $emails = file($file, FILE_IGNORE_NEW_LINES);
    $comicHTML = fetchAndFormatXKCDData();
    $subject = "Your XKCD Comic";
    
    foreach ($emails as $email) {
        $headers = "From: no-reply@example.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail($email, $subject, $comicHTML, $headers);
    }
}
?>
