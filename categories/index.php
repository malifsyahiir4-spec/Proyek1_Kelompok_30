<?php
include '../config/database.php';

$query = mysqli_query($conn,
"SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>

<title>Categories</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

body{
    background:#0f172a;
    color:white;
    font-family:Arial;
}

.container{
    margin-top:50px;
}

.card{
    background:#1e293b;
    border:none;
    border-radius:20px;
    padding:20px;
}

.table{
    color:white;
}

.btn-primary{
    background:#7c3aed;
    border:none;
}

.btn-primary:hover{
    background:#8b5cf6;
}

h2{
    font-weight:bold;
}

</style>

</head>
<body>

<div class="container">

<div class="card">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Category Management</h2>

<a href="create.php"
class="btn btn-primary">
+ Add Category
</a>

</div>

<table id="categoryTable"
class="table table-dark table-hover">

<thead>

<tr>
<th>No</th>
<th>Name</th>
<th>Description</th>
<th>Action</th>
</tr>

</thead>

<tbody>

<?php $no = 1; ?>

<?php while($row = mysqli_fetch_assoc($query)) : ?>

<tr>

<td><?= $no++; ?></td>

<td><?= $row['name']; ?></td>

<td><?= $row['description']; ?></td>

<td>

<a href="edit.php?id=<?= $row['id']; ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<button
class="btn btn-danger btn-sm delete-btn"
data-id="<?= $row['id']; ?>">

Delete

</button>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

<script>

$(document).ready(function(){

    $('#categoryTable').DataTable();

    $('.delete-btn').click(function(){

        const id = $(this).data('id');

        Swal.fire({

            title: 'Delete Category?',

            text: 'Data cannot be restored!',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#7c3aed',

            cancelButtonColor: '#ef4444',

            confirmButtonText: 'Delete'

        }).then((result) => {

            if(result.isConfirmed){

                window.location =
                'delete.php?id=' + id;

            }

        });

    });

});

</script>

</body>
</html>