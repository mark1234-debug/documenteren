<?php
include "../../crud-php/db_conn.php";

// Try and connect using the info above.
$conn = mysqli_connect($sname, $uname, $password, $db_name);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password'], $_POST['password_confirm'], $_POST['email'], $_POST['first_name'], $_POST['last_name'], $_POST['phone_number'])) {
    // Could not get the data that should have been sent.
    exit('Please complete the registration form!');
}

// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password_confirm']) || empty($_POST['email']) || empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['phone_number'])) {
    // One or more values are empty.
    exit('Please complete the registration form');
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    exit('Email is not valid!');
}

if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Username is not valid!');
}

if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
    exit('Password must be between 5 and 20 characters long!');
}

if ($_POST['password'] !== $_POST['password_confirm']) {
    exit('Passwords do not match!');
}
// We need to check if the account with that username exists.
if ($stmt = $conn->prepare('SELECT user_id, password FROM accounts WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    $stmt->store_result();
    // Store the result so we can check if the account exists in the database.
    if ($stmt->num_rows > 0) {
        // Username already exists
        echo 'Username exists, please choose another!';
    } else {
        if ($stmt = $conn->prepare('INSERT INTO accounts (username, password, email, first_name, last_name, phone_number) VALUES (?, ?, ?, ?, ?, ?)')) {
            // Hash the password using the default algorithm (currently bcrypt)
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $uniqid = uniqid();
            $stmt->bind_param('ssssss', $_POST['username'], $password, $_POST['email'], $_POST['first_name'], $_POST['last_name'], $_POST['phone_number']);
            $stmt->execute();
            // on the line below  put the location of the homepage with the role "Lezer" to ensure that the page that is redirected to is the homepage for clients
            header("Location: ../../crud-php/index.php ");
            die();
        } else {
            // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all the required fields.
            echo 'Could not prepare statement!';
        }
    }
    $stmt->close();
} else {
    // Something is wrong with the SQL statement, so you must check to make sure your accounts table exists with all the required fields.
    echo 'Could not prepare statement!';
}
$conn->close();
?>