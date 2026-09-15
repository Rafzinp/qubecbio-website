
<?php
error_reporting(0);
ini_set('display_errors', 0);

if (isset($_POST['email'])) {
    $email_to = "qubecbiosolutions@gmail.com";
    $email_cc = 'info@qubecbio.com';

    function died($error) {
        echo "We are very sorry, but there were error(s) found with the form you submitted.<br /><br />";
        echo $error . "<br /><br />";
        echo "Please go back and fix these errors.";
        die();
    }

    // Strip anything that could be used for header injection (newlines) and known header keywords
    function clean_string($string) {
        $string = str_replace(array("\r", "\n", "%0a", "%0d"), '', $string);
        $bad = array("content-type:", "bcc:", "to:", "cc:", "href");
        return str_ireplace($bad, "", $string);
    }

    $name    = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email   = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    if ($name === '' || $email === '' || $subject === '' || $message === '') {
        died('Please fill in all required fields.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        died('Please enter a valid email address.');
    }

    $email_from    = 'qubecbiosolutions@gmail.com';
    $email_reply   = clean_string($email);
    $email_subject = 'Qubec Customer Form';

    $email_message  = "Name : " . clean_string($name) . "\n";
    $email_message .= "Email : " . $email_reply . "\n";
    $email_message .= "Subject : " . clean_string($subject) . "\n";
    $email_message .= "Message : " . clean_string($message) . "\n";

    $headers  = 'From: ' . $email_from . "\r\n";
    $headers .= 'Cc: ' . $email_cc . "\r\n";
    $headers .= 'Reply-To: ' . $email_reply . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();

    $mail_sent = @mail($email_to, $email_subject, $email_message, $headers);

    if ($mail_sent) {
        echo "Thank you for contacting us. We will be in touch with you very soon.";
    } else {
        echo "We are very sorry, but your message could not be sent right now. Please try again later or reach us directly at qubecbiosolutions@gmail.com.";
    }
}
?>
