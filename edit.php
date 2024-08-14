// edit.php
<?php
include 'config.php';

$id = $_GET['id'];
$studentQuery = "SELECT * FROM student WHERE id = $id";
$studentResult = mysqli_query($conn, $studentQuery);
$student = mysqli_fetch_assoc($studentResult);

$classes = mysqli_query($conn, "SELECT * FROM classes");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image'];

    if ($name != '') {
        $imageName = $student['image'];
        if ($image['name'] && in_array(pathinfo($image['name'], PATHINFO_EXTENSION), ['jpg', 'png'])) {
            $imageName = time() . '_' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], 'uploads/' . $imageName);
        }

        $query = "UPDATE student SET name='$name', email='$email', address='$address', class_id=$class_id, image='$imageName' WHERE id=$id";
        mysqli_query($conn, $query);
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student - School Demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Edit Student</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $student['name']; ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $student['email']; ?>">
        </div>
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control"><?php echo $student['address']; ?></textarea>
        </div>
        <div class="form-group">
            <label>Class</label>
            <select name="class_id" class="form-control">
                <?php while ($row = mysqli_fetch_assoc($classes)): ?>
                    <option value="<?php echo $row['class_id']; ?>" <?php echo $row['class_id'] == $student['class_id'] ? 'selected' : ''; ?>>
                        <?php echo $row['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
