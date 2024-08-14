// delete.php
<?php
include 'config.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentQuery = "SELECT image FROM student WHERE id = $id";
    $studentResult = mysqli_query($conn, $studentQuery);
    $student = mysqli_fetch_assoc($studentResult);

    if ($student['image']) {
        unlink('uploads/' . $student['image']);
    }

    $query = "DELETE FROM student WHERE id = $id";
    mysqli_query($conn, $query);
    header("Location: index.php");
}

$studentQuery = "SELECT name FROM student WHERE id = $id";
$studentResult = mysqli_query($conn, $studentQuery);
$student = mysqli_fetch_assoc($studentResult);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Student - School Demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Delete Student</h1>
    <p>Are you sure you want to delete student <strong><?php echo $student['name']; ?></strong>?</p>
    <form method="POST">
        <button type="submit" class="btn btn-danger">Yes, Delete</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
