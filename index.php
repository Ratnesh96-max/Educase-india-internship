// index.php
<?php
include 'config.php';

$query = "SELECT student.*, classes.name as class_name FROM student JOIN classes ON student.class_id = classes.class_id";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - School Demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Students</h1>
    <a href="creates.php" class="btn btn-primary">Add Student</a>
    <table class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Class</th>
            <th>Image</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['class_name']; ?></td>
                <td><img src="uploads/<?php echo $row['image']; ?>" width="50" alt="Student Image"></td>
                <td><?php echo $row['created_at']; ?></td>
                <td>
                    <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-info">View</a>
                    <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
