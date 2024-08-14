// classes.php
<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_class'])) {
        $name = $_POST['name'];
        if ($name != '') {
            $query = "INSERT INTO classes (name) VALUES ('$name')";
            mysqli_query($conn, $query);
        }
    } elseif (isset($_POST['edit_class'])) {
        $class_id = $_POST['class_id'];
        $name = $_POST['name'];
        if ($name != '') {
            $query = "UPDATE classes SET name='$name' WHERE class_id=$class_id";
            mysqli_query($conn, $query);
        }
    } elseif (isset($_POST['delete_class'])) {
        $class_id = $_POST['class_id'];
        $query = "DELETE FROM classes WHERE class_id=$class_id";
        mysqli_query($conn, $query);
    }
    header("Location: classes.php");
}

$classes = mysqli_query($conn, "SELECT * FROM classes");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Classes - School Demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Manage Classes</h1>
    <h2>Add New Class</h2>
    <form method="POST">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" name="add_class" class="btn btn-primary">Add Class</button>
    </form>

    <h2 class="mt-5">Existing Classes</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = mysqli_fetch_assoc($classes)): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="class_id" value="<?php echo $row['class_id']; ?>">
                        <input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control d-inline w-auto">
                        <button type="submit" name="edit_class" class="btn btn-warning">Edit</button>
                    </form>
                    <form method="POST" class="d-inline">
                        <input type="hidden" name="class_id" value="<?php echo $row['class_id']; ?>">
                        <button type="submit" name="delete_class" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
