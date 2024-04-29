<?php require_once './core/sessions.php'; ?>
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in</title>
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <div class="main">

    <h1>Log In</h1>

    <i>Let's Enjoy</i>

    <br>
    <br>

    <form method="POST" action="./handelers/handelLogin.php">

      <?php if (issetSession('error')): ?>
        <div id="error">
          <?php if (isset($_SESSION['error']['email'])): ?>
            <?php echo getSessionValue('error', 'email'); ?>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <input type="text" name="email" placeholder="Email" value="<?php if (isset($_COOKIE['email'])):
        echo $_COOKIE['email'];
      endif; ?>">
      <br>

      <?php if (issetSession('error')): ?>
        <div id="error">
          <?php if (isset($_SESSION['error']['password'])): ?>
            <?php echo getSessionValue('error', 'password'); ?>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <?php if (issetSession('noPassword')): ?>
        <div id="error">
          <?php echo $_SESSION['noPassword']; ?>
        </div>
      <?php endif; ?>

      <input type="password" name="password" placeholder="Password" value="<?php if (isset($_COOKIE['password'])):
        echo $_COOKIE['password'];
      endif; ?>">
      <br>

      <label for="check"><input type="checkbox" name="keep" id="check" value="1"> Keep me signed in</label>
      <br>

      <?php if (issetSession('error')): ?>
        <?php removeSession('error'); ?>
      <?php endif; ?>

      <?php if (issetSession('noPassword')): ?>
        <?php removeSession('noPassword'); ?>
      <?php endif; ?>

      <input type="submit" name="submit" value="Log In"><br>
    </form>

    <a href="forget.php">Forget Password?</a>

    <h3>Or</h3><br>
    <a id="login" href="register.php">Register</a>
  </div>
</body>

</html>