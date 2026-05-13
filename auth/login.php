<?php
session_start();
include '../config/database.php';

if(isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn,
    "SELECT * FROM users WHERE email='$email'");

    $user = mysqli_fetch_assoc($query);

    if($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = $user;

        header('Location: ../dashboard.php');
    } else {
        $error = "Email atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login MindClash</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:
            linear-gradient(135deg,#0f172a,#1e1b4b,#312e81);

            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            font-family:Arial;
        }

        .login-box{
            width:400px;
            background:rgba(255,255,255,0.08);

            backdrop-filter:blur(10px);

            padding:40px;

            border-radius:20px;

            box-shadow:0 0 30px rgba(0,0,0,0.4);

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

        .btn-login{
            height:50px;
            border-radius:12px;
            background:#7c3aed;
            border:none;
            font-weight:bold;
            transition:0.3s;
        }

        .btn-login:hover{
            background:#8b5cf6;
            transform:scale(1.03);
        }

        .register{
            text-align:center;
            margin-top:20px;
        }

        .register a{
            color:#a78bfa;
            text-decoration:none;
        }

    </style>

</head>
<body>

<div class="login-box">

    <div class="title">
        MINDCLASH
    </div>

    <div class="subtitle">
        Quiz Battle Platform
    </div>

    <?php if(isset($error)) : ?>

        <div class="alert alert-danger">
            <?= $error; ?>
        </div>

    <?php endif; ?>

    <form method="POST">

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
            name="login"
            class="btn btn-login w-100 text-white">

            LOGIN

        </button>

    </form>

    <div class="register">

        Belum punya akun?

        <a href="register.php">
            Register
        </a>

    </div>

</div>

</body>
</html>