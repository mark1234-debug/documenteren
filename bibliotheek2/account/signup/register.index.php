<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="../CSS/signup.css">
</head>
<body>
    <div class="register">
        <h1>Register</h1>
        <form action="register.php" method="post" autocomplete="off">
            <label for="username">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="username" placeholder="Username" id="username" required>

            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Password" id="password" required>

            <label for="password_confirm">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password_confirm" placeholder="Confirm Password" id="password_confirm" required>

            <label for="email">
                <i class="fas fa-envelope"></i>
            </label>
            <input type="email" name="email" placeholder="Email" id="email" required>

            <label for="firstname">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="first_name" placeholder="First Name" id="first_name" required>

            <label for="lastname">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="last_name" placeholder="Last Name" id="last_name" required>

            <label for="phone">
                <i class="fas fa-phone"></i>
            </label>
            <input type="text" name="phone_number" placeholder="Phone Number" id="phone_number" required>
            <br><br>
            <button class="signup"><a href="../login/login.php">login</a></button>
            <button class="terug"><a href="../../crud-php/index.php">terug</a></button>
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>