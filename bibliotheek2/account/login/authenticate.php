<?php
session_start();

include "../../crud-php/db_conn.php";

// Try and connect using the info above.
$conn = mysqli_connect($sname, $uname, $password, $db_name);
if (mysqli_connect_errno()) {
  // If there is an error with the connection, stop the script and display the error.
  exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Now we check if the data from the login form was submitted, isset() will check if the data exists.
if (!isset($_POST['username'], $_POST['password'])) {
  // Could not get the data that should have been sent.
  exit('Please fill both the username and password fields!');
}

// Prepare our SQL, preparing the SQL statement will prevent SQL injection.
if ($stmt = $conn->prepare('SELECT user_id, password, role FROM accounts WHERE username = ?')) {
  // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
  $stmt->bind_param('s', $_POST['username']);
  $stmt->execute();
  // Store the result so we can check if the account exists in the database.
  $stmt->store_result();

  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $password, $role);
    $stmt->fetch();

    // Note: remember to use password_hash in your registration file to store the hashed passwords.
    if (password_verify($_POST['password'], $password)) {
      // Verification success! User has logged in!
      // Create sessions, so we know the user is logged in. They act like cookies but remember the data on the server.
      $_SESSION['loggedin'] = true;
      $_SESSION['name'] = $_POST['username'];
      $_SESSION['id'] = $id;
      $_SESSION['role'] = $role; // Store the role in the sessions
      // Redirect the user to the homepage based on their role.
      if ($role === 'Lezer' || $role === 'Medewerker' || $role === 'Admin') {
        header('Location: ../../crud-php/index.php');
      } else {
        // Unknown role, log the user out and display an error message.
        session_destroy();
        exit('Unknown role!');
      }
    } else {
      // Incorrect password
      echo 'Incorrect password and/or username!';
    }
  } else {
    // Username not found
    echo 'Incorrect password and/or username';
  }

  $stmt->close();
}
?>
