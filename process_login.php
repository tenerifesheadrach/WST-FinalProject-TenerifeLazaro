<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Sample users in XML format (example: users.xml)
$xmlFile = 'users.xml';

if (file_exists($xmlFile)) {
    $xml = simplexml_load_file($xmlFile);

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Flag to check if the login is successful
    $loginSuccessful = false;

    // Iterate over all users in the XML for login
    foreach ($xml->user as $user) {
        if ((string) $user->username === $username) {
            // Verify password
            if (password_verify($password, (string) $user->password)) {
                $loginSuccessful = true;
                echo "Login successful";
                exit;
            }
        }
    }

    // If no match found or incorrect password
    if (!$loginSuccessful) {
        echo "Invalid username or password.";
    }

} else {
    echo "Error loading user data.";
}
?>
