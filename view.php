// view.php
<?php
include 'config.php';

$id = $_GET['id'];
$query = "SELECT student.*, classes.name as class_name FROM student JOIN classes ON student.class_id = classes.class_id WHERE student.id = $id";
$result = mysqli_query($conn, $query);
$student = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Student - School Demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">View Student</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?php echo $student['name']; ?></h5>
            <p class="card-text">Email: <?php echo $student['email']; ?></p>
            <p class="card-text">Address: <?php echo $student['address']; ?></p>
            <p class="card-text">Class: <?php echo $student['class_name']; ?></p>
            <p class="card-text">Created At: <?php echo $student['created_at']; ?></p>
            <img src="uploads/<?php echo $student['image']; ?>" width="100" alt="Student Image">
        </div>
    </div>
</div>
</body>
</html>
