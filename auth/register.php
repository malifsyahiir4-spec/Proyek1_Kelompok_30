<?php
include '../config/database.php';

if(isset($_POST['register'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    mysqli_query($conn,
    "INSERT INTO users(username,email,password)
    VALUES('$username','$email','$password')");

    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register MindClash</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:
            linear-gradient(135deg,#020617,#1e1b4b,#312e81);

            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            font-family:Arial;
        }

        .register-box{
            width:450px;
            background:rgba(255,255,255,0.08);
            backdrop-filter:blur(12px);
            padding:40px;
            border-radius:20px;
            box-shadow:0 0 40px rgba(0,0,0,0.5);
            color:white;
        }

        .title{
            text-align:center;
            font-size:35px;
            font-weight:bold;
            margin-bottom:10px;
        }

        .subtitle{
            text-align:center;
            color:#cbd5e1;
            margin-bottom:30px;
        }

        .form-control{
            height:50px;
            border:none;
            border-radius:12px;
        }

        .btn-register{
            background:#7c3aed;
            border:none;
            height:50px;
            border-radius:12px;
            font-weight:bold;
        }

        .btn-register:hover{
            background:#8b5cf6;
        }

        .login-link{
            text-align:center;
            margin-top:20px;
        }

        .login-link a{
            color:#a78bfa;
            text-decoration:none;
        }

    </style>

</head>
<body>

<div class="register-box">

    <div class="title">
        MINDCLASH
    </div>

    <div class="subtitle">
        Create Your Account
    </div>

    <form method="POST">

        <div class="mb-3">
            <input
                type="text"
                name="username"
                class="form-control"
                placeholder="Username"
                required>
        </div>

        <div class="mb-3">
            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="Email"
                required>
        </div>

        <div class="mb-3">
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Password"
                required>
        </div>

        <button
            name="register"
            class="btn btn-register w-100 text-white">

            REGISTER

        </button>

    </form>

    <div class="login-link">

        Sudah punya akun?

        <a href="login.php">
            Login
        </a>

    </div>

</div>

</body>
</html>
```php
<?php
include '../config/database.php';

if(isset($_POST['register'])) {

    $username = $_POST['username'];
    $email = $_POST['email'];

    $password = password_hash(
        $_POST['password'],
        PASSWORD_DEFAULT
    );

    mysqli_query($conn,
    "INSERT INTO users(username,email,password)
    VALUES('$username','$email','$password')");

    header('Location: login.php');
}
?>

<form method="POST">

    <input type="text" name="username">

    <input type="email" name="email">

    <input type="password" name="password">

    <button name="register">REGISTER</button>

</form>