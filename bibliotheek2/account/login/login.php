<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="../CSS/login.css">
  </head>
  <body>
    <div class="login">
      <h1>Login</h1>
      <form action="authenticate.php" method="post">
        <label for="username"></label>
        <input type="text" name="username" placeholder="Username" id="username" required>
        <label for="password"></label>
        <br><br><br><br>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <button class="signup"><a href="../signup/register.index.php">sign up</a></button>
        <button class="terug"><a href="../../view/index.php">terug</a></button>
        <input type="submit" value="Login">
      </form>
    </div>
  </body>
</html>