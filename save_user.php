<?php
// Turn on error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = $_POST['password'];


    $xmlFile = 'users.xml';

    // Load or create XML
    if (!file_exists($xmlFile) || filesize($xmlFile) === 0) {
        $xml = new SimpleXMLElement('<users></users>');
    } else {
        $xml = simplexml_load_file($xmlFile);
        if ($xml === false) {
            die('Error loading XML file.');
        }
    }

    // Add new user node
    $user = $xml->addChild('user');
	$user->addChild('fullname', htmlspecialchars($fullname));
    $user->addChild('username', htmlspecialchars($username));
    $user->addChild('email', htmlspecialchars($email));
    $user->addChild('password', password_hash($password, PASSWORD_DEFAULT));  // Hashed password
   

    // Save and redirect
    if (is_writable($xmlFile) || !file_exists($xmlFile)) {
        if ($xml->asXML($xmlFile)) {
            // Success message to be used in JavaScript
            echo "Signup successful!";
        } else {
            echo "Failed to save user. Please try again.";
        }
    } else {
        echo "Cannot write to XML file. Check permissions.";
    }
} else {
    echo "Invalid request.";
}
?>
