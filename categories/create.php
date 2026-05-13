<?php
include '../config/database.php';

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $description = $_POST['description'];

    mysqli_query($conn,
    "INSERT INTO categories(name,description)
    VALUES('$name','$description')");

    header('Location:index.php');
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Create Category</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#0f172a;
    color:white;
}

.card{
    background:#1e293b;
    border:none;
    border-radius:20px;
}

.container{
    margin-top:80px;
    max-width:700px;
}

</style>

</head>
<body>

<div class="container">

<div class="card p-4">

<h2 class="mb-4">
Add Category
</h2>

<form method="POST">

<input
type="text"
name="name"
class="form-control mb-3"
placeholder="Category Name"
required>

<textarea
name="description"
class="form-control mb-3"
placeholder="Description"></textarea>

<button
name="submit"
class="btn btn-primary">

Save Category

</button>

<a href="index.php"
class="btn btn-secondary">

Back

</a>

</form>

</div>

</div>

</body>
</html>