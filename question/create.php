<?php
include '../config/database.php';

$categories = mysqli_query($conn,
"SELECT * FROM categories");

if(isset($_POST['submit'])) {

    $category_id = $_POST['category_id'];
    $question = $_POST['question'];
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $d = $_POST['d'];
    $correct = $_POST['correct'];

    mysqli_query($conn,
    "INSERT INTO questions(
    category_id,
    question_text,
    option_a,
    option_b,
    option_c,
    option_d,
    correct_answer
    ) VALUES(
    '$category_id',
    '$question',
    '$a',
    '$b',
    '$c',
    '$d',
    '$correct'
    )");

    header('Location: index.php');
}
?>

<form method="POST">

<select name="category_id"
class="form-control mb-3">

<?php while($cat = mysqli_fetch_assoc($categories)) : ?>

<option value="<?= $cat['id']; ?>">
<?= $cat['name']; ?>
</option>

<?php endwhile; ?>

</select>

<textarea
name="question"
class="form-control mb-3"></textarea>

<input type="text" name="a"
placeholder="Option A"
class="form-control mb-3">

<input type="text" name="b"
placeholder="Option B"
class="form-control mb-3">

<input type="text" name="c"
placeholder="Option C"
class="form-control mb-3">

<input type="text" name="d"
placeholder="Option D"
class="form-control mb-3">

<select name="correct"
class="form-control mb-3">
    <option>A</option>
    <option>B</option>
    <option>C</option>
    <option>D</option>
</select>

<button name="submit"
class="btn btn-primary">
Save Question
</button>

</form>