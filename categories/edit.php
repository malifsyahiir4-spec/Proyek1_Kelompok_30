<?php
include '../config/database.php';

$id = $_GET['id'];

$query = mysqli_query($conn,
"SELECT * FROM categories
WHERE id='$id'");

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $name = $_POST['name'];
    $description = $_POST['description'];

    mysqli_query($conn,
    "UPDATE categories SET
    name='$name',
    description='$description'
    WHERE id='$id'");

    header('Location:index.php');
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Edit Category</title>

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
Edit Category
</h2>

<form method="POST">

<input
type="text"
name="name"
value="<?= $data['name']; ?>"
class="form-control mb-3">

<textarea
name="description"
class="form-control mb-3"><?= $data['description']; ?></textarea>

<button
name="update"
class="btn btn-success">

Update

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