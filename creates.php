// create.php
<?php
include 'config.php';

// Function to handle file upload and return the file name or an error
function handleFileUpload($file) {
    $allowedExtensions = ['jpg', 'png'];
    $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
    
    if (in_array($fileExtension, $allowedExtensions)) {
        $imageName = time() . '_' . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], 'uploads/' . $imageName)) {
            return $imageName;
        }
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $address = htmlspecialchars($_POST['address']);
    $class_id = intval($_POST['class_id']);
    $image = $_FILES['image'];

    if ($name != '' && filter_var($email, FILTER_VALIDATE_EMAIL) && $imageName = handleFileUpload($image)) {
        $stmt = $conn->prepare("INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssds", $name, $email, $address, $class_id, $imageName);
        
        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Failed to create student. Please try again.";
        }
    } else {
        $error = "Invalid input or file upload failed. Please try again.";
    }
}

$classes = mysqli_query($conn, "SELECT * FROM classes");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Student - School Demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-5">Create Student</h1>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>
        
        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control-file" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
</body>
</html>
