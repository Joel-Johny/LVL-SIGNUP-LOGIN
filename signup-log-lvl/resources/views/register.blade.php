
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="vh-align">

    <form method="post" action="./register" class="flex-col-direction" id="register-form">
        <?= csrf_field() ?>

        <h3> REGISTER </h3>

        <input type="email" placeholder="Email" name="email" size=40 required >
        <span class="validate email"><?php echo (isset($email))?$email:"" ?></span>

        <input type="text" placeholder="Username" name="username"  required>
        <span  class="validate username"><?php echo (isset($username))?$username:"" ?></span>

        <input type="password" placeholder="Password" name="password" required >
        <span  class="validate password"><?php echo (isset($password))?$password:"" ?></span>

        <input type="password" placeholder="Confirm Password" name="confirm_password" required>
        <span  class="validate confirm_password"><?php echo (isset($confirm_password))?$confirm_password:"" ?></span>

        <button type="submit" id="form-submit">REGISTER</button>

        <span class="validate dbValidation"><?php echo (isset($dbValidation))?$dbValidation:"" ?></span>

        <a href="./login">Already a User?</a>

    </form>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="./js/index.js"></script>

</body>
</html>
