<?php
session_start();

if(!isset($_SESSION['user'])) {
    header('Location: auth/login.php');
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Dashboard MindClash</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

body{
    background:#0f172a;
    font-family:Arial;
    color:white;
}

.sidebar{
    width:260px;
    height:100vh;
    background:#111827;
    position:fixed;
    padding:30px 20px;
}

.logo{
    font-size:30px;
    font-weight:bold;
    text-align:center;
    margin-bottom:40px;
    color:#8b5cf6;
}

.menu a{
    display:block;
    padding:15px;
    margin-bottom:15px;
    border-radius:12px;
    text-decoration:none;
    color:white;
    background:#1e293b;
    transition:0.3s;
}

.menu a:hover{
    background:#7c3aed;
    transform:translateX(5px);
}

.content{
    margin-left:280px;
    padding:30px;
}

.card-box{
    background:#1e293b;
    border-radius:20px;
    padding:25px;
    box-shadow:0 0 20px rgba(0,0,0,0.3);
}

.card-title{
    color:#94a3b8;
    margin-bottom:10px;
}

.card-value{
    font-size:35px;
    font-weight:bold;
}

.welcome{
    margin-bottom:30px;
}

</style>

</head>
<body>

<div class="sidebar">

    <div class="logo">
        MINDCLASH
    </div>

    <div class="menu">

        <a href="dashboard.php">
            <i class="fa fa-home"></i>
            Dashboard
        </a>

        <a href="categories/index.php">
            <i class="fa fa-layer-group"></i>
            Categories
        </a>

        <a href="questions/index.php">
            <i class="fa fa-circle-question"></i>
            Questions
        </a>

        <a href="#">
            <i class="fa fa-trophy"></i>
            Leaderboard
        </a>

        <a href="#">
            <i class="fa fa-medal"></i>
            Achievement
        </a>

        <a href="auth/logout.php">
            <i class="fa fa-right-from-bracket"></i>
            Logout
        </a>

    </div>

</div>

<div class="content">

    <div class="welcome">

        <h1>
            Welcome,
            <?= $_SESSION['user']['username']; ?>
        </h1>

        <p>
            Manage your MindClash quiz system.
        </p>

    </div>

    <div class="row g-4">

        <div class="col-md-4">

            <div class="card-box">

                <div class="card-title">
                    TOTAL USERS
                </div>

                <div class="card-value">
                    120
                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card-box">

                <div class="card-title">
                    TOTAL QUESTIONS
                </div>

                <div class="card-value">
                    450
                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card-box">

                <div class="card-title">
                    TOTAL CATEGORIES
                </div>

                <div class="card-value">
                    12
                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>
```php
<?php
session_start();

if(!isset($_SESSION['user'])) {
    header('Location: auth/login.php');
}

include 'layouts/header.php';
include 'layouts/sidebar.php';
?>

<div class="content">

    <h1>Dashboard MindClash</h1>

    <div class="row">

        <div class="col-md-4">
            <div class="card-dashboard">
                <h3>Total Categories</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card-dashboard">
                <h3>Total Questions</h3>
            </div>
        </div>

    </div>

</div>